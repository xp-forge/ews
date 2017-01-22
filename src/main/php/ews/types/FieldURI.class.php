<?php namespace ews\types;

/**
 * Field URIs
 *
 * @see   https://msdn.microsoft.com/en-us/library/aa494315(v=exchg.80).aspx
 */
class FieldURI extends \ews\Object {

  public function __construct($uri) {
    parent::__construct(nameof($this));
    $this->attributes['FieldURI']= $uri;
  }
}