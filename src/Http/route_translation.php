<?php

Route::group(['middleware' => ['web']], function () {
    Route::group(
        ['prefix' => 'admin', 'middleware' => 'auth.admin'],
        function () {
            Route::any('translations_cms/phrases', 'Vis\TranslationsCMS\TranslateController@fetchIndex');

            if (Request::ajax()) {
                Route::post('translations_cms/create_pop', 'Vis\TranslationsCMS\TranslateController@fetchCreate');
                Route::post('translations_cms/translate', 'Vis\TranslationsCMS\TranslateController@doTranslate');
                Route::post('translations_cms/add_record', 'Vis\TranslationsCMS\TranslateController@doSaveTranslate');
                Route::post('translations_cms/change_text_lang', 'Vis\TranslationsCMS\TranslateController@doSavePhrase');
                Route::post('translations_cms/del_record', 'Vis\TranslationsCMS\TranslateController@doDelelePhrase');
            }
        }
    );
});
