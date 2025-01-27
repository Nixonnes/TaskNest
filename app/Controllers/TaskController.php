<?php

namespace App\Controllers;

use App\Models\Task;
use Core\View;

class TaskController extends Controller
{
    public function __construct(Task $task,View $view)
    {
        // Родительский конструктор будет автоматически вызываться и внедрять модель
        parent::__construct($task,$view);
    }

    /**
     * @throws \Exception
     */
    public function index(): void
    {
        View::render('tasks.index', ['tasks' => '1.Сделать репозиторий']);
    }
    public function show($id): void
    {
        echo $id;
    }
}