<?php

return [

    'model' => 'App\Models\Tree',
    'cache' => [
        'tags' => ['tree'],
    ],
    'templates' => [
        'contacts' => [
            'action'          => 'ContactsController@showPage',
            'node_definition' => 'contacts',
            'check'           => function () {
                return true;
            },
            'title' => 'Контакты',
            //'show_templates' => ['news', 'about']
        ],
        'news' => [
            'action'          => 'NewsController@showPages',
            'node_definition' => 'node',
            'check'           => function () {
                return true;
            },
            'title' => 'Новости',
        ],

        'about' => [
            'action'          => 'AboutController@showPage',
            'node_definition' => 'node',
            'check'           => function () {
                return true;
            },
            'title' => 'О нас',
        ],

        'article' => [
            'action'          => 'ArticleController@showPage',
            'node_definition' => 'node',
            'check'           => function () {
                return true;
            },
            'title' => 'Статья',
        ],

        'main' => [
            'action'          => 'HomeController@showPage',
            'node_definition' => 'node',
            'check'           => function () {
                return true;
            },
            'title' => 'Главная',
        ],

    ],

    'default' => [
        'type'            => 'node',
        'action'          => 'HomeController@showPage',
        'node_definition' => 'node',
    ],

    'actions' => [

        'update' => [
            'caption' => 'Редактировать',
            'check'   => function () {
                return true;
            },
        ],
        'preview' => [
            'caption' => 'Предпросмотр',
            'check'   => function () {
                return true;
            },
        ],
        'clone' => [
            'caption' => 'Клонировать',
            'check'   => function () {
                return true;
            },
        ],

        'revisions' => [
            'caption' => 'Версии',
            'check'   => function () {
                return true;
            },
        ],
        'delete' => [
            'caption' => 'Удалить',
            'check'   => function () {
                return true;
            },
        ],
    ],

];
