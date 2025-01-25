<?php

namespace Core;

use DI\Container;
use Exception;

class Router
{
    private array $middleware = [];
    private array $routes;
    protected Container $container;
    protected Request $request;

    public function __construct(Container $container,Request $request)
    {
        $this->container = $container;
        $this->request = $request;
    }

    protected function addRoute(string $method, string $path, $action): void
    {
        $method = strtoupper($method);
        $path = preg_replace_callback('#\{([a-zA-Z0-9_]+)(?::([^\}]+))?\}#', function($matches) {
            if(isset($matches[2]) && $matches[2] != '') {
                return '(' . $matches[2] . ')';
            }
            return '([^/]+)';
},
 $path);
        if (is_string($action) && strpos($action, '@') !== false) {
            [$controller, $action] = explode('@', $action, 2); // Разделяем строку на контроллер и метод
            $action = [$controller, $action]; // Формируем массив
        }
        $this->routes[$method][] =
            ['path' =>  $path,
                'action' => $action];
    }

    public function get(string $path, $action): void
    {
        $this->addRoute('GET', $path, $action);
    }

    public function post(string $path, $action): void
    {
        $this->addRoute('POST', $path, $action);
    }

    public function put(string $path, $action): void
    {
        $this->addRoute('PUT', $path, $action);
    }

    public function delete(string $path, $action): void
    {
        $this->addRoute('DELETE', $path, $action);
    }

    public function listRoutes(): void
    {
        echo "<pre>";
        foreach ($this->routes as $method => $routes) {
            echo strtoupper($method) . " routes:\n";
            foreach ($routes as $route) {
                echo "Path: " . $route['path'] . " -> Action: ";
                echo is_array($route['action']) ? $route['action'][0] . '::' . $route['action'][1] : 'Closure';
                echo "\n";
            }
        }
        echo "</pre>";
    }


    /**
     * @throws Exception
     */
    public function dispatch(string $method, string $path)
    {
        //echo "Dispatching: Method = $method, Path = $path<br>";
        $method = strtoupper($method);
        if (!isset($this->routes[$method])) {
            throw new Exception('Method not allowed');
        }
        foreach ($this->routes[$method] as $route) {
            if (preg_match('#^' . $route['path'] . '$#', $path, $matches)) {
                array_shift($matches);
                return $this->handleActionWithParams($route['action'], $matches);
            }
        }
        throw new Exception('Route not found', 404);
    }
    private function handleActionWithParams($action, $params)
    {
        if (is_callable($action)) {
            return call_user_func_array($action, $params);
        }
        if (is_array($action) && isset($action[0], $action[1])) {
            $controller = $this->container->get('App\Controllers\\'.$action[0]);
            return call_user_func_array([$controller, $action[1]], $params);
        }
        if (is_string($action) && strpos($action, '@') !== false) {
            [$controllerClass, $method] = explode('@', $action);
            dump($controllerClass);
            // Добавляем пространство имен, если его нет
            if (!class_exists($controllerClass)) {
                $controllerClass = 'App\\Controllers\\' . $controllerClass;

            }
            // Проверяем существование класса
            if (!class_exists($controllerClass)) {
                throw new \Exception("Controller class '$controllerClass' not found");
            }
            // Получаем экземпляр контроллера из контейнера
            $controller = $this->container->get($controllerClass);
            return call_user_func_array([$controller, $method], $params);

        }
        throw new \Exception('Invalid action format'); // Если формат действия некорректный
    }
}