<?php

return [
    'db' => [
        'table' => 'tableName',
        'order' => [
            'created_at' => 'asc',
        ],
        'pagination' => [
            'per_page' => 20,
            'uri'      => '/admin/tableName',
        ],
    ],
    'cache' => [
        'tags' => ['tableName'],
    ],
    'options' => [
        'caption' => 'modelName',
        'model'   => 'App\Models\modelName',
    ],
    'position' => [
        'tabs' => [
            'Общая' => [
                'id',
                'fieldsTabs',
                'created_at',
                'updated_at',
            ],
        ],
    ],
    'fields' => [
        'id' => [
            'caption'    => '#',
            'type'       => 'readonly',
            'filter'     => 'integer',
            'class'      => 'col-id',
            'width'      => '100px',
            'hide'       => true,
            'is_sorting' => false,
        ],

        'fieldsDescription',

        'created_at' => [
            'caption'     => 'Дата создания',
            'type'        => 'datetime',
            'is_sorting'  => true,
            'months'      => 2,
            'hide'        => true,
        ],
        'updated_at' => [
            'caption'     => 'Дата обновления',
            'type'        => 'readonly',
            'hide_list'   => true,
            'is_sorting'  => true,
            'hide'        => true,
        ],
    ],
    'filters' => [
    ],
    'actions' => [

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
