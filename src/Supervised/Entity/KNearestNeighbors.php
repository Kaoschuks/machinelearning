<?php

namespace League\MachineLearning\Supervised\Entity;

use League\MachineLearning\Supervised\Controller\KNearestNeighborsController;
use League\MachineLearning\Utility\Model\InstanceBasedLearningModel;
use League\MachineLearning\Utility\Entity\Config;
use League\MachineLearning\Data\Entity\Dataset;

/**
 * KNearestNeighbors, Find the nearest neighbors in the trainingset of the given testset.
 *
 * @author Willem Bressers <info@willembressers.nl>
 */
class KNearestNeighbors extends KNearestNeighborsController implements InstanceBasedLearningModel
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
        $config->set('KNearestNeighbors', array(
            'num.nearest.neighbors' => 3,
            'method' => 'random',
            'distance.boosting' => true,
        ));
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
     * Classify the testdata based on the trainingsdata.
     */
    public function test()
    {
        foreach ($this->testData->vectors as $vector) {
            $nearestNeighbors = $this->findNearestNeighbors($vector, $this->trainingData, $this->config);
            $this->classify($vector, $nearestNeighbors, $this->config);
        }
    }
}
