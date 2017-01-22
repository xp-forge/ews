<?php namespace ews\errors;

class FaultNamed extends Fault {

  public function __construct($name, $details, $cause= null) {
    parent::__construct($name.': '.$details, $cause);
  }
}