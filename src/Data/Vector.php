<?php

namespace MachineLearning\Data;

use MachineLearning\MachineLearning;

/**
 * A column class for fetching vector specific data.
 */
class Vector extends MachineLearning
{
    public $values;
    public $classified;

    /**
     * Set the values.
     */
    public function setValues($values)
    {
      $this->values = $values;
    }

    /**
     * Set the classified.
     */
    public function classify($classified)
    {
      $this->classified = $classified;
    }
}
