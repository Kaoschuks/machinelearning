<?php

namespace League\MachineLearning\Data\Entity;

use League\MachineLearning\Data\Entity\TreeNode;

/**
 * Contains the tree datastructure..
 *
 * @author Willem Bressers <info@willembressers.nl>
 */
class Tree
{
    protected $root;

    public function __construct() {
        $this->root = null;
    }

    public function isEmpty() {
        return $this->root === null;
    }

    public function insert($item) {
        $node = new TreeNode($item);
        if ($this->isEmpty()) {
            $this->root = $node;
        }
    }
}
