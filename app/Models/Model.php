<?php

namespace App\Models;

/**
 * Класс Model предоставляет методы для получения и обработки данных
 */
abstract class Model
{
    protected array $fillable = [];
    protected array $attributes = [];
    protected ?int $id = null;
    protected static string $table = '';


    /**
     * Заполняет массив данными, которые присутствуют в массиве $fillable
     * @param array $data
     * @return Model
     */
    public function fill(array $attributes): Model
    {
        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $this->attributes[$key] = $value;
            }
        }
        return $this;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getAttribute($name): string
    {
        return $this->getAttributes()[$name];
    }
    public function setAttribute($name, $value): void
    {
        $this->attributes[$name] = $value;
    }
    public function getId()
    {
        return $this->id;
    }
}