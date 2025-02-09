<?php

use Core\Session;
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '../../config/config.php';
require_once __DIR__ . '/../config/dotenv.php';


$container = (require __DIR__ . '/../config/di.php')();
Session::start();
$taskService = $container->get(\App\Services\TaskService::class);
$router = new \Core\Router($container, $container->get(\Core\Request::class));
$request = $container->get(\Core\Request::class);
require_once __DIR__ . '/../app/Routes/web.php';


try {
    $response = $router->dispatch(\Core\Request::method(), \Core\Request::uri());
} catch (Exception $e) {
    $response = new \Core\Response();
    $response->setContent($e->getMessage())->setStatus(404);
}
if ($response instanceof \Core\Response) {
    $response->send();
} else {
    echo $response;
}
//$router->listRoutes();
$migration = $container->get(\Core\Migration::class);
$migration->runMigrations();