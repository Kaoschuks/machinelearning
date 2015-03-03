<?php

namespace MachineLearning\Supervised\Entity;

use MachineLearning\Supervised\Controller\KNearestNeighborsController;
use MachineLearning\Utility\Model\InstanceBasedLearningModel;
use MachineLearning\Utility\Entity\Config;
use MachineLearning\Data\Entity\Dataset;
// use MachineLearning\Interfaces\InstanceBasedLearningInterface;

/**
 * Find the nearest neighbors in the trainingset of the given testset.
 */
class KNearestNeighbors extends KNearestNeighborsController implements InstanceBasedLearningModel
{
    private $config;
    private $trainingData;
    public $testData;

    /**
     * Set the configuration.
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
     * Get the configuration.
     */
    public function getConfig()
    {
        return $this->config->get('KNearestNeighbors');
    }

    /**
     * Set the training data.
     */
    public function setTrainingData(Dataset $dataset)
    {
        $this->trainingData = $dataset;
    }

    /**
     * Set the test data.
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
        $config = $this->getConfig();
        $trainingVectors = $this->trainingData->getVectors();
        $testVectors = $this->testData->getVectors();

        foreach ($testVectors as $testVector) {
            $nearestNeighbors = $this->findNearestNeighbors($testVector, $trainingVectors, $config);
            $class = array();

            if ($config['method'] == 'regression') {
                foreach ($testVector->getColumns() as $key => $column) {
                    if ($column->isNumeric()) {
                        $class[$key] = $this->mean($nearestNeighbors->getColumn($key)->getValues());
                    }
                }
            // } else {
            //     foreach ($testVector->getColumns() as $key => $column) {
            //         if ($column->isNumeric()) {
            //             $majority = $this->majority($nearestNeighbors->getColumn($key)->getValues());
            //         }
            //     }
            }

            $testVector->setClass($class);
        }
    }
}
