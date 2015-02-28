<?php

namespace MachineLearning\Supervised\Entity;

use MachineLearning\Supervised\Controller\KNearestNeighborsController;
use MachineLearning\Supervised\Model\InstanceBasedLearningModel;
use MachineLearning\Utility\Entity\Config;
use MachineLearning\Data\Entity\Dataset;
// use MachineLearning\Interfaces\InstanceBasedLearningInterface;

/**
 * Find the nearest neighbors in the trainingset of the given testset.
 */
class KNearestNeighbors extends KNearestNeighborsController implements InstanceBasedLearningModel
{
    const CLASSNAME = 'KNearestNeighbors';

    private $config;
    private $trainingData;
    public $testData;

    public function __construct(Config $config) {
        $this->config = $config;
        $this->config->set(self::CLASSNAME, array(
            'num.nearest.neighbors' => 3,
            'method' => 'random',
            'distance.boosting' => true,
        ));
    }

    public function setTrainingData(Dataset $dataset)
    {
        $this->trainingData = $dataset;
    }

    public function setTestData(Dataset $dataset)
    {
        $this->testData = $dataset;
    }

    /**
     * Classify the testdata based on the trainingsdata.
     */
    public function test()
    {
        $config = $this->config->get(self::CLASSNAME);
        $columns = $this->trainingData->getColumns();
        $trainingVectors = $this->trainingData->getVectors();
        $testVectors = $this->testData->getVectors();

        foreach ($testVectors as $testVector) {
            $nearestNeighbors = $this->findNearestNeighbors($testVector, $trainingVectors, $config);
            $class = array();

            if ($config['method'] == 'regression') {
                foreach ($columns as $key => $column) {
                    if ($column->isNumeric()) {
                        $class[$key] = $this->mean($nearestNeighbors->getColumn($key)->getValues());
                    }
                }
            } else {
                foreach ($columns as $key => $column) {
                    if ($column->isNumeric()) {
                        $majority = $this->majority($nearestNeighbors->getColumn($key)->getValues());
                    }
                }
            }

            $testVector->setClass($class);
        }
    }
}
