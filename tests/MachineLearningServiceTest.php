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
use League\MachineLearning\Service\MachineLearningService;
use League\MachineLearning\Service\ConfigurationHandler;

/**
 * This class test the MachineLearningService.
 *
 * Class MachineLearningServiceTest
 * @package League\MachineLearning\Test
 */
class MachineLearningServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @test training the k-nearest-neighbors with the Iris dataset.
    */
    public function testTrainIrisKnearestNeighbors()
    {
        $file = new CsvFileHandler(__DIR__ . '/assets/iris.csv');

        $service = new MachineLearningService(new ConfigurationHandler(), new DataHandler());
        $service->getConfiguration()->setFile(__DIR__ . '/assets/KNearestNeighborsConfig.yml');
        $service->getDataHandler()->addData($file->getContent());

        $service->train();
    }
}
