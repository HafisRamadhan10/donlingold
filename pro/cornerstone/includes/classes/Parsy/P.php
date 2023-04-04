<?php

namespace Themeco\Cornerstone\Parsy;

use Themeco\Cornerstone\Parsy\Parser;
use Themeco\Cornerstone\Parsy\Parsers\Generic;
use Themeco\Cornerstone\Parsy\Parsers\Str;
use Themeco\Cornerstone\Parsy\Parsers\Regex;
use Themeco\Cornerstone\Parsy\Parsers\Sequence;
use Themeco\Cornerstone\Parsy\Parsers\Any;
use Themeco\Cornerstone\Parsy\Parsers\Times;
use Themeco\Cornerstone\Parsy\Result;
use Themeco\Cornerstone\Parsy\Token;

function decode_escaped_characters( $input ) {

  $escapes = [ 'b' => "\b", 'f' =>  "\f", 'n' =>  "\n", 'r' =>  "\r", 't' => "\t" ];

  return preg_replace_callback('/(?:\\\u[0-9a-fA-F]{4})+|\\\[^u]/', function ( $matches ) use ($escapes) {
    $match = $matches[0];
    $type = substr($matches[0],1,1);
    if ( strpos( $type, 'u') === 0 ) {
      return json_decode('"'.$matches[0].'"');
    }
    if (isset($escapes[$type])) {
      return $escapes[$type];
    }
    return $type;
  }, $input);

}


class P {

  public static function end() {
    return (new Generic(function($state) {
      if ($state->isError() || $state->isComplete()) return $state;
      return $this->error($state, "Expected end of input but got: " . substr($state->next(), 0, 100) );
    }))->name('end');
  }

  public static function str( $str ) {
    return new Str($str);
  }

  public static function anyChar() {
    return (new Generic(function($state) {

      if ($state->isError()) return $state;

      return $this->update($state, $state->take(1), 1);

    }))->name("anyChar");
  }

  public static function regex($pattern, $group = 0) {
    return new Regex($pattern, $group);
  }

  public static function letter() {
    return self::regex('/^[A-Za-z]/')->name('letter');
  }

  public static function digit() {
    return self::regex('/^[0-9]/')->name('digit');
  }

  public static function letters() {
    return self::regex('/^[A-Za-z]+/')->name('letters');
  }

  public static function word() {
    return self::regex('/^[\w-]+/')->name('word'); // alphanumeric + underscores + hyphen
  }

  public static function char() {
    return self::regex('/^[\w-]/')->name('char'); // single alphanumeric + underscores + hyphen
  }

  public static function digits() {
    return self::regex('/^[0-9]+/')->name('digits');
  }

  public static function digitsWithHex() {
    return self::regex('/^[0-9a-fA-F]+/')->name('digits');
  }

  public static function ascii() {
    return self::regex('/^[\x00-\x7F]/')->name('ascii');
  }

  public static function non_ascii() {
    return self::regex('/^[^\x00-\x7F]/')->name('non_ascii');
  }

  public static function number() {
    return self::regex('/^-?(0|[1-9][0-9]*)([.][0-9]+)?([eE][+-]?[0-9]+)?/')->map(function($value) {
      return floatval($value);
    })->name('number');
  }

  public static function double_quoted_escaped_string() {
    return self::regex('/^"((?:\\.|.)*?)"/', 1)->map(function($value) {
      return decode_escaped_characters($value);
    })->name('double_quoted_escaped_string');
  }

  public static function single_quoted_escaped_string() {
    return self::regex("/^'(.*?)'/", 1)->name('single_quoted_string');
  }

  public static function quoted_string() {
    return self::any(
      self::single_quoted_escaped_string(),
      self::double_quoted_escaped_string()
    )->name('quoted_string');;
  }

  public static function whitespace() {
    return self::regex('/^\s*/m')->name('whitespace');
  }

  public static function whitespace1() {
    return self::regex('/^\s+/m')->name('whitespace1');
  }

  public static function sequence() {
    return new Sequence(func_get_args());
  }

  public static function any() {
    return new Any(func_get_args());
  }

  public static function noop() {
    return (new Generic(function($state) {
      return $state;
    }));
  }

  public static function otherwise($fallback) {

    return function($parser) use ($fallback) {
      return (new Generic(function($state) use ($parser, $fallback){

        if ($state->isError()) return $state;
        $nextState = $parser->parse($state);

        if (!$nextState->isError()) return $nextState;

        return new Result($nextState, $fallback);
      }));
    };
  }

