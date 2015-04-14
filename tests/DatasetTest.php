<?php

namespace League\MachineLearning\Test;

use PHPUnit_Framework_TestCase;
use League\MachineLearning\Data\Entity\Dataset;

class DatasetTest extends PHPUnit_Framework_TestCase
{
    public $dataset;

    public function __construct()
    {
        $this->dataset = new Dataset();
    }

    /**
     * @test
     */
    public function addData()
    {
        $data = array(
          'row_1' => array('first_column' => 0, 'second_column' => 1, 'third_column' => 2, 'forth_column' => 3),
          'row_2' => array('first_column' => 3, 'second_column' => 2, 'third_column' => 1, 'forth_column' => 0),
        );
        $this->dataset->addData($data);

        $this->assertEquals(count($this->dataset->vectorMap), count($data));
        $this->assertEquals(count($this->dataset->columnMap), count($data['row_1']));
    }

    /**
     * @test
     */
    public function split()
    {

    }

}
