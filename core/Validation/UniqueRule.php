<?php

namespace Core\Validation;

use Core\Database;
use Core\DatabaseInterface;

class UniqueRule implements ValidationRuleInterface
{
    private DatabaseInterface $db;
    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }
    public function validate(string $field, mixed $value, array|string $params = []): ?string
    {
        if (is_array($params) && count($params) > 0) {
            $table = $params[0];  // Имя таблицы передается в $params[0]
        } else if(is_string($params)) {
            $params = explode(',', $params);
            $table = $params[0];
        }
        else
        {
            return "Invalid table parameter"; // Если таблица не передана
        }

        // Подготовленный запрос для уникальности значения
        $sql = "SELECT COUNT(*) FROM {$table} WHERE {$field} = :value";
        // Подготовка и выполнение запроса
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':value', $value);
        $stmt->execute();

        // Проверка, если количество записей больше 0, значит, значение не уникально
        if ($stmt->fetchColumn() > 0) {
            return "Поле {$field} должно быть уникальным.";
        }

        return null;
    }
}