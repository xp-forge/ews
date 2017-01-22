<?php namespace ews;

use xml\parser\XMLParser;
use ews\xml\Emitter; 
use ews\xml\ParseInto;
use lang\IllegalArgumentException;

class Envelope extends Object {
  const INDENTED = 0;
  const COMPACT  = 2;

  private static $parser, $emitter, $styles;

  static function __static() {
    self::$parser= new XMLParser();
    self::$emitter= new Emitter();
    self::$styles= [
      self::INDENTED => function($result) { return $result->getDeclaration()."\n".$result->getSource(INDENT_DEFAULT); },
      self::COMPACT  => function($result) { return $result->getSource(INDENT_NONE); }
    ];
  }

  /**
   * Creates a new envelope
   *
   * @param  ews.Header $header
   * @param  ews.Body $body
   */
  public function __construct(Header $header= null, Body $body= null) {
    parent::__construct(nameof($this));
    $this->members= ['Header' => $header, 'Body' => $body];
  }

  /**
   * Parses XML
   *
   * @param  string $input
   * @return self
   * @throws xml.XMLFormatException
   */
  public static function parse($input) {
    $result= new Result();
    self::$parser->withCallback(new ParseInto($result))->parse($input);
    return $result->envelope();
  }

  /**
   * Emits XML
   *
   * @param  int $style one of INDENTED, COMPACT
   * @return string
   * @throws lang.IllegalArgumentException
   */
  public function emit($style= self::INDENTED) {
    if (!isset(self::$styles[$style])) {
      throw new IllegalArgumentException('Illegal emit style '.$style);
    }

    $func= self::$styles[$style];
    return $func(self::$emitter->emit($this));
  }

  /** @return ews.Fault */
  public function fault() {
    $message= $this->member('Body')->message();
    return $message instanceof Fault ? $message : null;
  }

  /** @return ews.Header */
  public function header() { return $this->member('Header'); }

  /** @return ews.Body */
  public function body() { return $this->member('Body'); }

}