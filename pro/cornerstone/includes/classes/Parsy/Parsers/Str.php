<?php

namespace Themeco\Cornerstone\Parsy\Parsers;

use Themeco\Cornerstone\Parsy\Parser;
use Themeco\Cornerstone\Parsy\Result;
use Themeco\Cornerstone\Parsy\Error;


class Str extends Parser {
  
  protected $name = 'str';
  protected $str;

  public function __construct($str) {
    $this->str = $str;
    $this->len = strlen($str);
    $this->name = "str:$str";
  }

  public function transform( $state ) {
    if ($state->isError()) return $state;
      
    if ($state->take($this->len) === $this->str) {
      return $this->update($state, $this->str, $this->len);
    }
          
    return $this->error($state, "Tried to match {$this->str} but got ");
  }

}