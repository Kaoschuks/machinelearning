<?php

namespace League\MachineLearning\Test;

use PHPUnit_Framework_TestCase;
use League\MachineLearning\Data\Entity\Dataset;
use League\MachineLearning\Clustering\Entity\KMeans;

class KMeansTest extends PHPUnit_Framework_TestCase
{

    public $algortihm;

    public function __construct()
    {
      $this->algortihm = new KMeans();

      // $this->trainingsDataSet = new Dataset();
      // $this->trainingsDataSet->addData(array(
      //     array('sepal_length' => 5.1, 'sepal_width' =>  3.5, 'petal_length' =>  1.4, 'petal_width' => 0.2, 'species' => 'Iris setosa'),
      //     array('sepal_length' => 4.9, 'sepal_width' =>  3.0, 'petal_length' =>  1.4, 'petal_width' => 0.2, 'species' => 'Iris setosa'),
      //     array('sepal_length' => 4.7, 'sepal_width' =>  3.2, 'petal_length' =>  1.3, 'petal_width' => 0.2, 'species' => 'Iris setosa'),
      //     array('sepal_length' => 7.0, 'sepal_width' =>  3.2, 'petal_length' =>  4.7, 'petal_width' => 1.4, 'species' => 'Iris versicolor'),
      //     array('sepal_length' => 6.4, 'sepal_width' =>  3.2, 'petal_length' =>  4.5, 'petal_width' => 1.5, 'species' => 'Iris versicolor'),
      //     array('sepal_length' => 6.9, 'sepal_width' =>  3.1, 'petal_length' =>  4.9, 'petal_width' => 1.5, 'species' => 'Iris versicolor'),
      //     array('sepal_length' => 6.3, 'sepal_width' =>  3.3, 'petal_length' =>  6.0, 'petal_width' => 2.5, 'species' => 'Iris virginica'),
      //     array('sepal_length' => 5.8, 'sepal_width' =>  2.7, 'petal_length' =>  5.1, 'petal_width' => 1.9, 'species' => 'Iris virginica'),
      //     array('sepal_length' => 7.1, 'sepal_width' =>  3.0, 'petal_length' =>  5.9, 'petal_width' => 2.1, 'species' => 'Iris virginica'),
      // ));

      // $this->testDataSet = new Dataset();
      // $this->testDataSet->addData(array(
      //     array('sepal_length' => 4.6, 'sepal_width' =>  3.1, 'petal_length' =>  1.5, 'petal_width' => 0.2, 'species' => 'Iris setosa'),
      //     array('sepal_length' => 5.0, 'sepal_width' =>  3.6, 'petal_length' =>  1.4, 'petal_width' => 0.2, 'species' => 'Iris setosa'),
      //     array('sepal_length' => 5.4, 'sepal_width' =>  3.9, 'petal_length' =>  1.7, 'petal_width' => 0.4, 'species' => 'Iris setosa'),
      //     array('sepal_length' => 5.5, 'sepal_width' =>  2.3, 'petal_length' =>  4.0, 'petal_width' => 1.3, 'species' => 'Iris versicolor'),
      //     array('sepal_length' => 6.5, 'sepal_width' =>  2.8, 'petal_length' =>  4.6, 'petal_width' => 1.5, 'species' => 'Iris versicolor'),
      //     array('sepal_length' => 5.7, 'sepal_width' =>  2.8, 'petal_length' =>  4.5, 'petal_width' => 1.3, 'species' => 'Iris versicolor'),
      //     array('sepal_length' => 6.3, 'sepal_width' =>  2.9, 'petal_length' =>  5.6, 'petal_width' => 1.8, 'species' => 'Iris virginica'),
      //     array('sepal_length' => 6.5, 'sepal_width' =>  3.0, 'petal_length' =>  5.8, 'petal_width' => 2.2, 'species' => 'Iris virginica'),
      //     array('sepal_length' => 7.6, 'sepal_width' =>  3.0, 'petal_length' =>  6.6, 'petal_width' => 2.1, 'species' => 'Iris virginica'),
      // ));
    }

    /**
     * Test the KMeans::setTrainingData() method.
     *
     * @test
     */
    public function setTrainingData()
    {
        // $this->algortihm->setTrainingData($this->trainingsDataSet);
    }

    /**
     * Test the KMeans::setTestData() method.
     *
     * @test
     */
    public function setTestData()
    {
    //     $this->algortihm->setTestData($this->testDataSet);
    }

    /**
     * Test the KMeans::train() method.
     *
     * @test
     */
    public function train()
    {
    //     $this->algortihm->train();
    }

    /**
     * Test the KMeans::test() method.
     *
     * @test
     */
    public function test()
    {
    //     $this->algortihm->test();
    }
}
