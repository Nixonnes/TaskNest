<?php

namespace Core;

use Exception;
use PDO;

class Database
{
    private PDO $connection;
    private string $dbType;
    private string $host;
    private string $dbName;
    private string $username;
    private string $password;

    public function __construct(string $dbType, string $host, $dbName, string $username, $password)
    {
        $this->dbType = $dbType;
        $this->host = $host;
        $this->dbName = $dbName;
        $this->username = $username;
        $this->password = $password;

        $this->connect();
    }
    private function connect(): void
    {
        try{
            $dsn = $this->getDsn();
            $this->connection = new PDO( $dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }
    private function getDsn(): string
    {
        switch($this->dbType) {
            case 'mysql':
                return "mysql:host={$this->host};dbname={$this->dbName}";
            case 'pqsql':
                return "pgsql:host={$this->host};dbname={$this->dbName}";
            default:
                throw new Exception("Unsupported database type: {$this->dbType}");
        }
    }
    public function query(string $sql, array $params = []): false|\PDOStatement
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    public function select(string $sql, array $params = []): array
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insert(string $sql, array $params = []): int
    {
        $stmt = $this->query($sql, $params);
        return $this->connection->lastInsertId();
    }
    public function update(string $sql, array $params = []): int
    {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }
    public function delete(string $sql, array $params = []): int
    {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }
    public function beginTransaction(): void
    {
        $this->connection->beginTransaction();
    }
    public function commit(): void
    {
        $this->connection->commit();
    }
    public function rollBack(): void
    {
        $this->connection->rollBack();
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}