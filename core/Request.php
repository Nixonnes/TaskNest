<?php

namespace Core;
/**
 * Класс Request предоставляет методы для работы с запросами.
 * Он позволяет получить URI, метод запроса, параметры запроса, заголовки и тело запроса
 */
class Request
{
    private array $data = [];

    public function __construct()
    {
        $this->data = array_merge($_GET, $_POST);

        // Если запрос JSON, декодируем его
        if ($this->isJson()) {
            $jsonData = json_decode(file_get_contents('php://input'), true);
            if (is_array($jsonData)) {
                $this->data = array_merge($this->data, $jsonData);
            }
        }
    }

    /**
     * @return string URI запроса
     */
    public static function uri(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    /**
     * @return string Метод запроса
     */
    public static function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Возвращает параметр запроса по ключу
     * @param string $key Ключ
     * @return string|null
     */
    public function getParam(string $key): ?string
    {
        return $_GET[$key] ?? null;
    }

    /**
     * Получает значение из массива $_POST по ключу
     * @param string $key Ключ
     * @return mixed|string
     */
    public function getPost(string $key): mixed
    {
        return $_POST[$key] ?? '';
    }

    /**
     * Получает заголовок по ключу
     * @param string $key Ключ
     * @return mixed|null
     */
    public function getHeader(string $key): mixed
    {
        return getallheaders()[$key] ?? null;
    }

    /**
     * Возвращает массив параметров GET запроса
     * @return array|null
     */
    public function get(): ?array
    {
        return $_GET ?? null;
    }
    /**
     * Возвращает массив параметров POST запроса
     * @return array|null
     */
    public function post(): ?array
    {
        return $_POST ?? null;
    }

    /**
     * Возвращает массив заголовков
     * @return array
     */
    public function getHeaders(): array
    {
        return getallheaders() ?? [];
    }

    /**
     * Проверяет, является ли запрос POST
     * @return bool
     */
    public function isPost(): bool
    {
        return static::method() === 'POST';
    }

    /**
     * Проверяет, является ли запрос GET
     * @return bool
     */
    public function isGet(): bool
    {
        return static::method() === 'GET';
    }
    private function isJson(): bool
    {
        return isset($_SERVER['CONTENT_TYPE']) && str_contains($_SERVER['CONTENT_TYPE'], 'application/json');
    }
    public function all(): array
    {
        return $this->data;
    }
}