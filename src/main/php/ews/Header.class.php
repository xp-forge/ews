<?php namespace ews;

class Header extends Object {

  /**
   * Creates a new header
   *
   * @param  ews.Element... $members
   */
  public function __construct(... $members) {
    parent::__construct(nameof($this));
    $this->members= array_filter($members);
  }

  /** @return ews.types.ServerVersionInfo */
  public function serverVersionInfo() { return $this->member('ServerVersionInfo'); }
}