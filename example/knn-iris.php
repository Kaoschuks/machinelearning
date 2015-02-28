<?php

require '../vendor/autoload.php';

use MachineLearning\Utility\Entity\Config;
use MachineLearning\Data\Entity\Dataset;
use MachineLearning\Supervised\Entity\KNearestNeighbors;

require_once dirname(__FILE__) . "/datasets/iris.php";

$config = new Config(dirname(__FILE__) . "/knn-iris-config.yml");

$dataset = new Dataset($config, $data);
list($training_data, , $test_data) = $dataset->split(0.8, 0, 0.2);

$cluster = new KNearestNeighbors($config);
$cluster->setTrainingData($training_data);
$cluster->setTestData($test_data);
$cluster->test();

print_r($cluster->testData->getVectors());
