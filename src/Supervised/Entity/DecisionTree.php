<?php

namespace League\MachineLearning\Supervised\Entity;

use League\MachineLearning\Utility\Model\BaseLearningModel;
use League\MachineLearning\Utility\Entity\Config;
use League\MachineLearning\Utility\Entity\Calculate;
use League\MachineLearning\Utility\Entity\Utility;
use League\MachineLearning\Data\Entity\Dataset;
use League\MachineLearning\Data\Entity\Object;
use League\MachineLearning\Data\Entity\Collection;
use League\MachineLearning\Data\Entity\Tree;
use League\MachineLearning\Data\Entity\TreeNode;

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
    public $tree;

    public function __construct()
    {
        $this->tree = new Tree();
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

        $configuration = $this->config->get('DecisionTree');
        foreach ($this->trainingData->columnMap as $key => $value) {
            if ($configuration['classifier'] == $value) {
                $this->classifier_key = $key;
            }
        }
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
        $configuration = $this->config->get('DecisionTree');

        $vectors = clone $this->trainingData->vectors;
        $this->buildTree($vectors, $configuration);
    }

    /**
     * Classify the testdata.
     */
    public function test()
    {

    }

    /**
     * Build the decision tree.
     */
    private function buildTree(Collection $vectors, $configuration)
    {
        $classifier_values = $vectors->getColumnValues($this->classifier_key);
        $classifier_frequencies = Utility::frequencies($classifier_values);
        $attributes = new Collection();

        // Calculate the entropy of each column.
        foreach ($this->trainingData->columnMap as $key => $value) {
            if ($configuration['classifier'] != $value) {
                $values = $this->trainingData->vectors->getColumnValues($key);
                $attribute_frequencies = Utility::classifierFrequencies($classifier_values, $values);

                $data = array(
                    'gain' => Calculate::gain($classifier_frequencies, $attribute_frequencies),
                    'frequencies' => $attribute_frequencies,
                );
                $attribute = new Object($key, $data);
                $attributes->set($key, $attribute);
            }
        }

        // Sort the attributes from high to low.
        $item = $attributes->getHighest('gain');

        $this->tree->insert($item);
        print_r($this->tree);
    }
}
