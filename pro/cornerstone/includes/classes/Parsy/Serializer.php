<?php

namespace Themeco\Cornerstone\Parsy;
use Themeco\Cornerstone\Parsy\Token;

class Serializer {

  static $count = 1;
  static $types = [];
  static $active = false;

  public function serialize( $input, $json_flags = 0) {
    self::$count = 1;
    self::$types = [];
    self::$active = true;
    json_encode($input); // run once to populate types

    $result = json_encode( [$input, self::$types], $json_flags);
    self::$active = false;
    return $result;
  }

  public static function isActive() {
    return self::$active;
  }

  public static function index($type) {
    if ( !isset( self::$types[$type] ) ) {
      return self::$types[$type] = self::$count++;
    }

    return self::$types[$type];
  }


  public function unserialize($input) {
    $decoded = json_decode($input);

    if (is_null($decoded)) {
      throw new \Exception('Invalid input: ' . $input);
    }
    list($doc, $types) = $decoded;

    $types = array_flip(get_object_vars($types));

    $tokenize = function($input) use ($types, &$tokenize) {
      if (is_array($input)) return array_map( $tokenize, $input);
      if (is_object($input) && ! is_a($input, Token::class)) {
        foreach($input as $type => $content) {
          $type = $types[(int)$type];
          $content = $content;
          break;
        }
        return new Token($type, $tokenize($content));
      }
      return $input;

    };

    return $tokenize($doc);
  }
}