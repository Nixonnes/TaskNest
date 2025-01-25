<?php

namespace Core;

class View
{
    protected static string $viewPath;

    public function __construct($viewPath = VIEWS . '/')
    {
        static::$viewPath = $viewPath;
    }

    public static function render(string $template, array $data=[])
    {
        // Проверка существования файла шаблона
        $file = static::$viewPath . str_replace('.', '/', $template) . '.php';
        if (!file_exists($file)) {
            throw new \Exception("View template '$template' not found.");
        }
        // Передаем данные в шаблон
        extract($data);

        // Загружаем шаблон
        include $file;
    }
}