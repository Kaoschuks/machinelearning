<?php

use MachineLearning\Utility\Entity\Project;

$pwd = dirname(__FILE__);

require '../vendor/autoload.php';
require_once $pwd."/datasets/iris.php";

$project = new Project();
$project->load($pwd."/project-config.yml");
$project->setTrainingData($data);
$project->train();
$project->save($pwd."/project-config.yml");

