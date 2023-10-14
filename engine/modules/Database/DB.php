<?php

namespace Excore\Core\Modules\Database;

use Excore\Core\Modules\Database\Exceptions\DatabaseException;
use PDO;
use PDOException;
use PDOStatement;

class DB
{
    private static ?DB $instance = null;
    private ?PDO $pdo = null;
    private bool $isConnected = false;
    private ?PDOStatement $statement;

    private function __construct(array $options)
    {
        try {
            $dsn = "mysql:host={$options['host']};dbname={$options['db']};charset=utf8";
            $this->pdo = new PDO($dsn, $options['user'], $options['password']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->isConnected = true;
        } catch (PDOException $e) {
            throw new DatabaseException("Error establishing a database connection: " . $e->getMessage());
        }
    }

    public static function getInstance(array $options): self
    {
        if (!self::$instance) {
            self::$instance = new self($options);
        }
        return self::$instance;
    }

    public function query(string $query, array $parameters = [], $mode = PDO::FETCH_OBJ)
    {
        $this->initConnection();
        $this->initStatement($query);
        $this->bindParameters($parameters);


        try {
            $this->statement->execute();
        } catch (PDOException $e) {
            throw new DatabaseException("Error executing the query: " . $e->getMessage());
        }

        return $this->handleQueryResult($mode);
    }

    public function execute(string $query, array $parameters = [])
    {
        $this->initConnection();
        $this->initStatement($query);
        $this->bindParameters($parameters);

        try {
            $this->statement->execute();
        } catch (PDOException $e) {
            throw new DatabaseException("Error executing the query: " . $e->getMessage());
        }
    }

    public function fetch(string $query, array $parameters = [], $mode = PDO::FETCH_OBJ)
    {
        return $this->query($query, $parameters, $mode);
    }

    public function fetchAll(string $query, array $parameters = [], $mode = PDO::FETCH_OBJ)
    {
        return $this->query($query, $parameters, $mode);
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    public function paginate(string $query, int $page, int $perPage, array $parameters = [], $mode = PDO::FETCH_OBJ)
    {
        $offset = ($page - 1) * $perPage;
        $query .= " LIMIT :limit OFFSET :offset";
        $parameters['limit'] = $perPage;
        $parameters['offset'] = $offset;

        return $this->query($query, $parameters, $mode);
    }

    public function closeConnection()
    {
        $this->pdo = null;
        $this->isConnected = false;
    }

    public function beginTransaction()
    {
        $this->initConnection();

        if (!$this->pdo->inTransaction()) {
            $this->pdo->beginTransaction();
        }
    }

    public function commit()
    {
        $this->initConnection();

        if ($this->pdo->inTransaction()) {
            $this->pdo->commit();
        } else {
            throw new DatabaseException("No active transaction to commit.");
        }
    }

    public function rollback()
    {
        $this->initConnection();

        if ($this->pdo->inTransaction()) {
            $this->pdo->rollback();
        } else {
            throw new DatabaseException("No active transaction to rollback.");
        }
    }

    public function isConnected(): bool
    {
        return $this->isConnected;
    }

    public function getPDO(): PDO
    {
        $this->initConnection();
        return $this->pdo;
    }

    public function getLastPDOError(): ?string
    {
        return $this->pdo ? $this->pdo->errorInfo()[2] : null;
    }

    private function initConnection()
    {
        if (!$this->isConnected) {
            throw new DatabaseException("Database connection is not established.");
        }
    }

    private function initStatement(string $query)
    {
        try {
            $this->statement = $this->pdo->prepare($query);
        } catch (PDOException $e) {
            throw new DatabaseException("Error preparing the query: " . $e->getMessage());
        }
    }

    private function bindParameters(array $parameters)
    {
        foreach ($parameters as $param => $value) {
            $this->statement->bindValue($param, $value);
        }
    }

    private function handleQueryResult($mode)
    {
        if (stripos($this->statement->queryString, 'SELECT') !== false) {
            return $this->statement->fetchAll($mode);
        } elseif (stripos($this->statement->queryString, 'INSERT') !== false) {
            return $this->lastInsertId();
        } else {
            return $this->statement->rowCount();
        }
    }
}
