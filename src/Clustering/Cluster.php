<?php

namespace MachineLearning\Clustering;

use MachineLearning\DataPreparation\Dataset;

/**
 *
 */
class Cluster {

  public $dataset;
  protected $config;

  /**
   * [addData description]
   * @param Dataset $dataset [description]
   */
  public function addData(Dataset $dataset) {
    $this->dataset = $dataset;
  }
}
