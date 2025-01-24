<?php
require_once __DIR__ . '/../vendor/autoload.php';
$container = (require __DIR__ . '/../config/di.php')();
$taskService = $container->get(\App\Services\TaskService::class);
