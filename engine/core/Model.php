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

    protected int $id;


    public function __construct($data)
    {
        $this->container = Container::getInstance();
        $this->db = $this->container->resolve('DB');
        $this->queryBuilder = new QueryBuilder($this->db, $this->table);
        foreach ($data as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->$attribute = $value;
            }
        }
    }

    public function find($id)
    {
        $data = $this->queryBuilder
            ->select(['*'])
            ->where($this->primaryKey, $id, '=')
            ->first();

        if ($data) {
            return new static($data);
        }
        return null;
    }


    public function first()
    {
        $data = $this->queryBuilder
            ->select(['*'])
            ->limit(1)
            ->first();

        if ($data) {
            return new static($data);
        }
        return null;
    }



    public function create(array $data)
    {
        return $this->queryBuilder->create($data);
    }

    public function update(array $data)
    {
        return $this->queryBuilder->update($data, "{$this->primaryKey} = :id", [':id' => $this->id]);
    }

    public function delete()
    {
        return $this->queryBuilder->delete("{$this->primaryKey} = :id", [':id' => $this->id]);
    }

    public function all()
    {
        $data = $this->queryBuilder->select(['*'])->get();
        
        foreach ($data as $value) {
            $instance[] = new static($value);
        }
        return $instance;
    }

    public function where($column, $value, $operator = '=')
    {
        $this->queryBuilder->where($column, $value, $operator);
        return $this;
    }

    public function orWhere($column, $value, $operator = '=')
    {
        $this->queryBuilder->orWhere($column, $value, $operator);
        return $this;
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $this->queryBuilder->orderBy($column, $direction);
        return $this;
    }

    public function limit($limit)
    {
        $this->queryBuilder->limit($limit);
        return $this;
    }

    public function offset($offset)
    {
        $this->queryBuilder->offset($offset);
        return $this;
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
