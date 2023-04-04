<?php

namespace Themeco\Cornerstone\Tss\Operations;
use Themeco\Cornerstone\Tss\Operations\Operation;

class DefineSplit extends Operation {

  public function run( $value ) {
    return $this->stack->evaluator()->makeTyped('split',array_map(function($item) {
      return $this->stack->evaluator()->resolve($item);
    }, $value));
  }
}