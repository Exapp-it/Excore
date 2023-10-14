<?php

namespace Excore\Core\Core;

use Excore\Core\Modules\Database\DB;
use Excore\Core\Modules\Database\QueryBuilder;

class Model
{
    protected DB $db;
    protected Container $container;
    protected QueryBuilder $queryBuilder;
    protected string $table = '';
    public string $primaryKey = 'id';

    public function __construct()
    {
        $this->container = Container::getInstance();
        $this->db = $this->container->resolve('DB');
        $this->queryBuilder = new QueryBuilder($this->db, $this->table);
    }

    public function find($id)
    {
        return $this->queryBuilder->select(['*'])
            ->where($this->primaryKey, '=', $id)
            ->get();
    }


    public function first()
    {
        return $this->queryBuilder
            ->select(['*'])
            ->limit(1)
            ->first();
    }



    public function create(array $data)
    {
        return $this->queryBuilder->create($data);
    }

    public function update($id, array $data)
    {
        return $this->queryBuilder->update($data, "{$this->primaryKey} = :id", [':id' => $id]);
    }

    public function delete($id)
    {
        return $this->queryBuilder->delete("{$this->primaryKey} = :id", [':id' => $id]);
    }

    public function all()
    {
        return $this->queryBuilder->select(['*'])->get();
    }

    public function where($column, $value, $operator = '=')
    {
        return $this->queryBuilder->where($column, $value, $operator);
    }

    public function orWhere($column, $value, $operator = '=')
    {
        return $this->queryBuilder->orWhere($column, $value, $operator);
    }

    public function orderBy($column, $direction = 'ASC')
    {
        return $this->queryBuilder->orderBy($column, $direction);
    }

    public function limit($limit)
    {
        return $this->queryBuilder->limit($limit);
    }

    public function offset($offset)
    {
        return $this->queryBuilder->offset($offset);
    }

    public function paginate($perPage, $currentPage)
    {
        $offset = ($currentPage - 1) * $perPage;

        $data = $this->queryBuilder
            ->select(['*'])
            ->limit($perPage)
            ->offset($offset)
            ->get();

        $totalItems = count($data);

        $totalPages = ceil($totalItems / $perPage);

        return [
            'data' => $data,
            'current_page' => $currentPage,
            'per_page' => $perPage,
            'total_items' => $totalItems,
            'total_pages' => $totalPages,
        ];
    }
}
