<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/MODAL.PHP
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

function x_control_partial_modal( $settings ) {

  // Setup
  // -----

  $group             = ( isset( $settings['group'] )             ) ? $settings['group']             : 'modal';
  $group_title       = ( isset( $settings['group_title'] )       ) ? $settings['group_title']       : cs_recall( 'label_modal' );
  $conditions        = ( isset( $settings['conditions'] )        ) ? $settings['conditions']        : [];
  $is_layout_element = ( isset( $settings['is_layout_element'] ) ) ? $settings['is_layout_element'] : false;
  $add_custom_atts   = ( isset( $settings['add_custom_atts'] )   ) ? $settings['add_custom_atts']   : false;


  // Condition
  // ---------

  $condition_modal_content_bg_advanced = [ 'modal_content_bg_advanced' => true ];


  // Groups
  // ------

  $group_modal_children           = $group . ':children';
  $group_modal_setup              = $group . ':setup';
  $group_modal_background_layers  = $group . ':background-layers';
  $group_modal_size               = $group . ':size';
  $group_modal_backdrop_and_close = $group . ':backdrop-and-close';
  $group_modal_design             = $group . ':design';


  // Options
  // -------

  $options_modal_close_location = [
    'choices' => [
      [ 'value' => 'top-left',     'label' => cs_recall( 'label_top_left' )     ],
      [ 'value' => 'top-right',    'label' => cs_recall( 'label_top_right' )    ],
      [ 'value' => 'bottom-left',  'label' => cs_recall( 'label_bottom_left' )  ],
      [ 'value' => 'bottom-right', 'label' => cs_recall( 'label_bottom_right' ) ],
    ],
  ];


  // Settings
  // --------

  $settings_modal_content = [
    'group'      => $group_modal_design,
    'conditions' => $conditions,
  ];

  $settings_modal_content_flexbox = [
    'toggle'       => 'modal_content_flexbox',
    'group'        => $group_modal_design,
    'conditions'   => $conditions
  ];


  // Individual Controls - Children
  // ------------------------------

  $control_modal_children = [
    'type'  => 'sortable',
    'group' => $group_modal_children
  ];


  // Individual Controls - Setup
  // ---------------------------

  $control_modal_base_font_size     = cs_recall( 'control_mixin_font_size',  [ 'key' => 'modal_base_font_size'                                                   ] );
  $control_modal_content_text_align = cs_recall( 'control_mixin_text_align', [ 'key' => 'modal_content_text_align'                                               ] );
  $control_modal_transition         = cs_recall( 'control_mixin_transition', [ 'keys' => [ 'duration' => 'modal_duration', 'timing' => 'modal_timing_function' ] ] );

  $control_modal_body_scroll = [
    'key'     => 'modal_body_scroll',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_body_scroll' ),
    'options' => cs_recall( 'options_choices_body_scroll' ),
  ];

  $control_modal_content_overflow   = cs_recall( 'control_mixin_overflow',          [ 'key' => 'modal_content_overflow'                                                            ] );
  $control_modal_content_bg_color   = cs_recall( 'control_mixin_bg_color_solo',     [ 'keys' => [ 'value' => 'modal_content_bg_color' ]                                            ] );
  $control_modal_content_background = cs_recall( 'control_mixin_bg_color_solo_adv', [ 'keys' => [ 'value' => 'modal_content_bg_color', 'checkbox' => 'modal_content_bg_advanced' ] ] );


  // Individual Controls - Size
  // --------------------------

  $control_modal_content_width      = cs_recall( 'control_mixin_width',      [ 'key' => 'modal_content_width'      ] );
  $control_modal_content_min_width  = cs_recall( 'control_mixin_min_width',  [ 'key' => 'modal_content_min_width'  ] );
  $control_modal_content_max_width  = cs_recall( 'control_mixin_max_width',  [ 'key' => 'modal_content_max_width'  ] );
  $control_modal_content_height     = cs_recall( 'control_mixin_height',     [ 'key' => 'modal_content_height'     ] );
  $control_modal_content_min_height = cs_recall( 'control_mixin_min_height', [ 'key' => 'modal_content_min_height' ] );
  $control_modal_content_max_height = cs_recall( 'control_mixin_max_height', [ 'key' => 'modal_content_max_height' ] );


  // Individual Controls - Backdrop and Close
  // ----------------------------------------

  $control_modal_bg_color   = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'modal_bg_color' ], 'label' => cs_recall( 'label_backdrop' ) ] );
  $control_modal_close_size = cs_recall( 'control_mixin_font_size', [ 'key' => 'modal_close_font_size', 'label' => cs_recall( 'label_close_size' )            ] );

  $control_modal_close_dimensions = [
    'key'     => 'modal_close_dimensions',
    'type'    => 'select',
    'label'   => cs_recall( 'label_dimensions' ),
    'options' => cs_recall( 'options_choices_close_dimensions' ),
  ];

  $control_modal_close_location = [
    'key'     => 'modal_close_location',
    'type'    => 'select',
    'label'   => cs_recall( 'label_location' ),
    'options' => $options_modal_close_location,
  ];

  $control_modal_close_colors = cs_recall( 'control_mixin_color_int', [ 'keys' => [ 'value' => 'modal_close_color', 'alt' => 'modal_close_color_alt' ] ] );


  // Control Lists
  // -------------

  $control_list_setup = [];
  $control_list_size  = [];

  if ( $is_layout_element === false ) {
    $control_list_setup = [
      $control_modal_base_font_size,
      $control_modal_content_max_width,
      $control_modal_body_scroll,
      $control_modal_transition,
      $control_modal_content_bg_color,
    ];
  }

  if ( $is_layout_element === true ) {
    $control_list_setup = [
      $control_modal_base_font_size,
      $control_modal_content_text_align,
      $control_modal_transition,
      $control_modal_body_scroll,
      $control_modal_content_overflow,
      $control_modal_content_background,
    ];

    $control_list_size = [
      $control_modal_content_width,
      $control_modal_content_min_width,
      $control_modal_content_max_width,
      $control_modal_content_height,
      $control_modal_content_min_height,
      $control_modal_content_max_height,
    ];
  }


  // Control List - Backdrop and Close
  // ---------------------------------

  $control_list_backdrop_and_close = [
    $control_modal_bg_color,
    $control_modal_close_size,
    $control_modal_close_dimensions,
    $control_modal_close_location,
    $control_modal_close_colors,
  ];


  // Compose Controls
  // ----------------

  $controls_before = [];
  $controls_after  = [];

  if ( $is_layout_element === true ) {
    $controls_before['controls'][] = $control_modal_children;
  }

  $controls_before['controls'][] = [
    'type'       => 'group',
    'group'      => $group_modal_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_setup,
  ];

  $controls_bg = ( $is_layout_element === true ) ? cs_partial_controls( 'bg', [
    'group'     => $group_modal_background_layers,
    'condition' => $condition_modal_content_bg_advanced,
  ] ) : [];

  if ( $is_layout_element === true ) {
    $controls_after['controls'][] = [
      'type'       => 'group',
      'group'      => $group_modal_size,
      'conditions' => $conditions,
      'controls'   => $control_list_size,
    ];
  }

  $controls_after['controls'][] = [
    'type'       => 'group',
    'group'      => $group_modal_backdrop_and_close,
    'conditions' => $conditions,
    'controls'   => $control_list_backdrop_and_close,
  ];

  if ( $is_layout_element === true ) {
    $controls_after['controls'][] = cs_control( 'flexbox', 'modal_content', $settings_modal_content_flexbox );
  }

  $controls_after['controls'][] = cs_control( 'padding', 'modal_content', $settings_modal_content );
  $controls_after['controls'][] = cs_control( 'border', 'modal_content', $settings_modal_content );
  $controls_after['controls'][] = cs_control( 'border-radius', 'modal_content', $settings_modal_content );
  $controls_after['controls'][] = cs_control( 'box-shadow', 'modal_content', $settings_modal_content );

  if ( $add_custom_atts ) {
    $controls_after['controls'][] = [
      'key'   => 'modal_custom_atts',
      'type'  => 'attributes',
      'group' => 'omega:setup',
      'label' => cs_recall( 'label_modal_custom_attributes' ),
    ];
  }

  $controls_after['control_nav'] = [
    $group                          => $group_title,
    $group_modal_children           => cs_recall( 'label_children' ),
    $group_modal_setup              => cs_recall( 'label_setup' ),
    $group_modal_background_layers  => cs_recall( 'label_background_layers' ),
    $group_modal_size               => cs_recall( 'label_size' ),
    $group_modal_backdrop_and_close => cs_recall( 'label_backdrop_and_close' ),
    $group_modal_design             => cs_recall( 'label_design' ),
  ];


  // Return Controls
  // ---------------

  return cs_compose_controls( $controls_before, $controls_bg, $controls_after );

}

cs_register_control_partial( 'modal', 'x_control_partial_modal' );
