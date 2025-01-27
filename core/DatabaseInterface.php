<?php

namespace Core;

interface DatabaseInterface
{
    public function query(string $sql, array $params = []): false|\PDOStatement;
    public function select(string $sql, array $params = []): array;
    public function insert(string $sql, array $params = []): int;
    public function update(string $sql, array $params = []): int;
    public function delete(string $sql, array $params = []): int;
    public function beginTransaction(): void;
    public function commit(): void;
    public function rollBack(): void;
}