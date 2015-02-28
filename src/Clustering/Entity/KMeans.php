<?php

namespace MachineLearning\Clustering;

use MachineLearning\MachineLearningConfiguration;
use MachineLearning\Data\Dataset;

/**
 * Cluster the data, based on the KMeans approach.
 */
class KMeans
{
    public $config;

    /**
     * Specify the basic configuration.
     */
    public function __construct() {
        $this->config = new ConfigurationController();
        $this->config->numClusters = 3;
        $this->config->convergionDistance = 1;
        $this->config->initializationMethod = 'random';
    }

    /**
     * Add trainings data to train the clusters.
     */
    public function setTrainingData(Dataset $dataset)
    {
        $this->trainingData = $dataset;
        $this->initialization();
    }

    /**
     * Train the clusters based on the trainingdata.
     */
    public function train()
    {
        $converged = false;

      // Keep on training until convergion.
      do {
          foreach ($this->trainingData->getVectors() as $key => $vector) {
              $nearestClusterKey = $this->getNearestCluster($vector);
              $this->clusters[$nearestClusterKey]['data'][$key] = $vector;
          }
          $this->updateClusters($converged);
      } while (!$converged);
    }

    /**
     * Test the clusters on the testdata.
     */
    public function test()
    {
        foreach ($this->testData->getVectors() as $key => $vector) {
            $this->testData->vectors[$key]['cluster'] = $this->getNearestCluster($vector);
        }
    }

    /**
     * Initialize the clusters.
     */
    private function initialization()
    {
        for ($cluster_key = 1; $cluster_key <= $this->config->numClusters; $cluster_key++) {
            $centroid = array();

            // Pick k random rows for initial centroid.
            if ($this->config->initializationMethod == 'forgy') {
                $vector = array_rand($this->trainingData->getVectors());
                foreach ($this->trainingData->getColumns() as $key => $column) {
                    if ($column->isNumeric()) {
                        $centroid[$key] = $vector->getValue($key);
                    }
                }
            }

            // Pick random centroid between the colomn max and min.
            else {
                foreach ($this->trainingData->getColumns() as $key => $column) {
                    if ($column->isNumeric()) {
                        $stats = $column->getStats();
                        $centroid[$key] = $this->rand($stats['min'], $stats['max']);
                    }
                }
            }
            $this->clusters[$cluster_key]['centroid'] = $centroid;
        }
    }

    /**
     * Update the cluster centroid for the next iteration, or mark the clusters as converged.
     */
    private function updateClusters(&$converged)
    {
        $distance = 0;
        print_r($this->clusters);

        foreach ($this->clusters as $cluster_key => $cluster) {
            $old_centroid = $this->clusters[$cluster_key]['centroid'];
            $centroid = array();

            // No data available, thus noting to update.
            if (!@$cluster['data']) {
                continue;
            }

            // // Pick new random centroid based on the subset.
            // foreach ($cluster['data'] as $row_key => $row) {
            //     foreach ($row as $key => $value) {
            //         if ($this->trainingData->getColumn($key)->isNumeric()) {
            //             $values = array_column($cluster['data'], $key);
            //             $centroid[$key] = $this->mean($values);
            //         }
            //     }
            // }

            // Update the centroid, and remove the subset.
            $this->clusters[$cluster_key]['centroid'] = $centroid;
            $distance += $this->euclideanDistance($old_centroid, $centroid);
            unset($this->clusters[$cluster_key]['data']);
        }

        $converged = $distance <= $this->config->convergionDistance ? true : false;
    }

    /**
     * Get the nearest cluster based on the give row.
     */
    private function getNearestCluster($vector)
    {
        $leastWcss = PHP_INT_MAX;
        $nearestClusterKey = null;

        // Calculate the distance from the the centroid.
        foreach ($this->clusters as $cluster_key => $cluster) {
            $wcss = 0;
            foreach ($vector->getValues() as $key => $value) {
                if ($this->trainingData->getColumn($key)->isNumeric()) {
                    $wcss += pow($value - $cluster['centroid'][$key], 2);
                }
            }
            if ($wcss < $leastWcss) {
                $leastWcss = $wcss;
                $nearestClusterKey = $cluster_key;
            }
        }

        return $nearestClusterKey;
    }
}
