<?php

namespace MachineLearning\Utility\Entity;

/**
 * Utility, Contains some global functionality.
 *
 * @author Willem Bressers <info@willembressers.nl>
 */
class Utility
{
    /**
     * Custom random method that works with floats.
     *
     * @param  float $min
     * @param  float $max
     *
     * @return float
     */
    public function rand($min, $max)
    {
        return $min + ($max - $min) * mt_rand(0, 32767) / 32767;
    }

    /**
     * Returns the item in the array that occurs the most.
     * All values are sorted by count, and the first (highest) is returned.
     * Values with the same count are also sorted but only the first one is returned.
     *
     * @param  array  $array
     *
     * @return mixed the first array occurence.
     */
    public function majority(array $array)
    {
          // Count each unique value.
        $count_values = array_count_values(array_map(function ($value) {
          return (string) $value;
        }, $array));

        // Sort from high to low.
        arsort($count_values);

        // return the first item.
        return reset(array_flip($count_values));
    }

    /**
     * Check if the majority type of the values in the array is numeric.
     */
    public function isNumeric(array $array) {
        $types = array();
        foreach ($array as $value) {
            $types[] = is_numeric($value);
        }
        return self::majority($types);
    }
}
