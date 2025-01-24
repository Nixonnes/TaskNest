<?php

namespace core;

use DI\Container;

class Router
{
    protected array $routes;
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

}