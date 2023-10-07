<?php

namespace Excore\Core\Modules\Database;

use ArrayAccess;


class Collection implements ArrayAccess
{
    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    public function toJSON()
    {
        return json_encode($this->toArray(), JSON_NUMERIC_CHECK);
    }

    public function toArray()
    {
        // return (array) get_object_vars($this);
        $array = [];
        foreach ($this as  $mareiObj) {
            $array[] = (array) $mareiObj;
        }
        return $array;
    }

    public function lists($field)
    {
        $list = [];
        foreach ($this as  $item) {
            $list[] = $item->{$field};
        }
        return $list;
    }

    public function first($offset = 0)
    {
        return isset($this->$offset) ? $this->$offset : null;
    }

    public function last($offset = null)
    {
        $offset = count($this->toArray()) - 1;
        return isset($this->$offset) ? $this->$offset : null;
    }

    #[\ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }

    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return isset($this->$offset) ? $this->$offset : null;
    }


    public function item($key)
    {
        dd($this);
        return isset($this->$key) ? $this->$key : null;
    }

    public function __toString()
    {
        header("Content-Type: application/json;charset=utf-8");
        // return json_encode(get_object_vars($this));
        return  $this->toJSON();
    }
}
