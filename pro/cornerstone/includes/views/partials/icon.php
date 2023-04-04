<?php

// =============================================================================
// VIEWS/PARTIALS/ICON.PHP
// -----------------------------------------------------------------------------
// Icon partial.
// =============================================================================

$atts        = ( isset( $atts )          ) ? $atts          : array();
$classes     = ( isset( $classes )       ) ? $classes       : array();
$custom_atts = ( isset( $custom_atts )   ) ? $custom_atts   : null;


// Prepare Attr Values
// -------------------

$_classes = [ 'x-icon' ];

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

$atts = array_merge( $atts, array(
  'class'       => array_merge( $_classes, $classes ),
  'aria-hidden' => 'true',
) );

$icon_data                = fa_get_attr( cs_dynamic_content( $icon ) );
$atts[$icon_data['attr']] = $icon_data['entity'];

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

if ( isset( $style ) && ! empty( $style ) ) {
  $atts['style'] = $style;
}

$atts = cs_apply_effect( $atts, $_view_data );


// Output
// ------

echo cs_tag( 'i', $atts, $custom_atts, '');
