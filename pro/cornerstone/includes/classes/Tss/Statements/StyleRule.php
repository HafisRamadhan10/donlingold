<?php

namespace Themeco\Cornerstone\Tss\Statements;

use Themeco\Cornerstone\Tss\Statements\Statement;

class StyleRule extends Statement {

  public function maybeInterpolateString($input) {
    return $this->stack->evaluator()->resolve($input)->toString();
  }
  
  public function process( $styleRule ) {
    list($selectors, $block) = $styleRule;
    
    // Create a new "stack" for the block of statements
    $scope = $this->stack->newScope();
    $scope->validator->setContext('styleRule');

    // Process the block statements in that stack
    $scope->processStatements($block);
    $result = $scope->result()->content();

    if ( ! is_null( $result ) ) {
      // Define the current rule
      $rule = [
        array_map( [$this, 'maybeInterpolateString'], $selectors),
        $scope->result()->content()
      ];
      
      // Add the rule to the current scope
      $this->stack->result()->update(function( $result ) use ($rule) {
        if ( ! is_array( $result ) ) $result = [];
        if ( ! isset( $result['styleRules'] ) ) $result['styleRules'] = [];
        $result['styleRules'][] = $rule;
        return $result;
      });
    }  
  }
  
}