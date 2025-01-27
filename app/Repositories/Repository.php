<?php

namespace App\Repositories;

use Core\Database;
use Core\DatabaseInterface;
use Core\RepositoryInterface;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use PDO;

abstract class Repository implements RepositoryInterface
{
    protected \Core\Database $db;
    protected Container $container;
    protected string $table;

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->db = $this->container->get(DatabaseInterface::class);
    }

    public function find(int $id): ?object
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE id = :id", ['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function findAll(): array
    {
        $stmt = $this->db->select("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    public function save(object $model): void
    {
        $propepties = get_object_vars($model);
        $reflect = new \ReflectionObject($model);
        foreach($reflect->getProperties() as $property) {
            $property->setAccessible(true);
            $propepties[$property->getName()] = $property->getValue($model);
        }
        $columns = implode(',', array_keys($propepties));
        $values = implode(',', array_map(fn($key) => ":$key", array_keys($propepties)));

        if (isset($propepties['id'])) {
            // Обновление записи
            $updates = [];
            foreach ($propepties as $key => $value) {
                if ($key !== 'id') {
                    $updates[] = "$key = :$key";
                }
            }
            $updatesString = implode(',', $updates);
            $stmt = $this->db->update("UPDATE {$this->table} SET $updatesString WHERE id = :id", $propepties);
        } else {
            $stmt = $this->db->insert("INSERT INTO {$this->table} ($columns) VALUES ($values)", $propepties);
        }

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