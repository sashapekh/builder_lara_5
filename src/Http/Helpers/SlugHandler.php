<?php

namespace Vis\Builder\Helpers;

use Vis\Builder\Facades\Jarboe;
use Vis\Builder\Handlers\CustomHandler;

/**
 * Class SlugHandler.
 */
class SlugHandler extends CustomHandler
{
    /**
     * @param array $response
     * @param $model
     *
     * @return string
     */
    protected function generateUniqueSlug(array $response, $model)
    {
        $slug = Jarboe::urlify(($response['values']['title']));

        $slugCheck = false;

        while ($slugCheck === false) {
            $slugCheckQuery = $model::where('slug', 'like', $slug)->where('id', '!=', $response['id'])->first();
            $slugCheckQuery ? $slug = $slug.'-1' : $slugCheck = true;
        }

        return $slug;
    }

    /**
     * @param array $response
     */
    protected function setSlug(array $response)
    {
        if (isset($response['values']['title'])) {
            $model = $this->controller->getDefinition()['options']['model'];
            $model::where('id', $response['id'])->update(['slug' => $this->generateUniqueSlug($response, $model)]);
        }
    }

    /**
     * @param array $response
     */
    public function onInsertRowResponse(array &$response)
    {
        $this->setSlug($response);
    }

    /**
     * @param array $response
     */
    public function onUpdateRowResponse(array &$response)
    {
        $this->setSlug($response);
    }
}
