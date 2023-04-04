<?php

namespace Themeco\Cornerstone\Tss\Typed;

class Dimension extends Typed {

  public function unaryPlus() {
    list($number, $unit) = $this->value;
    return $this->setValue([ abs($number), $unit]);
  }

  public function unaryMinus() {
    list($number, $unit) = $this->value;
    return $this->setValue([ $number * -1, $unit]);
  }

  public function toNumeric() {
    return floatval($this->value[0]);
  }

  public function toString() {
    return $this->value[0] . $this->value[1];
  }

}