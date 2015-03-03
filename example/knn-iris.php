<?php

$pwd = dirname(__FILE__);

require '../vendor/autoload.php';
require_once $pwd . "/datasets/iris.php";

use MachineLearning\Utility\Entity\Config;
use MachineLearning\Data\Entity\Dataset;
use MachineLearning\Supervised\Entity\KNearestNeighbors;

$config = new Config();
$config->load($pwd . "/knn-iris-config.yml");

$dataset = new Dataset();
$dataset->setConfig($config);
$dataset->addData($data);
list($training_data, , $test_data) = $dataset->split(0.8, 0, 0.2);

$cluster = new KNearestNeighbors();
$cluster->setConfig($config);
$cluster->setTrainingData($training_data);
$cluster->setTestData($test_data);
$cluster->test();

print_r($cluster->testData->getVectors());
