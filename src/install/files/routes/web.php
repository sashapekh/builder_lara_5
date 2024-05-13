<?php

Route::pattern('id', '[0-9]+');
Route::pattern('slug', '[a-z0-9-]+');

Route::group(
    ['prefix' => LaravelLocalization::setLocale()],
    function () {
        Route::get('/articles/{slug}-{id}', 'ArticlesController@showPage')->name('articles_article');
        Route::get('/product/{slug}-{id}', 'ProductController@showPage')->name('product');
    }
);
