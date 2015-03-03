<?php

namespace MachineLearning\Data\Entity;

use MachineLearning\Utility\Controller\BaseController;

/**
 * A column class for fetching column specific data.
 */
class Column extends BaseController
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
        $values = $this->values;

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

        $this->datatype = $datatype;
    }

    /**
     * Get the datatype.
     */
    public function getDataType()
    {
        return $this->datatype;
    }

    /**
     * Get the default statistics.
     */
    public function getStats()
    {
        return $this->getDefaultStatistics($this->values);
    }

    /**
     * Check if the column is numeric.
     */
    public function isNumeric()
    {
      return in_array($this->datatype, array('double'));
    }
}
