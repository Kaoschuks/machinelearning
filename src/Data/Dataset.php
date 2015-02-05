<?php

namespace MachineLearning\Data;

use MachineLearning\Data\Column;

/**
 * Base class for the data handling.
 */
class Dataset {

  private $raw_data;
  public $rows;
  public $columns;

   /**
   * Add the raw data
   */
  public function addData($raw_data) {
    $this->raw_data = $raw_data;
    $data = array();

    // Fetch all unique column names.
    $column_keys = array();
    foreach ($raw_data as $row_key => $row_values) {
      foreach ($row_values as $column_key => $value) {
        if (!in_array($column_key, array_keys($column_keys))) {
          $column_keys[$column_key] = NULL;
        }
      }
    }

    // Fill the missing values with NULL.
    foreach ($raw_data as $row_key => $row_values) {
      $data[$row_key] = $row_values + $column_keys;
    }

    // Add the columns.
    foreach (array_keys($column_keys) as $key) {
      $this->columns[$key] = new Column($key, array_column($data, $key));
    }

    $this->data = $data;
  }
}
