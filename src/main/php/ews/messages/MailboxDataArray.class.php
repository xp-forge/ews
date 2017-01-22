<?php namespace ews\messages;

class MailboxDataArray extends \ews\ListOf {

  public function __construct($mailboxes= []) {
    parent::__construct(nameof($this));
    $this->elements= $mailboxes;
  }
}