<?php

namespace Core;

interface RepositoryInterface
{
    public function find(int $id): ?object;
    public function findAll(): array;
    public function save(object $model): void;
    public function delete(int $id): void;

}