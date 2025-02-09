<?php

use App\Controllers\TaskController;
use App\Controllers\UserController;
use App\Models\Task;
use App\Repositories\TaskRepository;
use App\Services\TaskService;
use Core\Database;
use Core\DatabaseInterface;
use Core\Migration;
use Core\MysqlDsnGenerator;
use Core\Request;
use Core\Response;
use Core\Router;
use Core\Validation\UniqueRule;
use Core\Validation\Validator;
use Core\View;
use DI\ContainerBuilder;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use function DI\autowire;
use function DI\get;

return function() {
    $containerBuilder = new ContainerBuilder();

    $containerBuilder->addDefinitions([
        TaskService::class => autowire()->constructorParameter('repository', get(TaskRepository::class)),

        LoggerInterface::class => function () {
            $logger = new Logger('app');
            $logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/app.log', Logger::DEBUG));
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
            $logger = $container->get(LoggerInterface::class);
            $config = require __DIR__ . '/database.php'; // Загружаем конфигурацию

            // Создаём объект MysqlDsnGenerator
            $dsnGenerator = new \Core\MysqlDsnGenerator($config['host'], $config['database']);

            return new Database(
                $config['username'],
                $config['password'],
                $dsnGenerator, // Передаем объект DsnGenerator
                $logger
            );
        }, // Убедитесь, что путь правильный

        DatabaseInterface::class => \DI\get(Core\Database::class),
        TaskRepository::class => autowire(),
        Request::class => autowire(),
        Response::class => autowire(),
        Router::class => autowire(),
        UserController::class => autowire(),
        Task::class => autowire(),
        View::class => autowire(),
        Migration::class => autowire(),
        App\Repositories\UserRepository::class => \DI\autowire(),
        Validator::class => \DI\autowire(),
        TaskController::class => autowire(),
        UniqueRule::class => \DI\autowire()->constructorParameter('db', \DI\get(DatabaseInterface::class)),
        \Core\Validation\EmailRule::class => \DI\autowire(),
        \Core\Validation\MinRule::class => \DI\autowire(),
        \Core\Validation\RequiredRule::class => \DI\autowire(),

        \App\Services\AuthService::class => \DI\autowire(),
    ]);

    return $containerBuilder->build();
};