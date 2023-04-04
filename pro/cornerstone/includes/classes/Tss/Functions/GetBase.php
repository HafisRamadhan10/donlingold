<?php

namespace Themeco\Cornerstone\Tss\Functions;

class GetBase extends BuiltInFunction{

  public function run( $keyTyped ) {

    $current = $this->stack->lookup('data', 'module-base');
    $key = $keyTyped->toString();
    if (!isset($current[$key])) {
      return $this->stack->evaluator()->makeTyped('primitive', null);
    }

    return $this->stack->evaluator()->resolve( call_user_func($this->stack->lookup('parser', 'valueParser'), $current[$key], $key) );

  }

}