<?php

namespace Themeco\Cornerstone\Tss\Operations;
use Themeco\Cornerstone\Tss\Operations\Operation;

class DefineCommaList extends Operation {

  public function run( $value ) {
    return $this->stack->evaluator()->makeTyped('commaList',array_map(function($item) {
      return $this->stack->evaluator()->resolve($item);
    }, $value));
  }
}