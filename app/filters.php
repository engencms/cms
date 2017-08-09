<?php
$app->router->notFound(function () {
    return '404 - Page not found';
});

$app->router->methodNotAllowed(function () {
    return '405 - Method not allowed';
});

$app->router->filter('admin_setup', function () use($app) {
    //$app->config->push('views.extensions', 'Engen\ViewExtensions\AdminExtension');
});