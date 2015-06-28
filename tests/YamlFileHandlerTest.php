<?php
/**
 * @category
 * @package League\MachineLearning\Test
 * @author Willem Bressers <info@willembressers.nl>
 * @license
 * @link
 */

namespace League\MachineLearning\Test;


use League\MachineLearning\Service\YamlFileHandler;

/**
 * Class YamlFileHandlerTest
 * @package League\MachineLearning\Test
 */
class YamlFileHandlerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test Creation of MachineLearningService and loading Configuration.
     */
    public function testLoadYamlFile()
    {
        $file = new YamlFileHandler();
        $file->setFile(__DIR__ . '/assets/config.yml');
        $this->assertNotEmpty($file->getContent());
    }

    /**
     * @test Creation of MachineLearningService and loading Configuration.
     */
    public function testSaveYamlFile()
    {
        $file = new YamlFileHandler();
        $file->setFile(__DIR__ . '/assets/config.yml');

        // Backup the file contents.
        $content = $file->getContent();

        // Empty the file.
        $file->setContent(array());
        $this->assertEmpty($file->getContent());

        // Set back the contents.
        $file->setContent($content);
        $this->assertNotEmpty($file->getContent());

        // Compare the contents.
        $this->assertEquals($content,$file->getContent());
    }
}
