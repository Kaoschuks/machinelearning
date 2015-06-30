<?php
/**
 * @category Service Object.
 * @package League\MachineLearning\Service
 * @author Willem Bressers <info@willembressers.nl>
 * @license MIT
 * @link https://github.com/willembressers/machinelearning
 */

namespace League\MachineLearning\Service;

use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;

/**
 * This class handles the configuration.
 *
 * Class ConfigurationHandler
 * @package League\MachineLearning\Service
 */
class ConfigurationHandler
{
    const ALGORITHM_NAMESPACE = '\League\MachineLearning\Algorithm\\';

    protected $file;

    /**
     * @param string $file
     */
    public function __construct($file = '')
    {
        $this->file = $file;
    }

    /**
     * Specify the configuration file.
     *
     * @param $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Returns the raw contents of the configuration file.
     *
     * @return array|mixed
     */
    public function getContent()
    {
        if ($this->file && file_exists($this->file)) {
            $yaml = new Parser();
            return $yaml->parse(file_get_contents($this->file));
        }
        return array();
    }

    /**
     * Stores the raw contents to the configuration file.
     *
     * @param $content
     */
    public function setContent($content)
    {
        $dumper = new Dumper();
        $yaml = $dumper->dump($content, 2);
        file_put_contents($this->file, $yaml);
    }

    /**
     * Loops over the specified algorithms, loads and returns the class.
     *
     * @return \Generator
     */
    public function getAlgorithms()
    {
        $content = $this->getContent();
        foreach ($content['Algorithms'] as $algorithmInfo) {
            $class = self::ALGORITHM_NAMESPACE. $algorithmInfo['class'];
            if (class_exists($class, true)) {
                yield new $class();
            }
        }
    }
}
