<?php

return [
    'db' => [
        'table' => 'roles',
        'order' => [
            'id' => 'ASC',
        ],
        'pagination' => [
            'per_page' => 20,
            'uri'      => '/admin/handle/groups',
        ],
    ],

    'options' => [
        'caption'    => 'Группы пользователей',
        'handler'    => 'Vis\Builder\Helpers\GroupsHandler',
        'model'      => 'App\Models\Group',
    ],

    'position' => [
        'tabs' => [
            'Общая'     => [
                'id',
                'slug',
                'name',
            ],
            'Права доступа' => [
                'permissions',
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
        'slug' => [
            'caption'    => 'Имя',
            'type'       => 'text',
            'filter'     => 'text',
            'is_sorting' => true,
        ],
        'name' => [
            'caption'    => 'Название',
            'type'       => 'text',
            'filter'     => 'text',
            'is_sorting' => false,
        ],
        'permissions' => [
            'caption'     => 'Доступы',
            'type'        => 'text',
            'filter'      => 'text',
            'is_sorting'  => false,
            'hide_list'   => true,
            'permissions' => [
                'admin.access' => 'Доступ в админку',
                'новости'      => [
                    'admin.access_views'  => 'Просмотр',
                    'admin.access_edit'   => 'Редактирование',
                    'admin.access_delete' => 'Удаление',
                ],
            ],
        ],

    ],

    'actions' => [
        'search' => [
            'caption' => 'Поиск',
        ],
        'insert' => [
            'caption' => 'Добавить',
        ],
        'update' => [
            'caption' => 'Редактировать',
            'check'   => function () {
                return true;
            },
        ],
        'delete' => [
            'caption' => 'Удалить',
        ],
    ],
];
