<?php namespace ews\types;

use ews\Value;

class Email extends \ews\Object {

  public function __construct($address= null, $name= null, $routingType= null) {
    parent::__construct(nameof($this));
    $address && $this->members['Address']= Value::typed('ews.types.Address', $address);
    $name && $this->members['Name']= Value::typed('ews.types.Name', $name);
    $routingType && $this->members['RoutingType']= Value::typed('ews.types.RoutingType', $routingType);
  }
}