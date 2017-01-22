<?php namespace ews;

use util\Objects;

class Body extends Element {
  private $message;

  /**
   * Creates a new body
   *
   * @param  ews.Element $message
   */
  public function __construct($message= null) {
    parent::__construct(nameof($this));
    $this->message= $message;
  }

  /**
   * Adds an element
   *
   * @param  ews.Element $element
   * @param  string $name
   * @return self
   */
  public function with($element, $name= null) {
    $this->message= $element;
    return $this;
  }

  /** @return string */
  public function hashCode() {
    return 'B'.Objects::hashOf($this->message);
  }

  /** @return string */
  public function toString() {
    return nameof($this).'<'.Objects::stringOf($this->message).'>';
  }

  /**
   * Compares this object to a given value
   *
   * @param  var $value
   * @return bool
   */
  public function compareTo($value) {
    return $value instanceof self ? Objects::compare($this->message, $value->message) : 1;
  }

  /** @return ews.Element */
  public function message() { return $this->message; }

  /**
   * Emits this element
   *
   * @param  ews.xml.Emitter $emitter
   * @return xml.Node
   */
  public function emitUsing($emitter) {
    return $emitter->emitOne($this->type(), $this->message);
  }
}