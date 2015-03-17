<?php

namespace MachineLearning\Data\Controller;

use Iterator;
use MachineLearning\Data\Entity\Object;

class ObjectController implements Iterator
{
    private $objects = array();

    /**
     * Add an object to the array.
     */
    public function set($key, Object $object)
    {
        $this->objects[$key] = $object;
    }

    /**
     * Get an object from the array.
     */
    public function get($key)
    {
        return @$this->objects[$key];
    }

    /**
     * Get an multiple objects.
     */
    public function getMultiple($keys = array())
    {
        return empty($keys) ? $this->objects : array_intersect_key($this->objects, $keys);
    }

    /**
     * Delete an object from the array.
     */
    public function del($key)
    {
        unset($this->objects[$key]);
    }

    /**
     * Remove all the objects.
     */
    public function clear()
    {
        $this->objects = array();
    }

    /**
     * Remove all the objects.
     */
    public function count()
    {
        return count($this->objects);
    }

    /**
     * Return an random object.
     */
    public function random()
    {
        return $this->objects[array_rand($this->objects)];
    }

    /**
     * Get an object from the array.
     */
    public function getDataColumn($columnKey)
    {
        $values = array();
        foreach ($this->objects as $key => $object) {
            $values[$key] = $object->get($columnKey);
        }
        return $values;
    }

    /**
     * Iterator function.
     */
    public function rewind()
    {
        return reset($this->objects);
    }

    /**
     * Iterator function.
     */
    public function current()
    {
        return current($this->objects);
    }

    /**
     * Iterator function.
     */
    public function key()
    {
        return key($this->objects);
    }

    /**
     * Iterator function.
     */
    public function next()
    {
        return next($this->objects);
    }

    /**
     * Iterator function.
     */
    public function valid()
    {
        return key($this->objects) !== null;
    }
}

