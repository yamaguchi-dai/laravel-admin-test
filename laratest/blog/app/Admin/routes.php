<?php

use Illuminate\Routing\Router;

/**
 *
 */
Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('system/user',UserController::class);
    $router->resource('movie',MoviesController::class);
    $router->get('/api/users','UserController@users');
});
