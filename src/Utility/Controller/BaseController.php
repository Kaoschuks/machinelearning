<?php

namespace MachineLearning\Utility\Controller;

use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;

class BaseController
{
    /**
     * Import specified yml file.
     */
    public function import($path)
    {
        $yaml = new Parser();
        try {
            return file_exists($path) ? $yaml->parse(file_get_contents($path)) : array();
        } catch (ParseException $e) {
            printf("Unable to parse the YAML string: %s", $e->getMessage());
        }
    }

    /**
     * Export the given data to the specified path.
     */
    public function export($data, $path)
    {
        $dumper = new Dumper();
        $yaml = $dumper->dump($data, 2);
        file_put_contents($path, $yaml);
    }

    /**
     * Get the default statistics of an array.
     */
    public function getDefaultStatistics($values)
    {
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
     */
    public function mean($values)
    {
        return array_sum($values) / count($values);
    }

    /**
     * Calculates the variance of an array of values based on the mean.
     */
    public function variance($values, $mean)
    {
        $values = array_map(function ($value) use ($mean) {
            return pow($value - $mean, 2);
        }, $values);

        return $this->mean($values);
    }

    /**
     * Custom random method that works with floats.
     */
    public function rand($min, $max)
    {
        return $min + ($max - $min) * mt_rand(0, 32767)/32767;
    }

    /**
     * Calculate the Euclidean distance between 2 arrays with the same keys.
     */
    public function euclideanDistance($p, $q)
    {
        if (count($p) != count($q)) {
            return;
        }

        $total = 0;
        foreach ($p as $key => $pn) {
            $total += pow($p[$key] - $q[$key], 2);
        }

        return sqrt($total);
    }

    /**
     * Returns the item in the array that occurs the most.
     *
     * All values are sorted by count, and the first (highest) is returned. Values with the same count are also sorted but only the first one is returned.
     */
    public function majority($values)
    {
        // Count each unique value.
      $count_values = array_count_values(array_map(function ($value) {
        return (string) $value;
      }, $values));

      // Sort from high to low.
      arsort($count_values);

      // return the first item.
      return reset(array_flip($count_values));
    }
}
