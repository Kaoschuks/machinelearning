<?php

namespace MachineLearning\Clustering\Entity;

use MachineLearning\Data\Controller\ObjectController;
use MachineLearning\Data\Entity\Dataset;
use MachineLearning\Clustering\Controller\KMeansController;
use MachineLearning\Utility\Model\BaseLearningModel;
use MachineLearning\Utility\Entity\Config;

/**
 * KMeans, Cluster the data, based on the KMeans approach.
 *
 * @author Willem Bressers <info@willembressers.nl>
 */
class KMeans extends KMeansController implements BaseLearningModel
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
        $config->set('KMeans', array(
            'num.clusters' => 3,
            'convergion.distance' => 1,
            'initialization.method' => 'random',
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
        $this->initialization($dataset, $this->config);
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
     * Train the clusters based on the trainingdata.
     */
    public function train()
    {
        $converged = false;

        // Keep on training until convergion.
        do {
            foreach ($this->trainingData->vectors as $vector) {
                $nearestCluster = $this->getNearestCluster($vector);
                $nearestCluster->vectors->set($vector->key, $vector);
            }
            $this->updateClusters($converged, $this->config);
        } while (!$converged);
    }

    /**
     * Test the clusters on the testdata.
     */
    public function test()
    {
        foreach ($this->testData->vectors as $vector) {
            $vector->setClass($this->getNearestCluster($vector));
        }
    }
}
