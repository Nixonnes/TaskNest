<?php

return function() {
    $containerBuilder = new \DI\ContainerBuilder();

    $containerBuilder->addDefinitions([
        \App\Services\TaskService::class => \DI\autowire()->constructorParameter('repository', \DI\get(\App\Repositories\TaskRepository::class)),
        \App\Repositories\TaskRepository::class => \DI\autowire(),
        ]);
    return $containerBuilder->build();
};