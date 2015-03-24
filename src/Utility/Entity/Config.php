<?php

namespace MachineLearning\Utility\Entity;

use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * Config, Loads and saves configuration in a YAML file.
 *
 * @author Willem Bressers <info@willembressers.nl>
 */
class Config
{
    private $values;

    /**
     * Load the speficied config file.
     *
     * @param  string $path
     */
    public function load($path = 'config.yml')
    {
        $this->values = $this->import($path);
    }

    /**
     * Save the $values to the given path.
     *
     * @param  string $path
     */
    public function save($path = 'config.yml')
    {
        $this->export($this->values, $this->path);
    }

    /**
     * Import specified yml file.
     *
     * @param  string $path
     *
     * @return array of values
     */
    public function import($path)
    {
        $yaml = new Parser();
        try {
            return file_exists($path) ? $yaml->parse(file_get_contents($path)) : array();
        } catch (ParseException $e) {
            printf("Unable to parse the YAML string: %s", $e->getMessage());
        }
    }

    /**
     * Export the given data to the specified path.
     *
     * @param  array  $values
     * @param  string $path
     */
    public function export(array $values, $path)
    {
        $dumper = new Dumper();
        $yaml = $dumper->dump($values, 2);
        file_put_contents($path, $yaml);
    }

    /**
     * Set the configuration for a given class.
     *
     * @param string $classname
     * @param array  $values
     */
    public function set($classname, array $values) {
        $this->values[$classname] = array_merge($values, $this->get($classname));
    }

    /**
     * Get the configuration for a given class.
     *
     * @param string $classname
     *
     * @return array of values
     */
    public function get($classname) {
        return isset($this->values[$classname]) ? $this->values[$classname] : array();
    }
}
