<?php namespace ews\xml;

use xml\Tree;
use xml\Node;
use ews\Namespaces;

class Emitter {
  private static $packages, $namespaces;

  static function __static() {
    self::$packages= [
      'ews'          => 's',
      'ews.types'    => 't',
      'ews.messages' => 'm'
    ];    
    self::$namespaces= [
      'xmlns:s' => Namespaces::$SOAP->url(),
      'xmlns:t' => Namespaces::$TYPES->url(),
      'xmlns:m' => Namespaces::$MESSAGES->url()
    ];
  }

  /**
   * Emit envelope as XML
   *
   * @param  ews.Envelope $envelope
   * @return xml.Tree
   */
  public function emit($envelope) {
    return (new Tree())->withRoot((new Node('s:Envelope', null, self::$namespaces))
      ->withChild($envelope->header()->emitUsing($this))
      ->withChild($envelope->body()->emitUsing($this))
    );
  }

  /**
   * Creates an XML node
   *
   * @param  string $type Qualified type name including package
   * @param  string $content
   * @param  [:string] $attributes
   * @return xml.Node
   */
  private function node($type, $content, $attributes) {
    $p= strrpos($type, '.');
    return new Node(self::$packages[substr($type, 0, $p)].':'.substr($type, $p + 1), $content, $attributes);
  }

  public function emitObject($type, $attributes, $members) {
    $node= $this->node($type, null, $attributes);
    foreach ($members as $member) {
      $node->addChild($member->emitUsing($this));
    }
    return $node;
  }

  public function emitOne($type, $member) {
    $node= $this->node($type, null, []);
    $member && $node->addChild($member->emitUsing($this));
    return $node;
  }

  public function emitAll($type, $members) {
    $node= $this->node($type, null, []);
    foreach ($members as $member) {
      $node->addChild($member->emitUsing($this));
    }
    return $node;
  }

  public function emitValue($type, $string) {
    return $this->node($type, $string, []);
  }
}