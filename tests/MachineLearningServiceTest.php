<?php
/**
 * @category
 * @package
 * @author Willem Bressers <info@willembressers.nl>
 * @license
 * @link
 */

namespace League\MachineLearning\Test;


use League\MachineLearning\Service\MachineLearningService;
use League\MachineLearning\Service\YamlFileHandler;

/**
 * Class MachineLearningServiceTest
 * @package League\MachineLearning\Test
 */
class MachineLearningServiceTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test Creation of MachineLearningService and loading Configuration.
     */
    public function testCreateMachineLearningService()
    {
        $configuration = new YamlFileHandler(__DIR__ . '/assets/config.yml');

        $service = new MachineLearningService($configuration);
        $this->assertNotEmpty($service->getConfiguration());
    }
}
