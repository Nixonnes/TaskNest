<?php

namespace App\Repositories;

use Core\DatabaseInterface;
use Core\RepositoryInterface;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;

abstract class Repository implements RepositoryInterface
{
    protected \Core\DatabaseInterface $db;
    protected Container $container;
    protected string $table;


    public function __construct(DatabaseInterface $db)
    {

        $this->db = $db;
    }

    public function find(int $id): ?object
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE id = :id", ['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function findAll(): array
    {
        $stmt = $this->db->select("SELECT * FROM {$this->table}");
        return $stmt;
    }

    public function save(object $model): object
    {
        $data = $model->getAttributes();
        if (empty($data)) {
            throw new Exception("Нет данных для вставки в таблицу.");
        }
        if($model->id) {
            $fields = array_map(fn($key) => "$key = :$key", array_keys($data));
            $sql = "UPDATE {$this->table} SET " . implode(", ", $fields) . " WHERE id = :id";
            $data['id'] = $model->id;
        } else {
            // Создание новой записи
            $columns = implode(", ", array_keys($data));
            $placeholders = ":" . implode(", :", array_keys($data));
            $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        }
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->execute($data);
        if(!$model->id) {
            $model->id = $this->db->lastInsertId();
        }
        return $model;
    }

    public function delete(int $id): void
    {
        $this->db->delete("DELETE FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }
    public function beginTransaction(): void
    {
        $this->db->beginTransaction();
    }

    public function commit(): void
    {
        $this->db->commit();
    }

    public function rollBack(): void
    {
        $this->db->rollBack();
    }
}