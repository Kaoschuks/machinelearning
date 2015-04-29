<?php

namespace League\MachineLearning\Data\Entity;

/**
 * Contains the tree datastructure.
 *
 * @author Willem Bressers <info@willembressers.nl>
 */
class TreeNode
{
    public $item;
    public $parent;
    public $children;
    public $values;

    public function __construct($item) {
        $this->item = $item;
        $this->parent = null;
        $this->children = array();
        $this->values = array();
    }
}
