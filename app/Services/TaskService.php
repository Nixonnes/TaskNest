<?php

namespace App\Services;

use App\Repositories\TaskRepository;

class TaskService
{
    private  TaskRepository $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

}