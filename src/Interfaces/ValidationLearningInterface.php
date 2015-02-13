<?php

namespace MachineLearning\Interfaces;

use MachineLearning\Interfaces\LearningInterface;

/**
 * An interface that all Machine learning methods should have.
 */
interface ValidationLearningInterface extends LearningInterface {

  public function validate();

}
