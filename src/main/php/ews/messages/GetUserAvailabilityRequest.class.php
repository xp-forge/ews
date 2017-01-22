<?php namespace ews\messages;

use ews\types\FreeBusyViewOptions;

/** @see https://msdn.microsoft.com/en-us/library/office/aa563800(v=exchg.150).aspx */
class GetUserAvailabilityRequest extends \ews\Object {

  /**
   * Creates a new "UserAvailability" request
   *
   * @param  ews.MailboxData[]|ews.MailboxDataArray $mailboxes
   * @param  ews.FreeBusyViewOptions $freeBusyViewOptions
   */
  public function __construct($mailboxes= null, $freeBusyViewOptions= null) {
    parent::__construct(nameof($this));
    if ($mailboxes instanceof MailboxDataArray) {
      $this->with($mailboxes);
    } else if (is_array($mailboxes)) {
      $this->with(new MailboxDataArray($mailboxes));
    }
    $freeBusyViewOptions && $this->with($freeBusyViewOptions);
  }
}