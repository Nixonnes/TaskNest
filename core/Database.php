<?php

namespace Core;

use Exception;
use Monolog\Logger;
use PDO;
use PDOStatement;
use Psr\Log\LoggerInterface;

/**
 * Класс Database предоставляет методы для работы с базой данных.
 */
class Database implements DatabaseInterface
{
    private PDO $connection;
    protected DsnGenerator $dsnGenerator;
    private string $username;
    private string $password;
    private LoggerInterface $logger;

    /**
     * @throws Exception
     */
    public function __construct(string $username,string $password,DsnGenerator $dsnGenerator, LoggerInterface $logger)
    {

        $this->logger = $logger;
        $this->dsnGenerator = $dsnGenerator;
        $this->connect($username,$password);

    }

    /**
     * Подключение к базе данных.
     * @return void
     * @throws Exception
     */
    private function connect(string $username,string $password): void
    {
        try{
            $dsn = $this->getDsn();
            $this->connection = new PDO( $dsn, $username, $password);
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
        return $this->dsnGenerator->getDsn();
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
    public function select(string $sql, array $params = []): array|object
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
        $this->logger->info('Inserted data', ['sql' => $sql, 'params' => $params]);
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
    public function lastInsertId(): string
    {
        return $this->connection->lastInsertId();
    }
}