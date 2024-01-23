<?php


namespace Excore\App\Services\Auth;

use Excore\App\Models\User;
use Excore\Core\Modules\Session\Session;

class Auth
{
    protected static ?bool $auth = false;
    protected static ?User $user = null;




    public static function check(): bool
    {
        return $session->has('user');
    }

    public static function store(User $user, Session $session): void
    {
        self::$user = $user;
        self::$auth = true;

        $session->set('user', $user);
    }


    public static function logout(): void
    {
        self::$user = null;
        self::$auth = false;
    }

    public static function user()
    {
        return self::$user;
    }
}
