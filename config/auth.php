<?php
/*
 * @Author: arvinlp 
 * @Date: 2019-12-28 23:17:48 
 * Copyright by Arvin Loripour 
 * WebSite : http://www.arvinlp.ir 
 * @Last Modified by: Arvin.Loripour
 * @Last Modified time: 2019-12-29 00:01:37
 */

return [
    'defaults' => [
        'guard' => 'company',
        'passwords' => 'users',
    ],

    'guards' => [
        'company' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
        'chival' => [
            'driver' => 'jwt',
            'provider' => 'admins',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => \App\User::class
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model' => \App\Admin::class
        ]
    ]
];