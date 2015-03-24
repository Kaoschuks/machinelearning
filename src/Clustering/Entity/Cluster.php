<?php

namespace MachineLearning\Clustering\Entity;

use MachineLearning\Data\Entity\Object;
use MachineLearning\Data\Entity\Collection;

/**
 * Cluster, cluster the vectors.
 *
 * @author Willem Bressers <info@willembressers.nl>
 */
class Cluster
{
    public $key;
    public $centroid;
    public $vectors;

    public function __construct($key = 0)
    {
        $this->key = $key;
        $this->centroid = new Object($key);
        $this->vectors = new Collection($key);
    }
}
