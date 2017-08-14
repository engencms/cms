<?php
$app->router->notFound(function () {
    return '404 - Page not found';
});

$app->router->methodNotAllowed(function () {
    return '405 - Method not allowed';
});

$app->router->filter('admin_setup', function () use ($app) {
    //$app->config->push('views.extensions', 'Engen\ViewExtensions\AdminExtension');
});

$app->router->filter('engen_auth', function () use ($app) {
    if (!$app->auth->hasUser()) {
        $app->session->set('redirect', '/' . trim($app->request->currentPath(), '/'));
        return $app->routeRedirect('engen.login');
    }
});
