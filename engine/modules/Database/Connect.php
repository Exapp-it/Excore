<?php

namespace Excore\Core\Modules\Database;

use PDO;
use PDOException;

class Connect
{

    private PDO $pdo;


    public function __construct(
        private string $host,
        private string $username,
        private string $password,
        private string $dbname,
        private string $charset,

    ) {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";

        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            exit("Database connection failed: " . $e->getMessage());
        }
    }

    public function usePDO()
    {
        return $this->pdo;
    }
}
