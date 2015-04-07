<?php

namespace League\MachineLearning\Utility\Model;

use League\MachineLearning\Data\Entity\Dataset;

/**
 * InstanceBasedLearningModel, Interface for instance based learning methods.
 *
 * @author Willem Bressers <info@willembressers.nl>
 */
interface InstanceBasedLearningModel
{
    public function setTrainingData(Dataset $dataset);
    public function setTestData(Dataset $dataset);
    public function test();
}
