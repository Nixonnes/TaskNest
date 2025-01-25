<?php

global $router;

use App\Controllers\UserController;

$router->get('/', function() {
    return 'Hello, world!';
});
$router->get('/users', 'UserController@index');
$router->get('/register', [UserController::class, 'register']);
$router->get('/login', [UserController::class, 'login']);
$router->get('/users/{id}', [UserController::class, 'show']);