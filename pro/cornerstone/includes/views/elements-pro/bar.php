<?php

// =============================================================================
// VIEWS/ELEMENTS-PRO/BAR.PHP
// -----------------------------------------------------------------------------
// Bar element.
// =============================================================================

$bar_region_is_lr                       = $_region === 'left' || $_region === 'right';
$bar_region_is_tbf                      = $_region === 'top' || $_region === 'bottom' || $_region === 'footer';
$bar_is_sticky                          = $_region === 'top' && $bar_sticky === true;
$bar_has_content_scrolling              = $bar_scroll === true && $bar_scroll_allowed;
$bar_has_content_scrolling_with_buttons = $bar_region_is_tbf && $bar_has_content_scrolling && $bar_scroll_buttons === true;

$bar_position = cs_identity_bar_position( $_view_data );


// Prepare Classes
// ---------------

$class_region_specific = 'x-bar-' . $_region;
$class_region_general  = ( $bar_region_is_lr ) ? 'x-bar-v' : 'x-bar-h';
$class_position        = 'x-bar-' . $bar_position;
$class_sticky          = ( $bar_is_sticky ) ? 'x-bar-is-sticky' : '';
$class_hide_initially  = ( $bar_is_sticky && $bar_sticky_hide_initially ) ? 'x-bar-is-initially-hidden' : '';

$_classes = [
  'x-bar',
  $class_region_specific,
  $class_region_general,
  $class_position,
  $class_sticky,
  $class_hide_initially
];

if ( ( $bar_region_is_lr || ( $bar_region_is_tbf && $bar_global_container == false ) ) && $bar_scroll === false ) {
  $_classes[] = 'x-bar-outer-spacers';
}


// Prepare Data
// ------------

$bar_data = array(
  'id'     => $unique_id,
  'region' => $_region,
);

if ( $bar_region_is_lr ) {
  $bar_data['width'] = $bar_width;
}

if ( $bar_region_is_tbf ) {
  $bar_data['height'] = $bar_height;
}

if ( $bar_is_sticky ) {
  $bar_data['keepMargin']      = $bar_sticky_keep_margin;
  $bar_data['hideInitially']   = $bar_sticky_hide_initially;
  $bar_data['zStack']          = $bar_sticky_z_stack;
  $bar_data['triggerOffset']   = $bar_sticky_trigger_offset;
  $bar_data['triggerSelector'] = $bar_sticky_trigger_selector;
  $bar_data['shrink']          = $bar_sticky_shrink;
}

if ( $bar_has_content_scrolling ) {
  $bar_data['scroll'] = true;

  if ( $bar_has_content_scrolling_with_buttons ) {
    $bar_data['scrollButtons'] = true;
  }
}


// Atts: Bar
// ---------

$atts_bar = array(
  'class'      => array_merge( $_classes, $classes ),
  'data-x-bar' => cs_prepare_json_att( $bar_data, true ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts_bar['id'] = $id;
}

if ( isset( $style ) && ! empty( $style ) ) {
  $atts['style'] = $style;
}

$atts_bar = cs_apply_effect( $atts_bar, $_view_data );


// Atts: Bar Scroll
// ----------------

$bar_scroll_begin   = '';
$bar_scroll_end     = '';
$bar_scroll_buttons = '';

if ( $bar_has_content_scrolling ) {

  // $suppress_scroll      = ( $bar_region_is_tbf ) ? 'suppressScrollY' : 'suppressScrollX';
  // $atts_bar_scroll_data = array( $suppress_scroll => true );
  // $atts_bar_scroll      = array( 'class' => array( $style_id, 'x-bar-scroll', 'x-bar-outer-spacers' ), 'data-x-scrollbar' => cs_prepare_json_att( $atts_bar_scroll_data, true ) );
  // $bar_scroll_begin     = '<div ' . cs_atts( $atts_bar_scroll ) . '>';
  // $bar_scroll_end       = '</div>';

  $atts_bar_scroll_outer = array( 'class' => array( $style_id, 'x-bar-scroll-outer' ) );
  $atts_bar_scroll_inner = array( 'class' => array( $style_id, 'x-bar-scroll-inner', 'x-bar-outer-spacers' ) );
  $bar_scroll_begin      = '<div ' . cs_atts( $atts_bar_scroll_outer ) . '><div ' . cs_atts( $atts_bar_scroll_inner ) . '>';
  $bar_scroll_end        = '</div></div>';

  if ( $bar_has_content_scrolling_with_buttons ) {

    $atts_bar_scroll_button_bck  = array( 'class' => 'x-bar-scroll-button is-bck', 'data-x-bar-scroll-button' => 'bck' );
    $atts_bar_scroll_button_fwd  = array( 'class' => 'x-bar-scroll-button is-fwd', 'data-x-bar-scroll-button' => 'fwd' );
    $bar_scroll_buttons_icon_bck = cs_get_partial_view( 'icon', [ 'icon' => $bar_scroll_buttons_bck_icon ] );
    $bar_scroll_buttons_icon_fwd = cs_get_partial_view( 'icon', [ 'icon' => $bar_scroll_buttons_fwd_icon ] );
    $bar_scroll_buttons          = '<button ' . cs_atts( $atts_bar_scroll_button_bck ) . '>' . $bar_scroll_buttons_icon_bck . '</button><button ' . cs_atts( $atts_bar_scroll_button_fwd ) . '>' . $bar_scroll_buttons_icon_fwd . '</button>';

  }

}


// Content
// -------

$content_classes = array( $style_id, 'x-bar-content' );

if ( $bar_region_is_tbf && $bar_global_container == true ) {
  $content_classes[] = 'x-container max width';
}

$atts_bar_content = array(
  'class' => $content_classes
);

echo cs_tag('div', $atts_bar, $custom_atts, [
  $bar_before_space,
  $bar_bg_advanced ? cs_make_bg( $_view_data ) : '',
  $bar_scroll_begin,
  cs_tag('div', $atts_bar_content, cs_render_child_elements( $_view_data, 'x_bar' ) ),
  $bar_scroll_end,
  $bar_scroll_buttons
]);
