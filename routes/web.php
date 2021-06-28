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

$router->group(['prefix' => "/types"], function () use ($router) {
    $router->get("/", "TypeController@index");
    $router->post("/", "TypeController@store");
    $router->put("/{id}", "TypeController@update");
    $router->delete("/{id}", "TypeController@destoy");
});

//Na rota de usuários, quando for listar, vai listar o valor salvo carteira e o tipo junto
$router->group(['prefix' => "/users"], function () use ($router) {
    $router->get("/{id}", "UserController@show");
    $router->get("/", "UserController@index");
    $router->post("/", "UserController@store");
    $router->put("/{id}", "UserController@update");
    $router->delete("/{id}", "UserController@destoy");
});

//Na rota de transação, quando for listar, irá aparecer o status da transacao junto
$router->group(['prefix' => "/transactions"], function () use ($router) {
    $router->get("/{id}", "TransactionController@show");
    $router->get("/", "TransactionController@index");
    $router->post("/", "TransactionController@store");
});
