<?php

namespace Core;

use DI\Container;
use Exception;

class Router
{
    private array $routes;
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
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
        $this->routes[$method][] = ['path' =>  $path, 'action' => $action];
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

                // Проверка типа action и вывод
                if (is_array($route['action'])) {
                    // Это контроллер и метод
                    echo $route['action'][0] . '::' . $route['action'][1];
                } elseif ($route['action'] instanceof \Closure) {
                    // Это замыкание
                    echo 'Closure';
                } else {
                    echo 'Unknown action';
                }
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
        if(is_callable($action))
        {
            return call_user_func_array($action, $params);
        }
        if(is_array($action) && isset($action[0],$action[1]))
        {
            $controller = new $action[0];
            return call_user_func_array([$controller, $action[1]], $params);
        }

    }

}