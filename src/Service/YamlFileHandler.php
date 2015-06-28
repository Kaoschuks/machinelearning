<?php
/**
 * @category
 * @package
 * @author Willem Bressers <info@willembressers.nl>
 * @license
 * @link
 */

namespace League\MachineLearning\Service;


use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;

/**
 * Class YamlFileHandler
 * @package League\MachineLearning\Service
 */
class YamlFileHandler {

    protected $file;

    /**
     * @param mixed $file
     */
    function __construct($file = '')
    {
        $this->file = $file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
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
     * @param mixed $content
     */
    public function setContent($content)
    {
        $dumper = new Dumper();
        $yaml = $dumper->dump($content, 2);
        file_put_contents($this->file, $yaml);
    }
}