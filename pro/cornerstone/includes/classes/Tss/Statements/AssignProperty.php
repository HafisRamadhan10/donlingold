<?php

namespace Themeco\Cornerstone\Tss\Statements;

use Themeco\Cornerstone\Tss\Statements\Statement;
use Themeco\Cornerstone\Tss\Typed\Typed;
use Themeco\Cornerstone\Tss\Typed\Split;
use Themeco\Cornerstone\Tss\Util\ShorthandPropertyReducer;

class AssignProperty extends Statement {

  public function __construct(ShorthandPropertyReducer $shorthand) {
    $this->shorthand = $shorthand;
  }

  public function process( $assignProperty ) {
    list( $property, $valueToken, $important) = $assignProperty;

    $propertyName = $this->stack->evaluator()->resolve($property)->toString();

    $properties = $this->reduce(
      $propertyName,
      $this->stack->evaluator()->resolve($valueToken)
    );

    $this->stack->result->update(function($result) use ($properties, $important) {
      foreach( $properties as $key => $value ) {
        // if (! is_null($value) && $value !== '' ) { // allow zero
          if ( ! is_array( $result ) ) $result = [];
          if ( ! isset( $result['properties'] ) ) $result['properties'] = [];
          $result['properties'][$key] = $important ? "$value!important" : $value;
        // }
      }
      return $result;
    });

  }

  public function reduce($key, $value) {
    if (!$this->shorthand->has( $key ) ) {
      return [ $key => $value->toString()];
    }
    $normalized = $this->normalizeValue($value);
    if ( is_a( $value, Split::class ) ) {
      list($left, $right) = $normalized;
      return $this->shorthand->reduce( $key, ['split', $left, $right] );
    }
    return $this->shorthand->reduce( $key, $normalized );
  }

  public function normalizeValue( $value ) {
    if ( is_a( $value, Typed::class ) ) {
      return $value->toComponentValue();
    }
    return is_array( $value ) ? $value : [ $value ];
  }

}
