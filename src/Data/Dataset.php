<?php

namespace MachineLearning\Data;

/**
 * Base class for the data handling.
 */
class Dataset
{

    private $raw_data;
    public $data;
    public $columns;

    /**
     * Add the raw data
     */
    public function addData($raw_data)
    {
        $this->raw_data = $raw_data;
        $data = array();

        // Fetch all unique column names.
        $column_keys = array();
        foreach ($raw_data as $row_key => $row_values) {
            foreach ($row_values as $column_key => $value) {
                if (!in_array($column_key, array_keys($column_keys))) {
                    $column_keys[$column_key] = null;
                }
            }
        }

        // Fill the missing values with NULL.
        foreach ($raw_data as $row_key => $row_values) {
            $data[] = $row_values + $column_keys;
        }

        // Randomize the data.
        shuffle($data);

        // Add the columns.
        foreach (array_keys($column_keys) as $key) {
            $this->columns[$key] = new Column($key, array_column($data, $key));
        }

        $this->data = $data;
    }

    /**
     * Create a subset of the data, by the given start and end point.
     */
    private function subset($start, $end)
    {
        $data = array_slice($this->data, $start, $end, true);

        $subset = new Dataset();
        $subset->addData($data);

        return $subset;
    }

    /**
     * Split the dataset in sub-datasets.
     */
    public function split($training_ratio = 0.7, $validation_ratio = 0.2, $test_ratio = 0.1)
    {
        $training_length = count($this->data) * $training_ratio;
        $validation_length = count($this->data) * $validation_ratio;
        $test_length = count($this->data) * $test_ratio;

        return array(
          $this->subset(0, $training_length),
          $this->subset($training_length, $validation_length),
          $this->subset($training_length + $validation_length, $test_length),
        );
    }
}
