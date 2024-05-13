<?php

return [
    'db' => [
        'table' => 'users',
        'order' => [
            'created_at' => 'DESC',
        ],
        'pagination' => [
            'per_page' => 20,
            'uri'      => '/admin/users',
        ],
    ],
    'options' => [
        'caption'    => 'Пользователи',
        'handler'    => 'Vis\Builder\Helpers\UsersHandler',
        'model'      => 'App\Models\User',
    ],
    'position' => [
        'tabs' => [
            'Общая'     => [
                'id',
                'email',
                'password',
                'last_name',
                'first_name',
                'activated',
                'created_at',
                'last_login',
            ],
            'Фото' => [
                'image',
            ],
            'Группа' => [
                'many2many_groups',
            ],
        ],
    ],
    'fields' => [
        'id' => [
            'caption' => '#',
            'type'    => 'readonly',
            'class'   => 'col-id',
            'width'   => '1%',
            'hide'    => true,
        ],
        'email' => [
            'caption'     => 'Email',
            'type'        => 'text',
            'filter'      => 'text',
            'is_sorting'  => true,
            'placeholder' => 'Email',
            'validation'  => [
                'server' => [
                    'rules'    => 'required|email',
                    'messages' => [
                        'required' => 'Обязательно к заполнению',
                        'unique'   => 'Пользователь с таким емейлом уже существует',
                    ],
                    'ignore_this_id' => 'users',
                ],
                'client' => [
                    'rules' => [
                        'required' => true,
                        'email'    => true,
                    ],
                    'messages' => [
                        'required' => 'Обязательно к заполнению',
                        'email'    => 'Неправильный e-mail',
                    ],
                ],
            ],
        ],
        'password' => [
            'caption'     => 'Пароль',
            'type'        => 'text',
            'hide_list'   => true,
            'placeholder' => 'Введите пароль',
            'is_password' => true,
            'validation'  => [
                'server' => [
                    'rules' => 'required|min:6',
                ],
                'client' => [
                    'rules' => [
                        'required'  => true,
                        'minlength' => 6,
                    ],
                    'messages' => [
                        'required'  => 'Обязательно к заполнению',
                        'minlength' => 'Пароль долже быть минимум 6-ь символов',
                    ],
                ],
            ],
        ],
        'last_name' => [
            'caption'     => 'Фамилия',
            'type'        => 'text',
            'filter'      => 'text',
            'placeholder' => 'Фамилия',
            'is_sorting'  => true,
            'validation'  => [
                'server' => [
                    'rules' => 'required',
                ],
                'client' => [
                    'rules' => [
                        'required' => true,
                    ],
                    'messages' => [
                        'required' => 'Обязательно к заполнению',
                    ],
                ],
            ],
        ],
        'first_name' => [
            'caption'     => 'Имя',
            'type'        => 'text',
            'filter'      => 'text',
            'is_sorting'  => true,
            'placeholder' => 'Имя',
            'validation'  => [
                'server' => [
                    'rules' => 'required',
                ],
                'client' => [
                    'rules' => [
                        'required' => true,
                    ],
                    'messages' => [
                        'required' => 'Обязательно к заполнению',
                    ],
                ],
            ],
        ],

        'image' => [
            'caption'      => 'Фото',
            'type'         => 'image',
            'storage_type' => 'image', // image|tag|gallery
            'img_height'   => '50px',
            'is_upload'    => true,
            'is_null'      => true,
            'is_remote'    => false,
            'hide_list'    => true,
        ],
        'last_login' => [
            'caption'    => 'Дата последнего входа',
            'type'       => 'readonly',
            'is_sorting' => true,
            'months'     => 2,
        ],
        'activated' => [
            'caption' => 'Активен',
            'type'    => 'checkbox',
            'options' => [
                1 => 'Активные',
                0 => 'He aктивные',
            ],
            'is_sorting' => false,
        ],
        'created_at' => [
            'caption'    => 'Дата регистрации',
            'type'       => 'readonly',
            'is_sorting' => true,
            'months'     => 2,
        ],
        'updated_at' => [
            'caption'    => 'Дата обновления',
            'type'       => 'readonly',
            'hide'       => true,
            'is_sorting' => true,
            'months'     => 2,
            'hide_list'  => true,
        ],

        'many2many_groups' => [
            'caption'                        => 'Группы',
            'type'                           => 'many_to_many',
            'show_type'                      => 'select2',
            'hide_list'                      => true,
            'mtm_table'                      => 'role_users',
            'mtm_key_field'                  => 'user_id',
            'mtm_external_foreign_key_field' => 'id',
            'mtm_external_key_field'         => 'role_id',
            'mtm_external_value_field'       => 'name',
            'mtm_external_table'             => 'roles',
        ],
    ],
    'export' => [
        'caption'          => 'Экспорт',
        'filename'         => 'exp',
        'width'            => '300',
        'date_range_field' => 'created_at',
        'buttons'          => [
            'xls' => [
                'caption' => 'в XLS',
            ],
            'csv' => [
                'caption'   => 'в CSV',
                'delimiter' => ';',
            ],
        ],
        'check' => function () {
            return true;
        },
    ],

    'actions' => [
        'search' => [
            'caption' => 'Поиск',
        ],
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
        'delete' => [
            'caption' => 'Удалить',
        ],
    ],
];
