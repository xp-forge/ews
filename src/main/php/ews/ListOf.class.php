<?php namespace ews;

use util\Objects;

/**
 * Represent a list of elements 
 *
 * @test  xp://ews.unittest.ListOfTest
 */
class ListOf extends Element {
  private $elements= [];

  /**
   * Creates a new object with a given name
   *
   * @param  string $type
   * @param  ews.Element[] $elements
   * @return self
   */
  public static function typed($type, $elements= []) {
    $self= new self($type);
    foreach ($elements as $element) {
      $self->elements[]= $element;
    }
    return $self;
  }

  /**
   * Adds an element
   *
   * @param  ews.Element $element
   * @param  string $name
   * @return self
   */
  public function with($element, $name= null) {
    $this->elements[]= $element;
    return $this;
  }

  /** @return [:ews.Element] */
  public function elements() { return $this->elements; }

  /** @return string */
  public function hashCode() {
    return 'L'.Objects::hashOf($this->elements);
  }

  /** @return string */
  public function toString() {
    $s= nameof($this).'<'.sizeof($this->elements).">@[\n";
    foreach ($this->elements as $i => $element) {
      $s.= '  #'.$i.': '.str_replace("\n", "\n  ", $element->toString())."\n";
    }
    return $s.']';
  }

  /**
   * Compares this object to a given value
   *
   * @param  var $value
   * @return bool
   */
  public function compareTo($value) {
    return $value instanceof self ? Objects::compare($this->elements, $value->elements) : 1;
  }

  /**
   * Emits this element
   *
   * @param  ews.xml.Emitter $emitter
   * @return xml.Node
   */
  public function emitUsing($emitter) {
    return $emitter->emitAll($this->type(), $this->elements);
  }
}