<?php

namespace MachineLearning\Data;

use MachineLearning\MachineLearning;

/**
 *
 */
class Column extends MachineLearning {

  public $key;
  public $values;
  public $datatype;
  public $data;

  /**
   * Basic constructor.
   */
  public function __construct($key, $values) {
    $this->key = $key;
    $this->values = $values;
    $this->datatype = $this->getType($values);

    if ($this->datatype == 'numeric') {
      $this->data = $this->getDefaultStatistics($values);
    }
  }

  /**
   * [getType description]
   *
   * @param  [type] $values [description]
   * @return [type]         [description]
   */
  private function getType($values) {
    $types = array_count_values(array_filter(array_map('gettype', $values), function ($value) {
      return $value != 'NULL';
    }));
    arsort($types);
    $type = reset(array_flip($types));

    if (in_array($type, array('double'))) {
      return 'numeric';
    }
    elseif ($type == 'string') {
      return 'string';
    }
  }
}

