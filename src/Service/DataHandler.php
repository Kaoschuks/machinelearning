<?php
/**
 * @category Service Object.
 * @package League\MachineLearning\Service
 * @author Willem Bressers <info@willembressers.nl>
 * @license MIT
 * @link https://github.com/willembressers/machinelearning
 */

namespace League\MachineLearning\Service;

use League\MachineLearning\Data\Instance;
use League\MachineLearning\Data\Dataset;

/**
 * This class facilitates several actions on the dataset.
 *
 * Class DataHandler
 * @package League\MachineLearning\Service
 */
class DataHandler
{
    private $dataset;

    /**
     * @param array $data
     */
    public function __construct($data = array())
    {
        $this->dataset = new Dataset();
        $this->addData($data);
    }

    /**
     * Returns the dataset.
     *
     * @return mixed
     */
    public function getDataset()
    {
        return $this->dataset;
    }

    /**
     * Loads raw data into the dataset.
     *
     * @param $data
     */
    public function addData($data)
    {
        foreach ($data as $row) {
            $instance = new Instance();
            $instance->setData($row);
            $this->dataset->attach($instance);
        }
    }
}
