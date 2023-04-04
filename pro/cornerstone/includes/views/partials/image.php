<?php

// =============================================================================
// VIEWS/PARTIALS/IMAGE.PHP
// -----------------------------------------------------------------------------
// Image partial.
// =============================================================================

$_region      = ( isset( $_region )       ) ? $_region      : '';
$classes      = ( isset( $classes )       ) ? $classes      : [];
$atts         = ( isset( $atts )          ) ? $atts         : array();
$custom_atts  = ( isset( $custom_atts )   ) ? $custom_atts  : null;
$image_src    = ( isset( $image_src )     ) ? $image_src    : '';
$image_alt    = ( isset( $image_alt )     ) ? $image_alt    : '';
$image_retina = ( isset( $image_retina )  ) ? $image_retina : false;
$image_width  = ( isset( $image_width )   ) ? $image_width  : null;
$image_height = ( isset( $image_height )  ) ? $image_height : null;

// Prepare Attr Values
// -------------------

$_classes = [ 'x-image' ];

if (isset( $atts['class'])) {
  if (is_array( $atts['class'] ) ) {
    $_classes = array_merge( $_classes, $atts['class']);
  } else {
    $_classes[] = $atts['class'];
  }
  unset($atts['class']);
}


// Prepare Atts
// ------------

$atts = array_merge( array(
  'class' => array_merge( $_classes, $classes ),
), $atts );

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

if ( isset( $style ) && ! empty( $style ) ) {
  $atts['style'] = $style;
}

$atts = cs_apply_effect( $atts, $_view_data );

$atts_image = cs_apply_image_atts([
  'src'    => $image_src,
  'retina' => $image_retina,
  'width'  => $image_width,
  'height' => $image_height,
  'alt'    => $image_alt
]);


// Scaling
// -------

if ( $_region && ( isset( $image_type ) && $image_type === 'scaling' ) && ! empty( $atts_image['width'] ) && ! empty( $atts_image['height'] ) ) {

  $scaling_style = 'width: 100%; max-width: ' . $atts_image['width'] . 'px;';

  if ( $_region === 'top' || $_region === 'bottom' || $_region === 'footer' ) {
    $scaling_style = 'height: 100%; max-height: ' . $atts_image['height'] . 'px;';
  }

  $atts['class'][] = 'x-image-preserve-ratio';

  if ( isset( $atts['style'] ) ) {
    $atts['style'] .= ' ' . $scaling_style;
  } else {
    $atts['style'] = $scaling_style;
  }

}


// Linked vs. Not
// --------------

$is_in_link = apply_filters( 'cs_in_link', false );

if ( isset( $image_link ) && $image_link === true && ! $is_in_link ) {
  $tag  = 'a';
  $atts = cs_apply_link( $atts, $_view_data, 'image' );
} else {
  $tag = 'span';
}



// Output
// ------

echo cs_tag( $tag, $atts, $custom_atts, '<img ' . cs_atts( $atts_image ) . '>');
