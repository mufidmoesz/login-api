<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Route untuk mendaftarkan user baru
$router->post('/register', 'AuthController@register');

// Route untuk login user
$router->post('/login', 'AuthController@login');

// Route untuk menampilkan semua data user
$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/user', 'UserController@index');
});
