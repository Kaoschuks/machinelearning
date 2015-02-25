<?php

namespace MachineLearning\Data;

/**
 * A column class for fetching column specific data.
 */
class Column
{
    private $values;
    private $datatype;

    /**
     * Set the values.
     */
    public function setValues($values)
    {
        $this->values = $values;
        $this->setDataType();
    }

    /**
     * Get the values.
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Set the datatype.
     */
    private function setDataType()
    {
        $types = array_count_values(array_filter(array_map('gettype', $this->values), function ($value) {
          return $value != 'NULL';
        }));

        // Sort the type counts, highest first.
        arsort($types);

        // Get the type width the highest count.
        $this->datatype = reset(array_flip($types));

        // if (in_array($type, array('double'))) {
        //     $this->datatype = 'numeric';
        // } elseif ($type == 'string') {
        //     $this->datatype = 'string';
        // }
    }

    /**
     * Get the datatype.
     */
    public function getDataType()
    {
        return $this->datatype;
    }

    /**
     * Check if the column is numeric.
     */
    public function isNumeric()
    {
      return in_array($this->datatype, array('double'));
    }
}
