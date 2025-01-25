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
    public function index(): void
    {
        View::render('tasks.index');
    }
    public function show($id)
    {
        echo $id;
    }
}