<?php

namespace App\Models;

use Core\Database;

/**
 * Класс Model предоставляет методы для получения и обработки данных
 */
abstract class Model
{
    protected Database $db;
    protected static array $fillable = [];
    protected static string $table = '';

    /**
     * Заполняет массив данными, которые присутствуют в массиве $fillable
     * @param array $data
     * @return array
     */
    public static function fill(array $data): array
    {
        $filteredData = array_filter($data, function($key){
            return in_array($key, static::$fillable);
        }, ARRAY_FILTER_USE_KEY);
        return $filteredData;
    }
    public function save(array $data)
    {
        $data = static::fill($data);

        $columns = implode(',', array_keys($data));
        $values = implode(',', array_map(function($value) {
            return "'$value'";
        },$data));

        $sql = "INSERT INTO " . static::$table . " ($columns) VALUES ($values)";
        return $this->db->query($sql);
    }
}