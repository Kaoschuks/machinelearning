<?php

namespace MachineLearning;

/**
 * Basic Machine learning utility class.
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

    /**
   * Picks a random number, and returns a float.
   *
   * @return [type] [description]
   */
  public function rand($min, $max) {
    return $min + ($max - $min) * mt_rand(0, 32767)/32767;
  }

  /**
   * Calculate the Euclidean distance between 2 arrays with the same keys.
   *
   * @param  [type] $p [description]
   * @param  [type] $q [description]
   * @return [type]    [description]
   */
  public function euclideanDistance($p, $q) {
    if (count($p) != count($q)) {
      return;
    }

    $total = 0;
    foreach ($p as $key => $pn) {
      $total += pow($p[$key] - $q[$key], 2);
    }

    return sqrt($total);
  }
}
