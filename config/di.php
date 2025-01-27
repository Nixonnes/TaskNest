<?php

use App\Controllers\TaskController;
use App\Controllers\UserController;
use App\Models\Task;
use App\Repositories\TaskRepository;
use App\Services\TaskService;
use Core\Database;
use Core\DatabaseInterface;
use Core\Migration;
use Core\Request;
use Core\Response;
use Core\Router;
use Core\View;
use DI\ContainerBuilder;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use function DI\autowire;
use function DI\get;

return function() {
    $containerBuilder = new ContainerBuilder();

    $containerBuilder->addDefinitions([
        TaskService::class => autowire()->constructorParameter('repository', get(TaskRepository::class)),
        TaskRepository::class => autowire(),
        Request::class => autowire(),
        Response::class => autowire(),
        Router::class => autowire(),
        UserController::class => autowire(),
        Logger::class => function() {
            $logger = new Logger('app');
            $logPath = __DIR__ . '/logs/app.log';

            // Ротация логов (хранить 7 дней)
            $logger->pushHandler(new RotatingFileHandler($logPath, 7, Logger::DEBUG));

            return $logger;
        },
        PDO::class => function() {
            $config = require __DIR__ . '/database.php'; // Загружаем конфигурацию

            $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']}";
            return new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        },
        Database::class => function($container) {
        $logger = $container->get(Logger::class);
            $config = require __DIR__ . '/database.php'; // Загружаем конфигурацию
            return new Database($config['driver'],$config['host'],$config['database'],$config['username'], $config['password'], $logger); // Передаем конфигурацию в конструктор
        },
        TaskController::class => autowire(),
        Task::class => autowire(),
        View::class => autowire(),
        Migration::class => function(PDO $pdo) {
            return new Migration($pdo);
        },
        DatabaseInterface::class => get(Database::class),
// Добавляем логгер

        ]);
    return $containerBuilder->build();
};