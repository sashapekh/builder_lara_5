<?php

return [
    'db' => [
        'table' => '??',
        'order' => [
            'id' => 'DESC',
        ],
        'pagination' => [
            'per_page' => 20,
            'uri'      => '/admin/??',
        ],
    ],
    'cache' => [
        'tags' => ['??'],
    ],
    'options' => [
        'caption' => 'Title',
        'model'   => 'App\Models\??',
    ],
    'fields'  => 'fields_default',
    'filters' => [],
    'actions' => [
        /* 'search' => array(
             'caption' => 'Поиск',
         ),*/
        'insert' => [
            'caption' => 'Добавить',
            'check'   => function () {
                return true;
            },
        ],
        'update' => [
            'caption' => 'Редактировать',
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
