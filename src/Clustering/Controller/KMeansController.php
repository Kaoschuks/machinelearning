<?php

namespace MachineLearning\Clustering\Controller;

use MachineLearning\Data\Entity\Object;
use MachineLearning\Data\Controller\ObjectController;
use MachineLearning\Utility\Controller\BaseController;
use MachineLearning\Utility\Model\BaseControllerModel;
use MachineLearning\Clustering\Entity\Cluster;

/**
 * Base class for the clustering algortims.
 */
class KMeansController extends BaseController implements BaseControllerModel
{
    public $clusters;

    public function __construct()
    {
        $this->clusters = new ObjectController();
    }

    /**
     * Load the stored clusters.
     */
    public function load($path = 'KMeans.yml')
    {
        $data = $this->import($path);
        foreach ($data as $key => $values) {
            $cluster = new Cluster($key);
            $cluster->centroid->data = $values;
            $this->clusters->set($key, $cluster);
        }
    }

    /**
     * Save the clusters, to a yml file.
     */
    public function save($path = 'KMeans.yml')
    {
        $data = array();
        foreach ($this->clusters as $cluster) {
            $data[$cluster->key] = $cluster->centroid->data;
        }
        $this->export($data, $path);
    }

    /**
     * Initialize the clusters.
     */
    public function initialization($config, $dataset)
    {
        for ($key = 1; $key <= $config['num.clusters']; $key++) {
            $data = array();

            // Pick a random vector for initial centroid.
            if ($config['initialization.method'] == 'forgy') {;
                $data = $dataset->vectors->random()->data;
            }

            // Pick random centroid between the colomn max and min.
            else {
                foreach ($dataset->columns as $column) {
                    $value = null;
                    if ($this->isNumeric($column->data)) {
                        $stats = $this->getDefaultStatistics($column->data);
                        $value = $this->rand($stats['min'], $stats['max']);
                    }
                    $data[$column->key] = $value;
                }
            }

            $cluster = new Cluster($key);
            $cluster->centroid->data = $data;
            $this->clusters->set($key, $cluster);
        }
    }

    /**
     * Get the nearest cluster based on the give row.
     */
    public function getNearestCluster($vector)
    {
        $leastWcss = PHP_INT_MAX;
        $nearestCluster = null;

        // Calculate the distance from the vector to each cluster centroid.
        foreach ($this->clusters as $cluster) {

            $wcss = $this->squaredDistance($vector->data, $cluster->centroid->data);

            if ($wcss < $leastWcss) {
                $leastWcss = $wcss;
                $nearestCluster = $cluster;
            }
        }

        return $nearestCluster;
    }

    /**
     * Update the cluster centroid for the next iteration, or mark the clusters as converged.
     */
    public function updateClusters(&$converged, $config)
    {
        $distance = 0;

        foreach ($this->clusters as $cluster) {
            $oldCentroid = clone $cluster->centroid;

            // No data available, thus noting to update.
            if (!@$cluster->vectors) {
                continue;
            }

            $data = array();
            foreach ($cluster->vectors as $vector) {
                foreach (array_keys($vector->data) as $key) {
                    $values = $cluster->vectors->getDataColumn($key);
                    $data[$key] = $this->isNumeric($values) ? $this->mean($values) : null;
                }
            }

            // Update the centroid.
            $cluster->centroid->data = $data;

            // Remove the cluster vectors.
            $cluster->vectors->clear();

            // Calculate the distance.
            $distance += $this->euclideanDistance($oldCentroid->data, $cluster->centroid->data = $data);
        }

        $converged = $distance <= $config['convergion.distance'] ? true : false;
    }
}
