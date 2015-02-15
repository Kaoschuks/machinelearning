<?php

require '../vendor/autoload.php';

use MachineLearning\Data\Dataset;
use MachineLearning\Supervised\KNearestNeighbors;

require_once dirname(__FILE__) . "/datasets/iris.php";

$dataset = new Dataset();
$dataset->addData($data);
list($training_data, , $test_data) = $dataset->split(0.8, 0, 0.2);

$cluster = new KNearestNeighbors();
$cluster->addTrainingData($training_data);
$cluster->addTestData($test_data);
$cluster->test();

print_r($cluster->testData->data);
