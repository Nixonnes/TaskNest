<?php

namespace Core;

class Response
{
    protected string $content = '';
    protected int $statusCode;
    protected array $headers = [];

    public function __construct()
    {
        $this->statusCode = 200;
    }
    public function setContent($content): self
    {
        $this->content = $content;
        return $this;
    }
    public function addHeader(string $key,string $value): void
    {
        $this->headers[$key] = $value;
    }
    public function setStatus(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }
    public function send(): void
    {
        http_response_code($this->statusCode);
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }
        echo $this->content;
    }
    public function getContent(): string
    {
        return $this->content;
    }
}