<?php

namespace Themeco\Cornerstone\Parsy;

use Themeco\Cornerstone\Parsy\Result;
use Themeco\Cornerstone\Parsy\Error;

class State {
  protected $target = null;
  protected $index = 0;
  protected $isError = false;
  protected $result;

  public function copyFrom($state) {
    
    $this->target = $state->target;
    $this->result = $state->result;
    // $this->chars = $state->chars;
    $this->index = $state->index;

  }

  public function take( $len ) {
    return substr($this->target, $this->index, $len);
  }

  public function takeWhile( $fn ) {
    $buffer = [];

    $max = count($this->chars) - $this->index;
    $count = 0;
    while ($fn($this->chars[$this->index + $count++]) && $count < $max) {
      $buffer[] = $this->chars[$this->index + $count];
    }
    // return substr($this->target, $this->index, $len);
    return $buffer;
  }
  public function next() {
    return substr($this->target, $this->index);
  }

  public function getTarget() {
    return $this->target;
  }

  public function getIndex() {
    return $this->index;
  }

  public function setIndex( $index ) {
    return $this->index = $index;
  }

  public function isComplete() {
    return $this->index >= strlen($this->target);
  }

  public function isError() {
    return $this->isError;
  }

  public function getResult() {
    return $this->result;
  }

  public function getErrorMessage() {
    return '';
  }

  protected function setTarget($target) {
    $this->target = $target;
    // $this->chars = preg_split('//u', $target, -1, PREG_SPLIT_NO_EMPTY);
  }

  public function debug() {
    if ($this->error->isError()) {
      return ['error' => $this->getErrorMessage(), 'stack' => $this->debugStack];
    }
    return $this->getResult();
  }

  public static function create($target) {
    $state = new self;
    $state->setTarget($target);
    return $state;
  }
}
