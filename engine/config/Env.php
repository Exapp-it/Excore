<?php

namespace Excore\Core\Config;


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
            $lines = file($this->envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                list($key, $value) = explode('=', $line, 2);
                $value = trim($value);
                putenv("$key=$value");
            }
        }
    }

    public static function get(string $key)
    {
        return getenv($key);
    }
}
