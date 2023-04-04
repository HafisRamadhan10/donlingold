<?php

class Cornerstone_Looper_Provider_Shop extends Cornerstone_Looper_Provider_Wp_Query {

  public function query_begin() {
    woocommerce_product_loop_start(false);
    $this->has_total = wc_get_loop_prop( 'total' );
  }

  protected function query_advance() {
    if ($this->has_total && have_posts()) {
      the_post();
      global $product;
      if ( empty( $product ) ) {
        return false;
      }
      if ( ! $product->is_visible() ) {
        return $this->advance(); // skip products that are not visible
      }
      return $product;
    } else {
      return false;
    }
  }

}
