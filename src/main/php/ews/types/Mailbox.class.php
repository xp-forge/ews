<?php namespace ews\types;

use ews\Object;

class Mailbox extends Object {

  /** @return string */
  public function name() { return $this->member('Name', null); }
}