<?php

$pwd = dirname(__FILE__);

require '../vendor/autoload.php';
require_once $pwd."/datasets/iris-missing.php";

use MachineLearning\Utility\Entity\Config;
use MachineLearning\Data\Entity\Dataset;
use MachineLearning\Clustering\Entity\KMeans;

$config = new Config();
$config->load($pwd."/kmeans-iris-missing-config.yml");

$dataset = new Dataset();
$dataset->setConfig($config);
$dataset->addData($data);

$cluster = new KMeans();
$cluster->setConfig($config);
$cluster->setTrainingData($dataset);
$cluster->train();

// print_r($dataset);
