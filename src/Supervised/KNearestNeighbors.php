<?php

namespace MachineLearning\Supervised;

use MachineLearning\Data\Subset;
use MachineLearning\Interfaces\InstanceBasedLearningInterface;

/**
 *
 */
class KNearestNeighbors extends Supervised implements InstanceBasedLearningInterface
{

    public $num_nearest_neighbors;
    public $method;
    public $distance_boosting;

    /**
     * Basic constructor.
     */
    public function __construct($num_nearest_neighbors = 3, $method = 'regression', $distance_boosting = true)
    {
        $this->num_nearest_neighbors = $num_nearest_neighbors;
        $this->method = $method;
        $this->distance_boosting = $distance_boosting;
    }

    /**
     * Classify the testdata based on the trainingsdata.
     */
    public function test()
    {
        $columns = $this->trainingData->columns;

        foreach ($this->testData->vectors as $vector) {
            $nearestNeighbors = $this->findNearestNeighbors($vector);
            $classified = array();

            if ($this->method == 'regression') {
                foreach ($columns as $key => $column) {
                    if ($column->isNumeric()) {
                        $classified[$key] = $this->mean($nearestNeighbors->column($key));
                    }
                }
            } else {
                foreach ($columns as $key => $column) {
                    if ($column->isNumeric()) {
                        $majority = $this->majority($nearestNeighbors->column($key));
                    }
                }
            }

            $vector->classify($classified);
        }
    }

    /**
     * Find the K nearest neighbors of the given rows.
     */
    private function findNearestNeighbors($vector)
    {
        $nearestNeighbors = new Subset();
        $distances = array();
        $training_vectors = $this->trainingData->vectors;

        // Calculate the eucledian distance from the test_row to each row in the training data.
        foreach ($training_vectors as $training_vector_key => $training_vector) {
            $distance = $this->euclideanDistance($vector->values, $training_vector->values);
            if ($distance != 0 && $this->distance_boosting) {
                $distance -= (1 / $distance);
            }
            $distances[$training_vector_key] = $distance;
        }

        // Order the distances form low to hight.
        asort($distances);

        // Pick the top ones with the shortest distance.
        $keys = array_keys(array_slice($distances, 0, $this->num_nearest_neighbors, true));
        foreach ($keys as $key) {
            $nearestNeighbors->addVector($key, $training_vectors[$key]);
        }

        return $nearestNeighbors;
    }
}
