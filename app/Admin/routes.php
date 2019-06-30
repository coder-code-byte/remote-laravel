<?php

use Encore\Admin\Controllers\AuthController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->resource('auth/users', 'App\Admin\Controllers\Rewrite\UserController')->names('admin.auth.users');
    $router->resource('auth/roles', '\Encore\Admin\Controllers\RoleController')->names('admin.auth.roles');
    $router->resource('auth/permissions', '\Encore\Admin\Controllers\PermissionController')->names('admin.auth.permissions');
    $router->resource('auth/menu', 'App\Admin\Controllers\Rewrite\MenuController', ['except' => ['create']])->names('admin.auth.menu');
    $router->resource('auth/logs', '\Encore\Admin\Controllers\LogController', ['only' => ['index', 'destroy']])->names('admin.auth.logs');

    $router->post('_handle_form_', '\Encore\Admin\Controllers\HandleController@handleForm')->name('admin.handle-form');
    $authController = config('admin.auth.controller', AuthController::class);

    /* @var \Illuminate\Routing\Router $router */
    $router->get('auth/login', $authController.'@getLogin')->name('admin.login');
    $router->post('auth/login', $authController.'@postLogin');
    $router->get('auth/logout', $authController.'@getLogout')->name('admin.logout');
    $router->get('auth/setting', $authController.'@getSetting')->name('admin.setting');
    $router->put('auth/setting', $authController.'@putSetting');
});
Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

});
