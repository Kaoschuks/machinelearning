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
 * Class Dataset
 * @package League\MachineLearning\Dataset
 */
class Dataset
{
    private $instances;

    /**
     * @param Instance $instance
     */
    public function setInstance(Instance $instance)
    {
        $this->instances[] = $instance;
    }
}
