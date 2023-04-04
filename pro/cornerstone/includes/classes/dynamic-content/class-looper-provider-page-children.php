<?php

class Cornerstone_Looper_Provider_Page_Children extends Cornerstone_Looper_Provider_Generic_Array {
  
  public function get_array_items( $element ) {
    
    if (get_post_type() !== 'page') {
      return [];
    }

    return get_children([
      'post_parent' => get_the_ID(),
      'order' => 'ASC',
      'orderby' => 'menu_order'
    ]);

  }

}