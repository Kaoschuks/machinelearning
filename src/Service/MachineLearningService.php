<?php
/**
 * @category
 * @package
 * @author Willem Bressers <info@willembressers.nl>
 * @license
 * @link
 */

namespace League\MachineLearning\Service;

/**
 * Class MachineLearningService
 * @package League\MachineLearning\Service
 */
class MachineLearningService {

    private $configuration;

    /**
     * @param YamlFileHandler $configuration
     */
    function __construct(YamlFileHandler $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return YamlFileHandler
     */
    public function getConfiguration()
    {
        return $this->configuration->getContent();
    }

    /**
     * @param YamlFileHandler $configuration
     */
    public function setConfiguration($configuration)
    {
        $this->configuration->setContent($configuration);
    }
}