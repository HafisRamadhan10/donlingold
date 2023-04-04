<?php

namespace Themeco\Cornerstone\Tss\Functions;

class OldGlobal extends BuiltInFunction {

  public function color() {

  }
  public function run( $valueTyped, $typeTyped ) {


    $type = $typeTyped->toString();

    if ($type === 'color') {
      return $valueTyped->map(function($item) {
        $value = $item->toString();
        if (strpos($value,'global-color-') === 0) {
          return $this->stack->evaluator()->makeTyped(
            'primitive',
            '%%post tss-color%%' . str_replace('global-color-','', $value) . '%%/post%%'
          );
        }
        return $value;
      });
      return $valueTyped;
    }

    $value = $valueTyped->toString();

    if ($type === 'font-family') {
      if ($value === 'inherit') {
        return $this->stack->evaluator()->makeTyped( 'primitive', 'inherit');
      } else {
        return $this->stack->evaluator()->makeTyped(
          'primitive',
          "%%post font-family%%$value%%/post%%"
        );
      }
    }

    if ($type === 'font-weight') {

      $parts = explode(':',$value);

      if ($parts[0] === 'inherit') {
        return $this->stack->evaluator()->makeTyped( 'primitive', $parts[1]);
      } else {
        return $this->stack->evaluator()->makeTyped(
          'primitive',
          "%%post font-weight%%$value%%/post%%"
        );
      }
    }

    return $valueTyped;
  }

}