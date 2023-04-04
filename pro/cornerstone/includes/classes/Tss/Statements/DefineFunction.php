<?php

namespace Themeco\Cornerstone\Tss\Statements;

use Themeco\Cornerstone\Tss\Statements\Statement;
use Themeco\Cornerstone\Tss\Traits\StatementDefine;

class DefineFunction extends Statement {
  use StatementDefine;

  public function process( $definition ) {
    $this->define( 'function', $definition );
  }

}