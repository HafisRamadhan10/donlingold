<?php

namespace Themeco\Cornerstone\Tss\Statements;

use Themeco\Cornerstone\Tss\Statements\Statement;
use Themeco\Cornerstone\Tss\Constants\StatementTypes;

class CssAtRule extends Statement {

  public function process( $cssAtRule ) {

    list($name, $prelude, $blockOrTerminator) = $cssAtRule;

    $prelude = $this->stack->evaluator()->resolve( $prelude )->toString();
    $result = null;

    if ($blockOrTerminator->is('block')) {
      $result = $this->processBlock( $blockOrTerminator->content() );
    } elseif ($blockOrTerminator->is('terminator')) {
      // no terminated at rules supported
    }

    if ( ! is_null( $result ) ) {

      $rule = [ $name, $prelude, $result ];

      // Add the rule to the current scope
      $this->stack->result()->update(function( $result ) use ($rule) {
        if ( ! is_array( $result ) ) $result = [];
        if ( ! isset( $result['cssAtRules'] ) ) $result['cssAtRules'] = [];
        $result['cssAtRules'][] = $rule;
        return $result;
      });
    }

  }

  public function processBlock( $block ) {
    // Create a new "stack" for the block of statements
    $scope = $this->stack->newScope();
    $scope->validator->setContext('styleRule');

    // Process the block statements in that stack
    $scope->processStatements($block);

    return $scope->result()->content();
  }

}