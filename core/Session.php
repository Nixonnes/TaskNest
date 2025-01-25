<?php

namespace Core;
/**
 * Класс Session предоставляет методы для работы с сессиями.
 * Он позволяет управлять данными сессии, устанавливать и получать их,
 * а также обеспечивать возможность использования флеш-сообщений
 */
class Session
{
    public static function start() : void
    {
        session_start();
    }
    public static function set($key,$value): void
    {
        $_SESSION[$key] = $value;
    }
    public static function get($key)
    {
        return $_SESSION[$key] ?? null;
    }
    public static function remove($key): void
    {
        unset($_SESSION[$key]);
    }
    public static function clear(): void
    {
        session_unset();
    }
    public static function has($key): bool
    {
        return isset($_SESSION[$key]);
    }
    public static function flash($key, $message): void
    {
        self::set($key, $message);
    }
    public static function getFlash($key)
    {
        $message = self::get($key);
        self::remove($key);
        return $message;
    }
}