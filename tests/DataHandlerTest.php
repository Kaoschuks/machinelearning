<?php
/**
 * @category Service Object.
 * @package League\MachineLearning\Test
 * @author Willem Bressers <info@willembressers.nl>
 * @license MIT
 * @link https://github.com/willembressers/machinelearning
 */

namespace League\MachineLearning\Test;

use League\MachineLearning\Service\CsvFileHandler;
use League\MachineLearning\Service\DataHandler;

/**
 * This class test the DataHandler.
 *
 * Class DataHandlerTest
 * @package League\MachineLearning\Test
 */
class DataHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test the data insert on the Iris dataset.
     */
    public function testWithIrisDataset()
    {
        $file = new CsvFileHandler(__DIR__ . '/assets/iris.csv');

        $dataHandler = new DataHandler($file->getContent());
        $this->assertEquals($dataHandler->getDataset()->count(), 152);
    }
}
