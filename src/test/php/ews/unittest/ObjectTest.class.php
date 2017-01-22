<?php namespace ews\unittest;

use ews\Object;
use ews\Value;
use lang\ElementNotFoundException;

class ObjectTest extends \unittest\TestCase {

  #[@test]
  public function can_create() {
    new Object();
  }

  #[@test]
  public function typed() {
    Object::typed('ews.messages.CalendarView');
  }

  #[@test]
  public function type() {
    $this->assertEquals('ews.messages.CalendarView', Object::typed('ews.messages.CalendarView')->type());
  }

  #[@test]
  public function name_defaults_to_type() {
    $this->assertEquals('ews.Object', (new Object())->type());
  }

  #[@test]
  public function empty_attributes() {
    $this->assertEquals([], Object::typed('ews.messages.CalendarView')->attributes());
  }

  #[@test]
  public function with_attributes() {
    $attributes= ['StartDate' => '2017-01-23T00:00:00.000Z', 'EndDate' => '2017-01-24T00:00:00.000Z'];
    $this->assertEquals($attributes, Object::typed('ews.messages.CalendarView', $attributes)->attributes());
  }

  #[@test]
  public function pass_attributes() {
    $attributes= ['StartDate' => '2017-01-23T00:00:00.000Z', 'EndDate' => '2017-01-24T00:00:00.000Z'];
    $this->assertEquals($attributes, Object::typed('ews.messages.CalendarView')->pass($attributes)->attributes());
  }

  #[@test]
  public function empty_members() {
    $this->assertEquals([], Object::typed('ews.types.Mailbox')->members());
  }

  #[@test]
  public function with_member() {
    $address= Value::typed('ews.types.EmailAddress', 'test@example.com');
    $this->assertEquals(['EmailAddress' => $address], Object::typed('ews.types.Mailbox')->with($address)->members());
  }

  #[@test]
  public function with_members() {
    $address= Value::typed('ews.types.EmailAddress', 'test@example.com');
    $type= Value::typed('ews.types.RoutingType', 'SMTP');
    $this->assertEquals(
      ['EmailAddress' => $address, 'RoutingType' => $type],
      Object::typed('ews.types.Mailbox')->with($address)->with($type)->members()
    );
  }

  #[@test]
  public function member() {
    $address= Value::typed('ews.types.EmailAddress', 'test@example.com');
    $this->assertEquals($address, Object::typed('ews.types.Mailbox')->with($address)->member('EmailAddress'));
  }

  #[@test, @expect(ElementNotFoundException::class)]
  public function non_existant_member() {
    Object::typed('ews.types.Mailbox')->member('EmailAddress');
  }

  #[@test]
  public function non_existant_member_passing_default() {
    $this->assertNull(Object::typed('ews.types.Mailbox')->member('EmailAddress', null));
  }
}