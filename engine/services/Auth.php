<?php


namespace Excore\Core\services;

use Excore\App\Models\User;
use Excore\Core\Core\Container;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\Session\Session;

class Auth
{
    protected static Request $request;
    protected static Session $session;
    protected static ?User $user = null;
    protected static bool $auth = false;
    private static ?self $instance = null;

    public static function init(Request $request, Session $session, ?User $user = null): self
    {
        static::$request = $request;
        static::$session = $session;
        static::$user = $user;

        if (static::$instance === null) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    public static function getInstance(): self
    {
        if (static::$instance === null) {
            static::init(Container::getInstance()->resolve('Request'), Container::getInstance()->resolve('Session'));
        }
        return static::$instance;
    }

    public static function check(): bool
    {
        return static::getInstance()->getSession()->has('user') ?? false;
    }

    public static function store(User $user): void
    {
        static::getInstance()->getSession()->set('user', $user->__serialize());
        static::$auth = true;
    }

    public static function logout(): void
    {
        static::getInstance()->getSession()->clear();
        static::$user = null;
        static::$auth = false;
    }

    public static function user(): ?User
    {
        $userData = static::getInstance()->getSession()->get('user');
        if ($userData) {
            static::$user = new User($userData);
        }

        return static::$user;
    }

    protected function getSession(): Session
    {
        return static::$session;
    }
}
