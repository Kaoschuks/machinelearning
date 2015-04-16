<?php

namespace League\MachineLearning\Supervised\Entity;

use League\MachineLearning\Utility\Model\BaseLearningModel;
use League\MachineLearning\Utility\Entity\Config;
use League\MachineLearning\Utility\Entity\Calculate;
use League\MachineLearning\Data\Entity\Dataset;
use League\MachineLearning\Data\Entity\Object;
use League\MachineLearning\Data\Entity\Collection;

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

    public $entropy;

    public function __construct()
    {
        $this->entropy = new Collection();
    }

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

    /**
     * Build the decision tree.
     */
    public function train()
    {
        // Calculate the entropy of each column.
        foreach ($this->trainingData->columnMap as $key => $value) {
            $values = $this->trainingData->vectors->getColumnValues($key);
            $this->entropy->set($key, new Object($key, Calculate::entropy($values)));
        }
    }

    /**
     * Classify the testdata.
     */
    public function test()
    {

    }
}
