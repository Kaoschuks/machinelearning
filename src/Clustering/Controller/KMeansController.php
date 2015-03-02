<?php

namespace MachineLearning\Clustering\Controller;

use MachineLearning\Utility\Controller\BaseController;
use MachineLearning\Utility\Model\BaseControllerModel;
use MachineLearning\Clustering\Entity\Cluster;

/**
 * Base class for the clustering algortims.
 */
class KMeansController extends BaseController implements BaseControllerModel
{
    public $clusters;

    public function load()
    {

    }

    public function save()
    {

    }

    /**
     * Initialize the clusters.
     */
    public function initialization($config, $dataset)
    {
        for ($cluster_key = 1; $cluster_key <= $config['num.clusters']; $cluster_key++) {
            $cluster = new Cluster();

            // Pick k random rows for initial centroid.
            if ($config['initialization.method'] == 'forgy') {
                $vector = array_rand($dataset->getVectors());
                foreach ($dataset->getColumns() as $key => $column) {
                    if ($column->isNumeric()) {
                        $cluster->setColumnCentroid($key, $vector->getValue($key));
                    }
                }
            }

            // Pick random centroid between the colomn max and min.
            else {
                foreach ($dataset->getColumns() as $key => $column) {
                    if ($column->isNumeric()) {
                        $stats = $column->getStats();
                        $cluster->setColumnCentroid($key, $this->rand($stats['min'], $stats['max']));
                    }
                }
            }

            $this->clusters[$cluster_key] = $cluster;
        }
    }

    /**
     * Get the nearest cluster based on the give row.
     */
    public function getNearestCluster($vector, $dataset)
    {
        $leastWcss = PHP_INT_MAX;
        $nearestClusterKey = null;

        // Calculate the distance from the the centroid.
        foreach ($this->clusters as $cluster_key => $cluster) {
            $wcss = 0;
            foreach ($vector->getValues() as $key => $value) {
                if ($dataset->getColumn($key)->isNumeric()) {
                    $wcss += pow($value - $cluster->getColumnCentroid($key), 2);
                }
            }
            if ($wcss < $leastWcss) {
                $leastWcss = $wcss;
                $nearestClusterKey = $cluster_key;
            }
        }

        return $this->clusters[$nearestClusterKey];
    }

    /**
     * Update the cluster centroid for the next iteration, or mark the clusters as converged.
     */
    public function updateClusters(&$converged, $config)
    {
        $distance = 0;

        foreach ($this->clusters as $cluster_key => $cluster) {
            $old_centroid = $this->clusters[$cluster_key]->getCentroid();
            $new_centroid = array();

            // No data available, thus noting to update.
            if (!@$cluster->getVectors()) {
                continue;
            }

            // Pick new random centroid based on the subset.
            foreach ($cluster->getVectors() as $vector) {
                foreach ($cluster->getColumns() as $key => $column) {
                    if ($column->isNumeric()) {
                        $new_centroid[$key] = $this->mean($column->getValues());
                    }
                }
            }

            // Update the centroid, and remove the subset.
            $this->clusters[$cluster_key]->setCentroid($new_centroid);;
            $distance += $this->euclideanDistance($old_centroid, $new_centroid);
            unset($this->clusters[$cluster_key]->vectors);
        }

        $converged = $distance <= $config['convergion.distance'] ? true : false;
    }
}
