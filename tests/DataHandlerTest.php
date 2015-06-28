<?php
/**
 * @category Service Object.
 * @package League\MachineLearning\Test
 * @author Willem Bressers <info@willembressers.nl>
 * @license MIT
 * @link https://github.com/willembressers/machinelearning
 */

namespace League\MachineLearning\Test;

use League\MachineLearning\Service\YamlFileHandler;
use League\MachineLearning\Service\MachineLearningService;
use League\MachineLearning\Service\DataHandler;

/**
 * Class DataHandlerTest
 * @package League\MachineLearning\Test
 */
class DataHandlerTest extends \PHPUnit_Framework_TestCase
{

    private $service;
    private $simpleData;

    public function __construct()
    {
        $configuration = new YamlFileHandler(__DIR__ . '/assets/config.yml');
        $this->service = new MachineLearningService($configuration);

        $this->simpleData = array(
            array('a1' => 1, 'a2' => 2, 'a3' => 3, 'a4' => 4),
            array('b1' => 1, 'b2' => 2, 'b3' => 3, 'b4' => 4),
            array('c1' => 1, 'c2' => 2, 'c3' => 3, 'c4' => 4),
            array('d1' => 1, 'd2' => 2, 'd3' => 3, 'd4' => 4),
        );
    }

    /**
     * @test
     */
    public function testWithSimpleData()
    {
        $dataHandler = new DataHandler();
        $dataHandler->addData($this->simpleData);
        $this->assertNotEmpty($dataHandler->getDataset());
    }
}
