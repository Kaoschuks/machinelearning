<?php

namespace League\MachineLearning\Utility\Entity;

use League\MachineLearning\Utility\Entity\Config;
use League\MachineLearning\Data\Entity\Dataset;

/**
 * Project, Handle an entire project.
 *
 * @author Willem Bressers <info@willembressers.nl>
 */
class Project
{
    private $config;
    private $algorithm;

    /**
     * Set the configuration.
     *
     * @param Config $config
     */
    public function __construct()
    {
        $this->config = new Config();
    }

    /**
     * Loads the Project details from the config file.
     *
     * @param  string $path
     */
    public function load($path = 'config.yml')
    {
        $this->config->load($path);

        if ($project = $this->config->get('Project')) {
            $algorithm = @$project['algorithm'];
            if ($this->load_algorithm($algorithm)) {
                $data = $this->config->get($algorithm);
                $this->algorithm->import($data['training.data']);
            }
        }
    }

    /**
     * Saves the Project details from the config file.
     *
     * @param  string $path
     */
    public function save($path = 'config.yml')
    {
        if ($project = $this->config->get('Project')) {
            $algorithm = $project['algorithm'];

            $data = $this->algorithm->export();
            $this->config->set($algorithm, array('training.data' => $data));
            $this->config->save($path);
        }
    }

    /**
     * Loads the specified algorithm, and returns a true on success.
     *
     * @param  string $algorithm
     *
     * @return boolean
     */
    private function load_algorithm($algorithm)
    {
        $namespaces = array(
            'League\MachineLearning\Clustering\Entity',
            'League\MachineLearning\Supervised\Entity',
        );

        foreach ($namespaces as $namespace) {
            $class = $namespace . '\\' . $algorithm;
            if (class_exists($class)) {
                $this->algorithm = new $class();
                $this->algorithm->setConfig($this->config);
                return true;
            }
        }

        return false;
    }

     /**
     * Set the training data.
     *
     * @param Dataset $dataset
     */
    public function setTrainingData($data)
    {
        $dataset = new Dataset();
        $dataset->setConfig($this->config);
        $dataset->addData($data);
        $this->algorithm->setTrainingData($dataset);
    }

     /**
     * Set the test data.
     *
     * @param Dataset $dataset
     */
    public function setTestData($data)
    {
        $dataset = new Dataset();
        $dataset->setConfig($this->config);
        $dataset->addData($data);
        $this->algorithm->setTestData($dataset);
    }

    /**
     * Train the algorithm based on the training data.
     */
    public function train()
    {
        $this->algorithm->train();
    }

     /**
     * Test the algorithm based on the test data.
     */
    public function test()
    {
        $this->algorithm->test();
    }
}
