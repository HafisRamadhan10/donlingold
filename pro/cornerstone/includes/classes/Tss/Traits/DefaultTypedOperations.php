<?php

namespace Themeco\Cornerstone\Tss\Traits;
use Themeco\Cornerstone\Util\Factory;

trait DefaultTypedOperations {
  // opMultiply
  // opSlash
  // opModulo
  // opPlus
  // opMinus

  public function unaryNot() {
    return $this->produce( ! $this->toBinary() );
  }

  public function opGt( $operand ) {
    return $this->produce( $this->toNumeric() > $operand->toNumeric() );
  }

  public function opGte( $operand ) {
    return $this->produce( $this->toNumeric() >= $operand->toNumeric() );
  }

  public function opLt( $operand ) {
    return $this->produce( $this->toNumeric() < $operand->toNumeric() );
  }

  public function opLte( $operand ) {
    return $this->produce( $this->toNumeric() <= $operand->toNumeric() );
  }

  public function opEq( $operand ) {
    return $this->produce( $this->toString() == $operand->toString() );
  }

  public function opNotEq( $operand ) {
    return $this->produce( $this->toString() != $operand->toString() );
  }

  public function opAnd( $operand ) {
    return $this->produce( $this->toBinary() && $operand->toBinary() );
  }

  public function opOr( $operand ) {
    return $this->produce( $this->toBinary() || $operand->toBinary() );
  }

}