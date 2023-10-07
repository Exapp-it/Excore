<?php

namespace Excore\Core\Core;

use Excore\Core\Modules\Database\DB;


class Model
{
    protected DB $db;
    protected Container $container;
    protected string $table = '';
    public string $primaryKey;


    public function __construct()
    {
        $this->container = Container::getInstance();
        $this->db = $this->container->resolve('DB');
    }

    public function find($id)
    {
        return $this->db->table($this->table)->where('id', $id)->get();
    }

    public function all()
    {
        return $this->db->table($this->table)->get();
    }

    public function create(array $data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function update($id, array $data)
    {
        return $this->db->table($this->table)->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return $this->db->table($this->table)->where('id', $id)->delete($this->table    );
    }

    public function paginate($page, $perPage)
    {
        return $this->db->table($this->table)->paginate($page, $perPage);
    }

    public function count()
    {
        return $this->db->table($this->table)->count();
    }

    public function orderBy($field, $order = 'ASC')
    {
        return $this->db->table($this->table)->orderBy($field, $order);
    }

    public function where()
    {
        return $this->db->table($this->table)->where(...func_get_args());
    }

    public function orWhere()
    {
        return $this->db->table($this->table)->orWhere(...func_get_args());
    }

    public function exec()
    {
        return $this->db->table($this->table)->exec();
    }

    public function lastId()
    {
        return $this->db->table($this->table)->lastId();
    }

    public function getSQL()
    {
        return $this->db->table($this->table)->getSQL();
    }

    public function getCount()
    {
        return $this->db->table($this->table)->getCount();
    }

    public function rowCount()
    {
        return $this->db->table($this->table)->rowCount();
    }

    public function QGet()
    {
        return $this->db->table($this->table)->QGet();
    }

    public function QPaginate($page, $perPage)
    {
        return $this->db->table($this->table)->QPaginate($page, $perPage);
    }

    public function PaginationInfo()
    {
        return $this->db->table($this->table)->PaginationInfo();
    }
}
