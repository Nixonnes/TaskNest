<?php

use App\Controllers\UserController;
use Core\Router;
use DI\Container;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private Router $router;
    private Container $container;

    protected function setup(): void
    {
        $this->container = new Container();
        $this->request = $this->container->get('Core\Request');
        $this->router = new Router($this->container, $this->request);

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

    /**
     * @throws Exception
     */
    public function testDispatchValidRoute()
    {
        // Протестируем правильную работу маршрута
        $response = $this->router->dispatch('GET', '/users/1');
        $this->assertInstanceOf(Core\Response::class, $response);
        $responseContent = $response->getContent();
        $this->assertStringContainsString('User with id 1', $responseContent);

    }

    /**
     * @throws Exception
     */
    public function testDispatchInvalidRoute()
    {
        // Протестируем неправильный маршрут
        $response = $this->router->dispatch('GET', '/non-existing');
        $this->assertEquals('404 - Not Found', $response);
    }
}