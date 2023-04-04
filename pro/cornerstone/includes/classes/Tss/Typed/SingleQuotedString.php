<?php

namespace Themeco\Cornerstone\Tss\Typed;

class SingleQuotedString extends Typed {

  public function toComponentValue() {
    return "'" . $this->value . "'";
  }
}