<?php namespace ews;

abstract class Namespaces extends \lang\Enum {
  public static $SOAP, $TYPES, $MESSAGES, $ERRORS;

  static function __static() {
    self::$SOAP= newinstance(self::class, [0, 'SOAP'], '{
      static function __static() { }
      public function url() { return "http://schemas.xmlsoap.org/soap/envelope/"; }
    }');
    self::$TYPES= newinstance(self::class, [1, 'TYPES'], '{
      static function __static() { }
      public function url() { return "http://schemas.microsoft.com/exchange/services/2006/types"; }
    }');
    self::$MESSAGES= newinstance(self::class, [2, 'MESSAGES'], '{
      static function __static() { }
      public function url() { return "http://schemas.microsoft.com/exchange/services/2006/messages"; }
    }');
    self::$ERRORS= newinstance(self::class, [3, 'ERRORS'], '{
      static function __static() { }
      public function url() { return "http://schemas.microsoft.com/exchange/services/2006/errors"; }
    }');
  }

  /** @return string */
  public abstract function url();
}