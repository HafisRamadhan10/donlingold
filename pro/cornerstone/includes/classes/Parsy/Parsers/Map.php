<?php

namespace Themeco\Cornerstone\Parsy\Parsers;

use Themeco\Cornerstone\Parsy\Parser;

use Themeco\Cornerstone\Parsy\Result;
use Themeco\Cornerstone\Parsy\Error;

class Map extends Parser {
  
  protected $class = true;
  
  public function __construct($parser, $fn) {
    $this->parser = $parser;
    $this->mapFn = $fn;
  }

  public function transform($state) {
    $nextState = $this->parser->parse($state);
    if ($nextState->isError()) return $nextState;
    return new Result($nextState, call_user_func($this->mapFn,  $nextState->getResult()));
  }
  
}
