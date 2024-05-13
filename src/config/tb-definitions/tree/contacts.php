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
                'description',
                'map',
                'is_show_in_menu',
                'created_at',
                'updated_at',
            ],
            'SEO'    => [
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
        ],
        'description' => [
            'caption' => 'Текст',
            'type'    => 'wysiwyg',
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
        'created_at' => [
            'caption' => 'Дата создания',
            'type'    => 'datetime',
            'hide'    => true,
        ],
        'updated_at' => [
            'caption' => 'Дата обновления',
            'type'    => 'datetime',
            'hide'    => true,
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

    'filters' => [
    ],
];
