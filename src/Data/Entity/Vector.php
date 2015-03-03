<?php

namespace MachineLearning\Data\Entity;

use MachineLearning\Data\Controller\ColumnController;
use MachineLearning\Data\Entity\Column;

/**
 * A vector class for fetching vector specific data.
 */
class Vector extends ColumnController
{
    private $values;
    private $class;

    /**
     * Set the values.
     */
    public function setValues($values)
    {
        foreach ($values as $key => $value) {
            $this->setValue($key, $value);
        }
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
    public function setValue($key, $value)
    {
        $this->values[$key] = $value;
        $this->setColumn($key, $value);
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
        return $this->getDefaultStatistics($this->values);
    }
}
