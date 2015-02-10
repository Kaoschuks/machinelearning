<?php

namespace MachineLearning\Clustering;

use MachineLearning\Clustering\Cluster;
use MachineLearning\MachineLearningInterface;
use MachineLearning\Data\Dataset;

/**
 * Cluster the data, based on the KMeans approach.
 */
class KNearestNeighbors extends Cluster implements MachineLearningInterface {

  public $num_nearest_neighbors;

  /**
   * Basic constructor.
   */
  public function __construct($num_nearest_neighbors = 3) {
    $this->num_nearest_neighbors = $num_nearest_neighbors;
  }

    /**
   * Add trainings data to train the clusters.
   *
   * @param Dataset $dataset
   */
  public function addTrainingData(Dataset $dataset) {
    parent::addTrainingData($dataset);
  }

  /**
   * Add validation data to validate the clusters.
   *
   * @param Dataset $dataset
   */
  public function addValidationData(Dataset $dataset) {
    parent::addValidationData($dataset);
  }

  /**
   * Add test data.
   *
   * @param Dataset $dataset
   */
  public function addTestData(Dataset $dataset) {
    parent::addTestData($dataset);
  }

  /**
   * Train the clusters based on the trainingdata.
   */
  public function train() {
    // No need for training because of instance-based learning, or lazy learning,
  }

  /**
   * Validate the clusters.
   */
  public function validate() {
    // @TODO ...
  }

  /**
   * Test the clusters on the testdata.
   */
  public function test() {
    foreach ($this->testData->data as $test_row_key => $test_row) {
      foreach ($this->trainingData->data as $training_row_key => $training_row) {

      }
    }
  }
}
