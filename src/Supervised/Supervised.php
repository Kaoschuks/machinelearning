<?php

namespace MachineLearning\Supervised;

use MachineLearning\MachineLearning;
use MachineLearning\Interfaces\ControllerInterface;
use MachineLearning\Data\Dataset;

/**
 * Base class for the supervised algortims.
 */
class Supervised extends MachineLearning implements ControllerInterface
{

    public $trainingData;
    public $validationData;
    public $testData;

    /**
     * Add trainings data..
     */
    public function setTrainingData(Dataset $dataset)
    {
        $this->trainingData = $dataset;
    }

    /**
     * set validation data.
     */
    public function setValidationData(Dataset $dataset)
    {
        $this->validationData = $dataset;
    }

    /**
     * set test data.
     */
    public function setTestData(Dataset $dataset)
    {
        $this->testData = $dataset;
    }
}
