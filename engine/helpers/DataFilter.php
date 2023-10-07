<?php

namespace Excore\Core\Helpers;

use Psr\Log\InvalidArgumentException;

class DataFilter
{
    public static function sanitizeString($value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException("Ожидалась строка, получен " . gettype($value));
        }

        $filteredValue = strip_tags($value);
        $filteredValue = trim($filteredValue);
        $filteredValue = htmlspecialchars($filteredValue, ENT_QUOTES, 'UTF-8');

        return $filteredValue;
    }

    public static function sanitizeEmail($value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException("Ожидалась строка, получен " . gettype($value));
        }

        $filteredValue = filter_var($value, FILTER_SANITIZE_EMAIL);

        return $filteredValue;
    }

    public static function sanitizeInteger($value)
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException("Ожидалось числовое значение, получен " . gettype($value));
        }

        $filteredValue = filter_var($value, FILTER_SANITIZE_NUMBER_INT);

        return $filteredValue;
    }

    public static function sanitizeFloat($value)
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException("Ожидалось числовое значение, получен " . gettype($value));
        }

        $filteredValue = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        return $filteredValue;
    }

    public static function sanitizeUrl($value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException("Ожидалась строка, получен " . gettype($value));
        }

        $filteredValue = filter_var($value, FILTER_SANITIZE_URL);

        return $filteredValue;
    }
}
