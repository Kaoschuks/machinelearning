<?php
/**
 * @category Service Object.
 * @package League\MachineLearning\
 * @author Willem Bressers <info@willembressers.nl>
 * @license MIT
 * @link https://github.com/willembressers/machinelearning
 */

namespace League\MachineLearning\Test;

use League\MachineLearning\Service\YamlFileHandler;
use League\MachineLearning\Service\MachineLearningService;
use League\MachineLearning\Service\DataHandler;

/**
 * Class KNearestNeighborsTest
 * @package League\MachineLearning\Test
 */
class KNearestNeighborsTest extends \PHPUnit_Framework_TestCase
{
    private $service;
    private $simpleData;

    public function __construct()
    {
        $configuration = new YamlFileHandler(__DIR__ . '/assets/config.yml');
        $this->service = new MachineLearningService($configuration);

        $this->simpleData = array(
            array(
                'sepal_length' => 5.1,
                'sepal_width' => 3.5,
                'petal_length' => 1.4,
                'petal_width' => 0.2,
                'species' => 'Iris setosa'
            ),
            array(
                'sepal_length' => 4.9,
                'sepal_width' => 3.0,
                'petal_length' => 1.4,
                'petal_width' => 0.2,
                'species' => 'Iris setosa'
            ),
            array(
                'sepal_length' => 4.7,
                'sepal_width' => 3.2,
                'petal_length' => 1.3,
                'petal_width' => 0.2,
                'species' => 'Iris setosa'
            ),
            array(
                'sepal_length' => 7.0,
                'sepal_width' => 3.2,
                'petal_length' => 4.7,
                'petal_width' => 1.4,
                'species' => 'Iris versicolor'
            ),
            array(
                'sepal_length' => 6.4,
                'sepal_width' => 3.2,
                'petal_length' => 4.5,
                'petal_width' => 1.5,
                'species' => 'Iris versicolor'
            ),
            array(
                'sepal_length' => 6.9,
                'sepal_width' => 3.1,
                'petal_length' => 4.9,
                'petal_width' => 1.5,
                'species' => 'Iris versicolor'
            ),
            array(
                'sepal_length' => 6.3,
                'sepal_width' => 3.3,
                'petal_length' => 6.0,
                'petal_width' => 2.5,
                'species' => 'Iris virginica'
            ),
            array(
                'sepal_length' => 5.8,
                'sepal_width' => 2.7,
                'petal_length' => 5.1,
                'petal_width' => 1.9,
                'species' => 'Iris virginica'
            ),
            array(
                'sepal_length' => 7.1,
                'sepal_width' => 3.0,
                'petal_length' => 5.9,
                'petal_width' => 2.1,
                'species' => 'Iris virginica'
            ),
        );
    }

    /**
     * @test
     * @dataProvider simpleData
     */
    public function testTrainWithSimpleData()
    {
        $dataHandler = new DataHandler();
        $dataHandler->addData($this->simpleData);

    }
}
