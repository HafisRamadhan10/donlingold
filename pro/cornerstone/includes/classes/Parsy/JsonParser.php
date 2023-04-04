<?php

namespace Themeco\Cornerstone\Parsy;

use Themeco\Cornerstone\Parsy\Parser;
use Themeco\Cornerstone\Parsy\P;

// Whitespace lax helpers


class JsonParser {

  public function token( $parser ) {
    return $parser->thru(function($parser){
      return $parser->skip(P::whitespace());
    });
  }
  
  public function symbol( $str ) {
    return $this->token(P::str($str));
  }

  public function __construct( $args = [] ) {

    $pair_mapper = $this->getPairMapper(isset( $args['associative'] ) && $args['associative']);

    $this->language = P::createLanguage([
      'value' => function ($l) {
        return P::any( $l->object, $l->array, $l->string, $l->number, $l->null, $l->true, $l->false )->thru(function($parser) {
          return P::whitespace()->then($parser);
        });
      },
      
      'rbrace'   => function( $l ) { return symbol("}"); },
      'lbrace'   => function( $l ) { return symbol("{"); },
      'lbracket' => function( $l ) { return symbol("["); },
      'rbracket' => function( $l ) { return symbol("]"); },
      'comma'    => function( $l ) { return symbol(","); },
      'colon'    => function( $l ) { return symbol(":"); },
      'null'     => function( $l ) { return symbol('null')->result(null); },
      'true'     => function( $l ) { return symbol('true')->result(true); },
      'false'    => function( $l ) { return symbol('false')->result(false); },
      'string'   => function( $l ) { return token(P::double_quoted_escaped_string()); },
      'number'   => function( $l ) { return token(P::number()); },
      'pair'     => function( $l ) { return P::sequence( $l->string->skip( $l->colon ), $l->value ); },
      
      'array' => function( $l ) {
        return $l->lbracket->then(P::sep_by($l->comma)($l->value))->skip($l->rbracket);
      },

      'object' => function($l) use($pair_mapper) {
        return $l->lbrace->then(
          P::sep_by($l->comma)($l->pair)->skip($l->rbrace)->map($pair_mapper)
        );
      }
    ]);

  }

  public function getPairMapper( $associative ) {
    
    if ($associative) {
      return function( $pairs ) {
        $result = [];
        foreach ( $pairs as $pair ) {
          list($key, $value) = $pair;
          $result[$key] = $value;
        }
        return $result;
      };
    }

    return function ($pairs) {
      $result = new \stdClass;
      foreach ( $pairs as $pair ) {
        list($key, $value) = $pair;
        $result->{$key} = $value;
      }
      return $result;
    };
  }

  public function __get($key) {
    return $this->language->{$key};
  }

  public static function make( $args = []) {
    return new self($args);
  }
  
}