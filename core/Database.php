<?php

namespace Core;

use Exception;
use Monolog\Logger;
use PDO;
use PDOStatement;

/**
 * Класс Database предоставляет методы для работы с базой данных.
 */
class Database implements DatabaseInterface
{
    private PDO $connection;
    private string $dbType;
    private string $host;
    private string $dbName;
    private string $username;
    private string $password;
    private Logger $logger;

    public function __construct(string $dbType, string $host, $dbName, string $username, $password,Logger $logger)
    {
        $this->dbType = $dbType;
        $this->host = $host;
        $this->dbName = $dbName;
        $this->username = $username;
        $this->password = $password;
        $this->logger = $logger;
        $this->connect();
    }

    /**
     * Подключение к базе данных.
     * @return void
     * @throws Exception
     */
    private function connect(): void
    {
        try{
            $dsn = $this->getDsn();
            $this->connection = new PDO( $dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->logger->info('Соединение с базой данных установлено.');
        } catch (Exception $e) {
            $this->logger->error('Ошибка подключения к базе данных: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Возвращает строку подключения к базе данных.
     * @throws Exception
     */
    private function getDsn(): string
    {
        switch($this->dbType) {
            case 'mysql':
                return "mysql:host=$this->host;dbname=$this->dbName";
            case 'pqsql':
                return "pgsql:host=$this->host;dbname=$this->dbName";
            default:
                throw new Exception("Unsupported database type: $this->dbType");
        }
    }

    /**
     * Выполняет запрос.
     * @param string $sql
     * @param array $params
     * @return false|PDOStatement
     */
    public function query(string $sql, array $params = []): false|PDOStatement
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Выполняет запрос и возвращает все строки.
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function select(string $sql, array $params = []): array
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Выполняет запрос и возвращает одну строку.
     * @param string $sql
     * @param array $params
     * @return int
     */
    public function insert(string $sql, array $params = []): int
    {
        $stmt = $this->query($sql, $params);
        return $this->connection->lastInsertId();
    }

    /**
     * Выполняет запрос и возвращает количество обновленных строк.
     * @param string $sql
     * @param array $params
     * @return int
     */
    public function update(string $sql, array $params = []): int
    {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    /**
     * Выполняет запрос и возвращает количество удаленных строк.
     * @param string $sql
     * @param array $params
     * @return int
     */
    public function delete(string $sql, array $params = []): int
    {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    /**
     * Начинает транзакцию.
     * @return void
     */
    public function beginTransaction(): void
    {
        $this->connection->beginTransaction();
    }

    /**
     * Фиксирует изменения в базе данных.
     * @return void
     */
    public function commit(): void
    {
        $this->connection->commit();
    }

    /**
     * Откатывает изменения в базе данных.
     * @return void
     */
    public function rollBack(): void
    {
        $this->connection->rollBack();
    }

    /**
     * Возвращает объект PDO.
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }
}