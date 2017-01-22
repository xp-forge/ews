<?php namespace ews\types;

class AttendeeType extends \ews\Value {
  public static $ORGANIZER, $REQUIRED, $OPTIONAL, $ROOM, $RESOURCE;

  static function __static() {
    self::$ORGANIZER= new self('Organizer');
    self::$REQUIRED= new self('Required');
    self::$OPTIONAL= new self('Optional');
    self::$ROOM= new self('Room');
    self::$RESOURCE= new self('Resource');
  }

  public function __construct($string= null) {
    parent::__construct(nameof($this));
    $this->string= $string;
  }
}