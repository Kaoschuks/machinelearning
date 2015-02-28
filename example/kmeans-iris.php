<?php

require '../vendor/autoload.php';

use MachineLearning\Data\Dataset;
use MachineLearning\Clustering\KMeans;

require_once dirname(__FILE__) . "/datasets/iris.php";

$dataset = new Dataset();
$dataset->addData($data);

$cluster = new KMeans();
$cluster->config->numClusters = 3;
$cluster->config->convergionDistance = 0.001;
$cluster->setTrainingData($dataset);
$cluster->train();

// print_r($cluster->clusters);
