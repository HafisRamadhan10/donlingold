<?php

namespace Themeco\Cornerstone\Tss\Typed;

class Primitive extends Typed {

  public function unaryPlus() {
    return $this->setValue("+" . $this->value);
  }

  public function unaryMinus() {
    return $this->setValue("-" . $this->value);
  }

}