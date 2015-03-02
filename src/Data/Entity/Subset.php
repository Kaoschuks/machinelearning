<?php

namespace MachineLearning\Data\Entity;

use MachineLearning\Data\Entity\Column;
use MachineLearning\Data\Entity\Vector;

/**
 * Sub class for the data management.
 */
class Subset
{
    private $columns;
    private $vectors;

    /**
     * Add the raw data
     */
    public function addData($data)
    {
        $this->setColumns($data);
        $this->setVectors($data);
    }

    /**
     * Set vector.
     */
    public function setVector($key, $values) {
        if (!$this->getVector($key)) {
            $this->vectors[$key] = new Vector();
            $this->vectors[$key]->setValues($values);
        } else {
            $this->vectors[$key]->setValues(array_merge($values, $this->vectors[$key]->getValues()));
        }
    }

    /**
     * Get vector.
     */
    public function getVector($key) {
        return isset($this->vectors[$key]) ? $this->vectors[$key] : NULL;
    }

    /**
     * Set multiple vectors.
     */
    public function setVectors($data) {
        foreach ($data as $key => $values) {
            $this->setVector($key, $values);
        }
    }

    /**
     * Get multiple vectors.
     */
    public function getVectors($keys = array()) {
        return empty($keys) ? $this->vectors : array_intersect_key($this->vectors, array_flip($keys));
    }

    /**
     * Set column.
     */
    public function setColumn($key, $values) {
        if (!$this->getColumn($key)) {
            $this->columns[$key] = new Column();
            $this->columns[$key]->setValues($values);
        } else {
            $this->columns[$key]->setValues(array_merge($values, $this->columns[$key]->getValues()));
        }
    }

    /**
     * Get column.
     */
    public function getColumn($key) {
        return isset($this->columns[$key]) ? $this->columns[$key] : NULL;
    }

    /**
     * Set multiple columns.
     */
    public function setColumns($data) {
        foreach ($data as $row_key => $values) {
            foreach ($values as $column_key => $value) {
                $this->setcolumn($column_key, array_column($data, $column_key));
            }
        }
    }

    /**
     * Get multiple columns.
     */
    public function getColumns($keys = array()) {
        return empty($keys) ? $this->columns : array_intersect_key($this->columns, array_flip($keys));
    }
}

