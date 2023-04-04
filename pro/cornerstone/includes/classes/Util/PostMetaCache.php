<?php

namespace Themeco\Cornerstone\Util;

class PostMetaCache {
  protected $key = '';
  protected $bypass = null;

  public function setup( $key, $bypass = null ) {
    $this->key = $key;
    $this->bypass = $bypass;
  }

  public function resolve( $id, $fn ) {

    $cached = $this->unserialize( get_post_meta( $id, $this->key, true ) );

    if ( ! is_array( $cached ) || $this->shouldNotCache() ) {

      $cached = [ 'v' => $fn( $id ) ];

      if ( is_null( $cached ) ) {
        return null;
      }

      $s = $this->serialize( $cached );

      update_post_meta( $id, $this->key, $this->serialize( $cached ) );

    }

    return $cached['v'];
  }

  public function shouldNotCache() {
    $bypass = $this->bypass;

    return is_callable($bypass) ? $bypass() : false;
  }

  public function unserialize( $input ) {

    return json_decode( $input, true );
  }

  public function serialize( $input) {
    return wp_slash( wp_json_encode( $input ) );
  }
}