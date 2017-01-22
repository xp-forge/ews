<?php namespace ews\types;

use ews\Value;
use util\Date;

class TimeWindow extends \ews\Object {

  /**
   * Creates a new time window
   * 
   * @param  util.Date|string $start
   * @param  util.Date|string $end
   */
  public function __construct($start= null, $end= null) {
    parent::__construct(nameof($this));
    $start && $this->with(Value::typed('ews.types.StartTime', $this->format($start)));
    $end && $this->with(Value::typed('ews.types.EndTime', $this->format($end)));
  }

  /**
   * Format a date
   *
   * @param  util.Date|string $date
   * @return string
   */
  private function format($date) {
    return $date instanceof Date ? $date->toString('Y-m-d\TH:i:s') : $date;
  }
}