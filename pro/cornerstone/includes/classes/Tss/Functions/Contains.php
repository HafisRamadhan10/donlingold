<?php

namespace Themeco\Cornerstone\Tss\Functions;

class Contains extends BuiltInFunction {

  public function run( $haystack, $needle, $index = null ) {

    $i = intval($this->isTyped($index) ? $index->toString() : $index);

    $pos = strpos(
      $this->isTyped($haystack) ? $haystack->toString() : $haystack,
      $this->isTyped($needle) ? $needle->toString() : $needle
    );
    return is_null($i) ? $pos !== false : $pos === $i;

  }
}