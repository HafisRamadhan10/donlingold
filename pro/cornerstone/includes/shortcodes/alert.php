<?php

// Alert
// =============================================================================

function x_shortcode_alert( $atts, $content = null ) {
  extract( shortcode_atts( array(
    'id'      => '',
    'class'   => '',
    'style'   => '',
    'type'    => '',
    'heading' => '',
    'close'   => ''
  ), $atts, 'x_alert' ) );

  $close_class = ( $close == 'true' ) ? 'fade in' : 'x-alert-block';

  $atts = cs_atts( array(
    'id' => $id,
    'class' => trim( "x-alert x-alert-$type " . $close_class . ' ' . $class ),
    'style' => $style
  ) );

  $heading = cs_decode_shortcode_attribute( $heading );

  $button = ( $close == 'true' ) ? "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" : '';
  $heading = ( $heading ) ? "<h6 class=\"h-alert\">{$heading}</h6>" : '';

  return "<div {$atts}>{$button}{$heading}" . do_shortcode($content) . "</div>";
}

add_shortcode( 'cs_alert', 'x_shortcode_alert' );
