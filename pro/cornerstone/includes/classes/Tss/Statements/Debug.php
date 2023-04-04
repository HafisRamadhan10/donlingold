<?php

namespace Themeco\Cornerstone\Tss\Statements;

use Themeco\Cornerstone\Tss\Statements\Statement;

class Debug extends Statement {

  public function process( $expression ) {
    echo $this->stack->evaluator()->resolve( $expression )->toString() . "\n";
  }
  
}