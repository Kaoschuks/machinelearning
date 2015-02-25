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
        foreach ($this->testData->getVectors() as $vector) {
            $nearestNeighbors = $this->findNearestNeighbors($vector);
            // print_r($nearestNeighbors);
            $class = array();

            if ($this->method == 'regression') {
                foreach ($this->trainingData->getColumns() as $key => $column) {
                    if ($column->isNumeric()) {
                        $class[$key] = $this->mean($nearestNeighbors->getColumn($key)->getValues());
                    }
                }
            } else {
                foreach ($columns as $key => $column) {
                    if ($column->isNumeric()) {
                        $majority = $this->majority($nearestNeighbors->getColumn($key)->getValues());
                    }
                }
            }

            $vector->setClass($class);
        }
    }

    /**
     * Find the K nearest neighbors of the given rows.
     */
    private function findNearestNeighbors($vector)
    {
        $nearestNeighbors = new Subset();
        $distances = array();

        // Calculate the eucledian distance from the test_row to each row in the training data.
        foreach ($this->trainingData->getVectors() as $training_vector_key => $training_vector) {
            $distance = $this->euclideanDistance($vector->getValues(), $training_vector->getValues());
            if ($distance != 0 && $this->distance_boosting) {
                $distance -= (1 / $distance);
            }
            $distances[$training_vector_key] = $distance;
        }

        // Order the distances form low to hight.
        asort($distances);

        // Pick the top ones with the shortest distance.
        $keys = array_keys(array_slice($distances, 0, $this->num_nearest_neighbors, true));
        $data = array();
        foreach ($keys as $key) {
            $data[$key] = $this->trainingData->getVector($key)->getValues();
        }
        $nearestNeighbors->addData($data);

        return $nearestNeighbors;
    }
}
