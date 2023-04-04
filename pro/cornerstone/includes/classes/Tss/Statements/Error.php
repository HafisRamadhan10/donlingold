<?php

namespace Themeco\Cornerstone\Tss\Statements;

use Themeco\Cornerstone\Tss\Statements\Statement;

class Error extends Statement {

  public function process( $expression ) {
    throw new \Exception( $this->stack->evaluator()->resolve( $expression )->toString() );
  }
  
}