<?php

namespace MachineLearning\Clustering;

use MachineLearning\Clustering\Cluster;
use MachineLearning\Interfaces\InstanceBasedLearningInterface;
use MachineLearning\Data\Dataset;

/**
 * Cluster the data, based on the KMeans approach.
 */
class KNearestNeighbors extends Cluster implements InstanceBasedLearningInterface {

  public $num_nearest_neighbors;

  /**
   * Basic constructor.
   */
  public function __construct($num_nearest_neighbors = 3) {
    $this->num_nearest_neighbors = $num_nearest_neighbors;
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
