<?php

abstract class Cornerstone_Looper_Provider_Array extends Cornerstone_Looper_Provider {

  protected $items = [];
  protected $size = 0;
  protected $original_items = [];

  public function setup( $element ) {

    $items = $this->get_array_items( $element );

    // Handle WP errors
    if ( is_wp_error( $items ) ) {
      $this->set_error( $items );
      $items = [];
    }

    // If a single non array item is passed through we will consider it an array of a single item
    if ( ! is_array( $items ) || $this->has_string_keys( $items ) ) {
      $items = [ $items ];
    }
    
    $items = array_values( $items );
  
    $offset = intval( cs_dynamic_content( $element['looper_provider_array_offset'] ) );
    $this->items = $offset === 0 ? $items : array_slice( $items, $offset );
    $this->original_items = $this->items;
    $this->size = count($this->items);
    
  }
  
  public function advance() {
    return array_shift($this->items);
  }

  public function rewind() {
    $this->items = $this->original_items;
  }
  
  public function get_context() {
    return $this->items;
  }

  public function get_index() {
    return $this->size - (count($this->items) + 1); // return zero based index
  }

  public function get_size() {
    return $this->size;
  }

  public function has_string_keys($input) {
    return count(array_filter(array_keys($input), 'is_string')) > 0;
  }

  abstract function get_array_items( $element );

}
