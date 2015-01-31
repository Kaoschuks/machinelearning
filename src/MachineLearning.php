<?php

namespace MachineLearning;

/**
 *
 */
class MachineLearning {


  /**
   * [getDefaultStatistics description]
   *
   * @param  [type] $values [description]
   * @return [type]         [description]
   */
  public function getDefaultStatistics($values) {
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
  public function mean($values) {
    return array_sum($values) / count($values);
  }

  /**
   * Calculates the variance of an array of values based on the mean.
   *
   * @param  [array] $values [An array of column values.]
   * @param  [float] $mean   [The mean of the given array.]
   * @return [float]         [The calculated variance.]
   */
  public function variance($values, $mean) {
    $values = array_map(function ($value) use ($mean) {
      return pow($value - $mean, 2);
    }, $values);

    return $this->mean($values);
  }
}
