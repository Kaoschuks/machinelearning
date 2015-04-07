<?php

namespace League\MachineLearning\Clustering\Controller;

use League\MachineLearning\Data\Entity\Object;
use League\MachineLearning\Data\Entity\Collection;
use League\MachineLearning\Data\Entity\Dataset;
use League\MachineLearning\Clustering\Entity\Cluster;
use League\MachineLearning\Utility\Entity\Calculate;
use League\MachineLearning\Utility\Entity\Config;
use League\MachineLearning\Utility\Entity\Utility;

/**
 * KMeansController, Contains K means functionality.
 *
 * @author Willem Bressers <info@willembressers.nl>
 */
class KMeansController
{
    public $clusters;

    /**
     * Specify the defaults.
     */
    public function __construct()
    {
        $this->clusters = new Collection();
    }

    /**
     * Load the stored clusters.
     *
     * @param  string $path
     */
    public function load($path = 'KMeans.yml')
    {
        $data = Config::import($path);
        $this->import($data);
    }

    /**
     * Save the clusters.
     *
     * @param  string $path
     */
    public function save($path = 'KMeans.yml')
    {
        $data = $this->export();
        Config::export($data, $path);
    }

    /**
     * Import data, and build the clusters.
     *
     * @param Array $data
     */
    public function import($data)
    {
        foreach ($data as $key => $values) {
            $cluster = new Cluster($key);
            $cluster->centroid->data = $values;
            $this->clusters->set($key, $cluster);
        }
    }

    /**
     * Export the clusters data.
     *
     * @return Array $data
     */
    public function export()
    {
        $data = array();
        foreach ($this->clusters as $cluster) {
            $data[$cluster->key] = $cluster->centroid->data;
        }
        return $data;
    }

    /**
     * Initialize the clusters.
     *
     * @param Dataset $dataset
     * @param Config  $config
     */
    public function initialization(Dataset $dataset, Config $config)
    {
        $configuration = $config->get('KMeans');
        $data = array();

        for ($key = 1; $key <= $configuration['num.clusters']; $key++) {
            // Pick a random vector for initial centroid.
            if ($configuration['initialization.method'] == 'forgy') {
                $data[$key] = $dataset->vectors->random()->data;
            }

            // Pick random centroid between the colomn max and min.
            else {
                foreach (array_keys($dataset->columnMap) as $columnKey) {
                    $value = null;
                    $values = $dataset->vectors->getColumnValues($columnKey);
                    if (Utility::isNumeric($values)) {
                        $stats = Calculate::defaultStatistics($values);
                        $value = Utility::rand($stats['min'], $stats['max']);
                    }
                    $data[$key][$columnKey] = $value;
                }
            }
        }

        $this->import($data);
    }

    /**
     * Get the nearest cluster based on the give row.
     *
     * @param Object $vector
     *
     * @return Cluster
     */
    public function getNearestCluster(Object $vector)
    {
        $leastWcss = PHP_INT_MAX;
        $nearestCluster = null;

        // Calculate the distance from the vector to each cluster centroid.
        foreach ($this->clusters as $cluster) {
            $wcss = Calculate::squaredDistance($vector->data, $cluster->centroid->data);

            if ($wcss < $leastWcss) {
                $leastWcss = $wcss;
                $nearestCluster = $cluster;
            }
        }

        return $nearestCluster;
    }

    /**
     * Update the cluster centroid for the next iteration, or mark the clusters as converged.
     *
     * @param boolean &$converged
     * @param Config  $config
     */
    public function updateClusters(&$converged, Config $config)
    {
        $configuration = $config->get('KMeans');
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
                    $values = $cluster->vectors->getColumnValues($key);
                    $data[$key] = Utility::isNumeric($values) ? Calculate::mean($values) : null;
                }
            }

            // Update the centroid.
            $cluster->centroid->data = $data;

            // Remove the cluster vectors.
            $cluster->vectors->clear();

            // Calculate the distance.
            $distance += Calculate::euclideanDistance($oldCentroid->data, $cluster->centroid->data = $data);
        }

        $converged = $distance <= $configuration['convergion.distance'] ? true : false;
    }
}
