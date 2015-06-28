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
 * Class DataHandler
 * @package League\MachineLearning\Service
 */
class DataHandler
{
    private $dataset;

    public function __construct()
    {
        $this->dataset = new Dataset();
    }

    /**
     * @return Dataset
     */
    public function getDataset()
    {
        return $this->dataset;
    }

    /**
     * @param $data
     */
    public function addData($data)
    {
        foreach ($data as $row) {
            $instance = new Instance();
            $instance->setData($row);
            $this->dataset->setInstance($instance);
        }
    }
}
