<?php

return [
    'debug' => false,

    'datetime' => [
        'timezone' => 'UTC',
    ],

    'theme' => 'default',

    'views' => [
        'extensions' => [
            'Engen\ViewExtensions\EngenExtension',
            'Engen\ViewExtensions\PagesExtension',
            'Engen\ViewExtensions\MenusExtension',
        ],
    ],

    'providers' => [
        'Enstart\ServiceProvider\ServiceProvider',
        'Engen\ServiceProvider',
        'App\Providers\AppProvider',
    ],

    'logging' => [
        'name'  => 'engen',
        'level' => 'error',
        'file'  => __DIR__ . '/data/logs/' . date('Ymd') . '.log',
    ],

    'commands' => [
        'App\Commands\BuildCommand',
    ],
];
