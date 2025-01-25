<?php

use App\Controllers\UserController;

class RouterTest extends \PHPUnit\Framework\TestCase
{
    private \Core\Router $router;
    private \DI\Container $container;

    protected function setup(): void
    {
        $this->container = new \DI\Container();
        $this->router = new \Core\Router($this->container);

        // Регистрируем маршруты для тестирования
        $this->router->get('/users/{id}', [UserController::class, 'show']);
        $this->router->get('/login', [UserController::class, 'login']);
    }
    public function testListRoutes()
    {
        // Проверим,что маршруты верно зарегистрированы
        ob_start();
        $this->router->listRoutes();
        $output = ob_get_clean();

        $this->assertStringContainsString("/users/{id}", $output);
        $this->assertStringContainsString('/login', $output);
    }
    public function testDispatchValidRoute()
    {
        // Протестируем правильную работу маршрута
        $response = $this->router->dispatch('GET', '/users/1');
        $this->assertInstanceOf(Core\Response::class, $response);
        $responseContent = $response->getContent();
        $this->assertStringContainsString('User with id 1', $responseContent);

    }
    public function testDispatchInvalidRoute()
    {
        // Протестируем неправильный маршрут
        $response = $this->router->dispatch('GET', '/non-existing');
        $this->assertEquals('404 - Not Found', $response);
    }
}