<?php

namespace League\MachineLearning\Clustering\Entity;

use League\MachineLearning\Data\Entity\Object;
use League\MachineLearning\Data\Entity\Collection;

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
