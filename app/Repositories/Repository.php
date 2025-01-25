<?php

namespace App\Repositories;

use Core\Database;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;

abstract class Repository
{
    protected \Core\Database $db;
    protected Container $container;

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->db = $this->container->get(Database::class);
    }
}