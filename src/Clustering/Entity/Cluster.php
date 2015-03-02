<?php

namespace MachineLearning\Clustering\Entity;

use MachineLearning\Data\Entity\Subset;

class Cluster extends Subset
{
    private $centroid;

    /**
     * Set centroid.
     */
    public function setCentroid($centroid) {
        $this->centroid = $centroid;
    }

    /**
     * Get centroid.
     */
    public function getCentroid() {
        return isset($this->centroid) ? $this->centroid : array();
    }

    /**
     * Set column centroid.
     */
    public function setColumnCentroid($column, $value) {
        $this->centroid[$column] = $value;
    }

    /**
     * Get column centroid.
     */
    public function getColumnCentroid($column) {
        return isset($this->centroid[$column]) ? $this->centroid[$column] : null;
    }
}
