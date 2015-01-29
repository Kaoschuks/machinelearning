<?php

namespace MachineLearning\Clustering;

use MachineLearning\Clustering\Cluster;
use MachineLearning\MachineLearningInterface;

/**
 *
 */
class KMeans extends Cluster implements MachineLearningInterface{

  public $clusters;

  /**
   * Basic constructor.
   */
  public function __construct() {
    $this->setNumClusters(3);
  }

  /**
   * [setNumClusters description]
   *
   * @param [type] $num [description]
   */
  public function setNumClusters($num) {
    if (is_int($num)) {
      $this->config['num_clusters'] = $num;
    }
  }

  /**
   * [learn description]
   *
   * @return [type] [description]
   */
  public function learn() {
    $this->generateClusters();
  }

  /**
   * [generateClusters description]
   *
   * @return [type] [description]
   */
  private function generateClusters() {
    for ($i = 0; $i < $this->config['num_clusters']; $i++) {
      $this->clusters[] = array();
    }
  }
}
