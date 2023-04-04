<?php

namespace Themeco\Cornerstone\Tss\Functions;

use Themeco\Cornerstone\Tss\Typed\ValueList;

class Merge extends BuiltInFunction {

  public function run($left, $right) {

    $args = [$left,$right];
    $merged = [];

    foreach ($args as $arg) {
      if ( is_a( $arg, ValueList::class ) ) {
        $items = $arg->value();
        foreach ($items as $value) {
          $merged[] = $value;
        }
      } else {
        $merged[] = $arg;
      }
    }

    return $this->stack->evaluator()->makeTyped('valueList', $merged);

  }
}