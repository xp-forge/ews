<?php namespace ews;

use util\Objects;
use lang\ElementNotFoundException;

/**
 * Represents an object 
 *
 * @test  xp://ews.unittest.ObjectTest
 */
class Object extends Element {
  protected $attributes= [];
  protected $members= [];

  /**
   * Creates a new object with a given type name
   *
   * @param  string $type
   * @param  [:string] $attributes
   * @return self
   */
  public static function typed($type, $attributes= []) {
    return (new self($type))->pass($attributes);
  }

  /**
   * Passes attributes
   *
   * @param  [:string] $attributes
   * @return self
   */
  public function pass($attributes) {
    $this->attributes= $attributes;
    return $this;
  }

  /**
   * Adds an element
   *
   * @param  ews.Element $element
   * @param  string $name
   * @return self
   */
  public function with($element, $name= null) {
    if (null === $name) {
      $type= $element->type();
      $name= substr($type, strrpos($type, '.') + 1);
    }
    $this->members[$name]= $element;
    return $this;
  }

  /** @return [:ews.Element] */
  public function members() { return $this->members; }

  /** @return [:string] */
  public function attributes() { return $this->attributes; }

  /**
   * Returns a named member
   *
   * @param  string $name  
   * @param  ews.Element... $default
   * @return ews.Element
   * @throws lang.ElementNotFoundException
   */
  public function member($name, ... $default) {
    if (isset($this->members[$name])) {
      return $this->members[$name];
    } else if ($default) {
      return $default[0];
    } else {
      throw new ElementNotFoundException('No member "'.$name.'"');
    }
  }

  /** @return string */
  public function hashCode() {
    return Objects::hashOf($this->members);
  }

  /** @return string */
  public function toString() {
    if (empty($this->attributes)) {
      $str= nameof($this);
    } else {
      $attributes= '';
      foreach ($this->attributes as $attribute => $value) {
        $attributes.= ' '.$attribute.'="'.$value.'"';
      }
      $str= nameof($this).'('.substr($attributes, 1).')';
    }

    switch (sizeof($this->members)) {
      case 0: return $str;
      case 1: return $str.'@['.key($this->members).' => '.current($this->members)->toString().']';
      default: return $str.'@'.Objects::stringOf($this->members);
    }
  }

  /**
   * Compares this object to a given value
   *
   * @param  var $value
   * @return bool
   */
  public function compareTo($value) {
    return $value instanceof self ? Objects::compare($this->members, $value->members) : 1;
  }

  /**
   * Emits this element
   *
   * @param  ews.xml.Emitter $emitter
   * @return xml.Node
   */
  public function emitUsing($emitter) {
    return $emitter->emitObject($this->type(), $this->attributes, $this->members);
  }
}