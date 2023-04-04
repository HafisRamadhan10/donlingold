<?php

namespace Themeco\Cornerstone\Parsy\Parsers;

use Themeco\Cornerstone\Parsy\Parser;
use Themeco\Cornerstone\Parsy\Result;
use Themeco\Cornerstone\Parsy\Error;

class Any extends Parser {
  
  protected $name = 'any';
  protected $parsers;

  public function __construct($parsers) {
    $this->parsers = $parsers;
  }

  public function transform( $state ) {
    if ($state->isError()) return $state;
  
    foreach ($this->parsers as $index => $parser) {
      $nextState = $parser->parse($state);
      if (!$nextState->isError()) return $nextState;
    }

    return $this->error( $state, 'Unable to match any input');
  }
}
