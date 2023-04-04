<?php

// =============================================================================
// VIEWS/PARTIALS/ANCHOR.PHP
// -----------------------------------------------------------------------------
// Anchor partial.
// =============================================================================

$unique_id             = ( isset( $unique_id )             ) ? $unique_id : '';
$classes               = ( isset( $classes )               ) ? $classes               : array();
$atts                  = ( isset( $atts )                  ) ? $atts                  : array();
$anchor_custom_atts    = ( isset( $anchor_custom_atts )    ) ? $anchor_custom_atts    : null;
$anchor_classes        = ( isset( $anchor_classes )        ) ? $anchor_classes        : [];
$anchor_is_active      = ( isset( $anchor_is_active )      ) ? $anchor_is_active      : false;

if ( !$anchor_custom_atts && isset( $custom_atts ) ) {
  $anchor_custom_atts = $custom_atts;
}


// Conditions
// ----------

$is_type_button          = $anchor_type === 'button';
$is_type_menu_item       = $anchor_type === 'menu-item';
$is_not_type_menu_item   = $anchor_type !== 'menu-item';
$is_type_toggle          = $anchor_type === 'toggle';

$has_text                = isset( $anchor_text ) && $anchor_text == true;
$has_graphic             = isset( $anchor_graphic ) && $anchor_graphic == true;
$has_sub_indicator       = $is_type_menu_item && isset( $anchor_sub_indicator ) && $anchor_sub_indicator == true;
$has_interactive_content = isset( $anchor_interactive_content ) && $anchor_interactive_content == true;

$is_in_link              = apply_filters( 'cs_in_link', false );


// Prepare Classes
// ---------------

if ( $is_type_menu_item ) {
  if ( ! $anchor_is_active ) {
    $class = '';
  }
}

$_classes = array( 'x-anchor', 'x-anchor-' . $anchor_type );
$classes_content = array( 'x-anchor-content' );


// Text
// ----

$anchor_text_content = $has_text ? cs_anchor_text_content( $_view_data, 'main' ) : '';
$anchor_text_interactive_content = $has_text && $has_interactive_content ? cs_anchor_text_content( $_view_data, 'interactive' ) : '';


// Graphic
// -------

$anchor_graphic_content = '';
$anchor_graphic_interactive_content = '';

if ( $has_graphic ) {

  $_classes[] = 'has-graphic';

  if ( ! ($is_type_menu_item && isset( $anchor_graphic_menu_item_display ) && $anchor_graphic_menu_item_display === 'off') ) {

    $graphic_is_active = $anchor_is_active && isset( $anchor_graphic_always_active ) && $anchor_graphic_always_active === true;

    $anchor_graphic_content = cs_get_partial_view( 'graphic',
      array_merge(
        cs_extract( $_view_data, [ 'anchor_graphic' => 'graphic', 'toggle' => '' ] ),
        [ 'graphic_is_active' => $graphic_is_active ]
      )
    );

    if ( $has_interactive_content ) {
      $anchor_graphic_interactive_content = cs_get_partial_view( 'graphic',
        array_merge(
          cs_extract( $_view_data, [ 'anchor_graphic' => 'graphic', 'anchor_interactive_content_graphic' => 'graphic', 'toggle' => '' ] ),
          [ 'graphic_is_active' => $graphic_is_active ]
        )
      );
    }
  }

}


// Sub Indicator
// -------------

$anchor_sub_indicator_content = '';

if ( $has_sub_indicator ) {
  if ( ! empty( $anchor_sub_indicator_icon ) ) {

    $anchor_sub_indicator_atts = array(
      'class'               => 'x-anchor-sub-indicator',
      'data-x-skip-scroll'  => 'true',
      'aria-hidden'         => 'true',
    );

    $icon_data = fa_get_attr( $anchor_sub_indicator_icon );

    $anchor_sub_indicator_atts[$icon_data['attr']] = $icon_data['entity'];

    if ( isset( $anchor_sub_menu_trigger_location ) && $anchor_sub_menu_trigger_location === 'sub-indicator' ) {
      $anchor_sub_indicator_atts['data-x-toggle-nested-trigger'] = true;
    }

    $anchor_sub_indicator_content = cs_tag( 'i', $anchor_sub_indicator_atts, null );

  }
}


// Particles
// ---------

