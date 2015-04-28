<?php

namespace League\MachineLearning\Utility\Entity;

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

    /**
     * Calculate the entropy of a given array.
     *
     * @param  array  $frequencies
     *
     * @return float
     */
    public function entropy(array $frequencies)
    {
        $entropy = 0;
        $total = array_sum($frequencies);

        foreach ($frequencies as $frequency) {
            if ($proportion = $frequency / $total) {
                $entropy += -($proportion * log($proportion, 2));
            }
        }

        return $entropy;
    }

    /**
     * Calculate the informatoin gain of attributes array based on the classifier array.
     *
     * @param  array  $classifier_frequencies
     * @param  array  $attribute_frequencies
     *
     * @return float
     */
    public function gain(array $classifier_frequencies, array $attribute_frequencies)
    {
        $classifier_total = array_sum($classifier_frequencies);

        $gain = Calculate::entropy($classifier_frequencies);
        foreach ($attribute_frequencies as $value => $frequencies) {
            $gain -= (array_sum($frequencies) / $classifier_total) * Calculate::entropy($frequencies);
        }

        return $gain;
    }
}
