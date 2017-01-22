<?php namespace ews\types;

class RequestedView extends \ews\Value {
  public static $NONE, $MERGEDONLY, $FREEBUSY, $FREEBUSYMERGED, $DETAILED, $DETAILEDMERGED;

  static function __static() {
    self::$FREEBUSY= new self('FreeBusy');
    self::$NONE= new self('None');
    self::$MERGEDONLY= new self('MergedOnly');
    self::$FREEBUSY= new self('FreeBusy');
    self::$FREEBUSYMERGED= new self('FreeBusyMerged');
    self::$DETAILED= new self('Detailed');
    self::$DETAILEDMERGED= new self('DetailedMerged');
  }

  public function __construct($string= null) {
    parent::__construct(nameof($this));
    $this->string= $string;
  }
}