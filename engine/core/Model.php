<?php

namespace Excore\Core\Core;

use Excore\Core\Modules\Database\DB;
use Excore\Core\Modules\Database\Collection;

class Model
{
    protected DB $db;
    protected Container $container;
    protected string $table = '';
    public string $primaryKey = 'id';

    public function __construct()
    {
        $this->container = Container::getInstance();
        $this->db = $this->container->resolve('DB');
    }

    public function find($id): ?object
    {
        return $this->db
            ->table($this->table)
            ->where('id', $id)
            ->first();
    }

    public function all(): Collection
    {
        return $this->db
            ->table($this->table)
            ->get();
    }

    public function create(array $data): int
    {
        return $this->db
            ->table($this->table)
            ->insert($data);
    }

    public function update($id, array $data): int
    {
        return $this->db
            ->table($this->table)
            ->where('id', $id)
            ->update($data);
    }

    public function delete($id): int
    {
        return $this->db
            ->table($this->table)
            ->where('id', $id)
            ->delete();
    }

    public function select(string $columns): self
    {
        $this->db->select($columns);
        return $this;
    }

    public function first()
    {
        return $this->db->first();
    }

    public function where(...$conditions): self
    {
        $this->db->where(...$conditions);
        return $this;
    }

    public function orWhere(...$conditions): self
    {
        $this->db->orWhere(...$conditions);
        return $this;
    }

    public function get(): Collection
    {
        return $this->db->get();
    }

    public function limit(int $limit, int $offset = null): self
    {
        $this->db->limit($limit, $offset);
        return $this;
    }

    public function orderBy(string $fieldName, string $order = 'ASC'): self
    {
        $this->db->orderBy($fieldName, $order);
        return $this;
    }

    public function count(): int
    {
        return $this->db->count();
    }

    public function paginate(int $page, int $limit): Collection
    {
        return $this->db->paginate($page, $limit);
    }

    public function PaginationInfo(): array
    {
        return $this->db->PaginationInfo();
    }
}
