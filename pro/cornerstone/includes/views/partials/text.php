<?php

// =============================================================================
// VIEWS/PARTIALS/TEXT.PHP
// -----------------------------------------------------------------------------
// Text partial.
// =============================================================================

$classes     = ( isset( $classes )     ) ? $classes : [];
$custom_atts = ( isset( $custom_atts ) ) ? $custom_atts : null;
$is_headline = ( isset( $is_headline ) ) ? $is_headline : false;
$is_in_link  = apply_filters( 'cs_in_link', false );
$is_link     = ( isset( $text_link ) && $text_link === true && ! $is_in_link ) ? true : false;
$tag         = ( $is_headline && $is_link ) ? 'a' : 'div';


// Prepare Atts
// ------------

$_classes = [ 'x-text' ];

if ( $is_headline ) {
  $_classes[] = 'x-text-headline';
}

$atts = [];

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

if ( isset( $style ) && ! empty( $style ) ) {
  $atts['style'] = $style;
}

if ( $is_headline && $is_link ) {
  $atts = cs_apply_link( $atts, $_view_data, 'text' );
}


// Subheadline
// -----------
// Optional subheadline output for headline text content.

if ( $is_headline && $text_subheadline === true && ! empty( $text_subheadline_content ) ) {
  $text_subheadline_content = '<' . $text_subheadline_tag . ' class="x-text-content-text-subheadline">' . $text_subheadline_content . '</' . $text_subheadline_tag . '>';
} else {
  $text_subheadline_content = NULL;
}


// Graphic
// -------
// Optional graphic output for headlines.

if ( $is_headline && isset( $text_graphic ) && $text_graphic === true ) {
  $_classes[] = 'has-graphic';
  $text_graphic_content = cs_get_partial_view( 'graphic', cs_extract( $_view_data, [ 'text_graphic' => 'graphic' ] ) );
} else {
  $text_graphic_content = NULL;
}


// Text
// ----
// The primary text content. Extra markup structure is applied for headlines.

$the_text_content = '';

if ( $is_headline ) {

  if ( $text_typing === true ) {

    $text_typing_data = array(
      'strings'     => explode( "\n", esc_html( cs_dynamic_content( $text_typing_content ) ) ),
      'type_speed'  => cs_get_unitless_ms( $text_typing_speed ),
      'back_speed'  => cs_get_unitless_ms( $text_typing_back_speed ),
      'start_delay' => cs_get_unitless_ms( $text_typing_delay ),
      'back_delay'  => cs_get_unitless_ms( $text_typing_back_delay ),
      'loop'        => $text_typing_loop,
      'show_cursor' => $text_typing_cursor,
      'cursor'      => esc_attr( cs_dynamic_content( $text_typing_cursor_content ) ),
    );

    $atts = array_merge( $atts, cs_element_js_atts( 'text-type', $text_typing_data, true ) );

    $the_text_headline = esc_html( $text_typing_prefix ) . '<span class="x-text-typing"></span>' . esc_html( $text_typing_suffix );

  } else {

    $the_text_headline = $text_content;

  }

  $the_text_content .= '<div class="x-text-content">';
    $the_text_content .= $text_graphic_content;
    $the_text_content .= '<div class="x-text-content-text">';
      $the_text_content .= ( $text_subheadline_reverse === true ) ? $text_subheadline_content : '';
      $the_text_content .= '<' . $text_tag . ' class="x-text-content-text-primary">' . $the_text_headline . '</' . $text_tag . '>';
      $the_text_content .= ( $text_subheadline_reverse === false ) ? $text_subheadline_content : '';
    $the_text_content .= '</div>';
  $the_text_content .= '</div>';

} else {

  global $wp_embed;
  $the_text_content .= cs_expand_content( wp_filter_content_tags( $wp_embed->autoembed(  $text_content ) ) );

}


// Output
// ------

$atts['class'] =  array_merge( $_classes, $classes );

$atts = cs_apply_effect( $atts, $_view_data );

echo cs_tag( $tag, $atts, $custom_atts, $the_text_content );
