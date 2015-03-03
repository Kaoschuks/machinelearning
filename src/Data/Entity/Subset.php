<?php

namespace MachineLearning\Data\Entity;

use MachineLearning\Data\Controller\ColumnController;
use MachineLearning\Data\Entity\Vector;

/**
 * Sub class for the data management.
 */
class Subset extends ColumnController
{
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
}

