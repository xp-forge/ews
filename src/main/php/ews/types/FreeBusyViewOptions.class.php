<?php namespace ews\types;

use ews\Value;

class FreeBusyViewOptions extends \ews\Object {
  
  public function __construct(
    TimeWindow $timeWindow= null,
    $mergedFreeBusyIntervalInMinutes= null,
    RequestedView $requestedView= null
  ) {
    parent::__construct(nameof($this));
    $timeWindow && $this->with($timeWindow);
    $mergedFreeBusyIntervalInMinutes && $this->with(Value::typed(
      'ews.types.MergedFreeBusyIntervalInMinutes',
      $mergedFreeBusyIntervalInMinutes
    ));
    $requestedView && $this->with($requestedView);
  }
 
}