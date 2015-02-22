<?php

namespace MachineLearning\Interfaces;

use MachineLearning\Data\Dataset;

/**
 * An interface that all Machine learning methods should have.
 */
interface ControllerInterface
{
    public function setTrainingData(Dataset $dataset);
    public function setValidationData(Dataset $dataset);
    public function setTestData(Dataset $dataset);
}
