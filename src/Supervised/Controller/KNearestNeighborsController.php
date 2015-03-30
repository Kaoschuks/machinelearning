<?php

namespace MachineLearning\Supervised\Controller;

use MachineLearning\Utility\Entity\Calculate;
use MachineLearning\Utility\Entity\Config;
use MachineLearning\Utility\Entity\Utility;
use MachineLearning\Data\Entity\Collection;
use MachineLearning\Data\Entity\Dataset;
use MachineLearning\Data\Entity\Object;

/**
 * KNearestNeighborsController, Contains K nearest neighbors functionality.
 *
 * @author Willem Bressers <info@willembressers.nl>
 */
class KNearestNeighborsController
{
    /**
     * Find the K nearest neighbors of the given vector.
     *
     * @param Object  $testVector
     * @param Dataset $trainingData
     * @param Config  $config
     *
     * @return Collection of nearest neighbors
     */
    public function findNearestNeighbors(Object $testVector, Dataset $trainingData, Config $config)
    {
        $configuration = $config->get('KNearestNeighbors');
        $distances = array();

        // Calculate the eucledian distance from the test vector to each vector in the training data.
        foreach ($trainingData->vectors as $trainingVector) {
            $distance = Calculate::euclideanDistance($testVector->data, $trainingVector->data);

            if ($distance != 0 && $configuration['distance.boosting']) {
                $distance -= (1 / $distance);
            }

            $distances[$trainingVector->key] = $distance;
        }

        // Order the distances form low to high.
        asort($distances);

        // Pick the top ones with the shortest distance.
        $nearestNeighbors = new Collection($testVector->key);
        foreach (array_slice($distances, 0, $configuration['num.nearest.neighbors'], true) as $key => $distance) {
            $nearestNeighbors->set($key, $trainingData->vectors->get($key));
        }

        return $nearestNeighbors;
    }

    /**
     * Classify the given vector based on the it's nearest neighbors.
     *
     * @param Object     &$vector
     * @param Collection $nearestNeighbors
     * @param Config     $config
     */
    public function classify(Object &$vector, Collection $nearestNeighbors, Config $config)
    {
        $configuration = $config->get('KNearestNeighbors');

        if ($configuration['method'] == 'regression') {
            foreach ($vector->data as $key => $value) {
                $values = $nearestNeighbors->getColumnValues($key);
                if (Utility::isNumeric($values)) {
                    $vector->class = Calculate::mean($values);
                }
            }
        }
    }
}
