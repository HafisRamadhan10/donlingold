<?php

// =============================================================================
// FUNCTIONS/HEADER/HELPERS.PHP
// -----------------------------------------------------------------------------
// Header helper functions.
// =============================================================================

use Themeco\Cornerstone\Elements\NavMenuFallback;


// Preview
// =============================================================================

function x_preview_props($keys, $data) {
  return CS()->novus()->service('Elements')->decorator()->previewProps( $keys, $data );
}


// Generated Navigation
// =============================================================================

function cs_pre_wp_nav_menu( $menu, $args ) {

  if ( isset( $args->sample_menu ) ) {
    return cs_wp_nav_menu_fallback( array_merge( (array) $args, array( 'echo' => false ) ) );
  }

  return $menu;

}

add_filter( 'pre_wp_nav_menu', 'cs_pre_wp_nav_menu', 10, 2 );


function cs_wp_nav_menu_fallback( $args ) {

  $fallback = CS()->novus()->resolve(NavMenuFallback::class);
  $fallback->config($args);

  return $fallback->output();

}


function cs_render_child_elements( $parent, $hook = 'x_render_children') {
  ob_start();
  do_action( $hook, $parent['_modules'], $parent );
  return ob_get_clean();
}



// Image Setup
// -----------
// This function takes a source image which could be a URL or an attachment ID with a potential size appended.
// It returns an array with src, width, and height keys that can be used to display the image.
// The $retina argument determines if the natural dimensions are divided in half
// 01. Process dynamic content which will also cast any ints to strings
// 02. If $src is empty, return empty values or generate a placeholder for the preview
// 03. If $src contains an integer we assume it is the
//     WordPress attachment ID.
// 04. $src could also be in the format "123:full" which allows us to extract the image size

// 05. Treat all other $src values as a valid URL. This is the only time the $width and $height are actually used

function cs_apply_alt_text( $atts, $alt = '', $fallback_alt = '') {

  if ($alt) {
    $atts['alt'] = cs_dynamic_content($alt);
  } else if ($fallback_alt) {
    $atts['alt'] = $fallback_alt;
  }

  return $atts;
}


function cs_apply_placeholder_src_atts( $alt, $fallback_alt, $retina ) {

  if ( apply_filters( 'cs_is_preview', false ) || did_action( 'cs_element_rendering' ) ) {

    $natural_width  = apply_filters( 'cs_default_image_width', 48 );
    $natural_height = apply_filters( 'cs_default_image_width', 48 );

    return cs_apply_alt_text([
      'src'    => cornerstone_make_placeholder_image_uri( 'rgba(0, 0, 0, 0.35)', $natural_height, $natural_width ),
      'width'  => ( $retina === true ) ? $natural_width / 2 : $natural_width,
      'height' => ( $retina === true ) ? $natural_height / 2 : $natural_height,
    ], $alt, $fallback_alt );

  }

  return cs_apply_alt_text([ 'src' => ''], $alt, $fallback_alt );

}

function cs_apply_lazy_loading( $atts, $enabled ) {
  // https://developer.wordpress.org/reference/functions/wp_get_attachment_image/
  if ( $enabled && function_exists('wp_lazy_loading_enabled') && wp_lazy_loading_enabled( 'img', 'cs_apply_image_atts' ) ) {
    $atts['loading'] = 'lazy';
  }
  return $atts;
}


function cs_resolve_image_source( $source, $size = null ) {
  $img_atts = cs_apply_image_atts( [ 'src' => $source, 'size' => null ]);
  return isset( $img_atts['src'] ) && $img_atts['src'] ? $img_atts['src'] : $source;
}

