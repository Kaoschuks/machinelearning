<?php

namespace MachineLearning\Clustering;

use MachineLearning\Clustering\Cluster;
use MachineLearning\MachineLearningInterface;

/**
 * https://github.com/simonrobb/php-kmeans/blob/master/KMeans.php
 */
class KMeans extends Cluster implements MachineLearningInterface{

  public $clusters;

  /**
   * Basic constructor.
   */
  public function __construct($dataset, $num_clusters = 3) {
    parent::__construct($dataset);
    $this->generateClusters($num_clusters);
  }

  /**
   * [learn description]
   *
   * @return [type] [description]
   */
  public function learn() {
    $converged = FALSE;
    do {
      foreach ($this->clusters as $cluster_key => $cluster) {
        foreach ($this->dataset->data as $row_key => $row) {
          $nearestClusterKey = $this->getNearestCluster($row);
          $this->clusters[$nearestClusterKey]['data'][$row_key] = $row;
        }
      }
      $this->updateClusters($converged);
    } while (!$converged);
  }

  /**
   * [generateClusters description]
   *
   * @return [type] [description]
   */
  private function generateClusters($num_clusters) {
    for ($i = 1; $i <= $num_clusters; $i++) {
      $centroids = array();
      foreach ($this->dataset->columns as $key => $column_data) {
        if ($column_data['datatype'] == 'numeric') {
          $centroids[$key] = $this->rand($column_data['min'], $column_data['max']);
        }
      }
      $this->clusters[$i] = $centroids;
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
        if ($this->dataset->columns[$key]['datatype'] == 'numeric') {
          $wcss += pow($value - $cluster[$key], 2);
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
