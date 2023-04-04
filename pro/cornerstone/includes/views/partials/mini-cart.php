<?php

// =============================================================================
// VIEWS/PARTIALS/MINI-CART.PHP
// -----------------------------------------------------------------------------
// Mini cart partial.
// =============================================================================

if ( class_exists( 'WC_API' ) ) {

  // Notes
  // -----
  // 01. $show_title should be set by the registration itself, which indicates
  //     if the Mini Cart is part of one of the ole non-prefab versions.

  $show_title       = ( isset( $show_title )  ) ? $show_title  : false; // 01
  $custom_atts      = ( isset( $custom_atts ) ) ? $custom_atts : null;
  $classes          = ( isset( $classes )     ) ? $classes     : [];

  // Prepare Atts
  // ------------

  $atts = array(
    'class' => array_merge([ 'x-mini-cart'], $classes)
  );

  if ( isset( $id ) && ! empty( $id ) ) {
    $atts['id'] = $id;
  }

  $atts = cs_apply_effect( $atts, $_view_data );


  // Output
  // ------

  // Notes
  // -----
  // 01. Conditionally output the cart title
  // 02. WooCommerce's JavaScript looks for this element and fills it with their
  // cart markup on page load and certain AJAX actions.
  //
  // Thumbnail size for all carts must be the same and is set in the
  // WordPress admin under WooCommerce > Settings > Products > Display.


  echo cs_tag('div', $atts, $custom_atts, [
    $show_title && ! empty( $cart_title ) ? cs_tag('h2', [ 'class' => 'x-mini-cart-title' ], $cart_title ) : '', // 01
    cs_tag( 'div', ['class' => 'widget_shopping_cart_content'], '' ) // 02
  ] );

} else {

  $message = __( 'The shopping cart currently unavailable.', 'cornerstone' );
  echo '<div style="padding: 35px; line-height: 1.5; text-align: center; color: #000; background-color: #fff;">' . $message . '</div>';

}