function cs_apply_image_atts( $args ) {

  /**
   * Add the code below to a child theme to enable srcset for any images
   * not configured to use retina (double pixel density)
   * This is not enabled by default because the implementation is subject
   * to change in a future major release where we are revisiting theme options.
   *
   * add_filter( 'cs_enable_srcset', '__return_true' );
   *
   */

  $args = array_merge([
    'src'          => '',
    'retina'       => false,
    'width'        => null,
    'height'       => null,
    'alt'          => '',
    'size'         => null,
    'fallback_alt' => apply_filters( 'cs_fallback_alt_text', __('Image', '__x___') ),
    'lazy'         => apply_filters( 'cs_lazy_load_images', true ),
    'srcset'       => apply_filters( 'cs_enable_srcset', false )
  ], $args );

  extract( $args );

  if ($retina) {
    $srcset = false;
  }

  $src = cs_dynamic_content( $src ); // 01

  if ( empty( $src ) ) { // 02
    return cs_apply_placeholder_src_atts( $alt, $fallback_alt, $retina );
  }

  $parts = explode(':', $src);
  $attachment_id = intval($parts[0]);

  if ($attachment_id) { // 03

    $size = isset( $parts[1] ) ? $parts[1] : 'full'; // 04
    if ( ! is_null( $args['size'] ) ) {
      $size = $args['size'];
    }

    $attachment_meta = wp_get_attachment_image_src( $attachment_id, $size );

    list( $img_src, $img_width, $img_height ) = $attachment_meta;

    if (empty($img_src)) {
      return cs_apply_placeholder_src_atts( $alt, $fallback_alt, $retina );
    }

    $img_alt = trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );

    if ($img_alt) {
      $fallback_alt = $img_alt;
    }

    $atts = [ 'src' => $img_src ];

    if ( ! $srcset ) {
      $atts['width']  =  ( $retina === true ) ? $img_width / 2 : $img_width;
      $atts['height'] =  ( $retina === true ) ? $img_height / 2 : $img_height;
    }

    if ( $srcset ) {
      $image_meta = wp_get_attachment_metadata( $attachment_id );

      if ( is_array( $image_meta ) ) {
        $size_array = array( absint( $img_width ), absint( $img_height ) );
        $srcset     = wp_calculate_image_srcset( $size_array, $img_src, $image_meta, $attachment_id );
        $sizes      = wp_calculate_image_sizes( $size_array, $img_src, $image_meta, $attachment_id );

        if ( $srcset && ( $sizes || ! empty( $attr['sizes'] ) ) ) {
          $atts['srcset'] = $srcset;

          if ( empty( $attr['sizes'] ) ) {
            $atts['sizes'] = $sizes;
          }
        }
      }
    }

    return cs_apply_lazy_loading( cs_apply_alt_text( $atts, $alt, $fallback_alt ), $lazy );

  }

  $atts = [ 'src' => $src ];

  $natural_width  = $width ? round( $width ) : $width;
  $natural_height = $height ? round( $height ) : $height;

  if ( !empty( $natural_width ) ) {
    $atts['width'] = (is_float($natural_width)  && $retina === true) ? $natural_width / 2  : $natural_width;
  }

  if ( !empty( $natural_height ) ) {
    $atts['height'] = (is_float($natural_height) && $retina === true) ? $natural_height / 2 : $natural_height;
  }

  return cs_apply_lazy_loading( cs_apply_alt_text( $atts, $alt, $fallback_alt ), $lazy );

}

function cs_identity_bar_position( $bar ) {

  if ( $bar['_region'] === 'top' ) {
    if ( $bar['bar_sticky'] === true && $bar['bar_sticky_hide_initially'] === true ) {
      return 'absolute';
    } else {
      return $bar['bar_position_top'];
    }
  } else if ( $bar['_region'] === 'footer' ) {
    return 'relative';
  }

  return 'fixed';

}


function cs_get_path( $data, $key ) {

  if ( ! is_array( $data) || ! $key || ! is_string( $key ) ) {
    return null;
  }

  $paths = array_reverse( explode('.', $key) );

  $current = $data;
  while( count($paths) > 0 ){
    $path = array_pop($paths);
    if (! isset($current[$path])) {
      return null;
    }
    $current = $current[$path];
  }

  return $current;

}