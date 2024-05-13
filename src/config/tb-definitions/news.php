<?php

return [
    'db' => [
        'table' => 'news',
        'order' => [
            'priority' => 'asc',
        ],
        'pagination' => [
            'per_page' => 20,
            'uri'      => '/admin/news',
        ],
    ],
    'cache' => [
        'tags' => ['news'],
    ],
    'options' => [
        'caption'     => 'Новости',
        'is_sortable' => true,
        'model'       => 'App\Models\News',
    ],
    'position' => [
        'tabs' => [
            'Общая' => [
                'id',
                'title',
                'picture',
                'short_description',
                'description',
                'created_at',
                'updated_at',
                'is_active',
            ],

            'SEO' => [
                'seo_title',
                'seo_description',
                'seo_keywords',
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
            'is_sorting' => false,
        ],

        'picture' => [
            'caption'      => 'Изображение',
            'type'         => 'image',
            'storage_type' => 'image', // image|tag|gallery
            'img_height'   => '50px',
            'is_upload'    => true,
            'is_null'      => true,
            'is_remote'    => false,
            'hide_list'    => true,

        ],
        'title' => [
            'caption'    => 'Название',
            'type'       => 'text',
            'filter'     => 'text',
            'is_sorting' => true,
        ],

        'short_description' => [
            'caption'   => 'Краткое описание',
            'type'      => 'wysiwyg',
            'wysiwyg'   => 'redactor',
            'hide_list' => true,
        ],
        'description' => [
            'caption'   => 'Полное описание',
            'type'      => 'wysiwyg',
            'hide_list' => true,
        ],

        'created_at' => [
            'caption'    => 'Дата создания',
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
        'is_active' => [
            'caption' => 'Статья активна',
            'type'    => 'checkbox',
            'options' => [
                1 => 'Активные',
                0 => 'He aктивные',
            ],
        ],

        'seo_title' => [
            'caption'   => 'Seo: title',
            'type'      => 'text',
            'filter'    => 'text',
            'hide_list' => true,
        ],
        'seo_description' => [
            'caption'   => 'Seo: description',
            'type'      => 'text',
            'filter'    => 'text',
            'hide_list' => true,
        ],
        'seo_keywords' => [
            'caption'   => 'Seo: keywords',
            'type'      => 'text',
            'filter'    => 'text',
            'hide_list' => true,
        ],
    ],
    'filters' => [
    ],
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
        'update' => [
            'caption' => 'Редактировать',
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
