<?php

namespace Themeco\Cornerstone\Tss\Statements;

use Themeco\Cornerstone\Tss\Statements\Statement;

class ReturnCall extends Statement {

  public function process( $call ) {
    $this->stack->result()->update($this->stack->evaluator()->resolve($call));
    $this->stack->result()->setComplete();
  }

}