<?php

// Text
// =============================================================================

function x_shortcode_text( $atts, $content = null ) {
  extract( shortcode_atts( array(
    'id'    => '',
    'class' => '',
    'style' => '',
    'text_align' => ''
  ), $atts, 'x_text' ) );


  $class = ( ( '' == $text_align ) ? 'x-text' : 'x-text ' . $text_align ) . ' ' . esc_attr( $class );

  $atts = cs_atts( array(
    'id' => $id,
    'class' => trim( $class ),
    'style' => $style
  ) );

  return "<div {$atts} >" . do_shortcode( wpautop( $content ) ) ."</div>";

}

add_shortcode( 'cs_text', 'x_shortcode_text' );