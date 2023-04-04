<?php

namespace Themeco\Cornerstone\Tss\Operations;
use Themeco\Cornerstone\Tss\Operations\Operation;

class Binary extends Operation {

  public function run( $input ) {
    list( $operandA, $operator, $operandB ) = $input;

    return $this->stack->evaluator()
      ->resolve( $operandA )
      ->binaryOperation(
        $operator,
        $this->stack->evaluator()->resolve( $operandB ) );
  
  }
}