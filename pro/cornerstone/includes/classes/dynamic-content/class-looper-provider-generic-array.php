<?php

// Allows get_array_items to accept an array of WP_Post objects
// This looper will setup post data while they are being looped and restore the last known post

abstract class Cornerstone_Looper_Provider_Generic_Array extends Cornerstone_Looper_Provider_Array {
  
  protected $previous_post = null;

  public function begin() {
    global $post;
    $this->previous_post = $post;
  }

  public function end() {
    global $post;
    if ($this->previous_post) {
      $post = $this->previous_post;
      setup_postdata( $post );
    }
  }

  public function advance() {
    
    global $post;
    
    $next_post = array_shift($this->items);
    
    if ( is_a( $next_post, 'WP_Post') ) {
      $post = $next_post;
      setup_postdata( $post );
    }

    return $next_post;
  }
}