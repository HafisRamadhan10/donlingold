<?php

// =============================================================================
// VIEWS/PARTIALS/DROPDOWN.PHP
// -----------------------------------------------------------------------------
// Dropdown partial.
// =============================================================================

$_region              = ( isset( $_region )                               ) ? $_region              : '';
$classes              = ( isset( $classes )                               ) ? $classes              : [];
$atts                 = ( isset( $atts )                                  ) ? $atts                 : [];
$dropdown_custom_atts = ( isset( $dropdown_custom_atts )                  ) ? $dropdown_custom_atts : null;
$tag                  = ( isset( $dropdown_tag ) && $dropdown_tag         ) ? $dropdown_tag         : 'div';


// Prepare Atts
// ------------

$atts = array_merge([
  'id'                => ( isset( $id ) && ! empty( $id ) ) ? $id . '-dropdown' : $toggleable_id . '-dropdown',
  'class'             => array_merge( [ 'x-dropdown' ], $classes ),
  'data-x-stem'       => NULL,
  'data-x-stem-root'  => NULL,
  'data-x-toggleable' => $toggleable_id,
  'aria-hidden'       => 'true',
], $atts);

if ( isset( $style ) && ! empty( $style ) ) {
  $atts['style'] = $style;
}

if ( $_region === 'left' ) {
  $atts['data-x-stem-root'] = 'h';
}

if ( $_region === 'right' ) {
  $atts['data-x-stem-root'] = 'rh';
}

// Output
// ------

echo cs_tag( $tag, $atts, $dropdown_custom_atts, $dropdown_content);