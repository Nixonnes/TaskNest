<?php

namespace Core;

use Exception;

/**
 * Класс View предоставляет методы для работы с шаблонами
 */
class View
{
    protected string $viewPath;

    public function __construct($viewPath = VIEWS . '/')
    {
        $this->viewPath = $viewPath;
    }

    /**
     * Метод для отображения шаблона
     * @throws Exception
     */
    public function render(string $template, array $data=[]): void
    {
        // Проверка существования файла шаблона
        $file = $this->viewPath . str_replace('.', '/', $template) . '.php';
        if (!file_exists($file)) {
            throw new Exception("View template '$template' not found.");
        }
        // Передаем данные в шаблон
        extract($data);

        // Загружаем шаблон
        include $file;
    }
}