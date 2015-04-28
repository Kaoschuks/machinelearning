<?php

namespace League\MachineLearning\Data\Entity;

use IteratorAggregate;
use ArrayIterator;

/**
 * Collection, contains a collection of items.
 *
 * @author Willem Bressers <info@willembressers.nl>
 */
class Collection implements IteratorAggregate
{
    private $key;
    private $items = array();

    /**
     * Set the defaults.
     *
     * @param integer $key
     */
    public function __construct($key = 0)
    {
        $this->key = $key;
    }

    /**
     * Defines the iterator for this collection.
     *
     * @return Itereator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Add an object to the array.
     *
     * @param integer $key
     * @param mixed   $item\
     */
    public function set($key, $item)
    {
        $this->items[$key] = $item;
    }

    /**
     * Set multiple items.
     *
     * @param array $items An array of items, yet to be added to the collection.
     */
    public function setMultiple(array $items)
    {
        foreach ($items as $key => $item) {
            $this->set($key, $item);
        }
    }

    /**
     * Get an object from the array.
     *
     * @param integer $key
     *
     * @return item
     */
    public function get($key)
    {
        return @$this->items[$key];
    }
    /**
     * Get multiple items.
     *
     * @param array $keys An array of item keys, yet to be returned.
     *
     * @return array of items.
     */
    public function getMultiple(array $keys = array())
    {
        return empty($keys) ? $this->items : array_intersect_key($this->items, $keys);
    }

    public function getHighest($objectKey)
    {
        $values = array();
        foreach ($this->items as $key => $item) {
            $values[$key] = $item->get($objectKey);
        }
        arsort($values);
        reset($values);

        return $this->items[key($values)];
    }

    /**
     * Remove all the items.
     */
    public function clear()
    {
        $this->items = array();
    }

    /**
     * Get the column values from all items.
     */
    public function getColumnValues($columnKey)
    {
        $values = array();
        foreach ($this->items as $item) {
            $values[$item->key] = $item->get($columnKey);
        }

        return $values;
    }

    /**
     * Count all items.
     *
     * @return integer.
     */
    public function count()
    {
        return count($this->items);
    }
}
