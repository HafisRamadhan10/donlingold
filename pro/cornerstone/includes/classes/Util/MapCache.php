<?php

namespace Themeco\Cornerstone\Util;

abstract class MapCache {

  protected $cache = [];

  public function get( $key ) {
    if ( ! isset( $this->cache[ $key ] ) ) {
      throw new \Exception("Missing cached value: $key " . static::class );
    }
    return $this->cache[$key];
  }

  public function set( $key, $value ) {
    $this->cache[$key] = $this->transform( $key, $value );
  }

  public function resolve( $key, $resolver ) {
    if (!isset($this->cache[$key])) {
      $this->set( $key, $resolver() );
    }
    return $this->cache[$key];
  }

  public function transform( $key, $value) {
    return $value;
  }

}