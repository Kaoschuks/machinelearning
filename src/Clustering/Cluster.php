<?php

namespace MachineLearning\Clustering;

use MachineLearning\MachineLearning;
use MachineLearning\DataPreparation\Dataset;

/**
 *
 */
class Cluster extends MachineLearning {

  public $trainingData;
  public $testData;
  public $clusters;

  /**
   * [addTrainingData description]
   *
   * @param Dataset $dataset [description]
   */
  public function addTrainingData(Dataset $dataset) {
    $this->trainingData = $dataset;
  }

  /**
   * [addTestData description]
   *
   * @param Dataset $dataset [description]
   */
  public function addTestData(Dataset $dataset) {
    $this->testData = $dataset;
  }
}
