<?php

namespace MachineLearning\Data\Entity;

use MachineLearning\Utility\Entity\Config;

/**
 * Dataset, Base class for the data handling.
 *
 * @author Willem Bressers <info@willembressers.nl>
 */
class Dataset
{
    private $config;

    public $vectors;
    public $vectorMap = array();
    public $columnMap = array();

    /**
     * Set the configuration.
     *
     * @param Config $config
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
     * Add the raw data.
     */
    public function addData($data)
    {
        $config = $this->config->get('Dataset');

        $this->deAssociativeVectorKeys($data);
        $this->deAssociativeColumnKeys($data);
        $this->floatval($data);

        $this->vectors = new Collection();

        // Add the data.
        foreach ($data as $key => $values) {
            $vector = new Object($key, $values);
            $this->vectors->set($key, $vector);
        }
    }

    /**
     * Map the associative vectors array to an non-associative vectors array.
     *
     * @param array &$data
     */
    private function deAssociativeVectorKeys(array &$data)
    {
        // Get the vector keys map.
        $this->vectorMap = array_keys($data);

        $new_data = array();
        foreach ($this->vectorMap as $key => $value) {
            $new_data[$key] = $data[$value];
        }
        $data = $new_data;
    }

    /**
     * Map the associative columns array to an non-associative columns array.
     *
     * @param array &$data
     */
    private function deAssociativeColumnKeys(array &$data)
    {
        // Get the column keys map.
        foreach ($data as $array) {
            $this->columnMap = array_unique(array_merge($this->columnMap, array_keys($array)));
        }

        // Map the column keys to the numeric keys.
        foreach ($data as &$row) {
            foreach ($this->columnMap as $key => $value) {
                $row[$key] = null;
                if (isset($row[$value])) {
                    $row[$key] = $row[$value];
                    unset($row[$value]);
                }
            }
        }
    }

    /**
     * Make the numeric values in the data floats.
     *
     * @param array &$data
     */
    private function floatval(array &$data)
    {
        foreach ($data as &$row) {
            foreach ($row as &$value) {
                $value = is_numeric($value) ? floatval($value) : $value;
            }
        }
    }

    /**
     * Create a subset of the data, by the given start and end point.
     *
     * @param integer $start
     * @param integer $length
     *
     * @return Dataset
     */
    private function subset($start, $length)
    {
        $config = $this->config;
        $config->set('Dataset', array('shuffle.data' => false));

        $subset = new Dataset();
        $subset->setConfig($config);

        $subset->vectors = new Collection();
        $subset->vectors->setMultiple(array_slice($this->vectors->getMultiple(), $start, $length, true));

        return $subset;
    }

    /**
     * Split the dataset in sub-datasets.
     *
     * @param float $training_ratio
     * @param float $validation_ratio
     * @param float $test_ratio
     *
     * @return array
     */
    public function split($training_ratio = 0.7, $validation_ratio = 0.2, $test_ratio = 0.1)
    {
        $size = $this->vectors->count();

        $training_length = $size * $training_ratio;
        $validation_length = $size * $validation_ratio;
        $test_length = $size * $test_ratio;

        return array(
            $this->subset(0, $training_length),
            $this->subset($training_length, $validation_length),
            $this->subset($training_length + $validation_length, $test_length),
        );
    }
}
