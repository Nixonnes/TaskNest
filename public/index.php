<?php
require_once __DIR__ . '/../vendor/autoload.php';
$container = (require __DIR__ . '/../config/di.php')();
$taskService = $container->get(\App\Services\TaskService::class);
$router = new \Core\Router($container);
require_once __DIR__ . '/../app/Routes/web.php';

try {
    dump($_SERVER['REQUEST_URI']);
    $response = $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
} catch (Exception $e) {
    $response = new \Core\Response();
    $response->setContent($e->getMessage())->setStatus(404);
}
if ($response instanceof \Core\Response) {
    $response->send();
} else {
    echo $response;
}
$router->listRoutes();