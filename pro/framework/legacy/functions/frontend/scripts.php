<?php

// =============================================================================
// FUNCTIONS/FRONT-END/SCRIPTS.PHP
// -----------------------------------------------------------------------------
// Script output.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Enqueue Site Scripts
//   02. Output Inline Scripts
// =============================================================================

// Enqueue Site Scripts
// =============================================================================

function x_enqueue_site_scripts() {

  $deps = array( 'jquery' );

  if ( function_exists('CS') ) {
    $deps[] = 'cornerstone-site-body'; // ensure Cornerstone is loaded in case optimization plugins rearrange loading order
  }

  wp_register_script( 'x-site', X_TEMPLATE_URL . '/framework/dist/js/site/x.js', $deps, X_ASSET_REV === 'dev' ? null : X_ASSET_REV, true );

  $data = [];

  if (x_get_option( 'x_footer_scroll_top_display' ) == '1' ) {
    $data['scrollTop'] = floatval( x_get_option( 'x_footer_scroll_top_display_unit' ) ) / 100;
  }

  $backstretch = x_get_backstretch_images();

  if ($backstretch) {
    $data['backstretch'] = $backstretch;
  }

  wp_localize_script( 'x-site', 'xJsData', $data );

  wp_enqueue_script( 'x-site' );

  if ( is_singular() ) {
    wp_enqueue_script( 'comment-reply' );
  }

}

add_action( 'wp_enqueue_scripts', 'x_enqueue_site_scripts' );



// Output Inline Scripts
// =============================================================================

function x_get_backstretch_images() {

  // Custom Scripts
  // --------------

  $x_design_bg_image_full = x_get_option( 'x_design_bg_image_full' );
  $bg_images = array();
  $params    = array();

  if ( $x_design_bg_image_full ) {
    $src = x_make_protocol_relative( $x_design_bg_image_full );
    if ( $src ) {
      $bg_images = array( $src );
      $params = array( 'fade' => x_get_option( 'x_design_bg_image_full_fade' ) );
    }

  }

  if ( is_singular() ) {

    $entry_id              = get_the_ID();
    $x_entry_bg_image_full = get_post_meta( $entry_id, '_x_entry_bg_image_full', true );

    if ( $x_entry_bg_image_full ) {

      $page_bg_images = explode( ',', $x_entry_bg_image_full );

      $bg_images = array_values($page_bg_images);

      $fade = get_post_meta( $entry_id, '_x_entry_bg_image_full_fade', true );
      $fade = ( $fade ) || $fade == "0" ? $fade : '750';

      $duration = get_post_meta( $entry_id, '_x_entry_bg_image_full_duration', true );
      $duration = ( $duration ) ? $duration : '7500';

      $params = array( 'fade'     => (int)$fade, 'duration' => (int)$duration );

    }

  }

  return empty ( $bg_images ) ? null : [ $bg_images, $params ];

}
