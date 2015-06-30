<?php
/**
 * @category Service Object.
 * @package League\MachineLearning\Test
 * @author Willem Bressers <info@willembressers.nl>
 * @license MIT
 * @link https://github.com/willembressers/machinelearning
 */

namespace League\MachineLearning\Test;

use League\MachineLearning\Service\ConfigurationHandler;

/**
 * This class test the ConfigurationHandler.
 *
 * Class ConfigurationHandlerTest
 * @package League\MachineLearning\Test
 */
class ConfigurationHandlerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test the loading of the configuration file.
     */
    public function testLoadConfigurationFile()
    {
        $file = new ConfigurationHandler();
        $file->setFile(__DIR__ . '/assets/KNearestNeighborsConfig.yml');
        $this->assertNotEmpty($file->getContent());
    }

    /**
     * @test the saving of the configuration file.
     * @depends testLoadConfigurationFile
     */
    public function testSaveConfigurationlFile()
    {
        $file = new ConfigurationHandler();
        $file->setFile(__DIR__ . '/assets/KNearestNeighborsConfig.yml');

        // Backup the file contents.
        $content = $file->getContent();

        // Empty the file.
        $file->setContent(array());
        $this->assertEmpty($file->getContent());

        // Set back the contents.
        $file->setContent($content);
        $this->assertNotEmpty($file->getContent());

        // Compare the contents.
        $this->assertEquals($content, $file->getContent());
    }
}
