<?php

namespace MachineLearning\Interfaces;

use MachineLearning\Data\Dataset;

/**
 * An interface that all Machine learning methods should have.
 */
interface ControllerInterface
{
    public function addTrainingData(Dataset $dataset);
    public function addValidationData(Dataset $dataset);
    public function addTestData(Dataset $dataset);
}
