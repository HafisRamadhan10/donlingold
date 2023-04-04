<?php

class Cornerstone_Looper_Element {

  protected $id;
  protected $provider = null;
  protected $complete = false;

  protected $is_provider = false;
  protected $is_consumer = false;

  protected $rewind = false;
  protected $repeat = false;
  protected $repeat_all = false;
  protected $repeat_counter = 0;

  public function __construct( $id ) {
    $this->id = $id;
  }

  public function set_is_provider( $is_provider = true ) {
    $this->is_provider = $is_provider;
  }

  public function is_provider() {
    return $this->is_provider;
  }

  public function set_rewind( $rewind ) { 
    $this->rewind = $rewind;
  }

  public function should_rewind() {
    return $this->rewind;
  }

  public function set_repeat( $count ) {
    $this->repeat = true;
    if ( $count === -1 ) {
      $this->repeat_all = true;
    } else {
      $this->repeat_counter = max(1, $count); // should be at least 1
    }
  }

  public function set_is_consumer( $is_consumer = true ) {
    $this->is_consumer = $is_consumer;
  }

  public function is_consumer() {
    return $this->is_consumer;
  }

  public function set_provider( $provider ) {
    $this->provider = $provider;
  }

  public function provider() {
    return $this->provider;
  }

  public function consume() {

    if ($this->repeat && !$this->repeat_all) {
      if ( $this->repeat_counter <= 0 ) {
        $this->complete = true;
      }
      $this->repeat_counter -= 1;
    }

    $has_more = !$this->complete && $this->provider->consume();

    if (!$this->repeat) {
      $this->complete = true;
    }

    return $has_more;
  }

}
