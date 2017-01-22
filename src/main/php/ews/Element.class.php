<?php namespace ews;

abstract class Element implements \lang\Value {
  private $type;

  /**
   * Creates a new object
   *
   * @param  string $type
   */
  public function __construct(string $type= null) {
    $this->type= $type ?: nameof($this);
  }

  /** @return string */
  public function type() { return $this->type; }

  /**
   * Passes attributes - defaults to NOOP.
   *
   * @param  [:string] $attributes
   * @return self
   */
  public function pass($attributes) {
    return $this;
  }

  /**
   * Adds an element - defaults to NOOP.
   *
   * @param  ews.Element $element
   * @param  string $name
   * @return self
   */
  public function with($element, $name= null) {
    return $this;
  }

  /**
   * Emits this element
   *
   * @param  ews.xml.Emitter $emitter
   * @return xml.Node
   */
  public abstract function emitUsing($emitter);
}