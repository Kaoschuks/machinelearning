<?php

namespace MachineLearning\DataPreparation;

/**
 *
 */
class Dataset {

  public $data;
  public $columns;
  private $config;

  /**
   * Basic constructor.
   *
   * @param [array] $data [The dataset to work with.]
   */
  public function __construct($data, $max_nominal_values = 100) {
    $this->data = $data;
    $this->config['max_nominal_values'] = $max_nominal_values;
    $this->setColumnData();
  }

  /**
   * [getNumRows description]
   *
   * @return [type] [description]
   */
  public function getNumRows() {
    return count($this->data);
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
   * [getDefaultStatistics description]
   *
   * @param  [type] $values [description]
   * @return [type]         [description]
   */
  private function getDefaultStatistics($values) {
    $mean = $this->mean($values);
    $variance = $this->variance($values, $mean);

    return array(
      'min' => min($values),
      'max' => max($values),
      'mean' => $mean,
      'variance' => $variance,
      'std_dev' => sqrt($variance),
    );
  }

  /**
   * Calculates the mean of the given values.
   *
   * @param  [array] $values [An array of column values.]
   * @return [float]         [The calculated mean.]
   */
  private function mean($values) {
    return array_sum($values) / $this->getNumRows();
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

    return array_sum($values) / $this->getNumRows();
  }
}
