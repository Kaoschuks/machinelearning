<?php

namespace MachineLearning\Data\Entity;

use MachineLearning\Data\Entity\Subset;
use MachineLearning\Utility\Entity\Config;

/**
 * Base class for the data handling.
 */
class Dataset extends Subset
{
    private $config;
    public $traningData;
    public $validationData;
    public $testData;

    /**
     * Set the configuration.
     */
    public function setConfig(Config $config)
    {
        $config->set('Dataset', array(
            'remove.missing.values' => true,
            'deassociative.column.keys' => true,
            'normalize.data' => false,
            'shuffle.data' => true,
        ));
        $this->config = $config;
    }

    /**
     * Get the configuration.
     */
    public function getConfig()
    {
        return $this->config->get('Dataset');
    }

    /**
     * Add the raw data
     */
    public function addData($data)
    {
        $config = $this->getConfig();

//         // Remove rows with missing values.
//         if ($config['remove.missing.values']) {
//             $data = $this->missing($data);
//         }

//         // Normalize the numeric values.
//         if ($config['normalize.data']) {
//             $data = $this->normalize($data);
//         }

//         // Randomize the data.
//         if ($config['shuffle.data']) {
//             shuffle($data);
//         }

//         $this->data = $data;

        parent::addData($data);
    }

//     /**
//      * Handle missing values.
//      */
//     private function missing($data, $action = 'remove')
//     {
//         $missing = array();

//         // Fetch all unique column names.
//         $column_keys = array();
//         foreach ($data as $row_key => $row) {
//             foreach ($row as $column_key => $value) {
//                 if (!in_array($column_key, array_keys($column_keys))) {
//                     $column_keys[$column_key] = null;
//                 }
//             }
//         }

//         // Fill the missing values with NULL.
//         foreach ($data as $row_key => $row) {
//             if (!empty(array_diff_key($row, $column_keys))) {
//                 if ($action == 'remove') {
//                     unset($data[$row_key]);
//                 } elseif ($action == 'list') {
//                     $missing[$row_key] = $row;
//                 } elseif ($action == 'fill') {
//                     $data[] = $row + $column_keys;
//                 }
//             }
//         }

//         if ($action == 'list') {
//             return $missing;
//         }

//         return $data;
//     }

//     /**
//      * Normalize the data.
//      */
//     private function normalize($data)
//     {
//         $count = count($data);
//         foreach ($data as $row_key => $row) {
//             foreach ($row as $column_key => $value) {
//                 if (is_numeric($value)) {
//                     $data[$row_key][$column_key] = $value / ($count * sqrt($count));
//                 }
//             }
//         }
//         return $data;
//     }

    /**
     * Create a subset of the data, by the given start and end point.
     */
    private function subset($start, $length)
    {
        $config = $this->config;
        $config->set('Dataset', array('shuffle.data' => false));

        $subset = new Dataset();
        $subset->setConfig($config);
        $subset->setVectors(array_slice($this->vectors->getMultiple(), $start, $length, true));

        return $subset;
    }

    /**
     * Split the dataset in sub-datasets.
     */
    public function split($training_ratio = 0.7, $validation_ratio = 0.2, $test_ratio = 0.1)
    {
        $size = $this->vectors->count();

        $training_length = $size * $training_ratio;
        $validation_length = $size * $validation_ratio;
        $test_length = $size * $test_ratio;

        $this->traningData = $this->subset(0, $training_length);
        $this->validationData = $this->subset($training_length, $validation_length);
        $this->testData = $this->subset($training_length + $validation_length, $test_length);
    }
}
