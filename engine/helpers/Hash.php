<?php

namespace Excore\Core\Helpers;

use Exception;
use Excore\Core\Modules\Session\Session;
use InvalidArgumentException;
use RuntimeException;


class Hash
{

    private static Session $session;

    public function __construct(Session $session)
    {
        self::$session = $session;
    }


    public static function init(Session $session)
    {
        return new static($session);
    }

    public static function uuid()
    {
        $randomBytes = [
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
        ];

        $uuid = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            ...$randomBytes
        );

        return $uuid;
    }

    public static function passwordHash(string $password)
    {
        $options = [
            'cost' => 12,
        ];

        $hash = password_hash($password, PASSWORD_BCRYPT, $options);

        if ($hash === false) {
            throw new RuntimeException('Ошибка при хешировании пароля.');
        }

        return $hash;
    }

    public static function passwordVerify(string $password, string $hash)
    {
        $verificationResult = password_verify($password, $hash);

        if ($verificationResult === false) {
            throw new RuntimeException('Ошибка при проверке пароля.');
        }

        return $verificationResult;
    }

    public static function randomInt(int $min = 5, int $max = 15): int
    {
        if ($min > $max) {
            throw new InvalidArgumentException('Минимальное значение должно быть меньше или равно максимальному значению.');
        }

        try {
            $randomInt = random_int($min, $max);
        } catch (Exception $e) {
            throw new Exception('Не удалось сгенерировать случайное число.', 0, $e);
        }

        return $randomInt;
    }


    public static function randomString(int $length = 16)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public static function generateCsrfToken()
    {
        $token = bin2hex(random_bytes(32));
        self::$session->set('csrf_token', $token);
        return $token;
    }

    public static function verifyCsrfToken($userToken)
    {
        if (!self::$session->has('csrf_token') || !hash_equals(self::$session->get('csrf_token'), $userToken)) {
            return false;
        }
        self::$session->remove('csrf_token');
        return true;
    }
}
