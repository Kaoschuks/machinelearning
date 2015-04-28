<?php

namespace League\MachineLearning\Test;

use PHPUnit_Framework_TestCase;
use League\MachineLearning\Utility\Entity\Config;
use League\MachineLearning\Data\Entity\Dataset;
use League\MachineLearning\Supervised\Entity\DecisionTree;

class DecisionTreeTest extends PHPUnit_Framework_TestCase
{
    public $algortihm;
    public $dataset;

    public function __construct()
    {
        $pwd = dirname(__FILE__);
        include($pwd . "/datasets/playtennis.php");

        $config = new Config();
        $config->set('DecisionTree', array(
            'classifier' => 'playtennis',
        ));

        $dataset = new Dataset();
        $dataset->addData($data);

        $this->dataset = $dataset;
        $this->algortihm = new DecisionTree();
        $this->algortihm->setConfig($config);
    }

    /**
     * Train the DecisionTree
     *
     * @test
     */
    public function train()
    {
        $this->algortihm->setTrainingData($this->dataset);
        $this->algortihm->train();

        // Validate the entropy.
        // $this->assertEquals(count($this->dataset->columnMap), $this->algortihm->entropy->count());
    }
}
