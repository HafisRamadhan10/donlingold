<?php

namespace Themeco\Cornerstone\Tss\Functions;

class IsEmpty extends BuiltInFunction {

  public function run($input) {

    $val = $this->isTyped($input) ? $input->toString() : $input;

    if (is_array($val)) return empty( $val );

    if ( '' === $val ) {
      return true;
    }

    $trimmed = trim( $val );

    // empty when value starts with !
    if ( 0 === strpos( $trimmed, '!' ) ) {
      return true;
    }

    $parts = explode(' ', $trimmed );

    foreach ($parts as $i => $part) {
      $parts[$i] = preg_replace('/^0[a-zA-Z%]+|0$|none$/', '', $part);
    }

    $parts = array_filter( $parts );

    return empty($parts);

  }
}