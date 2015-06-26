<?php
/**
 * Created by PhpStorm.
 * User: willembressers
 * Date: 26/06/15
 * Time: 21:43
 */

namespace League\MachineLearning\Service;


use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;

class MachineLearningService {

    private $path;
    private $configuration;

    function __construct($path = '')
    {
        $this->loadConfiguration($path);
    }

    /**
     * Get the configuration.
     *
     * @return mixed
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Load the configuration from a path.
     *
     * @param string $path
     */
    public function loadConfiguration($path)
    {
        $this->path = $path;
        $this->configuration = array();

        if ($this->path && file_exists($this->path)) {
            $yaml = new Parser();
            try {
                $this->configuration = $yaml->parse(file_get_contents($this->path));
            } catch (ParseException $e) {
                printf("Unable to parse the YAML string: %s", $e->getMessage());
            }
        }
    }

}