<?php

return [
    'db' => [
        'table' => 'revisions',
        'order' => [
            'created_at' => 'desc',
        ],
        'pagination' => [
            'per_page' => 20,
            'uri'      => '/admin/revisions',
        ],
    ],
    'options' => [
        'caption' => 'Контроль изменений',
        'model'   => 'Vis\Builder\Revision',
    ],
    'position' => [
        'tabs' => [
            'Общая'     => [
                'id',
                'user_id',
                'revisionable_type',
                'revisionable_id',
                'key',
                'old_value',
                'new_value',
                'created_at',
            ],
        ],
    ],
    'fields' => [
        'id' => [
            'caption'    => '#',
            'type'       => 'readonly',
            'class'      => 'col-id',
            'width'      => '1%',
            'hide'       => true,
            'is_sorting' => true,
        ],
        'user_id' => [
            'caption'             => 'Имя',
            'type'                => 'foreign',
            'is_sorting'          => true,
            'foreign_table'       => 'users',
            'foreign_key_field'   => 'id',
            'foreign_value_field' => 'first_name',
            'result_show'         => "<a href='/admin/users?id=%user_id%' target='_blank'>%users_first_name%</a>",
        ],
        'revisionable_type' => [
            'caption'    => 'Модель',
            'type'       => 'text',
            'filter'     => 'text',
            'is_sorting' => true,
        ],
        'revisionable_id' => [
            'caption'    => 'Id записи',
            'type'       => 'text',
            'filter'     => 'text',
            'is_sorting' => true,
        ],
        'key' => [
            'caption'    => 'Поле',
            'type'       => 'text',
            'filter'     => 'text',
            'is_sorting' => true,
        ],
        'old_value' => [
            'caption'    => 'Старое значение',
            'type'       => 'text',
            'filter'     => 'text',
            'is_sorting' => true,
        ],
        'new_value' => [
            'caption'    => 'Новое значение',
            'type'       => 'text',
            'filter'     => 'text',
            'is_sorting' => true,
        ],

        'created_at' => [
            'caption'    => 'Дата/Время',
            'type'       => 'datetime',
            'is_sorting' => true,
            'months'     => 2,
            'field'      => 'datetime',
        ],

    ],
    'filters' => [
    ],
    'actions' => [
    ],
];
