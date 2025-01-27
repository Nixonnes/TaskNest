<?php

namespace Core;
    /**
     * Класс Session предоставляет методы для работы с сессиями.
     * Он позволяет управлять данными сессии, устанавливать и получать их,
     * а также обеспечивать возможность использования флеш-сообщений
     */
class Session
{
    /**
     * Запускает сессию
     */
    public static function start() : void
    {
        session_start();
    }

    /**
     * Устанавливает значение в сессии
     *
     * @param string $key Ключ
     * @param mixed $value Значение
     */
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key Ключ
     * @return mixed|null Значение или null, если ключ отсутствует
     */
    public static function get(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * Удаляет значение из сессии по ключу
     *
     * @param string $key Ключ
     */
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Очищает все данные сессии
     */
    public static function clear(): void
    {
        session_unset();
    }

    /**
     * Проверяет существование ключа в сессии
     *
     * @param string $key Ключ
     * @return bool true если ключ существует, false если отсутствует
     */
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Устанавливает флеш-сообщение.
     *
     * @param string $key Ключ
     * @param mixed $message Сообщение
     */
    public static function flash(string $key, mixed $message): void
    {
        self::set($key, $message);
    }

    /**
     * Получает сообщение из сессии и удаляет его.
     *
     * @param string $key Ключ
     * @return mixed|null Сообщение или null, если ключ отсутствует.
     */
    public static function getFlash(string $key): mixed
    {
        $message = self::get($key);
        self::remove($key);
        return $message;
    }
}