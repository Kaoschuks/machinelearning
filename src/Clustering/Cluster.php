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
   * Basic constructor.
   */
  public function __construct($dataset) {
    $this->dataset = $dataset;
  }

  /**
   * [addData description]
   *
   * @param Dataset $dataset [description]
   */
  public function updateDataset(Dataset $dataset) {
    $this->dataset = $dataset;
  }
}
