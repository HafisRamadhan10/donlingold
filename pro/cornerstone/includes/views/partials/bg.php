<?php

// =============================================================================
// VIEWS/PARTIALS/BG.PHP
// -----------------------------------------------------------------------------
// Background partial.
// =============================================================================

// Local Variables
// ---------------

$hide_lower = $bg_lower_type === 'none' || $bg_lower_type === 'color' || $bg_lower_type === 'image' || $bg_lower_type === 'video' || ( $bg_lower_type === 'custom' && $bg_lower_custom_aria_hidden === true );
$hide_upper = $bg_upper_type === 'none' || $bg_upper_type === 'color' || $bg_upper_type === 'image' || $bg_upper_type === 'video' || ( $bg_upper_type === 'custom' && $bg_upper_custom_aria_hidden === true );
$hide_all   = $hide_lower && $hide_upper;


// Prepare Atts
// ------------

$bg_atts = array(
  'class' => 'x-bg',
);

if ( $hide_all ) {
  $bg_atts['aria-hidden'] = 'true';
}

if ( isset( $bg_border_radius ) && $bg_border_radius !== 'inherit' && $bg_border_radius !== 'inherit inherit inherit inherit' && strpos( $bg_border_radius, '!' ) === false ) {
  $bg_atts['style'] = 'border-radius: ' . $bg_border_radius . ';';
}


// Lower & Upper Layers
// --------------------

$bg_lower_layer = cs_bg_layer( $_view_data, 'lower', $hide_lower, $hide_upper, $hide_all );
$bg_upper_layer = cs_bg_layer( $_view_data, 'upper', $hide_lower, $hide_upper, $hide_all );


// Output
// ------

if ( ! empty( $bg_lower_layer ) || ! empty( $bg_upper_layer ) ) {
  echo cs_tag('div', $bg_atts, [
    $bg_lower_layer,
    $bg_upper_layer
  ]);
}

?>
