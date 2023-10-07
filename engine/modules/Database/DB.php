<?php

namespace Excore\Core\Modules\Database;

use Exception;
use Excore\Core\Modules\Database\Collection;
use PDO;
use PDOStatement;

class DB
{
    private static ?DB $instance = null;
    private ?PDO $dbh = null;


    private function __construct(private array $options)
    {
        try {
            $dsn = "mysql:host={$this->options['host']};dbname={$this->options['db']};charset=utf8";
            $this->dbh = new PDO($dsn, $this->options['user'], $this->options['password']);
            $this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw new Exception("Error establishing a database connection.");
        }
    }

    public static function getInstance(array $options): self
    {
        if (!self::$instance) {
            self::$instance = new self($options);
        }
        return self::$instance;
    }


}
