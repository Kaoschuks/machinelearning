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
    const CLASSNAME = 'KMeans';

    private $config;
    private $trainingData;
    public $testData;

    public function __construct(Config $config) {
        $this->config = $config;
        $this->config->set(self::CLASSNAME, array(
            'num.clusters' => 3,
            'convergion.distance' => 1,
            'initialization.method' => 'random',
        ));
    }

    public function setTrainingData(Dataset $dataset)
    {
        $this->trainingData = $dataset;

        $config = $this->config->get(self::CLASSNAME);
        $this->initialization($config, $dataset);
    }

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
        $dataset = $this->trainingData;
        $config = $this->config->get(self::CLASSNAME);

      // Keep on training until convergion.
      do {
          foreach ($this->trainingData->getVectors() as $key => $vector) {
              $nearestCluster = $this->getNearestCluster($vector, $dataset);

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
        $dataset = $this->trainingData;
        foreach ($this->testData->getVectors() as $key => $vector) {
            $vector->setClass($this->getNearestCluster($vector, $dataset));
        }
    }
}
