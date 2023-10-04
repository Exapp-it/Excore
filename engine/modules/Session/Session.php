<?php

namespace Excore\Core\Modules\Session;


class Session
{
    public function __construct()
    {
        session_start();
    }

    public static function init()
    {
        return new static();
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key, $defaultValue = null)
    {
        return $_SESSION[$key] ?? $defaultValue;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public function clear()
    {
        session_unset();
        session_destroy();
    }

    public function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public function getAll()
    {
        return $_SESSION;
    }

    public function regenerateId()
    {
        session_regenerate_id();
    }

    public function flash($key, $value)
    {
        $this->set($key, $value);
        $this->regenerateId();
    }
}
