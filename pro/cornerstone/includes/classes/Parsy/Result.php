<?php

namespace Themeco\Cornerstone\Parsy;

class Result extends State {

  protected $result;
  
  public function __construct($previous, $result, $advance = null) {
    $this->copyFrom($previous);
    $this->result = $result;
    
    if (! is_null( $advance ) ) {
      $this->index += $advance;
    }
  }
  
}