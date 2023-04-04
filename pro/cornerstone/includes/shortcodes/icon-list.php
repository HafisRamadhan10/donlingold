<?php

// Icon List
// =============================================================================

function x_shortcode_icon_list( $atts, $content = null ) {
  extract( shortcode_atts( array(
    'id'    => '',
    'class' => '',
    'style' => ''
  ), $atts, 'x_icon_list' ) );

  $atts = cs_atts( array(
    'id' => $id,
    'class' => trim( 'x-ul-icons ' . $class ),
    'style' => $style
  ) );

  return "<ul {$atts} >" . do_shortcode( $content ) . "</ul>";
}

add_shortcode( 'cs_icon_list', 'x_shortcode_icon_list' );



// Icon List Item
// =============================================================================

function x_shortcode_icon_list_item( $atts, $content = null ) {

  extract( shortcode_atts( array(
    'id'           => '',
    'class'        => '',
    'style'        => '',
    'type'         => '',
    'icon_color'   => '',
    'link_enabled' => '',
    'link_url'     => '',
    'link_title'   => '',
    'link_new_tab' => ''
  ), $atts, 'x_icon_list_item' ) );

  $atts = cs_atts( array(
    'id' => $id,
    'class' => trim( 'x-li-icon ' . $class ),
    'style' => $style
  ) );

  $icon_style = ( $icon_color != '' ) ? "color: $icon_color;" : '';

  $icon_atts = array(
    'class' => 'x-icon-' . $type,
    'aria-hidden' => 'true',
    'style' => $icon_style
  );

  $icon_attr = fa_get_attr( $type );
  $icon_atts[$icon_attr['attr']] = $icon_attr['entity'];

  $icon_atts = cs_atts( $icon_atts );

  $link_begin = '';
  $link_end   = '';

  if ( $link_enabled == 'true' ) {

    $link_atts = array(
      'href'   => $link_url,
      'title'  => $link_title,
      'target' => $link_new_tab == 'true' ? '_blank' : ''
    );

    if ( $link_new_tab ) {
      $link_atts = cs_atts_with_targeted_link_rel( $link_atts );
    }

    $link_atts = cs_atts( $link_atts );

    $link_begin = "<a {$link_atts}>";
    $link_end   = "</a>";

  }

  return "<li {$atts} ><i {$icon_atts} ></i>" . $link_begin . do_shortcode( $content ) .  $link_end . "</li>";

}

add_shortcode( 'cs_icon_list_item', 'x_shortcode_icon_list_item' );
