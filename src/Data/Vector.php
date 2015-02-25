<?php

namespace MachineLearning\Data;

/**
 * A vector class for fetching vector specific data.
 */
class Vector
{
    private $values;
    private $class;

    /**
     * Set the values.
     */
    public function setValues($values)
    {
        $this->values = $values;
    }

    /**
     * Get the values.
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Set the class.
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * Get the class.
     */
    public function getClass()
    {
        return $this->class;
    }
}
