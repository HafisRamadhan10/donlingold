<?php

namespace Themeco\Cornerstone\Tss\Functions;

class IsBase extends BuiltInFunction{

  public function run() {
    return $this->stack->evaluator()->makeTyped('primitive', $this->stack->lookup('data', 'is-base' ));
  }

}