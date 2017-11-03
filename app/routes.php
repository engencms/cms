<?php

/**
 * Catch all - must be the last route
 */
$app->get('/(:all)', 'App\Controllers\HomeController@generate', [
    'name' => 'home'
]);
