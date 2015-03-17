<?php

namespace MachineLearning\Clustering\Entity;

use MachineLearning\Data\Entity\Object;
use MachineLearning\Data\Controller\ObjectController;

class Cluster extends Object
{
    public $centroid;
    public $vectors;

    public function __construct($key = null, $data = null) {
        parent::__construct($key, $data);

        $this->centroid = new Object($key);
        $this->vectors = new ObjectController();
    }
}
