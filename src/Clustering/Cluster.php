<?php

namespace MachineLearning\Clustering;

use MachineLearning\DataPreparation\Dataset;

/**
 *
 */
class Cluster {

  public $dataset;
  public $trainingData;

  public $clusters;

  /**
   * [addTrainingData description]
   *
   * @param Dataset $dataset [description]
   */
  public function addTrainingData(Dataset $dataset) {
    $this->trainingData = $dataset;
  }
}
