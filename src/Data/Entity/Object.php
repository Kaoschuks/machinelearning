<?php

namespace MachineLearning\Data\Entity;

/**
 * Object, contains the values.
 *
 * @author Willem Bressers <info@willembressers.nl>
 */
class Object
{
    public $key;
    public $data;

    /**
     * Set the defaults.
     *
     * @param integer $key
     * @param array   $data
     */
    public function __construct($key = null, $data = null) {
        $this->key = $key;
        $this->data = $data;
    }

    /**
     * Get an item from the array.
     *
     * @param integer $key
     *
     * @return array
     */
    public function get($key)
    {
        return @$this->data[$key];
    }
}
