<?php

namespace Themeco\Cornerstone\Parsy\Parsers;

use Themeco\Cornerstone\Parsy\Parser;
use Themeco\Cornerstone\Parsy\Result;
use Themeco\Cornerstone\Parsy\Error;

class Times extends Parser {
  
  protected $name = 'times';
  protected $parser;
  protected $min;
  protected $max;

  public function __construct($parser, $min, $max) {
    $this->parser = $parser;
    $this->min = $min;
    $this->max = $max;
  }

  public function transform( $state ) {
    if ($state->isError()) return $state;
    
    $nextState = $state;

    $results = [];

    $iterations = 0;
    $has_max = $this->max !== -1;
    
    while (!$has_max || ($iterations++ < $this->max)) {
      $out = $this->parser->parse($nextState);
      if ($out->isError()) break;
      $nextState = $out;
      $results[] = $out->getResult();      
      if ($nextState->isComplete()) break;

    }

    if (count($results) < $this->min) {
      return $this->error( $state, 'Unable to match any input');
    }

    return new Result($nextState, $results);
  }

}
