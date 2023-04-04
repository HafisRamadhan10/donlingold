<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/MENU.PHP
// -----------------------------------------------------------------------------
// Element Controls
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
// =============================================================================

// Controls
// =============================================================================

function x_control_partial_menu( $settings ) {

  // Setup
  // -----
  // 01. Available types:
  //     -- 'inline'
  //     -- 'dropdown'
  //     -- 'collapsed'
  //     -- 'modal'
  //     -- 'layered'

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'menu';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : cs_recall( 'label_menu' );
  $conditions  = ( isset( $settings['conditions'] )  ) ? $settings['conditions']  : [];
  $type        = ( isset( $settings['type'] )        ) ? $settings['type']        : 'inline'; // 01


  // Groups
  // ------

  $group_menu_setup        = $group . ':setup';
  $group_menu_active_links = $group . ':active-links';
  $group_menu_design       = $group . ':design';


  // Individual Controls
  // -------------------

  $control_menu_base_font_size = cs_recall( 'control_mixin_font_size', [ 'key' => 'menu_base_font_size' ] );

  $control_menu_menu = [
    'key'   => 'menu',
    'type'  => 'menu',
    'label' => cs_recall( 'label_menu' ),
  ];

  $control_menu_align_self = [
    'key'     => 'menu_align_self',
    'type'    => 'select',
    'label'   => cs_recall( 'label_align_self' ),
    'options' => [
      'choices' => [
        [ 'value' => 'flex-start', 'label' => cs_recall( 'label_start' )   ],
        [ 'value' => 'center',     'label' => cs_recall( 'label_center' )  ],
        [ 'value' => 'flex-end',   'label' => cs_recall( 'label_end' )     ],
        [ 'value' => 'stretch',    'label' => cs_recall( 'label_stretch' ) ],
      ],
    ],
  ];

  $control_menu_sub_menu_trigger_location = [
    'key'     => 'menu_sub_menu_trigger_location',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_sub_menu_trigger' ),
    'options' => [
      'choices' => [
        [ 'value' => 'anchor',        'label' => cs_recall( 'label_anchor' )    ],
        [ 'value' => 'sub-indicator', 'label' => cs_recall( 'label_indicator' ) ],
      ],
    ],
  ];

  $control_menu_layered_back_label = [
    'key'   => 'menu_layered_back_label',
    'type'  => 'text',
    'label' => cs_recall( 'label_back_label' ),
  ];

  $control_menu_active_links_highlight_current = [
    'key'     => 'menu_active_links_highlight_current',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_current' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  ];

  $control_menu_active_links_highlight_ancestors = [
    'key'     => 'menu_active_links_highlight_ancestors',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_ancestors' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  ];

  $control_menu_active_links_show_graphic = [
    'key'     => 'menu_active_links_show_graphic',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_graphic' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  ];

  $control_menu_active_links_show_primary_particle = [
    'key'     => 'menu_active_links_show_primary_particle',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_primary_particle' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  ];

  $control_menu_active_links_show_secondary_particle = [
    'key'     => 'menu_active_links_show_secondary_particle',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_secondary_particle' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  ];

  $control_list_menu_adv_setup = [];

  if ( $type !== 'dropdown' ) {
    $control_list_menu_adv_setup[] = $control_menu_base_font_size;
  }

  $control_list_menu_adv_setup[] = $control_menu_menu;

  if ( $type === 'inline' ) {
    $control_list_menu_adv_setup[] = $control_menu_align_self;
  }

  if ( $type === 'collapsed' || $type === 'modal' || $type === 'layered' ) {
    $control_list_menu_adv_setup[] = $control_menu_sub_menu_trigger_location;
  }

  if ( $type === 'modal' || $type === 'layered' ) {
    $control_list_menu_adv_setup[] = $control_menu_layered_back_label;
  }

  // if ( $type === 'collapsed' || $type === 'layered' ) {
  //   $control_list_menu_adv_setup[] = $control_menu_transition;
  // }


  // Compose Controls
  // ----------------

  $controls = [
    [
      'type'       => 'group',
      'group'      => $group_menu_setup,
      'conditions' => $conditions,
      'controls'   => $control_list_menu_adv_setup,
    ],
    [
      'type'       => 'group',
      'group'      => $group_menu_active_links,
      'conditions' => $conditions,
      'controls'   => [
        $control_menu_active_links_highlight_current,
        $control_menu_active_links_highlight_ancestors,
        $control_menu_active_links_show_graphic,
        $control_menu_active_links_show_primary_particle,
        $control_menu_active_links_show_secondary_particle,
      ],
    ],
  ];

  if ( $type !== 'dropdown' ) {
    $controls[] = cs_control( 'margin', 'menu', [
      'group'     => $group_menu_design,
      'conditions' => $conditions
    ] );
  }

  if ( $type === 'inline' ) {

    $controls[] = cs_control( 'flexbox', 'menu', [
      'layout_pre' => 'row',
      'group'      => $group_menu_design,
      'conditions' => [ [ 'key' => '_region', 'op' => 'IN', 'value' => [ 'content', 'top', 'bottom', 'footer' ] ] ],
      'self_flex'  => true
    ] );

    $controls[] = cs_control( 'flexbox', 'menu', [
      'layout_pre' => 'col',
      'group'      => $group_menu_design,
      'conditions' => [ [ 'key' => '_region', 'op' => 'IN', 'value' => [ 'left', 'right' ] ] ],
      'self_flex'  => true
    ] );

    $controls[] = [
      'key'        => 'menu_items_flex',
      'type'       => 'flex',
      'label'      => cs_recall( 'label_flex_with_prefix' ),
      'label_vars' => [ 'prefix' => cs_recall( 'label_items' ) ],
      'group'      => $group_menu_design,
      'conditions' => $conditions,
    ];

  }

  $controls[] = [
    'key'        => 'menu_custom_atts',
    'type'       => 'attributes',
    'group'      => 'omega:setup',
    'label'      => cs_recall( 'label_custom_attributes_with_prefix' ),
    'label_vars' => [ 'prefix' => cs_recall( 'label_menu' ) ]
  ];

  $control_nav = [
    $group                   => $group_title,
    $group_menu_setup        => cs_recall( 'label_setup' ),
    $group_menu_active_links => cs_recall( 'label_active_links' ),
  ];

  if ( $type !== 'dropdown' ) {
    $control_nav[$group_menu_design] = cs_recall( 'label_design' );
  }

  return [
    'controls' => $controls,
    'control_nav'               => $control_nav,
  ];

}

cs_register_control_partial( 'menu', 'x_control_partial_menu' );
