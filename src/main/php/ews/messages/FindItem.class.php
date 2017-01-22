<?php namespace ews\messages;

class FindItem extends \ews\Object {

  public function __construct($traversal= null) {
    parent::__construct(nameof($this));
    $traversal && $this->attributes['Traversal']= $traversal;
  }
}