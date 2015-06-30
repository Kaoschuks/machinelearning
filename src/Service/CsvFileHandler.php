<?php
/**
 * [Description]
 *
 * @category Service Object.
 * @package League\MachineLearning\Service
 * @author Willem Bressers <info@willembressers.nl>
 * @license MIT
 * @link https://github.com/willembressers/machinelearning
 */

namespace League\MachineLearning\Service;

use League\Csv\Reader;

/**
 * This is a helper class for fetching csv file contents.
 *
 * Class CsvFileHandler
 * @package League\MachineLearning\Service
 */
class CsvFileHandler
{
    protected $file;

    /**
     * @param string $file
     */
    public function __construct($file = '')
    {
        $this->file = $file;
    }

    /**
     * Specify the csv file.
     *
     * @param string $file
     */
    public function setFile($file = '')
    {
        $this->file = $file;
    }

    /**
     * Returns the parsed raw csv content.
     *
     * @return array
     */
    public function getContent()
    {
        if ($this->file && file_exists($this->file)) {
            $reader = Reader::createFromPath($this->file);
            return $reader->fetchAll();
        }
        return array();
    }
}
