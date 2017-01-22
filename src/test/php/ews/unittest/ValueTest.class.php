<?php namespace ews\unittest;

use ews\Value;

class ValueTest extends \unittest\TestCase {

  #[@test]
  public function can_create() {
    new Value();
  }

  #[@test]
  public function typed() {
    Value::typed('ews.types.EmailAddress');
  }

  #[@test]
  public function type() {
    $this->assertEquals('ews.types.EmailAddress', Value::typed('ews.types.EmailAddress')->type());
  }

  #[@test]
  public function type_defaults_to_typename() {
    $this->assertEquals('ews.Value', (new Value())->type());
  }

  #[@test]
  public function null_by_default() {
    $this->assertEquals(null, Value::typed('ews.types.EmailAddress')->get());
  }

  #[@test]
  public function string() {
    $this->assertEquals('test@example.com', Value::typed('ews.types.EmailAddress', 'test@example.com')->get());
  }
}