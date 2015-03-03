<?php

namespace MachineLearning\Utility\Entity;

use MachineLearning\Utility\Controller\BaseController;
use MachineLearning\Utility\Model\BaseControllerModel;

/**
 *
 */
class Config extends BaseController implements BaseControllerModel
{
    private $values;

    /**
     * Load the speficied config file.
     */
    public function load($path = 'config.yml')
    {
        $this->values = $this->import($path);
    }

    /**
     * Save the $values to the given path.
     */
    public function save($path = 'config.yml')
    {
        $this->export($this->values, $this->path);
    }

    /**
     * Set the configuration for a given class.
     */
    public function set($classname, $values) {
        $this->values[$classname] = array_merge($values, $this->get($classname));
    }

    /**
     * Get the configuration for a given class.
     */
    public function get($classname) {
        return isset($this->values[$classname]) ? $this->values[$classname] : array();
    }
}
