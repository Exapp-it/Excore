<?php


namespace Excore\Core\Modules\Database;

class QueryBuilder
{
    protected $db;
    protected $table;
    protected $select = '*';
    protected $where = [];
    protected $orderBy = [];
    protected $limit;

    public function __construct(DB $db, string $table)
    {
        $this->db = $db;
        $this->table = $table;
    }

    public function select($columns)
    {
        $this->select = is_array($columns) ? implode(', ', $columns) : $columns;
        return $this;
    }

    public function where($column, $operator, $value)
    {
        $this->where[] = compact('column', 'operator', 'value');
        return $this;
    }

    public function orderBy($column, $direction = 'asc')
    {
        $this->orderBy[] = compact('column', 'direction');
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function get()
    {
        $sql = "SELECT {$this->select} FROM {$this->table}";

        if (!empty($this->where)) {
            $sql .= ' WHERE ' . $this->buildWhereClause();
        }

        if (!empty($this->orderBy)) {
            $sql .= ' ORDER BY ' . $this->buildOrderByClause();
        }

        if (!is_null($this->limit)) {
            $sql .= ' LIMIT ' . $this->limit;
        }

        $stmt = $this->db->query($sql, $this->getBindings());

        return $stmt->fetchAll();
    }

    protected function buildWhereClause()
    {
        $whereClauses = [];
        foreach ($this->where as $condition) {
            $whereClauses[] = "{$condition['column']} {$condition['operator']} :{$condition['column']}";
        }
        return implode(' AND ', $whereClauses);
    }

    protected function buildOrderByClause()
    {
        $orderByClauses = [];
        foreach ($this->orderBy as $orderBy) {
            $orderByClauses[] = "{$orderBy['column']} {$orderBy['direction']}";
        }
        return implode(', ', $orderByClauses);
    }

    protected function getBindings()
    {
        $bindings = [];
        foreach ($this->where as $condition) {
            $bindings[":{$condition['column']}"] = $condition['value'];
        }
        return $bindings;
    }
}
