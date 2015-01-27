<?php

namespace MachineLearning\DataPreparation;

use MachineLearning\DataPreparation\Dataset;

class TestDataset extends Dataset {

  public function __construct($data) {
    $this->data = $data;
  }

}
