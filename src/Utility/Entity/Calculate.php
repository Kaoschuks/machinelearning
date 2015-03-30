<?php

namespace MachineLearning\Utility\Entity;

/**
 * Calculate, contains several calculations with arrays.
 *
 * @author Willem Bressers <info@willembressers.nl>
 */
class Calculate
{
    /**
     * Get the default statistics of an array.
     *
     * @param array $array
     *
     * @return array of default statistics.
     */
    public function defaultStatistics(array $array)
    {
        $mean = self::mean($array);
        $variance = self::variance($array, $mean);

        return array(
            'min' => min($array),
            'max' => max($array),
            'mean' => $mean,
            'variance' => $variance,
            'std_dev' => sqrt($variance),
        );
    }

    /**
     * Calculates the mean of the given values.
     *
     * @param array $array
     *
     * @return float
     */
    public function mean(array $array)
    {
        return array_sum($array) / count($array);
    }

    /**
     * Calculates the variance of an array of values based on the mean.
     *
     * @param array $array
     * @param float $mean
     *
     * @return float
     */
    public function variance(array $array, $mean)
    {
        $array = array_map(function ($value) use ($mean) {
            return pow($value - $mean, 2);
        }, $array);

        return self::mean($array);
    }

    /**
     * Calculate the squared distance between 2 arrays.
     *
     * @param array $p
     * @param array $q
     *
     * @return float
     */
    public function squaredDistance(array $p, array $q)
    {
        if (count($p) != count($q)) {
            return;
        }

        $total = 0;
        foreach ($p as $key => $pn) {
            $total += pow($p[$key] - $q[$key], 2);
        }

        return $total;
    }

    /**
     * Calculate the Euclidean distance between 2 arrays with the same keys.
     *
     * @param array $p
     * @param array $q
     *
     * @return float
     */
    public function euclideanDistance(array $p, array $q)
    {
        return sqrt(self::squaredDistance($p, $q));
    }
}
