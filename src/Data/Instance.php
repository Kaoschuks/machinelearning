<?php
/**
 * @category Value Object.
 * @package League\MachineLearning\Dataset
 * @author Willem Bressers <info@willembressers.nl>
 * @license MIT
 * @link https://github.com/willembressers/machinelearning
 */

namespace League\MachineLearning\Data;

/**
 * This class contains the individual instance data.
 *
 * Class Instance
 * @package League\MachineLearning\Data
 */
class Instance
{
    private $data;

    /**
     * Add data to the instance.
     *
     * @param $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}
