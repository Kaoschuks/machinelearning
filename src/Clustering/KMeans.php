<?php

namespace MachineLearning\Clustering;

use MachineLearning\Clustering\Cluster;
use MachineLearning\MachineLearningInterface;
use MachineLearning\Data\Dataset;

/**
 * Cluster the data, based on the KMeans approach.
 */
class KMeans extends Cluster implements MachineLearningInterface{

  public $num_clusters;
  public $convergion_distance;

  /**
   * Basic constructor.
   */
  public function __construct($num_clusters = 3, $convergion_distance = 1) {
    $this->num_clusters = $num_clusters;
    $this->convergion_distance = $convergion_distance;
  }

    /**
   * Add trainings data to train the clusters.
   *
   * @param Dataset $dataset
   */
  public function addTrainingData(Dataset $dataset) {
    parent::addTrainingData($dataset);
    $this->generateClusters();
  }

  /**
   * Add validation data to validate the clusters.
   *
   * @param Dataset $dataset
   */
  public function addValidationData(Dataset $dataset) {
    parent::addValidationData($dataset);
  }

  /**
   * Add test data.
   *
   * @param Dataset $dataset
   */
  public function addTestData(Dataset $dataset) {
    parent::addTestData($dataset);
  }

  /**
   * Train the clusters based on the trainingdata.
   */
  public function train() {
    $converged = FALSE;

    // Keep on training until convergion.
    do {
      foreach ($this->trainingData->data as $row_key => $row) {
        $nearestClusterKey = $this->getNearestCluster($row);
        $this->clusters[$nearestClusterKey]['data'][$row_key] = $row;
      }
      $this->updateClusters($converged);
    } while (!$converged);
  }

  /**
   * Validate the clusters.
   */
  public function validate() {
    // @TODO ...
  }

  /**
   * Test the clusters on the testdata.
   */
  public function test() {
    // @TODO ...
  }

  /**
   * Initialize the clusters.
   */
  private function generateClusters() {
    $columnData = $this->trainingData->getColumnData();
    for ($cluster_key = 1; $cluster_key <= $this->num_clusters; $cluster_key++) {
      $centroids = array();
      foreach ($columnData as $key => $column_data) {
        if ($column_data['datatype'] == 'numeric') {
          $centroids[$key] = $this->rand($column_data['min'], $column_data['max']);
        }
      }
      $this->clusters[$cluster_key]['centroids'] = $centroids;
    }
  }

  /**
   * Update the cluster centroids for the next iteration, or mark the clusters as converged.
   *
   * @param  boolean   &$converged
   */
  private function updateClusters(&$converged) {
    $distance = 0;
    $columnData = $this->trainingData->getColumnData();

    foreach ($this->clusters as $cluster_key => $cluster) {
      $old_centroids = $this->clusters[$cluster_key]['centroids'];
      $centroids = array();

      // No data available, thus noting to update.
      if (!@$cluster['data']) {
        continue;
      }

      // Pick new random centroids based on the subset.
      foreach ($cluster['data'] as $row_key => $row) {
        foreach ($row as $key => $value) {
          if ($columnData[$key]['datatype'] == 'numeric') {
            $values = array_column($cluster['data'], $key);
            $centroids[$key] = $this->mean($values);
          }
        }
      }

      // Update the centroids, and remove the subset.
      $this->clusters[$cluster_key]['centroids'] = $centroids;
      $distance += $this->euclideanDistance($old_centroids, $centroids);
      unset($this->clusters[$cluster_key]['data']);
    }

    $converged = $distance <= $this->convergion_distance ? TRUE : FALSE;
  }

  /**
   * Get the nearest cluster based on the give row.
   *
   * @param  array  $row
   * @return The cluster key.
   */
  private function getNearestCluster($row) {
    $columnData = $this->trainingData->getColumnData();
    $leastWcss = PHP_INT_MAX;
    $nearestClusterKey = NULL;

    // Calculate the distance from the the centroids.
    foreach ($this->clusters as $cluster_key => $cluster) {
      $wcss = 0;
      foreach ($row as $key => $value) {
        if ($columnData[$key]['datatype'] == 'numeric') {
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
