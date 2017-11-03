<?php

return [
    'debug' => false,

    'datetime' => [
        'timezone' => 'UTC',
    ],

    'themes' => [
        'path'  => __DIR__ . '/public/themes',
        'theme' => 'default',
    ],

    'views' => [
        'extensions' => [
            'Engen\ViewExtensions\EngenExtension',
            'Engen\ViewExtensions\PagesExtension',
            'Engen\ViewExtensions\BlocksExtension',
            'Engen\ViewExtensions\FieldsExtension',
            'Engen\ViewExtensions\MenusExtension',
            'Engen\ViewExtensions\UsersExtension',
            'Engen\ViewExtensions\FilesExtension',
        ],
    ],

    'build' => [
        'path' => __DIR__ . '/build',
        'permissions' => [
            'directiories' => 0777,
            'files' => 0666,
        ],
        'before' => [],
        'after'  => [],
    ],

    'uploads' => [
        'path' => __DIR__  . '/public/uploads',
        'uri'  => '/uploads'
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
        'App\Commands\UsersCreateCommand',
        'App\Commands\ExportCommand',
        'App\Commands\ImportCommand',
    ],
];
