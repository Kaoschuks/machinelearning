<?php

namespace MachineLearning\Interfaces;

/**
 * An interface that all Machine learning methods should have.
 */
interface LearningInterface
{
    public function train();
    public function test();
}
