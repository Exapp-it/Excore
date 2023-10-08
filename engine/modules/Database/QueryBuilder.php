<?php

namespace Excore\Core\Modules\Database;

class QueryBuilder
{
    private DB $db;
    private string $table;
    private array $select = ['*'];
    private array $parameters = [];
    private array $joins = [];
    private array $where = [];
    private array $orderBy = [];
    private int $limit = 0;
    private int $offset = 0;

    public function __construct(DB $db, string $table)
    {
        $this->db = $db;
        $this->table = $table;
    }


    public function create(array $data)
    {
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO $this->table ($columns) VALUES ($values)";

        return $this->db->execute($query, $data);
    }


    public function update(array $data, string $condition, array $parameters = [])
    {
        $set = [];
        foreach ($data as $column => $value) {
            $set[] = "$column = :$column";
            $parameters[":$column"] = $value;
        }

        $query = "UPDATE $this->table SET " . implode(', ', $set);

        if (!empty($condition)) {
            $query .= " WHERE $condition";
        }

        return $this->db->execute($query, $parameters);
    }


    public function delete(string $condition, array $parameters = [])
    {
        $query = "DELETE FROM $this->table";

        if (!empty($condition)) {
            $query .= " WHERE $condition";
        }

        return $this->db->execute($query, $parameters);
    }



    public function select(array $columns)
    {
        $this->select = $columns;
        return $this;
    }

    public function first()
    {
        $results = $this->get();
        return !empty($results) ? $results[0] : null;
    }



    public function join(string $table, string $condition)
    {
        $this->joins[] = "JOIN $table ON $condition";
        return $this;
    }


    public function where(string $column, string $operator, $value)
    {
        $this->parameters[":$column"] = $value; // Сохраняем параметр
        $this->where[] = empty($this->where) ? "$column $operator :$column" : "AND $column $operator :$column";
        return $this;
    }

    public function orWhere(string $column, string $operator, $value)
    {
        $this->parameters[":$column"] = $value; // Сохраняем параметр
        $this->where[] = empty($this->where) ? "$column $operator :$column" : "OR $column $operator :$column";
        return $this;
    }



    public function orderBy(string $column, string $direction = 'ASC')
    {
        $this->orderBy[] = "$column $direction";
        return $this;
    }

    public function limit(int $limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset(int $offset)
    {
        $this->offset = $offset;
        return $this;
    }

    public function get()
    {
        $select = implode(', ', $this->select);
        $query = "SELECT $select FROM $this->table";

        if (!empty($this->joins)) {
            $query .= ' ' . implode(' ', $this->joins);
        }

        if (!empty($this->where)) {
            $query .= ' WHERE ' . implode(' ', $this->where);
        }

        if (!empty($this->orderBy)) {
            $query .= ' ORDER BY ' . implode(', ', $this->orderBy);
        }

        if ($this->limit > 0) {
            $query .= " LIMIT $this->limit";
        }

        if ($this->offset > 0) {
            $query .= " OFFSET $this->offset";
        }

        return $this->db->query($query, $this->parameters);
    }
}
