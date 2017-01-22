<?php namespace ews\types;

class RequestServerVersion extends \ews\Object {

  public function __construct($version) {
    parent::__construct(nameof($this));
    $this->attributes['Version']= $version;
  }
}