<?php

namespace MachineLearning\DataPreparation;

use MachineLearning\DataPreparation\Dataset;

class TrainDataset extends Dataset {

  public function __construct($data) {
    $this->data = $data;
  }

}
