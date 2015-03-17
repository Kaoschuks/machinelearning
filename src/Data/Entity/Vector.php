<?php

namespace MachineLearning\Data\Entity;

use MachineLearning\Data\Entity\Object;

class Vector extends Object
{
    public $class;

    public function __construct($key = null, $data = null) {
        parent::__construct($key, $data);
    }
}
