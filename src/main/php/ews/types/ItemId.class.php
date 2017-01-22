<?php namespace ews\types;

use ews\Object;

class ItemId extends Object {

  public function id() { return $this->member('Id'); }

  public function changeKey() { return $this->member('ChangeKey'); }
}