  public static function many( $parser ) {
    return self::times(0, -1)($parser)->name('many');
  }

  public static function many1( $parser ) {
    return self::times(1, -1)($parser)->name('many1');
  }

  public static function times( $min = 0, $max = -1) {
    return function($parser) use ($min, $max) {
      return new Times($parser, $min, $max);
    };
  }

  public static function sep_by( $separatorParser ) {
    return function($valueParser) use ($separatorParser) {
      return (new Generic(function($state) use ($separatorParser, $valueParser) {
        $results = [];
        $nextState = $state;

        while (true) {
          $valueState = $valueParser->parse($nextState);
          if ($valueState->isError()) break;
          $results[] = $valueState->getResult();
          $nextState = $valueState;

          $separatorState = $separatorParser->parse($nextState);
          if ($separatorState->isError()) break;
          $nextState = $separatorState;
        }

        return new Result($nextState, $results);
      }))->name('sep_by');
    };
  }

  public static function lookahead( $parser ) {
    if ( is_string( $parser ) ) {
      return self::lookahead(self::str($parser));
    }
    return (new Generic(function($state) use ($parser) {
      $valueState = $parser->parse($state);
      if ($valueState->isError()) $this->error( $state, 'Unable to match any input');
      $valueState->setIndex($state->getIndex());
      return $valueState;
    }));
  }

  public static function followed_by( $parser ) {
    if ( is_string( $parser ) ) {
      return self::followed_by(self::str($parser));
    }
    return (new Generic(function($state) use ($parser) {
      $valueState = $parser->parse($state);
      if ($valueState->isError()) $this->error( $state, 'Unable to match any input');
      return new Result($state, null);
    }));
  }

  public static function not_followed_by( $parser ) {
    if ( is_string( $parser ) ) {
      return self::not_followed_by(self::str($parser));
    }
    return (new Generic(function($state) use ($parser) {
      $valueState = $parser->parse($state);
      if ($valueState->isError()) return new Result($state, null);
      return $this->error( $state, 'not_followed_by matched');
    }));
  }

  public static function abort( $content = null) {
    return (new Generic(function($state) use ($parser, $content) {
      return $this->error( new Result($state, $content), 'abort');
    }));
  }

  public static function sep_by1( $separatorParser ) {
    return function($valueParser) use ($separatorParser) {
      return (new Generic(function($state) use ($separatorParser, $valueParser) {
        $results = [];
        $nextState = $state;

        while (true) {
          $valueState = $valueParser->parse($nextState);
          if ($valueState->isError()) break;
          $results[] = $valueState->getResult();
          $nextState = $valueState;

          $separatorState = $separatorParser->parse($nextState);
          if ($separatorState->isError()) break;
          $nextState = $separatorState;
        }

        if (count($results) <=0) {
          return $this->error( $state, 'Unable to match any input');
        }

        return new Result($nextState, $results);
      }))->name('sep_by_1');
    };
  }

  public static function between( $left, $right ) {
    return function ($contentParser) use ($left, $right) {
      return self::sequence($left, $contentParser, $right)->map(function($results){
        return $results[1];
      })->name('between');
    };
  }

  public static function between_square_brackets() {
    return self::between(self::str('['), self::str(']'));
  }

  public static function comma_seperated($parser) {
    return self::sep_by1(self::str(','))($parser);
  }

  public static function lazy($fn, $name = '') {
    return (new Generic(function($state) use ($fn){
      return $fn()->parse( $state );
    }))->name( "r*lazy:$name" );
  }

  // This lets us define a set of parsers that can be called recursively
  public static function createLanguage( $parsers ) {
    $language = new \stdClass;
    foreach ( $parsers as $key => $parserFn ) {
      if (is_a($parserFn, Parser::class)) {
        $language->{$key} = $parserFn;
      } else {
        $language->{$key} = self::lazy(function() use( $parserFn, $language, $key ) {
          $parser = $parserFn($language,$key)->name( $key );
          $language->{$key} = $parser; // On the first call reassign the parser so it isn't reconstructed everytime
          return $parser;
        }, $key);
      }
    }
    return $language;
  }

  public static function token( $name, $content ) {
    $token = new Token( $name );
    $token->setContent( $content );
    return $token;
  }

}
