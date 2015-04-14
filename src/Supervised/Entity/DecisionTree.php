<?php

namespace League\MachineLearning\Supervised\Entity;

use League\MachineLearning\Utility\Model\BaseLearningModel;
use League\MachineLearning\Utility\Entity\Config;
use League\MachineLearning\Data\Entity\Dataset;

/**
 * DecisionTree, Build a decision tree.
 *
 * @author Willem Bressers <info@willembressers.nl>
 */
class DecisionTree implements BaseLearningModel
{

    private $config;
    private $trainingData;
    public $testData;

    /**
     * Set the configuration.
     *
     * @param Config $config
     */
    public function setConfig(Config $config)
    {
        $config->set('DecisionTree', array());
        $this->config = $config;
    }

    /**
     * Set the training data.
     *
     * @param Dataset $dataset
     */
    public function setTrainingData(Dataset $dataset)
    {
        $this->trainingData = $dataset;
    }

    /**
     * Set the test data.
     *
     * @param Dataset $dataset
     */
    public function setTestData(Dataset $dataset)
    {
        $this->testData = $dataset;
    }

    public function train()
    {

    }

    public function test()
    {

    }
}
