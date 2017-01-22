<?php namespace ews;

class Result extends Object {

  /** @return ews.Envelope */
  public function envelope() { return $this->member('Envelope'); }

  /** @return void */
  public function clear() { $this->members= []; }
}