<?php

return function() {
    $containerBuilder = new \DI\ContainerBuilder();

    $containerBuilder->addDefinitions([
        \App\Services\TaskService::class => \DI\autowire()->constructorParameter('repository', \DI\get(\App\Repositories\TaskRepository::class)),
        \App\Repositories\TaskRepository::class => \DI\autowire(),
        \Core\Request::class => \DI\autowire(),
        \Core\Response::class => \DI\autowire(),
        \Core\Router::class => \DI\autowire(),
        \App\Controllers\UserController::class => \DI\autowire(),
        \Core\Database::class => function() {
            $config = require __DIR__ . '/database.php'; // Загружаем конфигурацию
            return new \Core\Database($config['driver'],$config['host'],$config['database'],$config['username'], $config['password']); // Передаем конфигурацию в конструктор
        },
        \App\Controllers\TaskController::class => \DI\autowire(),
        \App\Models\Task::class => \DI\autowire(),
        \Core\View::class => \DI\autowire()

        ]);
    return $containerBuilder->build();
};