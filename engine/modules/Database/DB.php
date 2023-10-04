<?php

namespace Excore\Core\Modules\Database;

use PDO;


class DB
{
    private PDO $db;

    public function __construct(array $options)
    {
        $connect = new Connect(
            $options['host'],
            $options['user'],
            $options['password'],
            $options['db'],
            $options['charset']
        );

        $this->db = $connect->usePDO();
    }

    public static function init(array $options)
    {
        return new self($options);
    }


    public function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetchAll($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        dd($stmt->fetchAll(PDO::FETCH_ASSOC));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetch($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($table, $data)
    {
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        return $this->db->lastInsertId();
    }

    public function update($table, $data, $where, $params = [])
    {
        $set = [];
        foreach ($data as $column => $value) {
            $set[] = "{$column} = :{$column}";
        }

        $set = implode(', ', $set);
        $sql = "UPDATE {$table} SET {$set} WHERE {$where}";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_merge($data, $params));

        return $stmt->rowCount();
    }

    public function delete($table, $where, $params = [])
    {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->rowCount();
    }

    public function getLastInsertId()
    {
        return $this->db->lastInsertId();
    }

    public function beginTransaction()
    {
        return $this->db->beginTransaction();
    }

    public function commit()
    {
        return $this->db->commit();
    }

    public function rollback()
    {
        return $this->db->rollback();
    }
}