$primary_is_always_active   = $anchor_is_active && isset( $anchor_primary_particle_always_active ) && $anchor_primary_particle_always_active === true;
$secondary_is_always_active = $anchor_is_active && isset( $anchor_secondary_particle_always_active ) && $anchor_secondary_particle_always_active === true;
$anchor_particle_content    = cs_make_particles( $_view_data, 'anchor', $primary_is_always_active, $secondary_is_always_active );

if ( ! empty( $anchor_particle_content ) ) {
  $_classes[] = 'has-particle';
}


// Interactive Content
// -------------------

$anchor_interactive_content_content = '';

if ( $has_interactive_content ) {

  $_classes[]                         = 'has-int-content';
  $classes_content[]                  = $anchor_interactive_content_interaction;
  $classes_interactive_content        = array_merge( $classes_content, array( 'is-int' ) );
  $anchor_graphic_interactive_content = ( isset( $anchor_graphic_interactive_content ) ) ? $anchor_graphic_interactive_content : '';
  $anchor_text_interactive_content    = ( isset( $anchor_text_interactive_content )    ) ? $anchor_text_interactive_content    : '';

  $anchor_interactive_content_content = cs_tag('div', [ 'class' => $classes_interactive_content ], [
    $anchor_graphic_interactive_content,
    $anchor_text_interactive_content
  ]);

}


// Atts - Foundation
// -----------------

if ( isset( $atts['class'] ) ) { // support classes from nav_menu_link_attributes
  $_classes[] = $atts['class'];
  unset($atts['class']);
}

$atts = array_merge( [
  'class'    => array_merge( $_classes, $anchor_classes, $classes ),
  'tabindex' => 0
], $atts );

if ( isset( $id ) && ! empty( $id ) ) {
  if ( $is_type_button ) {
    $atts['id'] = $id;
  } else if ( $is_type_toggle ) {
    $atts['id'] = $id . '-anchor-' . $anchor_type;
  }
}

if ( isset( $style ) && ! empty( $style ) ) {
  $atts['style'] = $style;
}


// Atts - Sharing / Linking
// ------------------------

if ( ! $is_in_link ) {
  if ( isset( $anchor_share_enabled ) && isset( $anchor_share_type ) && isset( $anchor_share_title ) && $anchor_share_enabled ) {
    $atts = cs_atts_for_social_sharing( $atts, cs_dynamic_content( $anchor_share_type), cs_dynamic_content( $anchor_share_title ) ) ;
  } else {
    $atts = cs_apply_link( $atts, $_view_data, 'anchor' );
  }
}


// Atts - Toggle
// -------------

if ( $is_type_toggle ) {
  $atts['data-x-toggle']     = true;
  $atts['data-x-toggleable'] = $unique_id;
  if ( ! empty( $toggle_hash ) ) {
    $atts['data-x-toggle-hash'] = $toggle_hash;
  }
  if ( isset( $anchor_aria_controls ) && ! strpos( $anchor_aria_controls, 'dropdown' ) ) {
    $atts['data-x-toggle-overlay'] = true;
  }

  if (isset($toggle_trigger) && $toggle_trigger === 'hover') {
    $atts['data-x-toggle-hover'] = true;
  }

}


// Atts - Effect
// -------------

if ( $is_not_type_menu_item ) {
  $atts = cs_apply_effect( $atts, $_view_data );
}


// Atts - Accessibility
// --------------------

if ( isset( $anchor_aria_controls ) ) { $atts['aria-controls'] = $anchor_aria_controls; }
if ( isset( $anchor_aria_expanded ) ) { $atts['aria-expanded'] = $anchor_aria_expanded; }
if ( isset( $anchor_aria_haspopup ) ) { $atts['aria-haspopup'] = $anchor_aria_haspopup; }
if ( isset( $anchor_aria_label )    ) { $atts['aria-label']    = $anchor_aria_label;    }
if ( isset( $anchor_aria_selected ) ) { $atts['aria-selected'] = $anchor_aria_selected; }


// Output
// ------

echo cs_tag( $is_in_link ? 'div' : 'a', $atts, $anchor_custom_atts, [
  isset( $anchor_before_content ) ? $anchor_before_content : '',
  cs_tag('div', [ 'class' => $classes_content ], [
    $anchor_graphic_content,
    $anchor_text_content,
    $anchor_sub_indicator_content
  ]),
  $anchor_interactive_content_content,
  $anchor_particle_content,
  isset( $anchor_after_content ) ? $anchor_after_content : ''
]);
