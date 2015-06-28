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
 * Class Instance
 * @package League\MachineLearning\Dataset
 */
class Instance
{

    private $data;

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}
