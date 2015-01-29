<?php

namespace MachineLearning\DataPreparation;

/**
 *
 */
class Dataset {

  public $data;
  public $num_rows;
  public $columns;
  public $max_nominal_values;

  /**
   * Basic constructor.
   *
   * @param [array] $data [The dataset to work with.]
   */
  public function __construct($data) {
    $this->max_nominal_values = 100;
    $this->data = $data;
    $this->num_rows = count($data);

    $this->fetchColumnData();
  }

  /**
   * Fetch the column data
   */
  public function fetchColumnData() {
    foreach (reset($this->data) as $key => $value) {
      $values = $this->getColumnValues($key);
      $type = gettype($value);

      $this->columns[$key]['type'] = $type;

      if (is_numeric($value)) {
        $this->columns[$key]['datatype'] = 'numeric';
        $mean = $this->mean($values);
        $variance = $this->variance($values, $mean);

        $this->columns[$key]['min'] = min($values);
        $this->columns[$key]['max'] = max($values);
        $this->columns[$key]['mean'] = $mean;
        $this->columns[$key]['variance'] = $variance;
        $this->columns[$key]['std_dev'] = sqrt($variance);
      }

      if (is_string($value)) {
        $options = array_unique($values);
        if (count($options) < $this->max_nominal_values) {
          $this->columns[$key]['datatype'] = 'nominal';
          $this->columns[$key]['options'] = array_values($options);
        }
      }
    }
  }

  /**
   * Get all values in the specified column.
   *
   * @param  [mixed] $key    [The name of the column.]
   * @return [array]         [An array of column values.]
   */
  public function getColumnValues($key) {
    // Custom version of the array_column function available from php 5.5.
    $array_column = function ($array, $column_key) {
      return array_map(function ($row) use ($column_key) {
        return $row[$column_key];
      }, $array);
    };

    return $array_column($this->data, $key);
  }

  /**
   * Calculates the mean of the given values.
   *
   * @param  [array] $values [An array of column values.]
   * @return [float]         [The calculated mean.]
   */
  private function mean($values) {
    return array_sum($values) / $this->num_rows;
  }

  /**
   * Calculates the variance of an array of values based on the mean.
   *
   * @param  [array] $values [An array of column values.]
   * @param  [float] $mean   [The mean of the given array.]
   * @return [float]         [The calculated variance.]
   */
  private function variance($values, $mean) {
    $values = array_map(function ($value) use ($mean) {
      return pow($value - $mean, 2);
    }, $values);
    return array_sum($values) / $this->num_rows;
  }
}
