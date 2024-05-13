<?php

namespace Vis\TranslationsCMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Class Trans.
 */
class Trans extends Model
{
    /**
     * @var string
     */
    protected $table = 'translations_phrases_cms';

    /**
     * @var array
     */
    public static $rules = [
        'phrase' => 'required|unique:translations_phrases_cms',
    ];

    /**
     * @var array
     */
    protected $fillable = ['phrase'];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return mixed
     */
    public function getTrans()
    {
        $res = $this->hasMany('Vis\TranslationsCMS\Translate', 'id_translations_phrase')->get()->toArray();

        if ($res) {
            foreach ($res as $el) {
                $trans[$el['lang']] = $el['translate'];
            }

            return $trans;
        }
    }

    /**
     * @return array|mixed
     */
    public static function fillCacheTrans()
    {
        if (Cache::tags('translations')->has('translations_cms')) {
            $arrayTranslate = Cache::tags('translations')->get('translations_cms');
        } else {
            $translationsGet = DB::table('translations_phrases_cms')->leftJoin(
                'translations_cms',
                'translations_cms.id_translations_phrase',
                '=',
                'translations_phrases_cms.id'
            )
                ->get(['translate', 'lang', 'phrase']);

            $arrayTranslate = [];
            foreach ($translationsGet as $el) {
                $el = (array) $el;
                $arrayTranslate[$el['phrase']][$el['lang']] = $el['translate'];
            }
            Cache::tags('translations')->forever('translations_cms', $arrayTranslate);
        }

        return $arrayTranslate;
    }

    public static function reCacheTrans()
    {
        Cache::tags('translations')->flush();
        self::fillCacheTrans();
    }
}
