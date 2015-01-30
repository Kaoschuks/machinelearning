<?php

require '../vendor/autoload.php';

use MachineLearning\DataPreparation\Dataset;
use MachineLearning\Clustering\KMeans;

require_once dirname(__FILE__) . "/datasets/iris.php";

$dataset = new Dataset($data);
$cluster = new KMeans($dataset);
// $cluster->updateDataset($dataset);
$cluster->learn();

// print_r($dataset->columns);
print_r($cluster->clusters);
