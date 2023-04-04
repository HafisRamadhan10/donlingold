<?php

namespace Themeco\Cornerstone\Tss\Functions;

class IsOff extends BuiltInFunction {

  public function run($input) {
    $val = $this->isTyped($input) ? $input->toString() : $input;
    return is_string( $val ) && 0 === strpos( trim($val), '!' );
  }
}