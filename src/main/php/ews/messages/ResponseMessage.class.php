<?php namespace ews\messages;

class ResponseMessage extends \ews\Object {

  /** @return bool */
  public function isSuccess() { return 'Success' === $this->member('ResponseClass', null); }
}