<?php namespace ews;

use util\Objects;

/**
 * Represents a single value 
 *
 * @test  xp://ews.unittest.ValueTest
 */
class Value extends Element {
  protected $string= '';

  /**
   * Creates a new value with a given string
   *
   * @param  string $type
   * @param  string $string
   * @return self
   */
  public static function typed($type, $string= null) {
    $self= new self($type);
    $self->string= $string;
    return $self;
  }

  /** @return string */
  public function get() { return $this->string; }

  /** @return string */
  public function hashCode() { return 'S'.Objects::hashOf($this->string); }

  /** @return string */
  public function toString() { return nameof($this).'("'.$this->string.'")'; }

  /**
   * Compares this object to a given value
   *
   * @param  var $value
   * @return bool
   */
  public function compareTo($value) {
    return $value instanceof self ? Objects::compare($this->string, $value->string) : 1;
  }

  /**
   * Emits this element
   *
   * @param  ews.xml.Emitter $emitter
   * @return xml.Node
   */
  public function emitUsing($emitter) {
    return $emitter->emitValue($this->type(), $this->string);
  }
}