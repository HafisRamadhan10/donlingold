<?php

namespace Themeco\Cornerstone\Tss\Statements;

use Themeco\Cornerstone\Tss\Statements\Statement;

class FlowEach extends Statement {

  public function process( $each ) {
    list($variables, $input, $block ) = $each;

    $iterate = $this->stack->evaluator()->resolve($input);

    if ( is_null( $iterate->value() ) ) {
      return;
    }

    $list = $iterate->isIterable() ? $iterate->value() : [$iterate->value()];

    $count = count( $list );
    $this->stack->define('variable', '_count', $count );
    foreach ($list as $i => $item) {

      $this->stack->define('variable', '_index', $i + 1);
      $this->stack->define('variable', '_remaining', $count - 1 - $i);

      $varList = $variables;
      $next = $this->stack->evaluator()->resolve($item);

      if ( $next->isIterable() ) {
        $values = $next->value();
        while ( count( $varList ) && count( $values ) ) {
          $this->stack->define('variable', array_shift( $varList ), array_shift( $values ) );
        }
      } else {
        $this->stack->define('variable', array_shift( $varList ), $next );
      }

      if ($this->stack->processStatements($block)) {
        break;
      };
    }

  }

}