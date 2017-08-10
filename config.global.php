<?php

return [
    'debug' => false,

    'datetime' => [
        'timezone' => 'UTC',
    ],

    'themes' => [
        'path'  => __DIR__ . '/public/_themes',
        'theme' => 'default',
    ],

    'views' => [
        'extensions' => [
            'Engen\ViewExtensions\EngenExtension',
            'Engen\ViewExtensions\PagesExtension',
            'Engen\ViewExtensions\MenusExtension',
        ],
    ],

    'build' => [
        'path' => __DIR__ . '/build',
        'permissions' => [
            'directiories' => 0775,
            'files' => 0664,
        ],
        'before' => [],
        'after'  => [],
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
