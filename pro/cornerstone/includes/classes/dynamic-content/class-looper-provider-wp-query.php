<?php

// Base class for all WP Query based loopers

abstract class Cornerstone_Looper_Provider_Wp_Query extends Cornerstone_Looper_Provider {

  protected $previous_post = null;

  public function setup( $element = []) {
    $this->setup_query( $element, $this->config );
  }

  public function begin() {
    global $post;
    if ( $post ) {
      $this->previous_post = $post;
    }
    $this->set_in_loop( true );
    $this->query_begin();
  }

  public function resume() {
    $this->set_in_loop( true );
    $this->query_resume();
  }

  public function end() {
    
    $this->set_in_loop( false );
    $this->query_end();
    
    global $post;

    if ( $this->previous_post ) {
      $post = $this->previous_post;
      setup_postdata( $post );
    }

  }

  public function advance() {
    return $this->query_advance();
  }
  
  public function rewind() {
    return $this->query_rewind();
  }
  
  public function get_context() {
    global $wp_query;
    return $wp_query;
  }

  public function get_index() {
    global $wp_query;
    return $wp_query->current_post;
  }

  public function get_size() {
    global $wp_query;
    return $wp_query->post_count;
  }

  public function setup_query($element, $config) {

  }

  public function set_in_loop( $in ) {
    if ($in) {
      if ( !has_filter( 'cs_looper_in_wp_query', '__return_true' ) ) {
        add_filter( 'cs_looper_in_wp_query', '__return_true' );
      }
    } else {
      remove_filter('cs_looper_in_wp_query', '__return_true' );
    }
  }

  

  public function query_begin() {

  }

  public function query_end() {

  }

  public function query_resume() {
    wp_reset_postdata();
  }

  protected function query_rewind() {
    rewind_posts();
  }

  protected function query_advance() {
    global $post;
    if (!is_singular() && have_posts()) {
      the_post();
      return $post;
    } else {
      return false;
    }
  }

}
