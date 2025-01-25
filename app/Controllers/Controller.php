<?php

namespace App\Controllers;

use App\Models\Model;
use Core\View;

abstract class Controller
{
    protected Model $model;
    protected View $view;

    public function __construct(Model $model, View $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    // Этот метод будет общим для всех контроллеров (например, вывод всех объектов модели)
    abstract public function index();
}