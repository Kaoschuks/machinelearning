<?php

namespace MachineLearning\Data;

/**
 * Base class for the data handling.
 */
class Dataset
{
    private $raw_data;
    private $data;
    public $columns;
    public $vectors;

    // Config properties.
    public $config;

    public function __construct($config = array()) {
        $this->config = $config + array(
            'removeMissingValues' => true,
            'normalizeData' => false,
            'shuffleData' => true,
        );
    }

    /**
     * Add the raw data
     */
    public function addData($data)
    {
        $this->raw_data = $data;

        // Remove rows with missing values.
        if ($this->config['removeMissingValues']) {
            $data = $this->missing($data);
        }

        // Normalize the numeric values.
        if ($this->config['normalizeData']) {
            $data = $this->normalize($data);
        }

        // Randomize the data.
        if ($this->config['shuffleData']) {
            shuffle($data);
        }

        $this->data = $data;

        // Add the columns.
        $this->setColumns($data);

        // Add the vectors.
        $this->setVectors($data);
    }

    /**
     * Create a subset of the data, by the given start and end point.
     */
    private function subset($start, $end)
    {
        $config = $this->config;
        $config['shuffleData'] = false;
        $data = array_slice($this->data, $start, $end, true);

        $subset = new Dataset($config);
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

     /**
     * Create the columns.
     */
    private function setColumns($data)
    {
        $missing = array();

        // Fetch all unique column names.
        $column_keys = array();
        foreach ($data as $row_key => $row) {
            foreach ($row as $column_key => $value) {
                if (!in_array($column_key, array_keys($column_keys))) {
                    $column_keys[$column_key] = null;
                }
            }
        }

        // Add the columns.
        foreach (array_keys($column_keys) as $key) {
            $this->columns[$key] = new Column($key, array_column($data, $key));
        }
    }

     /**
     * Create the vectors.
     */
    private function setVectors($data)
    {
        foreach ($data as $key => $row) {
            $vector = new Vector();
            $vector->setValues($row);

            $this->vectors[$key] = $vector;
        }
    }

    /**
     * Handle missing values.
     */
    private function missing($data, $action = 'remove')
    {
        $missing = array();

        // Fetch all unique column names.
        $column_keys = array();
        foreach ($data as $row_key => $row) {
            foreach ($row as $column_key => $value) {
                if (!in_array($column_key, array_keys($column_keys))) {
                    $column_keys[$column_key] = null;
                }
            }
        }

        // Fill the missing values with NULL.
        foreach ($data as $row_key => $row) {
            if (!empty(array_diff_key($row, $column_keys))) {
                if ($action == 'remove') {
                    unset($data[$row_key]);
                } elseif ($action == 'list') {
                    $missing[$row_key] = $row;
                } elseif ($action == 'fill') {
                    $data[] = $row + $column_keys;
                }
            }
        }

        if ($action == 'list') {
            return $missing;
        }

        return $data;
    }

    /**
     * Normalize the data.
     */
    private function normalize($data)
    {
        $count = count($data);
        foreach ($data as $row_key => $row) {
            foreach ($row as $column_key => $value) {
                if (is_numeric($value)) {
                    $data[$row_key][$column_key] = $value / ($count * sqrt($count));
                }
            }
        }
        return $data;
    }
}
