<?php

namespace App\Lib;

class Session
{
    /**
     * Check if session has a specific key
     *
     * @param $key
     * @return bool
     */
    public static function has($key): bool
    {
        return (bool)static::get($key);
    }

    /**
     * Add a key and value to session
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function put(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get a value from session
     *
     * @param string $key
     * @param $default
     * @return mixed|null
     */
    public static function get(string $key, $default = null): mixed
    {
        return $_SESSION['_flash'][$key] ?? $_SESSION[$key] ?? $default;
    }

    /**
     * Flash a message for one request
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function flash(string $key, mixed $value): void
    {
        $_SESSION['_flash'][$key] = $value;
    }

    /**
     * Remove flash messages
     *
     * @return void
     */
    public static function unflash(): void
    {
        unset($_SESSION['_flash']);
    }
}