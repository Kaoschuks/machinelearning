<?php

namespace MachineLearning\Data\Controller;

/**
 *
 */
class DatasetController
{
    private $dataset;

    /**
     * Set data.
     */
    public function setDataset(Dataset $dataset)
    {
        $this->dataset = $dataset;
    }

    /**
     * Get data.
     */
    public function getDataset()
    {
        return $this->dataset;
    }
}
