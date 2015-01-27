<?php

namespace MachineLearning\Clustering;

class KMeans {

  public $data =array();
  public $num_clusters;

  public function __construct($data, $num_clusters = 3) {
    $this->data = $data;
    $this->num_clusters = $num_clusters;
  }

  public function cluster() {
    if (!$this->validate()) {
      return;
    }

    var_dump($this->num_clusters);
  }

  public function validate() {
    return $this->num_clusters >= count($this->data);
  }
}
