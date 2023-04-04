<?php

namespace Themeco\Cornerstone\Parsy\Parsers;
use Themeco\Cornerstone\Parsy\Parser;

class Generic extends Parser {

  protected $stateTransformer;
  
  public function __construct($fn) {
    $this->stateTransformer = PHP_VERSION_ID >= 70000 ? $fn : $fn->bindTo($this);
  }

  public function transform( $state ) {
    if (PHP_VERSION_ID >= 70000) {
      return $this->stateTransformer->call($this,$state);
    }
    return call_user_func($this->stateTransformer, $state);
    $call = $this->stateTransformer;
    return $call($state);
  }
}