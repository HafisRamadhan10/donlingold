<?php

namespace Themeco\Cornerstone\Tss\Operations;
use Themeco\Cornerstone\Tss\Operations\Operation;

class Unary extends Operation {

  public function run( $input ) {
    list( $operator, $value ) = $input;
    $typed = $this->stack->evaluator()->resolve( $value );

    return $typed->copy()->unaryOperation( $operator );
    
  }
}