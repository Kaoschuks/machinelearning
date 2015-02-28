<?php

namespace MachineLearning\Utility\Entity;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 *
 */
class Config
{
    private $values;
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
        $this->load();
    }

    public function load()
    {
        $yaml = new Parser();
        try {
            if (file_exists($this->path)) {
                $this->values = $yaml->parse(file_get_contents($this->path));
            }
        } catch (ParseException $e) {
            printf("Unable to parse the YAML string: %s", $e->getMessage());
        }
    }

    public function set($classname, $values) {
        $this->values[$classname] = array_merge($values, $this->get($classname));
    }

    public function get($classname) {
        return isset($this->values[$classname]) ? $this->values[$classname] : array();
    }
}
