<?php
$adminPrefix =  $app->config->get('admin.url_prefix', 'admin');

$app->router->group(['prefix' => $adminPrefix, 'before' => 'admin_setup'], function ($router) {
    $router->get('/', 'Engen\Controllers\DashboardController@showDashboard', [
        'name' => 'engen.dashboard'
    ]);

    /**
     * Pages
     * ----------------------------------------------------
     */
    $router->group(['prefix' => 'pages'], function ($router) {
        $router->get('/', 'Engen\Controllers\PagesController@showPages', [
            'name' => 'engen.pages'
        ]);

        $router->post('/save', 'Engen\Controllers\PagesController@savePage', [
            'name' => 'engen.pages.save'
        ]);

        $router->get('/new', 'Engen\Controllers\PagesController@newPage', [
            'name' => 'engen.pages.new'
        ]);

        $router->get('/(:any)', 'Engen\Controllers\PagesController@editPage', [
            'name' => 'engen.pages.edit'
        ]);
    });

    /**
     * Menus
     * ----------------------------------------------------
     */
    $router->group(['prefix' => 'menus'], function ($router) {
        $router->get('/', 'Engen\Controllers\MenusController@showMenus', [
            'name' => 'engen.menus'
        ]);

        $router->get('/new', 'Engen\Controllers\MenusController@showNew', [
            'name' => 'engen.menus.new'
        ]);

        $router->post('/save', 'Engen\Controllers\MenusController@saveMenu', [
            'name' => 'engen.menus.save'
        ]);

        $router->post('/delete', 'Engen\Controllers\MenusController@deleteMenu', [
            'name' => 'engen.menus.delete'
        ]);

        $router->get('/(:any)', 'Engen\Controllers\MenusController@editMenu', [
            'name' => 'engen.menus.edit'
        ]);
    });

    /**
     * Settings
     * ----------------------------------------------------
     */
    $router->group(['prefix' => 'settings'], function ($router) {
        $router->get('/', 'Engen\Controllers\SettingsController@editSettings', [
            'name' => 'engen.settings'
        ]);

        $router->post('/save', 'Engen\Controllers\SettingsController@saveSettings', [
            'name' => 'engen.settings.save'
        ]);
    });

    /**
     * Files
     * ----------------------------------------------------
     */
    $router->group(['prefix' => 'files'], function ($router) {
        $router->get('/', 'Engen\Controllers\FilesController@showFiles', [
            'name' => 'engen.files'
        ]);

        $router->post('/delete', 'Engen\Controllers\FilesController@deleteFile', [
            'name' => 'engen.files.delete'
        ]);

        $router->post('/upload', 'Engen\Controllers\FilesController@upload', [
            'name' => 'engen.files.upload'
        ]);
    });


    /**
     * Actions
     * ----------------------------------------------------
     */
    $router->group(['prefix' => 'actions'], function ($router) {
        $router->post('/build', 'Engen\Controllers\BuildController@build', [
            'name' => 'engen.build'
        ]);
    });
});


/**
 * Catch all - must be the last route
 */
$app->get('/(:all)', 'App\Controllers\HomeController@generate', [
    'name' => 'home'
]);
