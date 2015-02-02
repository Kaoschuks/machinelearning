<?php

namespace MachineLearning;

use MachineLearning\Data\Dataset;

/**
 * An interface that all Machine learning methods should have.
 */
interface MachineLearningInterface {

  // Add the data to work with.
  public function addTrainingData(Dataset $dataset);
  public function addValidationData(Dataset $dataset);
  public function addTestData(Dataset $dataset);

  // Do the work.
  public function train();
  public function validate();
  public function test();

}
