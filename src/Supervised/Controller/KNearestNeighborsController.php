<?php

namespace MachineLearning\Supervised\Controller;

use MachineLearning\Utility\Controller\BaseController;
use MachineLearning\Data\Entity\Subset;

class KNearestNeighborsController extends BaseController
{
    /**
     * Find the K nearest neighbors of the given rows.
     */
    public function findNearestNeighbors($testVector, $trainingVectors, $config)
    {
        $distances = array();

        // Calculate the eucledian distance from the test vector to each vector in the training data.
        foreach ($trainingVectors as $trainingVector) {
            $distance = $this->euclideanDistance($testVector->data, $trainingVector->data);

        //     if ($distance != 0 && $config['distance.boosting']) {
        //         $distance -= (1 / $distance);
        //     }

        //     $distances[$key] = $distance;
        // }

        // // Order the distances form low to high.
        // asort($distances);

        // // Pick the top ones with the shortest distance.
        // $data = array();
        // foreach (array_slice($distances, 0, $config['num.nearest.neighbors'], true) as $key => $distance) {
        //     $data[$key] = $trainingVectors[$key]->getValues();
        }

        $nearestNeighbors = new Subset();
        // $nearestNeighbors->addData($data);

        return $nearestNeighbors;
    }
}
