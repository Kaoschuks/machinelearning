<?php

namespace MachineLearning\Data\Entity;

use MachineLearning\MachineLearning;

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
     * Set the value.
     */
    public function setValue($key, $values)
    {
        $this->values[$key] = $value;
    }

    /**
     * Get the value.
     */
    public function getValue($key)
    {
        return isset($this->values[$key]) ? $this->values[$key] : NULL;
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

    /**
     * Get the default statistics.
     */
    public function getStats()
    {
        return MachineLearning::DefaultStatistics($this->values);
    }
}
