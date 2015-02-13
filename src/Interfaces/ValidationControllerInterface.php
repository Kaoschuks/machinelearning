<?php

namespace MachineLearning\Interfaces;

use MachineLearning\Data\Dataset;

/**
 * An interface that all Machine learning methods should have.
 */
interface ValidationControllerInterface {

  public function addValidationData(Dataset $dataset);

}
