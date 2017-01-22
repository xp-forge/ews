<?php namespace ews\unittest;

use ews\ListOf;
use ews\Value;

class ListOfTest extends \unittest\TestCase {

  #[@test]
  public function can_create() {
    new ListOf();
  }

  #[@test]
  public function typed() {
    ListOf::typed('ews.types.Items');
  }

  #[@test]
  public function type() {
    $this->assertEquals('ews.types.Items', ListOf::typed('ews.types.Items')->type());
  }

  #[@test]
  public function name_defaults_to_type() {
    $this->assertEquals('ews.ListOf', (new ListOf())->type());
  }

  #[@test]
  public function empty_by_default() {
    $this->assertEquals([], ListOf::typed('ews.types.Items')->elements());
  }

  #[@test]
  public function elements() {
    $elements= [Value::typed('ews.types.EmailAddress', 'test@example.com')];
    $this->assertEquals($elements, ListOf::typed('ews.types.Items', $elements)->elements());
  }

  #[@test]
  public function with_element() {
    $element= Value::typed('ews.types.EmailAddress', 'test@example.com');
    $this->assertEquals([$element], ListOf::typed('ews.types.Items')->with($element)->elements());
  }
}