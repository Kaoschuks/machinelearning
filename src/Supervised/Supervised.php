<?php

namespace MachineLearning\Supervised;

use MachineLearning\MachineLearning;
use MachineLearning\Interfaces\ControllerInterface;
use MachineLearning\Data\Dataset;

/**
 * Base class for the clustering algortims.
 */
class Supervised extends MachineLearning implements ControllerInterface {

  public $trainingData;
  public $validationData;
  public $testData;

  /**
   * Add trainings data to train the clusters.
   *
   * @param Dataset $dataset
   */
  public function addTrainingData(Dataset $dataset) {
    $this->trainingData = $dataset;
  }

  /**
   * Add validation data to validate the clusters.
   *
   * @param Dataset $dataset
   */
  public function addValidationData(Dataset $dataset) {
    $this->validationData = $dataset;
  }

  /**
   * Add test data.
   *
   * @param Dataset $dataset
   */
  public function addTestData(Dataset $dataset) {
    $this->testData = $dataset;
  }
}
