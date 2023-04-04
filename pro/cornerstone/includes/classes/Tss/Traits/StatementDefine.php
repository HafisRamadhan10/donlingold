<?php

namespace Themeco\Cornerstone\Tss\Traits;

Trait StatementDefine {

  public function define( $type, $definition ) {
    list($name, $arguments, $block) = $definition;
    
    $defaultArguments = [];
    foreach( $arguments as $argument) {
      if ( $argument->type() === 'variable') {
        $defaultArguments[$argument->content()] = null;
      } else if ( $argument->type() === 'keywordArgument') {
        list($variable, $value) = $argument->content();
        $defaultArguments[$variable] = $this->stack->evaluator()->resolve($value->content());
      }
    }
    $this->stack->define($type, $name, [$defaultArguments, $block]);
  }
  
}