<?php

namespace MachineLearning\Data\Entity;

class Object
{
    public $key;
    public $data;

    public function __construct($key = null, $data = null) {
        $this->key = $key;
        $this->data = $data;
    }

    /**
     * Get an item from the array.
     */
    public function get($key)
    {
        return @$this->data[$key];
    }
}
