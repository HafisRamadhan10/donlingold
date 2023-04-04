<?php

namespace Themeco\Cornerstone\Parsy;

use Themeco\Cornerstone\Parsy\State;
use Themeco\Cornerstone\Parsy\ParseException;

use Themeco\Cornerstone\Parsy\Result;
use Themeco\Cornerstone\Parsy\Error;
use Themeco\Cornerstone\Parsy\Parsers\Generic;
use Themeco\Cornerstone\Parsy\Parsers\Map;


class Parser {
  
  protected $name = 'generic';
  
  public function transform( $state ) {
    return $state;
  }

  public function parse($state) {
    return $this->transform( $state );
  }

  public function run($targetString) {
    
    $finalState = $this->parse(State::create($targetString) );

    if ($finalState->isError()) {
      throw new \Exception($finalState->getErrorMessage() );
    }
    
    return $finalState->getResult();

  }

  public function name( $name ) {
    $this->name = $name;
    return $this;
  }

  public function getName() {
    return $this->name;
  }

  public function update($state, $result, $advance = null) {
    return new Result($state, $result, $advance);
  }

  public function error($state, $message) {
    return new Error($state, $this->name, $message);
  }

  public function chain($fn) {
    $parser = $this;
    return (new Generic(function($state) use($fn, $parser) {
      $nextState = $parser->parse($state);
      if ($nextState->isError()) return $nextState;
      $nextParser = $fn($nextState->getResult());
      if (!$nextParser) {
        return new Error($state, 'chain', 'next parser not identified');
      }
      return $nextParser->parse($nextState);
    }))->name( "{$this->name}:chain" );
  }

  public function map($fn) {
    return new Map($this, $fn);
  }

  public function errorMap($fn) {
    $parser = $this;
    return (new Generic(function($state) use($fn, $parser) {
      $nextState = $parser->parse($state);
      if (!$nextState->isError()) return $nextState;
      return $this->error($state, $fn($nextState->getResult(), $nextState->getIndex()));
    }))->name( "{$this->name}:errorMap" );
  }

  public function abortOnError() {
    $parser = $this;
    return (new Generic(function($state) use($parser) {
      $nextState = $parser->parse($state);
      if ($nextState->isError()) {
        throw new ParseException($nextState->getErrorMessage(), [$state,$nextState]);
      }
      return $nextState;
    }))->name( "{$this->name}:fail" );
  }

  public function result( $result ) {
    $parser = $this;
    return (new Generic(function($state) use($result, $parser) {
      $nextState = $parser->parse($state);
      if ($nextState->isError()) return $nextState;
      return new Result($nextState, $result);
    }))->name( "{$this->name}:result" );
  }

  public function skip($parser) {
    return P::sequence($this, $parser)->map(function($results) {
      return $results[0];
    });
  }

  public function then($parser) {
    return P::sequence($this, $parser)->map(function($results) {
      
      return $results[1];
    });
  }

  public function otherwise($fallback) {
    return P::otherwise($fallback)($this);
  }

  public function maybeSkip( $parser ) {
    return $this->skip(P::times(0,1)($parser));
  }

  public function maybeNext( $parser ) {
    return $this->next(P::times(0,1)($parser));
  }

  public function next($parser) {
    return P::sequence($this, $parser);
  }

  public function expectEnd() {
    return P::sequence($this, P::end())->name('end');
  }

  public function thru($wrapper) {
    return $wrapper($this);
  }

  public function concat( $parser ) {
    return $this->next($parser)->join();
  }
  
  public function join($sep = '') {
    return $this->map(function( $items) use ($sep) {
      return implode( $sep, $items );
    })->name( "{$this->name}:join" );
  }

  public function notFollowedBy($parser) {
    return $this->skip(P::not_followed_by($parser));
  }

  public function followedBy($parser) {
    return $this->skip(P::followed_by($parser));
  }
  
  public function flatten() {
    return $this->map(function( $items) {
      return array_reduce( $items, function($acc, $next) {
        return array_merge( $acc, is_array( $next ) ? $next : [ $next ] ) ;
      }, []);
    })->name( "{$this->name}:flat" );
  }

  public function trim() {
    return $this->map(function($result) {
      return is_string( $result ) ? trim( $result) : $result;      
    })->name( "{$this->name}:trim" );
  }

  public function split($sep) {
    return $this->map(function( $items) use ($sep) {
      return explode( $sep, $items );
    })->name( "{$this->name}:split" );
  }

  public function token($name) {
    return $this->map(function( $result ) use ($name ){
      return P::token($name, $result);
    })->trace($name);
  }

  public function tap() {
    return $this->map(function($result){
      echo json_encode($result, JSON_PRETTY_PRINT);
      return $result;
    });
  }

  public function nth($index) {
    return $this->map(function( $items) use ($index) {
      return $items[$index < 0 ? count($items) + $index : $index];
    })->name( "{$this->name}:nth" );
  }
  
  public function first() {
    return $this->nth(0)->name( "{$this->name}:first" );
  }

  public function last() {
    return $this->nth(-1)->name( "{$this->name}:last" );
  }

  public function trace($name) {
    return $this->errorMap(function($error) use ($name){
      global $tracing;
      if (!isset($tracing[$name])) $tracing[$name] = 0;
      $tracing[$name]++;
      return $error;
    });
  }

}
