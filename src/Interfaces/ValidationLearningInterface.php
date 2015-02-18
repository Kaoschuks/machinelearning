<?php

namespace MachineLearning\Interfaces;

/**
 * An interface that all Machine learning methods should have.
 */
interface ValidationLearningInterface extends LearningInterface
{
    public function validate();
}
