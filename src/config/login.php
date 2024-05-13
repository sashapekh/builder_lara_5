<?php

return [

    'is_active_remember_me' => false,

    'background_url' => '/packages/vis/builder/img/vis-admin-lock.jpg',

    'email_support' => 'support@vis-design.com',

    'bottom_block' => '',

    // callbacks
    'on_login' => function () {
        return \Redirect::to('/admin/tree');
    },
    'on_logout' => function () {
        return \Redirect::to('/');
    },
];
