<?php

namespace Themeco\Cornerstone\Tss;

use Themeco\Cornerstone\Util\Factory;
use Themeco\Cornerstone\Tss\Evaluator;
use Themeco\Cornerstone\Tss\Statements\Validator;

class Stack {

  protected $definitions = [];
  protected $evaluator;
  protected $parent = null;

  public $__id = '';

  public function __construct(Evaluator $evaluator, Validator $validator, Result $result) {
    $this->evaluator = $evaluator;
    $this->validator = $validator;
    $this->result = $result;
    $this->evaluator->setStack($this);
    $this->__id = uniqid();
  }

  public function define($type, $name, $content) {

    if (!isset($this->definitions[$type])) {
      $this->definitions[$type] = [];
    }

    $this->definitions[$type][$name] = $content;

  }

  public function lookup( $type, $name ) {

    return $this->lookupWithStack($type, $name)[0];
  }

  public function lookupLocal( $type, $name ) {
    if ( isset( $this->definitions[$type]) && isset( $this->definitions[$type][$name] ) ) {
      return [true, $this->definitions[$type][$name]];
    }
    return [false,null];
  }

  public function lookupWithStack($type, $name) {

    $next = $this;

    while( ! is_null( $next ) ) {

      list($found, $value) = $next->lookupLocal( $type, $name );

      if ( $found ) {
        return [ $value, $next ];
      }

      $next = $next->parent();
    }


    return [null,$this];
  }

  public function getAllFromNamespace( $type ) {
    return isset( $this->definitions[$type]) ? $this->definitions[$type] : [];
  }

  public function evaluator() {
    return $this->evaluator;
  }

  public function validator() {
    return $this->validator;
  }

  public function result() {
    return $this->result;
  }

  public function setParent($parent) {
    $this->parent = $parent;
  }

  public function parent() {
    return $this->parent;
  }

  public function newScope() {
    $next = Factory::create(Stack::class);
    $next->setParent($this);
    return $next;
  }

  public function processStatements($statements) {
    foreach ($statements as $statement) {
      if ($this->result()->isComplete()) {
        return true;
      }
      $this->validator()->make($statement->type(), $this)->process($statement->content());
    }
  }

}