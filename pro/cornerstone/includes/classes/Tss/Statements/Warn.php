<?php

namespace Themeco\Cornerstone\Tss\Statements;

use Themeco\Cornerstone\Tss\Statements\Statement;

class Warn extends Statement {

  public function process( $expression ) {
    trigger_error($this->stack->evaluator()->resolve( $expression )->toString(), E_USER_WARNING);
  }
  
}