<?php

namespace MachineLearning\Clustering;

use MachineLearning\Clustering\Cluster;
use MachineLearning\MachineLearningInterface;
use MachineLearning\DataPreparation\Dataset;

/**
 * https://github.com/simonrobb/php-kmeans/blob/master/KMeans.php
 */
class KMeans extends Cluster implements MachineLearningInterface{

  public $num_clusters;

  /**
   * Basic constructor.
   */
  public function __construct($num_clusters = 3) {
    $this->num_clusters = $num_clusters;
  }

  /**
   * [train description]
   *
   * @return [type] [description]
   */
  public function train() {
    $converged = FALSE;
    do {
      foreach ($this->clusters as $cluster_key => $cluster) {
        foreach ($this->trainingData->data as $row_key => $row) {
          $nearestClusterKey = $this->getNearestCluster($row);
          $this->clusters[$nearestClusterKey]['data'][$row_key] = $row;
        }
      }
      $this->updateClusters($converged);
    } while (!$converged);
  }

  /**
   * [test description]
   *
   * @return [type] [description]
   */
  public function test() {

  }

  /**
   * [addTrainingData description]
   *
   * @param Dataset $dataset [description]
   */
  public function addTrainingData(Dataset $dataset) {
    parent::addTrainingData($dataset);
    $this->generateClusters();
  }

  /**
   * [generateClusters description]
   *
   * @return [type] [description]
   */
  private function generateClusters() {
    for ($cluster_key = 1; $cluster_key <= $this->num_clusters; $cluster_key++) {
      $centroids = array();
      foreach ($this->trainingData->columns as $key => $column_data) {
        if ($column_data['datatype'] == 'numeric') {
          $centroids[$key] = $this->rand($column_data['min'], $column_data['max']);
        }
      }
      $this->clusters[$cluster_key]['centroids'] = $centroids;
    }
  }

  /**
   * [updateClusters description]
   *
   * @return [type] [description]
   */
  private function updateClusters(&$converged) {
    foreach ($this->clusters as $cluster_key => $cluster) {
      $centroids = array();
      foreach ($cluster['data'] as $row_key => $row) {
        foreach ($row as $key => $value) {
          // @TODO check on numeric.
          $values = array_column($cluster['data'], $key);
          $centroids[$key] = $this->rand(min($values), max($values));
        }
      }
      // @TODO update the centroids.
    }

    // @TODO do some calculation for convergion.
    $converged = TRUE;
  }

  /**
   * Picks a random number, and returns a float.
   *
   * @return [type] [description]
   */
  private function rand($min, $max) {
    return $min + ($max - $min) * mt_rand(0, 32767)/32767;
  }

  /**
   * [getNearestCluster description]
   *
   * @param  [type] $row [description]
   * @return [type]      [description]
   */
  private function getNearestCluster($row) {
    $leastWcss = PHP_INT_MAX;
    $nearestClusterKey = NULL;
    foreach ($this->clusters as $cluster_key => $cluster) {
      $wcss = 0;
      foreach ($row as $key => $value) {
        if ($this->trainingData->columns[$key]['datatype'] == 'numeric') {
          $wcss += pow($value - $cluster['centroids'][$key], 2);
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
