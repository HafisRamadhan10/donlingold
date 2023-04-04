<?php

namespace Themeco\Cornerstone\Tss\Operations;
use Themeco\Cornerstone\Tss\Operations\Operation;
use Themeco\Cornerstone\Parsy\Token;

class StringInterpolation extends Operation {

  public function run( $input ) {
    list($format, $args) = $input;

    $values = array_map(function($arg) {
      return $this->stack->evaluator()->resolve($arg)->toString();
    }, $args);

    $formatted = vsprintf(str_replace("\%", '##PERCENT##', $format),$values);
    $formatted = str_replace("##PERCENT##", '%', $formatted);

    return $this->stack->evaluator()->makeTyped('primitive',$formatted);

  }
}
