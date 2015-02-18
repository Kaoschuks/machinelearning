<?php

namespace MachineLearning\Supervised;

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

        foreach ($this->testData->data as $test_row_key => $test_row) {
            $nearestNeighbors = $this->findNearestNeighbors($test_row);
            $classified = array();

            if ($this->method == 'regression') {
                foreach ($columns as $key => $column) {
                    if ($column->datatype == 'numeric') {
                        $classified[$key] = $this->mean(array_column($nearestNeighbors, $key));
                    }
                }
            } else {
                foreach ($columns as $key => $column) {
                    if ($column->datatype == 'numeric') {
                        $majority = $this->majority(array_column($nearestNeighbors, $key));
                    }
                }
            }

            $this->testData->data[$test_row_key]['kNearestNeighbors'] = $nearestNeighbors;
            $this->testData->data[$test_row_key]['classified'] = $classified;
        }
    }

    /**
     * Find the K nearest neighbors of the given rows.
     */
    private function findNearestNeighbors($test_row)
    {
        $nearestNeighbors = array();
        $distances = array();
        $training_data = $this->trainingData->data;

        // Calculate the eucledian distance from the test_row to each row in the training data.
        foreach ($training_data as $training_row_key => $training_row) {
            $distance = $this->euclideanDistance($test_row, $training_row);
            if ($this->distance_boosting) {
                $distance -= (1 / $distance);
            }
            $distances[$training_row_key] = $distance;
        }

        // Order the distances form low to hight.
        asort($distances);

        // Pick the top ones with the shortest distance.
        $training_row_keys = array_keys(array_slice($distances, 0, $this->num_nearest_neighbors, true));
        foreach ($training_row_keys as $training_row_key) {
            $nearestNeighbors[$training_row_key] = $training_data[$training_row_key];
        }

        return $nearestNeighbors;
    }
}
