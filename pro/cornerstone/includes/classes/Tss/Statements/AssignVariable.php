<?php

namespace Themeco\Cornerstone\Tss\Statements;

use Themeco\Cornerstone\Tss\Statements\Statement;

class AssignVariable extends Statement {

  public function process( $assignVariable ) {
    list($variable, $valueToken) = $assignVariable;
    $this->stack->define( 'variable', $variable, $this->stack->evaluator()->resolve($valueToken) );
  }

}