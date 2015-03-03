<?php

namespace MachineLearning\Clustering\Entity;

use MachineLearning\Clustering\Controller\KMeansController;
use MachineLearning\Utility\Model\BaseLearningModel;
use MachineLearning\Utility\Entity\Config;
use MachineLearning\Data\Entity\Dataset;

/**
 * Cluster the data, based on the KMeans approach.
 */
class KMeans extends KMeansController implements BaseLearningModel
{
    private $config;
    private $trainingData;
    public $testData;

    /**
     * Set the configuration.
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
     * Get the configuration.
     */
    public function getConfig()
    {
        return $this->config->get('KMeans');
    }

    /**
     * Set the training data.
     */
    public function setTrainingData(Dataset $dataset)
    {
        $this->trainingData = $dataset;
        $config = $this->getConfig();

        $this->initialization($config, $dataset);
    }

    /**
     * Set the test data.
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
        $config = $this->getConfig();

      // Keep on training until convergion.
      do {
          foreach ($this->trainingData->getVectors() as $key => $vector) {
              $nearestCluster = $this->getNearestCluster($vector);

              // @TODO fix this adddata it takes to much time.
              $nearestCluster->addData(array($key => $vector->getValues()));
          }
          $this->updateClusters($converged, $config);
      } while (!$converged);
    }

    /**
     * Test the clusters on the testdata.
     */
    public function test()
    {
        foreach ($this->testData->getVectors() as $key => $vector) {
            $vector->setClass($this->getNearestCluster($vector));
        }
    }
}
