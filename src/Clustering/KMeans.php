<?php

namespace MachineLearning\Clustering;

use MachineLearning\Interfaces\LearningInterface;
use MachineLearning\Data\Dataset;

/**
 * Cluster the data, based on the KMeans approach.
 */
class KMeans extends Cluster implements LearningInterface
{

    public $num_clusters;
    public $convergion_distance;
    public $initialization_method;

    /**
     * Basic constructor.
     */
    public function __construct($num_clusters = 3, $convergion_distance = 1, $initialization_method = 'random')
    {
        $this->num_clusters = $num_clusters;
        $this->convergion_distance = $convergion_distance;
        $this->initialization_method = $initialization_method;
    }

    /**
     * Add trainings data to train the clusters.
     */
    public function setTrainingData(Dataset $dataset)
    {
        parent::setTrainingData($dataset);
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
          foreach ($this->trainingData->vectors as $key => $vector) {
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
        foreach ($this->testData->vectors as $key => $vector) {
            $this->testData->vectors[$key]['cluster'] = $this->getNearestCluster($vector);
        }
    }

    /**
     * Initialize the clusters.
     */
    private function initialization()
    {
        $columns = $this->trainingData->columns;
        for ($cluster_key = 1; $cluster_key <= $this->num_clusters; $cluster_key++) {
            $centroid = array();

            // Pick k random rows for initial centroid.
            if ($this->initialization_method == 'forgy') {
                $vector = array_rand($this->trainingData->vectors);
                foreach ($columns as $key => $column) {
                    if ($column->isNumeric()) {
                        $centroid[$key] = $vector->values[$key];
                    }
                }
            }

            // Pick random centroid between the colomn max and min.
            else {
                foreach ($columns as $key => $column) {
                    if ($column->isNumeric()) {
                        $centroid[$key] = $this->rand($column->data['min'], $column->data['max']);
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
        $columns = $this->trainingData->columns;

        foreach ($this->clusters as $cluster_key => $cluster) {
            $old_centroid = $this->clusters[$cluster_key]['centroid'];
            $centroid = array();

            // No data available, thus noting to update.
            if (!@$cluster['data']) {
                continue;
            }

            // Pick new random centroid based on the subset.
            foreach ($cluster['data'] as $row_key => $row) {
                foreach ($row as $key => $value) {
                    if ($columns[$key]->isNumeric()) {
                        $values = array_column($cluster['data'], $key);
                        $centroid[$key] = $this->mean($values);
                    }
                }
            }

            // Update the centroid, and remove the subset.
            $this->clusters[$cluster_key]['centroid'] = $centroid;
            $distance += $this->euclideanDistance($old_centroid, $centroid);
            unset($this->clusters[$cluster_key]['data']);
        }

        $converged = $distance <= $this->convergion_distance ? true : false;
    }

    /**
     * Get the nearest cluster based on the give row.
     */
    private function getNearestCluster($vector)
    {
        $columns = $this->trainingData->columns;
        $leastWcss = PHP_INT_MAX;
        $nearestClusterKey = null;

        // Calculate the distance from the the centroid.
        foreach ($this->clusters as $cluster_key => $cluster) {
            $wcss = 0;
            foreach ($vector->values as $key => $value) {
                if ($columns[$key]->isNumeric()) {
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
