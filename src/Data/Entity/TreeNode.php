<?php

namespace League\MachineLearning\Data\Entity;

/**
 * Contains the tree datastructure..
 *
 * @author Willem Bressers <info@willembressers.nl>
 */
class TreeNode
{
    public $item;
    public $children;

    public function __construct($item) {
        $this->item = $item;
        $this->children = null;
    }
}
