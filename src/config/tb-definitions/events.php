<?php

return [
    'db' => [
        'table' => 'events',
        'order' => [
            'created_at' => 'desc',
        ],
        'pagination' => [
            'per_page' => 20,
            'uri'      => '/admin/events',
        ],
    ],
    'options' => [
        'caption'     => 'Логирование',
        'is_sortable' => false,
        'model'       => 'Vis\Builder\Event',
    ],
    'position' => [
        'tabs' => [
            'Общая'     => [
                'id',
                'id_user',
                'ip_user',
                'message',
                'model',
                'id_record',
                'action',
                'created_at',
                'updated_at',
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
        'id_user' => [
            'caption'    => 'ID пользователя',
            'type'       => 'text',
            'filter'     => 'text',
            'is_sorting' => true,
        ],
        'ip_user' => [
            'caption'    => 'IP пользователя',
            'type'       => 'text',
            'is_sorting' => true,
        ],
        'message' => [
            'caption'    => 'Сообщение',
            'type'       => 'text',
            'is_sorting' => true,
        ],
        'model' => [
            'caption'    => 'Модель/таблица',
            'type'       => 'text',
            'is_sorting' => true,
        ],
        'id_record' => [
            'caption'    => 'Id записи',
            'type'       => 'text',
            'filter'     => 'text',
            'is_sorting' => true,
        ],
        'action' => [
            'caption'    => 'Действие',
            'type'       => 'text',
            'filter'     => 'text',
            'is_sorting' => true,
        ],

        'created_at' => [
            'caption'    => 'Дата/Время',
            'type'       => 'datetime',
            'is_sorting' => true,
            'months'     => 2,
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
    ],
];
