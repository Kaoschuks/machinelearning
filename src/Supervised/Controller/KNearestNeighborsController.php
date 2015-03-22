<?php

namespace MachineLearning\Supervised\Controller;

use MachineLearning\Utility\Controller\BaseController;
use MachineLearning\Data\Entity\Subset;

class KNearestNeighborsController extends BaseController
{
    /**
     * Find the K nearest neighbors of the given rows.
     */
    public function findNearestNeighbors($testVector, $trainingData, $config)
    {
        $distances = array();

        // Calculate the eucledian distance from the test vector to each vector in the training data.
        foreach ($trainingData->vectors as $trainingVector) {
            $distance = $this->euclideanDistance($testVector->data, $trainingVector->data);

            if ($distance != 0 && $config['distance.boosting']) {
                $distance -= (1 / $distance);
            }

            $distances[$trainingVector->key] = $distance;
        }

        // Order the distances form low to high.
        asort($distances);

        // Pick the top ones with the shortest distance.
        $vectors = array();
        foreach (array_slice($distances, 0, $config['num.nearest.neighbors'], true) as $key => $distance) {
            $vector = $trainingData->vectors->get($key);
            $vectors[$vector->key] = $vector;
        }

        $nearestNeighbors = new Subset();
        $nearestNeighbors->setVectors($vectors);

        return $nearestNeighbors;
    }

    public function classify(&$vector, $nearestNeighbors, $config)
    {
        if ($config['method'] == 'regression') {
            foreach ($vector->data as $key => $value) {
                $values = $nearestNeighbors->getColumnValues($key);
                if ($this->isNumeric($values)) {
                    $vector->class = $this->mean($values);
                }
            }
        }
    }
}
