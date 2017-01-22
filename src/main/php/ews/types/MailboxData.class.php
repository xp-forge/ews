<?php namespace ews\types;

use ews\Value;

class MailboxData extends \ews\Object {

  public function __construct(Email $email= null, AttendeeType $attendeeType= null, $excludeConflicts= null) {
    parent::__construct(nameof($this));
    $email && $this->members['Email']= $email;
    $attendeeType && $this->members['AttendeeType']= $attendeeType;
    null === $excludeConflicts || $this->members['ExcludeConflicts']= Value::typed(
      'ews.types.ExcludeConflicts',
      $excludeConflicts ? 'true' : 'false'
    );
  }
}