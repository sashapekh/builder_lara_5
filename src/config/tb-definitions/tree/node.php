<?php

return [
    'db' => [
        'table' => 'tb_tree',
        'order' => [
            'id' => 'ASC',
        ],
        'pagination' => [
            'per_page' => 1,
            'uri'      => '/admin/tree',
        ],
    ],
    'options' => [
        'caption' => '',
        'model'   => 'App\Models\Tree',
    ],
    'position' => [
        'tabs' => [
            'Общая'     => [
                'id',
                'title',
                'slug',
                'picture',
                'description',
                'is_show_in_menu',
                'is_show_in_footer_menu',
                'created_at',
                'updated_at',
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
            'is_sorting' => true,
        ],
        'title' => [
            'caption' => 'Заголовок',
            'type'    => 'text',
            'field'   => 'string',
        ],

        'picture' => [
            'caption'      => 'Изображение',
            'type'         => 'image',
            'storage_type' => 'image',
            'img_height'   => '150px',
            'is_upload'    => true,
            'is_null'      => true,
            'is_remote'    => false,
            'limit_mb'     => '2',
            'field'        => 'string',
        ],

        'description' => [
            'caption' => 'Текст',
            'type'    => 'wysiwyg',
            'field'   => 'text',
        ],
        'created_at' => [
            'caption' => 'Дата создания',
            'type'    => 'datetime',
            'hide'    => true,
            'field'   => 'datetime',
        ],
        'updated_at' => [
            'caption' => 'Дата обновления',
            'type'    => 'datetime',
            'hide'    => true,
            'field'   => 'datetime',
        ],
        'is_show_in_menu' => [
            'caption' => 'Показывать в меню',
            'type'    => 'checkbox',
            'options' => [
                1 => 'Да',
                0 => 'Нет',
            ],
            'field' => 'tinyInteger',
        ],
        'is_show_in_footer_menu' => [
            'caption' => 'Показывать в футере меню ',
            'type'    => 'checkbox',
            'options' => [
                1 => 'Да',
                0 => 'Нет',
            ],
            'field' => 'tinyInteger',
        ],

        'seo_title' => [
            'caption' => 'SEO title',
            'type'    => 'text',
        ],

        'seo_description' => [
            'caption' => 'SEO description',
            'type'    => 'textarea',
            'rows'    => '2',
        ],

        'seo_keywords' => [
            'caption' => 'SEO keywords',
            'type'    => 'text',
        ],

        'slug' => [
            'caption' => 'Url',
            'type'    => 'text',
        ],

    ],

    'filters' => [],

    'actions' => [
       'search' => [
            'caption' => 'Search',
        ],
        'insert' => [
            'caption' => 'Создать',
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
        'delete' => [
            'caption' => 'Удалить',
            'check'   => function () {
                return true;
            },
        ],
    ],
];
