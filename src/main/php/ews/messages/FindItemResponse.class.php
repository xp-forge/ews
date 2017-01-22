<?php namespace ews\messages;

class FindItemResponse extends \ews\Object {

  public function responseMessages() { return $this->member('ResponseMessages'); }
}