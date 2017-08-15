<?php

$adminPrefix =  $app->config->get('admin.url_prefix', 'admin');

$app->router->group(['prefix' => $adminPrefix, 'before' => 'admin_setup'], function ($router) {

    $router->get('/login', 'Engen\Controllers\AuthController@showLogin', [
        'name' => 'engen.login'
    ]);

    $router->post('/login', 'Engen\Controllers\AuthController@login', [
        'name' => 'engen.login.do'
    ]);


    $router->group(['before' => 'engen_auth'], function ($router) {
        $router->get('/', 'Engen\Controllers\DashboardController@showDashboard', [
            'name' => 'engen.dashboard'
        ]);

        $router->get('/logout', 'Engen\Controllers\AuthController@logout', [
            'name' => 'engen.logout'
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

            // Slugify the page slug
            $router->get('/slugify-slug', 'Engen\Controllers\PagesController@slugifySlug', [
                'name' => 'engen.pages.slugify.slug'
            ]);

            // Slugify the page key
            $router->get('/slugify-key', 'Engen\Controllers\PagesController@slugifyKey', [
                'name' => 'engen.pages.slugify.key'
            ]);

            $router->post('/preview', 'App\Controllers\HomeController@preview', [
                'name' => 'engen.pages.preview'
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
         * Users
         * ----------------------------------------------------
         */
        $router->group(['prefix' => 'users'], function ($router) {
            $router->get('/', 'Engen\Controllers\UsersController@showUsers', [
                'name' => 'engen.users'
            ]);

            $router->get('/new', 'Engen\Controllers\UsersController@showNew', [
                'name' => 'engen.users.new'
            ]);

            $router->post('/save', 'Engen\Controllers\UsersController@saveUser', [
                'name' => 'engen.users.save'
            ]);

            $router->post('/delete', 'Engen\Controllers\UsersController@deleteUser', [
                'name' => 'engen.users.delete'
            ]);

            $router->get('/(:any)', 'Engen\Controllers\UsersController@editUser', [
                'name' => 'engen.users.edit'
            ]);
        });

        /**
         * Blocks
         * ----------------------------------------------------
         */
        $router->group(['prefix' => 'block'], function ($router) {
            $router->get('/', 'Engen\Controllers\BlocksController@showBlocks', [
                'name' => 'engen.blocks'
            ]);

            $router->post('/save', 'Engen\Controllers\BlocksController@saveBlock', [
                'name' => 'engen.blocks.save'
            ]);

            $router->get('/new', 'Engen\Controllers\BlocksController@newBlock', [
                'name' => 'engen.blocks.new'
            ]);

            $router->get('/slugify-key', 'Engen\Controllers\BlocksController@slugifyKey', [
                'name' => 'engen.blocks.slugify.key'
            ]);

            $router->get('/(:any)', 'Engen\Controllers\BlocksController@editBlock', [
                'name' => 'engen.blocks.edit'
            ]);
        });

        /**
         * Actions
         * ----------------------------------------------------
         */
        $router->group(['prefix' => 'actions'], function ($router) {
            // Build the static site
            $router->post('/build', 'Engen\Controllers\BuildController@build', [
                'name' => 'engen.build'
            ]);
        });
    });
});


/**
 * Catch all - must be the last route
 */
$app->get('/(:all)', 'App\Controllers\HomeController@generate', [
    'name' => 'home'
]);
