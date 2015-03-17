<?php

namespace MachineLearning\Data\Entity;

use MachineLearning\Data\Entity\Object;

class Column extends Object
{
    public $datatype;

    public function __construct($key = null, $data = null) {
        parent::__construct($key, $data);
    }

    /**
     * Get the datatype.
     */
    private function getDataType()
    {
        $values = $this->data;

        if (is_array($values)) {
            $types = array_count_values(array_filter(array_map('gettype', $values), function ($value) {
              return $value != 'NULL';
            }));

            // Sort the type counts, highest first.
            arsort($types);

            // Get the type width the highest count.
            $datatype = reset(array_flip($types));
        } else {
            $datatype = gettype($values);
        }

        return $datatype;
    }
}
