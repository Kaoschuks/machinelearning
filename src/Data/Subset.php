<?php

namespace MachineLearning\Data;

/**
 * Base class for the data handling.
 */
class Subset
{
    public $vectors;

    public function addVector($key, $vector) {
        $this->vectors[$key] = $vector;
    }

    public function column($key) {
        $values = array();
        foreach ($this->vectors as $vector_key => $vector) {
            if ($value = $vector->values[$key]) {
                $values[$vector_key] = $value;
            }
        }
        return $values;
    }
}
