<?php

namespace App\Services;

class TaskService
{
    private $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

}