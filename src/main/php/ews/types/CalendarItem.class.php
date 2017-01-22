<?php namespace ews\types;

use ews\Object;
use util\Date;

class CalendarItem extends Object {

  public function start() {
    $start= $this->member('Start');
    return $start ? new Date($start) : null;
  }

  public function end() {
    $end= $this->member('End');
    return $end ? new Date($end) : null;
  }
}