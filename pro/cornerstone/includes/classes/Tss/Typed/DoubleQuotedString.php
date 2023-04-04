<?php

namespace Themeco\Cornerstone\Tss\Typed;

class DoubleQuotedString extends Typed {

  public function toComponentValue() {
    return '"' . $this->value . '"';
  }
}