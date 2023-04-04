<?php

namespace Themeco\Cornerstone\Tss\Traits;

trait StackAccessor {
  protected $stack;

  public function setStack($stack) {
    $this->stack = $stack;
    return $this;
  }

  public function getStack() {
    return $this->stack;
  }

}