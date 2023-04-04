<?php


namespace Themeco\Cornerstone\Tss\Typed;
use Themeco\Cornerstone\Util\Factory;
use Themeco\Cornerstone\Tss\Typed\Primitive;
use Themeco\Cornerstone\Tss\Traits\DefaultTypedOperations;

use Themeco\Cornerstone\Parsy\Token;

abstract class Typed {

  use DefaultTypedOperations;
  protected $iterable = false;
  protected $value;

  public function setValue( $value ) {
    $this->value = $value;
    return $this;
  }

  public function toString() {

    if ( is_a( $this->value, Typed::class ) ) {
      return $this->value->toString();
    }
    if ( is_string( $this->value ) ) {
      return $this->value;
    }

    if ( is_array( $this->value ) ) {
      return implode('', array_map(function($value) {
        return is_scalar( $value ) ? $value : $value->toString();
      }, $this->value));
    }

    if ($this->value === true) {
      return 'true';
    }

    if ($this->value === false) {
      return 'false';
    }

    if ($this->value === null) {
      return '';
    }

    return strval($this->value);

  }

  public function toComponentValue() {
    return $this->toString();
  }

  public function toNumeric() {
    return floatval($this->toScalar());
  }

  public function toBinary() {
    if ( is_bool( $this->value ) ) {
      return $this->value;
    }
    if ( is_null ($this->value ) ) {
      return false;
    }
    return $this->toNumeric() !== 0;
  }

  public function value() {
    return $this->value;
  }

  public function toScalar() {
    return is_scalar( $this->value ) ? $this->value : $this->toString();
  }

  public function isIterable() {
    return $this->iterable;
  }

  public function map( $cb ) {
    $next = Factory::create(static::class);
    $next->setValue($cb($this));
    return $next;
  }

  public function produce($value) {
    return Factory::create(Primitive::class)->setValue($value);
  }

  public function copy() {
    return Factory::create(static::class)->setValue($this->value);
  }

  public function unaryOperation( $operator ) {

    switch ($operator) {
      case '+':
        return $this->unaryPlus();
      case '-':
        return $this->unaryMinus();
      case 'not':
        return $this->unaryNot();
      default:
        throw new \Exception("Unknown unary operator: $operator");
    }

  }

  public function binaryOperation( $operator, $operand ) {


    switch ($operator) {
      case '*':
        return $this->opMultiply( $operand );
      case '/':
        return $this->opSlash( $operand );
      case '%':
        return $this->opModulo( $operand );
      case '+':
        return $this->opPlus( $operand );
      case '-':
        return $this->opMinus( $operand );
      case '>':
        return $this->opGt( $operand );
      case '>=':
        return $this->opGte( $operand );
      case '<':
        return $this->opLt( $operand );
      case '<=':
        return $this->opLte( $operand );
      case '==':
        return $this->opEq( $operand );
      case '!=':
        return $this->opNotEq( $operand );
      case 'and':
        return $this->opAnd( $operand );
      case 'or':
        return $this->opOr( $operand );
      default:
        throw new \Exception("Unknown binary operator: $operator");
    }

  }

  public function __call($name, $args) {
    var_dump($args);
    trigger_error("Invalid types in TSS operation. Can not perform $name on " . static::class, E_USER_WARNING);
    return $this;
  }
}