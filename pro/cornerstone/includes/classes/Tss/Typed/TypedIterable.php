<?php

namespace Themeco\Cornerstone\Tss\Typed;
use Themeco\Cornerstone\Util\Factory;

class TypedIterable extends Typed {

  protected $iterable = true;
  protected $delimiter = ' ';

  public function toString() {
    return implode($this->delimiter, array_map(function($value) {
      return is_scalar( $value ) ? $value : $value->toString();
    }, $this->value));
  }

  public function toComponentValue() {
    return array_map(function($value) {
      return is_scalar( $value ) ? $value : $value->toComponentValue();
    }, $this->value);
  }

  public function map($cb) {
    $next = Factory::create(static::class);
    $next->setValue(array_map( $cb, $this->value));
    return $next;
  }

}