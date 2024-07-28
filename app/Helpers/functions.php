<?php

use App\Lib\Session;

if (!function_exists('view')) {
    function view($view, $data = []): void
    {
        $path = str_replace('.', '/', $view);
        extract($data);
        require VIEWS_PATH . $path . '.php';
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url): void
    {
        header("location:{$url}");
        exit();
    }
}

if (!function_exists('back')) {
    function back()
    {
        return $_SESSION['HTTP_REFERER'];
    }
}


if (!function_exists('dd')) {
    function dd(...$args)
    {
        echo "<pre>";
        var_dump(...$args);
        echo "</pre>";

        die();
    }
}

if (!function_exists('json')) {
    /**
     * Convert a given data to json string
     *
     * @param mixed $value
     * @param int $status
     * @return string|false
     */
    function json(mixed $value, int $status = 200): string|false
    {
        http_response_code($status);
        return json_encode($value);
    }
}


if (!function_exists('flash')) {
    /**
     * Flash a message for one request
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    function flash(string $key, mixed $value): void
    {
        Session::flash($key, $value);
    }
}


if (!function_exists('old')) {
    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function old(string $key, mixed $default = ''): mixed
    {
        return Session::get('old')[$key] ?? $default;
    }
}

