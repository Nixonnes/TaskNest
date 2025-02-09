<?php

global $router;

use App\Controllers\TaskController;
use App\Controllers\UserController;
use App\Controllers\AuthController;

$router->get('/', function() {
     (new \Core\View())->render('welcome');
}, ['GuestMiddleware']);
$router->get('/tasks', 'TaskController@index', ['AuthMiddleware']);
$router->get('/tasks/{id}', [TaskController::class, 'show']);
$router->get('/register', [AuthController::class, 'showRegisterForm']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/users', [UserController::class, 'index'], ['AuthMiddleware']);
$router->get('/login', [AuthController::class, 'showLoginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/users/{id}', [UserController::class, 'show']);