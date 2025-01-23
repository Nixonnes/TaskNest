<?php


$router->get('/register', [UserController::class, 'register']);
$router->get('/login', [UserController::class, 'login']);