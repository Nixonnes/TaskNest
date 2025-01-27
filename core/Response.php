<?php

namespace Core;

/**
 * Класс Response предоставляет методы для работы с HTTP-ответом.
 */
class Response
{
    protected string $content = '';
    protected int $statusCode;
    protected array $headers = [];

    public function __construct()
    {
        $this->statusCode = 200;
    }

    /**
     * Устанавливает тело ответа.
     * @param $content
     * @return $this
     */
    public function setContent($content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Добавляет HTTP-заголовок.
     * @param string $key Ключ
     * @param string $value Значение
     * @return void
     */
    public function addHeader(string $key,string $value): void
    {
        $this->headers[$key] = $value;
    }

    /**
     * Устанавливает код ответа.
     * @param int $statusCode
     * @return $this
     */
    public function setStatus(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * Отправляет заголовки и тело ответа.
     * @return void
     */
    public function send(): void
    {
        http_response_code($this->statusCode);
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }
        echo $this->content;
    }

    /**
     * Возвращает тело ответа.
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Возвращает массив заголовков.
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}