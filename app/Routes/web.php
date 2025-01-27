<?php

global $router;

use App\Controllers\UserController;

$router->get('/', function() {
     (new \Core\View())->render('welcome');
});
$router->get('/tasks', 'TaskController@index');
$router->get('/tasks/{id}', [\App\Controllers\TaskController::class, 'show']);
$router->get('/register', [UserController::class, 'register']);
$router->get('/login', [UserController::class, 'login']);
$router->get('/users/{id}', [UserController::class, 'show']);