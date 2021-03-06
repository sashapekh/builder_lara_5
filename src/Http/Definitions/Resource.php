<?php

namespace Vis\Builder\Definitions;

use Vis\Builder\Services\Listing;
use Illuminate\Support\Arr;
use Vis\Builder\Fields\Definition;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class Resource
{
    protected $orderBy = 'created_at desc';
    protected $isSortable = false;
    protected $perPage = [20, 100, 1000];
    protected $cacheTag;
    protected $updateManyToManyList = [];
    protected $updateHasOneList = [];
    protected $updateMorphOneList = [];
    protected $relations = [];

    public function model()
    {
        return new $this->model;
    }

    public function cards()
    {
        return [];
    }

    public function getTitle() : string
    {
        return __cms($this->title);
    }

    public function getPerPage()
    {
        return $this->perPage;
    }

    public function getIsSortable()
    {
        return $this->isSortable;
    }

    public function getCacheKey()
    {
        return $this->cacheTag ?: $this->getNameDefinition();
    }

    public function clearCache()
    {
        Cache::tags($this->getCacheKey())->flush();
    }

    public function getOrderBy()
    {
        $sessionOrder = session($this->getSessionKeyOrder());

        if ($sessionOrder) {
            return $sessionOrder['field'] . ' ' . $sessionOrder['direction'];
        }

        return $this->orderBy;
    }

    public function getFilter()
    {
        return session($this->getSessionKeyFilter());;
    }

    public function getPerPageThis()
    {
        return session($this->getSessionKeyPerPage()) ? session($this->getSessionKeyPerPage())['per_page'] : $this->perPage[0];
    }

    public function getNameDefinition() : string
    {
        return mb_strtolower(class_basename($this));
    }

    public function getSessionKeyOrder() : string
    {
        return "table_builder.{$this->getNameDefinition()}.order";
    }

    public function getSessionKeyFilter() : string
    {
        return "table_builder.{$this->getNameDefinition()}.filter";
    }

    public function getSessionKeyPerPage() : string
    {
        return "table_builder.{$this->getNameDefinition()}.per_page";
    }

    public function getUrlAction() : string
    {
        $page = $this->getNameDefinition();

        return '/admin/actions/' . $page;
    }

    public function getAllFields() : array
    {
        $fields = $this->fields();
        $fields = isset($fields[0]) ? $fields : Arr::flatten($fields);

        $fieldsResults = [];
        foreach ($fields as $field) {
            $fieldsResults[$field->getNameField()] = $field;

            if ($field->getHasOne()) {
                $this->relations[] = $field->getHasOne();
            }

            if ($field->getMorphOne()) {
                $this->relations[] = $field->getMorphOne();
            }
        }

        return $fieldsResults;
    }

    public function remove(int $id) : array
    {
        $this->model()->destroy($id);

        return [
            'status' => 'success'
        ];
    }

    public function clone(int $id) : array
    {
        $model = $this->model()->find($id);
        $newModel = $model->replicate();
        $newModel->push();

        return [
            'status' => 'success',
        ];
    }

    public function changeOrder($requestOrder, $params) : array
    {
        parse_str($requestOrder, $order);
        $pageThisCount = $params ?: 1;
        $perPage = 20;

        $lowest = ($pageThisCount * $perPage) - $perPage;

        foreach ($order['sort'] as $id) {
            $lowest++;

            $this->model()->where('id', $id)->update([
                'priority' => $lowest,
            ]);
        }

        return [
            'status' => 'success'
        ];
    }

    public function showAddForm()
    {
        $definition = $this;
        $fields = $this->fields();

        return [
            view('admin::new.form.create', compact('definition', 'fields'))->render()
        ];
    }

    public function showEditForm(int $id) : array
    {
        $definition = $this;

        $record = $this->model()->find($id);

        $fields = $this->fields();

        if (isset($fields[0])) {
            foreach ($fields as $field) {
                $field->setValue($record);
            }
        } else {
            foreach ($fields as $fieldBlock) {
                foreach ($fieldBlock as $field) {
                    $field->setValue($record);
                }
            }
        }

        return [
            'html' => view('admin::new.form.edit', compact('definition', 'fields'))->render(),
            'status' => true
        ];
    }

    public function saveAddForm($request) : array
    {
        $record = $this->model();
        $recordNew = $this->saveActive($record, $request);

        return [
            'id' => $recordNew->id,
            'html' => $this->getSingleRow($recordNew)
        ];
    }

    public function saveEditForm($request) : array
    {
        $recordNew = $this->updateForm($request);

        return [
            'id' => $recordNew->id,
            'html' => $this->getSingleRow($recordNew)
        ];
    }

    protected function updateForm($request)
    {
        $record = $this->model()->find($request['id']);
        $recordNew = $this->saveActive($record, $request);

        return $recordNew;
    }

    private function getRules($fields) : array
    {
        $rules = [];
        foreach ($fields as $field) {
            if ($field->getRules()) {
                $rules[$field->getNameField()] = $field->getRules();
            }
        }

        return $rules;
    }

    protected function saveActive($record, $request)
    {
        $fields = $this->getAllFields();
        Validator::make($request, $this->getRules($fields))->validate();

        foreach ($fields as $field) {
            $nameField = $field->getNameField();
            if ($nameField != 'id') {

                if ($field->getLanguage() && !$field->getMorphOne() && !$field->getHasOne()) {
                    $this->saveLanguage($field, $record, $request);
                }

                if ($field->getHasOne()) {
                    $this->updateHasOne($field, $request[$nameField]);
                    continue;
                }

                if ($field->getMorphOne()) {
                    $this->updateMorphOne($field, $request[$nameField]);
                    continue;
                }

                if ($field->isManyToMany()) {
                    $this->updateManyToMany($field, $request[$nameField] ?? '');
                    continue;
                }

                if ($field instanceof Definition) {
                    continue;
                }

                $record->$nameField = $field->prepareSave($request);
            }
        }

        $record->save();

        if (count($this->updateManyToManyList)) {
            foreach ($this->updateManyToManyList as $item) {
                if ($item['collectionsIds']) {
                    $item['field']->save($item['collectionsIds'], $record);
                }
            }
        }

        if (count($this->updateHasOneList)) {
            foreach ($this->updateHasOneList as $item) {

                $relationHasOne = $item['field']->getHasOne();
                $data = [
                    $item['field']->getNameField() => $item['value']
                ];

                $record->$relationHasOne ? $record->$relationHasOne()->update($data) : $record->$relationHasOne()->create($data);
            }
        }

        if (count($this->updateMorphOneList)) {

            $data = [];

            foreach ($this->updateMorphOneList as $item) {

                $relationMorphOne = $item['field']->getMorphOne();

                if ($item['field']->getLanguage()) {
                    foreach ($item['field']->getLanguage() as $language) {
                        $data[$item['field']->getNameField().$language['postfix']] = $request[$item['field']->getNameField().$language['postfix']];
                    }

                } else {
                    $data = [
                        $item['field']->getNameField() => $item['value']
                    ];
                }
            }

            $record->$relationMorphOne ? $record->$relationMorphOne()->update($data) : $record->$relationMorphOne()->create($data);
        }

        Cache::tags($this->getNameDefinition())->flush();

        return $record;
    }

    protected function saveLanguage($field, &$record, $request)
    {
        $nameField = $field->getNameField();

        foreach ($field->getLanguage() as $slugLang => $langPrefix) {
            $langField = $nameField . $langPrefix['postfix'];

            if (isset($request[$langField]) && $request[$langField]) {
                $translate = $request[$langField];
            } else {
                $translate = $this->getTranslate($field, $slugLang, $request[$nameField]);
            }

            $record->$langField = $translate;
        }
    }

    private function getTranslate($field, $slugLang, $phrase)
    {
        try {
            $langDef = $field->getLanguageDefault();

            if ($langDef == $slugLang || !$phrase) {
                return '';
            }

            $translator = new \Yandex\Translate\Translator(config('builder.translations.cms.api_yandex_key'));
            $translation = $translator->translate($phrase, $langDef . '-' . $slugLang);

            if (isset($translation->getResult()[0])) {
                return $translation->getResult()[0];
            }
        } catch (\Yandex\Translate\Exception $e) {}
    }

    protected function updateManyToMany($field, $collectionsIds)
    {
        $this->updateManyToManyList[] = [
            'field' => $field,
            'collectionsIds' => $collectionsIds
        ];
    }

    protected function updateHasOne($field, $value)
    {
        $this->updateHasOneList[] = [
            'field' => $field,
            'value' => $value
        ];
    }

    protected function updateMorphOne($field, $value)
    {
        $this->updateMorphOneList[] = [
            'field' => $field,
            'value' => $value
        ];
    }

    protected function getSingleRow($recordNew)
    {
        $list = new Listing($this);
        $head = $list->head();
        $definition = $this;

        $recordNew->fields = clone $head;
        $head->map(function ($item2, $key) use ($recordNew, $definition) {
            $item2->setValue($recordNew);
            $recordNew->fields[$key]->value = $item2->getValueForList($definition);
        });

        return view('admin::new.list.single_row',
            [
                'list' => $list,
                'record' => $recordNew
            ]
        )->render();
    }

    public function getListing()
    {
        $this->checkPermissions();

        $head = $this->head();
        $list = $this->getCollection();
        $definition = $this;

        $list->map(function ($item, $key) use ($head, $definition) {
            $item->fields = clone $head;
            $item->fields->map(function ($item2, $key) use ($item, $definition) {
                $item->fields[$key] = clone $item2;
                $item2->setValue($item);

                $item->fields[$key]->value = $item2->getValueForList($definition);
            });
        });

        return $list;
    }

    protected function checkPermissions()
    {
        if (!app('user')->hasAccess([$this->getNameDefinition(). '.view'])) {
            abort(403);
        }
    }

    protected function getCollection()
    {
        $collection = $this->model()->with($this->relations);
        $filter = $this->getFilter();
        $orderBy = $this->getOrderBy();
        $perPage = $this->getPerPageThis();

        if (isset($filter['filter']) && is_array($filter['filter'])) {
            foreach ($filter['filter'] as $field => $value) {
                if (is_null($value) || $value == '') {
                    continue;
                }

                if (is_array($value)) {
                    if ($value['from'] && $value['to']) {
                        $collection = $collection->whereBetween($field, [$value['from'], $value['to']]);
                    }

                    continue;
                }

                $collection = $collection->where($field, '=', $value);
            }
        }

        return $collection->orderByRaw($orderBy)->paginate($perPage);
    }

    public function head()
    {
        $fields = $this->getAllFields();

        return collect($fields)->reject(function ($name) {
            return $name->isOnlyForm() == true;
        });
    }
}
