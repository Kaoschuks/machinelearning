<?php

namespace MachineLearning\Data\Entity;

use MachineLearning\Data\Entity\Vector;
use MachineLearning\Data\Entity\Column;
use MachineLearning\Data\Controller\ObjectController;

class Subset
{
    private $vectorMap = array();
    private $columnMap = array();
    public $vectors;
    public $columns;

    public function __construct()
    {
        $this->vectors = new ObjectController();
        $this->columns = new ObjectController();
    }

    public function addData($data)
    {
        $this->deAssociativeVectorKeys($data);
        $this->deAssociativeColumnKeys($data);
        $this->floatval($data);

        // Create the vectors.
        foreach ($this->vectorMap as $key => $value) {
            $vector = new Vector($key, $data[$key]);
            $this->vectors->set($key, $vector);
        }

        // Create the columns.
        foreach ($this->columnMap as $key => $value) {
            $column = new Column($key, array_column($data, $key));
            $this->columns->set($key, $column);
        }
    }

    public function getVectors($start, $end)
    {
        $vectors = array();
        foreach ($this->vectors as $vector) {

            $vectors[$vector->key] = $vector;
        }
        return $vectors;
    }

    public function setVectors($vectors)
    {
        foreach ($vectors as $key => $vector) {
            $this->vectors->set($key, $vector);
        }
    }

    private function deAssociativeVectorKeys(&$data)
    {
        $new_data = array();
        $this->vectorMap = array_keys($data);
        foreach ($this->vectorMap as $key => $value) {
          $new_data[$key] = $data[$value];
        }
        $data = $new_data;
    }

    private function deAssociativeColumnKeys(&$data)
    {
        foreach ($data as $array) {
            $this->columnMap = array_unique(array_merge($this->columnMap, array_keys($array)));
        }

        // Map the column keys to the numeric keys.
        foreach ($data as &$row) {
            foreach ($this->columnMap as $key => $value) {
                $row[$key] = null;
                if (isset($row[$value])) {
                    $row[$key] = $row[$value];
                    unset($row[$value]);
                }
            }
        }
    }

    private function floatval(&$data)
    {
        foreach ($data as &$row) {
            foreach ($row as &$value) {
                $value = is_numeric($value) ? floatval($value) : $value;
            }
        }
    }
}
