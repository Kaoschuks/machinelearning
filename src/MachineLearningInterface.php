<?php

namespace MachineLearning;

use MachineLearning\DataPreparation\Dataset;

/**
 *
 */
interface MachineLearningInterface {

  public function train();
  public function test();
  public function addTrainingData(Dataset $dataset);
  public function addTestData(Dataset $dataset);
}
