<?php

namespace Core;

use Exception;

/**
 * Класс View предоставляет методы для работы с шаблонами
 */
class View
{
    protected static string $viewPath;

    public function __construct($viewPath = VIEWS . '/')
    {
        static::$viewPath = $viewPath;
    }

    /**
     * Метод для отображения шаблона
     * @throws Exception
     */
    public static function render(string $template, array $data=[]): void
    {
        // Проверка существования файла шаблона
        $file = static::$viewPath . str_replace('.', '/', $template) . '.php';
        if (!file_exists($file)) {
            throw new Exception("View template '$template' not found.");
        }
        // Передаем данные в шаблон
        extract($data);

        // Загружаем шаблон
        include $file;
    }
}