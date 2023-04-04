<?php

namespace Themeco\Cornerstone\Tss\Operations;
use Themeco\Cornerstone\Tss\Operations\Operation;

class GetVariable extends Operation {

  public function run( $name ) {
    return $this->stack->evaluator()->ensureType($this->stack->lookup('variable', $name));
  }
}