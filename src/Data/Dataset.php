<?php

namespace MachineLearning\Data;

use MachineLearning\MachineLearning;

/**
 * Base class for the data handling.
 */
class Dataset extends MachineLearning {

  public $data;
  private $columns;
  private $config;

  /**
   * Basic constructor.
   *
   * @param [array] $data [The dataset to work with.]
   */
  public function __construct($data, $max_nominal_values = 100) {
    $this->data = $this->addUniqueKeys($data);
    $this->config['max_nominal_values'] = $max_nominal_values;
    $this->setColumnData();
  }

  /**
   * Fetch the column data
   */
  private function setColumnData() {
    foreach (reset($this->data) as $key => $value) {
      $values = array_column($this->data, $key);
      if (is_numeric($value)) {
        $this->columns[$key]['datatype'] = 'numeric';
        $this->columns[$key] += $this->getDefaultStatistics($values);
      }

      if (is_string($value)) {
        $this->columns[$key]['datatype'] = 'string';
        $options = array_values(array_unique($values));
        if (count($options) < $this->config['max_nominal_values']) {
          $this->columns[$key]['datatype'] = 'nominal';
          $this->columns[$key]['options'] = $options;
        }
      }
    }
  }

  /**
   * [getColumnData description]
   *
   * @param  string $key [description]
   * @return [type]      [description]
   */
  public function getColumnData($key = '') {
    return @$this->columns[$key] ?: $this->columns;
  }

  /**
   * Ensure the data has unique keys.
   */
  private function addUniqueKeys($data) {
    // Set unique keys on eacht row.
    foreach ($data as $key => $row) {
      $data[uniqid()] = $row;
      unset($data[$key]);
    }

    // Shuffle the data random.
    shuffle($data);

    return $data;
  }
}
