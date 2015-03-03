<?php

namespace MachineLearning\Data\Controller;

use MachineLearning\Utility\Controller\BaseController;
use MachineLearning\Data\Entity\Column;

/**
 *
 */
class ColumnController extends BaseController
{
    private $columns;

    /**
     * Set column.
     */
    public function setColumn($key, $values) {
        if (!$this->getColumn($key)) {
            $this->columns[$key] = new Column();
            $this->columns[$key]->setValues($values);
        } else {
            if (is_array($values)) {
                $this->columns[$key]->setValues(array_merge($values, $this->columns[$key]->getValues()));
            } else {
                $this->columns[$key]->setValues($values);
            }
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
