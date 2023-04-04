<?php

namespace Themeco\Cornerstone\Tss\Statements;

use Themeco\Cornerstone\Tss\Statements\Statement;

class FlowIf extends Statement {

  public function process( $if ) {
    list( $condition, $firstBlock ) = $if;

    if ($condition->type() === 'call') {
      // var_dump($condition->content());
    }
    if ($this->stack->evaluator()->resolve($condition)->toBinary()) {
      $this->stack->processStatements($firstBlock);
    } else {

      $elseStatements = array_slice($if, 2);

      foreach ($elseStatements as $else) {
        $type = $else->type();

        if ($type === 'elseIf') {
          list($condition, $block ) = $else->content();
          if ($this->stack->evaluator()->resolve($condition)->toBinary()) {
            $this->stack->processStatements($block);
            return;
          }
        }

        if ($type === 'else') {
          $this->stack->processStatements($else->content());
          return;
        }
      }

    }

  }

}