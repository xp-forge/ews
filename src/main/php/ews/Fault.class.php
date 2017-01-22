<?php namespace ews;

class Fault extends Object {

  /** @return string */
  public function code() {
    $code= $this->member('faultcode')->get();
    return ($p= strpos($code, ':')) ? substr($code, $p + 1) : $code;
  }

  /** @return ews.Object */
  public function detail() { return $this->member('detail'); }
}