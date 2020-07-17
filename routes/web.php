<?php

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

$router->get('start-import', [
    'as' => 'profile', 'uses' => 'ItemsController@startImport'
]);

$router->get('/images/{file}', 'ItemsController@getImage');
$router->get('/items', 'ItemsController@getAllItems');
