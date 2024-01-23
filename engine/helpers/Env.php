<?php

namespace Excore\Core\Helpers;

use Excore\Core\Helpers\Path;

class Env
{
    protected $envFilePath;

    public function __construct(string $root)
    {
        $this->envFilePath = $root . Path::SEPARATOR . '.env';
        $this->load();
    }

    public static function init(string $root): static
    {
        return new static($root);
    }

    private function load()
    {
        if (file_exists($this->envFilePath)) {
            // Загружаем переменные окружения из файла .env
            $lines = file($this->envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                [$key, $value] = explode('=', $line, 2);
                $value = trim($value);
                putenv("$key=$value");
            }
        } else {
            // Обработка случая, когда файл .env отсутствует
            // Возможно, стоит выбрать другой способ обработки этого случая
        }
    }

    public static function get(string $key)
    {
        return getenv($key);
    }
}
