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

$router->group(['prefix' => "/users"], function () use ($router) {
    $router->get("/{id}", "UsersController@show");
    $router->get("/", "UsersController@index");
    $router->post("/", "UsersController@store");
    $router->put("/{id}", "UsersController@update");
    $router->delete("/{id}", "UsersController@destoy");
});

$router->group(['prefix' => "/transactions"], function () use ($router) {
    $router->get("/{id}", "TransactionController@show");
    $router->get("/", "TransactionController@index");
    $router->post("/", "TransactionController@store");
});


// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });
