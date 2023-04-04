<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-BP-DROPDOWN.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Values
//   02. Style
//   03. Render
//   04. Builder Setup
//   05. Register Element
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  'omega'
);



// Style
// =============================================================================

function x_element_tss_tp_bp_dropdown() {
  return [
    'modules' => [
      ['anchor', [ 'args' => [ 'keyPrefix' => 'toggle' ] ]],
      ['dropdown', [ 'nested' => true ]],
      ['effects', [
        'args' => [
          'selectors' => ['.x-anchor-text-primary', '.x-anchor-text-secondary', '.x-graphic-child']
        ]
      ]]
    ]
  ];
}


// Render
// =============================================================================

function x_element_render_tp_bp_dropdown( $data ) {
  if ( bp_is_active( 'activity' ) ) {
    $logged_out_link = bp_get_activity_directory_permalink();
  } else if ( bp_is_active( 'groups' ) ) {
    $logged_out_link = bp_get_groups_directory_permalink();
  } else {
    $logged_out_link = bp_get_members_directory_permalink();
  }

  $anchor_href = ( is_user_logged_in() ) ? bp_loggedin_user_domain() : $logged_out_link;

  $data = array_merge(
    $data,
    array(
      'anchor_href'  => $anchor_href,
      'dropdown_tag' => 'ul'
    ),
    cs_make_aria_atts( 'toggle_anchor', array(
      'controls' => 'dropdown',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Dropdown Content', 'cornerstone' ),
    ), $data['id'], $data['unique_id'] )
  );

  $data_dropdown = array_merge( cs_extract( $data, [ 'dropdown' => '' ] ), [
    'id' => $data['id'],
    'classes' => [
      $data['_tss']['dropdown'],
      $data['style_id'],
      $data['class']
    ],
    'style' => $data['style'],
    'toggleable_id' => $data['unique_id'],
  ] );

  if ( X_BUDDYPRESS_IS_ACTIVE ) {

    if ( bp_is_active( 'activity' ) ) {
      $logged_out_link = bp_get_activity_directory_permalink();
    } else if ( bp_is_active( 'groups' ) ) {
      $logged_out_link = bp_get_groups_directory_permalink();
    } else {
      $logged_out_link = bp_get_members_directory_permalink();
    }

    $top_level_link = ( is_user_logged_in() ) ? bp_loggedin_user_domain() : $logged_out_link;
    $submenu_items  = '';

    if ( bp_is_active( 'activity' ) ) {
      $submenu_items .= '<li><a href="' . bp_get_activity_directory_permalink() . '"><span>' . x_get_option( 'x_buddypress_activity_title' ) . '</span></a></li>';
    }

    if ( bp_is_active( 'groups' ) ) {
      $submenu_items .= '<li><a href="' . bp_get_groups_directory_permalink() . '"><span>' . x_get_option( 'x_buddypress_groups_title' ) . '</span></a></li>';
    }

    if ( is_multisite() && bp_is_active( 'blogs' ) ) {
      $submenu_items .= '<li><a href="' . bp_get_blogs_directory_permalink() . '"><span>' . x_get_option( 'x_buddypress_blogs_title' ) . '</span></a></li>';
    }

    $submenu_items .= '<li><a href="' . bp_get_members_directory_permalink() . '"><span>' . x_get_option( 'x_buddypress_members_title' ) . '</span></a></li>';

    if ( ! is_user_logged_in() ) {
      if ( bp_get_signup_allowed() ) {
        $submenu_items .= '<li><a href="' . bp_get_signup_page() . '"><span>' . x_get_option( 'x_buddypress_register_title' ) . '</span></a></li>';
        $submenu_items .= '<li><a href="' . bp_get_activation_page() . '"><span>' . x_get_option( 'x_buddypress_activate_title' ) . '</span></a></li>';
      }
      $submenu_items .= '<li><a href="' . wp_login_url() . '"><span>' . __( 'Log in', 'cornerstone' ) . '</span></a></li>';
    } else {
      $submenu_items .= '<li><a href="' . bp_loggedin_user_domain() . '"><span>' . __( 'Profile', 'cornerstone' ) . '</span></a></li>';
    }

    $data_dropdown['dropdown_content'] = $submenu_items;
  }

  cs_defer_partial( 'dropdown', $data_dropdown );

  $data_toggle = array_merge( cs_extract( $data, [ 'toggle_anchor' => 'anchor', 'toggle' => '', 'effects' => '' ] ), [
    'id' => $data['id'],
    'classes' => $data['classes'],
    'style' => $data['style'],
    '_region' => $data['_region'],
    'unique_id' => $data['unique_id'],
    'toggle_trigger' => $data['dropdown_toggle_trigger']
  ]);

  return cs_get_partial_view( 'anchor', $data_toggle );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_bp_dropdown() {
  return cs_compose_controls(
    cs_partial_controls( 'dropdown', array( 'add_custom_atts' => true, 'add_toggle_trigger' => true ) ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'tp-bp-dropdown', [
  'title'   => __( 'BuddyPress Dropdown', '__x__' ),
  'values'  => $values,
  'components' => [ 'toggle', 'dropdown', 'effects' ],
  'builder' => 'x_element_builder_setup_tp_bp_dropdown',
  'tss'     => 'x_element_tss_tp_bp_dropdown',
  'render'  => 'x_element_render_tp_bp_dropdown',
  'icon'    => 'native',
  'active'  => class_exists( 'BuddyPress' ),
  'group'   => 'buddypress',
] );
