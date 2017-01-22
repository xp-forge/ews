<?php namespace ews\xml;

use xml\parser\ParserCallback;
use lang\reflect\Package;
use ews\Namespaces;
use ews\Value;
use ews\Object;
use ews\Result;

class ParseInto implements ParserCallback {
  const CHILDREN = 0;
  const CONTENT  = 1;
  const MEMBERS  = 2;
  const NAME     = 0;
  const ELEMENT  = 1;

  private static $packages;

  private $target, $namespaces, $nodes;

  static function __static() {
    self::$packages= [
      Namespaces::$SOAP->url()     => Package::forName('ews'),
      Namespaces::$TYPES->url()    => Package::forName('ews.types'),
      Namespaces::$MESSAGES->url() => Package::forName('ews.messages'),
      Namespaces::$ERRORS->url()   => Package::forName('ews')
    ];    
  }

  /**
   * Parse into this result
   *
   * @param  ews.Result $target
   */
  public function __construct(Result $target) {
    $this->target= $target;
  }

  public function onStartElement($parser, $name, $attributes) {
    $members= [];
    foreach ($attributes as $attribute => $value) {
      if (0 === strncmp($attribute, 'xmlns', 5)) {
        $this->namespaces[substr($attribute, 6)]= $value;
      } else {
        $members[$attribute]= $value;
      }
    }

    array_unshift($this->nodes, [
      self::CHILDREN => [],
      self::CONTENT  => '',
      self::MEMBERS  => $members
    ]);
  }

  public function onEndElement($parser, $name) {
    if ($p= strpos($name, ':')) {
      $package= self::$packages[$this->namespaces[substr($name, 0, $p)]];
      $name= substr($name, $p + 1);
    } else {
      $package= Package::forName('ews');
    }

    $node= array_shift($this->nodes);
    if ($package->providesClass($name)) {
      $target= $package->loadClass($name)->newInstance()->pass($node[self::MEMBERS]);
    } else if ($node[self::CHILDREN] || $node[self::MEMBERS]) {
      $target= Object::typed($package->getName().'.'.$name, $node[self::MEMBERS]);
    } else {
      $target= Value::typed($package->getName().'.'.$name, trim($node[self::CONTENT]));
    }

    foreach ($node[self::CHILDREN] as $element) {
      $target->with($element[self::ELEMENT], $element[self::NAME]);
    }
    $this->nodes[0][self::CHILDREN][]= [self::NAME => $name, self::ELEMENT => $target];
  }

  public function onCData($parser, $cdata) {
    $this->nodes[0][self::CONTENT].= $cdata;
  }

  public function onDefault($parser, $data) { }

  public function onBegin($instance) {
    $this->namespaces= [];
    $this->nodes= [[]];
    $this->target->clear();
  }

  public function onError($instance, $exception) { }

  public function onFinish($instance) {
    foreach ($this->nodes[0][self::CHILDREN] as $element) {
      $this->target->with($element[self::ELEMENT], $element[self::NAME]);
    }
  }
}