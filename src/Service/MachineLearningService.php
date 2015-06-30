<?php
/**
 * @category Service Object.
 * @package League\MachineLearning\Service
 * @author Willem Bressers <info@willembressers.nl>
 * @license MIT
 * @link https://github.com/willembressers/machinelearning
 */

namespace League\MachineLearning\Service;

/**
 * This class handles the basic commands.
 *
 * Class MachineLearningService
 * @package League\MachineLearning\Service
 */
class MachineLearningService
{
    private $configuration;
    private $dataHandler;

    /**
     * @param ConfigurationHandler $configuration
     * @param DataHandler $dataHandler
     */
    public function __construct(ConfigurationHandler $configuration, DataHandler $dataHandler)
    {
        $this->configuration = $configuration;
        $this->dataHandler = $dataHandler;
    }

    /**
     * Returns the ConfigurationHandler.
     *
     * @return ConfigurationHandler
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Returns the DataHandler.
     *
     * @return DataHandler
     */
    public function getDataHandler()
    {
        return $this->dataHandler;
    }

    /**
     * Applies training on all the specified algorithms.
     */
    public function train()
    {
        foreach ($this->getConfiguration()->getAlgorithms() as $algorithm) {
            var_dump($algorithm);
        }
    }
}
