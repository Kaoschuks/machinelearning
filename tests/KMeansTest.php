<?php

namespace League\MachineLearning\Test;

use PHPUnit_Framework_TestCase;
use League\MachineLearning\Data\Entity\Dataset;
use League\MachineLearning\Clustering\Entity\KMeans;

class KMeansTest extends PHPUnit_Framework_TestCase
{
    public $algortihm;
    public $traningData;
    public $validationData;
    public $testData;

    public function __construct()
    {
        $pwd = dirname(__FILE__);
        include($pwd . "/datasets/iris.php");

        $dataset = new Dataset();
        $dataset->addData($data);
        list($traningData, $validationData, $testData) = $dataset->split(0.8, 0, 0.2);

        $this->traningData = $traningData;
        $this->validationData = $validationData;
        $this->testData = $testData;

        $this->algortihm = new KMeans();
    }

    /**
     * Test the KMeans::setTrainingData() method.
     *
     * @test
     */
    public function setTrainingData()
    {
        $this->algortihm->setTrainingData($this->traningData);
    }

    /**
     * Test the KMeans::setTestData() method.
     *
     * @test
     * @depends setTrainingData
     */
    public function setTestData()
    {
        $this->algortihm->setTestData($this->testData);
    }

    /**
     * Test the KMeans::train() method.
     *
     * @test
     * @depends setTrainingData
     */
    public function train()
    {
        // $this->algortihm->train();
    }

    /**
     * Test the KMeans::test() method.
     *
     * @test
     * @depends setTrainingData
     * @depends train
     * @depends setTestData
     */
    public function test()
    {
        // $this->algortihm->test();
    }
}
