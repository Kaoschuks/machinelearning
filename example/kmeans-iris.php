<?php

require '../vendor/autoload.php';

use MachineLearning\Utility\Entity\Config;
use MachineLearning\Data\Entity\Dataset;
use MachineLearning\Clustering\Entity\KMeans;

require_once dirname(__FILE__) . "/datasets/iris.php";

$config = new Config(dirname(__FILE__) . "/kmeans-iris-config.yml");

$dataset = new Dataset($config, $data);

$cluster = new KMeans($config);
$cluster->setTrainingData($dataset);
$cluster->train();

print_r($cluster->clusters[1]->getCentroid());
