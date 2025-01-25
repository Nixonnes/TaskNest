<?php

namespace Core;

class Request
{
    public static function uri(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public static function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
    public function getParam(string $key): ?string
    {
        return $_GET[$key] ?? null;
    }
    public function getPost($key)
    {
        return $_POST[$key] ?? '';
    }
    public function getHeader($key)
    {
        return getallheaders()[$key] ?? null;
    }
    public function get()
    {
        return $_GET ?? null;
    }
    public function post()
    {
        return $_POST ?? null;
    }
    public function getHeaders(): array
    {
        return getallheaders() ?? [];
    }
    public function isPost(): bool
    {
        return $this->method() === 'POST';
    }

    public function isGet(): bool
    {
        return $this->method() === 'GET';
    }
}