<?php

namespace MachineLearning\DataPreparation;

abstract class Dataset {

  public $data;
  public $num_rows;

  public function __construct($data) {
    $this->data = $data;
    $this->num_rows = count($data);
  }
}
