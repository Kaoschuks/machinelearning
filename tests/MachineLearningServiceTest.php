<?php
/**
 * Created by PhpStorm.
 * User: willembressers
 * Date: 26/06/15
 * Time: 21:43
 */

namespace League\MachineLearning\Test;


use League\MachineLearning\Service\MachineLearningService;

class MachineLearningServiceTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test Creation of MachineLearningService and loading Configuration.
     */
    public function testCreateMachineLearningService() {
        $service = new MachineLearningService();

        // Test if configuration initially is empty.
        $this->assertEmpty($service->getConfiguration());

        // Test if configuration initially is NOT empty.
        $service->loadConfiguration(__DIR__ . '/assets/config.yml');
        $this->assertNotEmpty($service->getConfiguration());
    }
}
