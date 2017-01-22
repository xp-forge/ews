<?php namespace ews\unittest;

use ews\TimeZones;
use lang\ElementNotFoundException;

class TimeZonesTest extends \unittest\TestCase {

  #[@test]
  public function utc() {
    $this->assertEquals('UTC', TimeZones::named('Etc/GMT'));
  }

  #[@test]
  public function europe_berlin() {
    $this->assertEquals('W. Europe Standard Time', TimeZones::named('Europe/Berlin'));
  }

  #[@test, @expect(ElementNotFoundException::class)]
  public function unknown() {
    TimeZones::named('unknown');
  }

  #[@test]
  public function unknown_with_default() {
    $this->assertEquals('W. Europe Standard Time', TimeZones::named('unknown', 'W. Europe Standard Time'));
  }
}