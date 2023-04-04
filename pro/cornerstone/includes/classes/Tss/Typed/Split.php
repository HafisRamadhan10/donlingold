<?php

namespace Themeco\Cornerstone\Tss\Typed;

class Split extends Typed {

  public function toComponentValue() {
    return array_map(function($value) {
      return is_scalar( $value ) ? $value : $value->toComponentValue();
    }, array_slice($this->value,0,2));
  }
  
}