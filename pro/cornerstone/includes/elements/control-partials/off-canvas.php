<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/OFF-CANVAS.PHP
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

function x_control_partial_off_canvas( $settings ) {

  // Setup
  // -----

  $group             = ( isset( $settings['group'] )             ) ? $settings['group']             : 'off_canvas';
  $group_title       = ( isset( $settings['group_title'] )       ) ? $settings['group_title']       : cs_recall( 'label_off_canvas' );
  $conditions        = ( isset( $settings['conditions'] )        ) ? $settings['conditions']        : [];
  $is_layout_element = ( isset( $settings['is_layout_element'] ) ) ? $settings['is_layout_element'] : false;
  $add_custom_atts   = ( isset( $settings['add_custom_atts'] )   ) ? $settings['add_custom_atts']   : false;


  // Groups
  // ------

  $group_off_canvas_children           = $group . ':children';
  $group_off_canvas_setup              = $group . ':setup';
  $group_off_canvas_background_layers  = $group . ':background-layers';
  $group_off_canvas_size               = $group . ':size';
  $group_off_canvas_backdrop_and_close = $group . ':backdrop-and-close';
  $group_off_canvas_design             = $group . ':design';


  // Conditions
  // ----------

  $condition_off_canvas_content_bg_advanced = [ 'off_canvas_content_bg_advanced' => true ];


  // Options
  // -------

  $options_off_canvas_location = [
    'choices' => [
      [ 'value' => 'left',  'label' => cs_recall( 'label_left' )  ],
      [ 'value' => 'right', 'label' => cs_recall( 'label_right' ) ],
    ],
  ];

  $options_off_canvas_close_offset = [
    'choices' => [
      [ 'value' => true,  'label' => cs_recall( 'label_include' ) ],
      [ 'value' => false, 'label' => cs_recall( 'label_exclude' ) ],
    ],
  ];


  // Settings
  // --------

  $settings_off_canvas_content = [
    'k_pre'      => 'off_canvas_content',
    'group'      => $group_off_canvas_design,
    'conditions' => $conditions
  ];

  $settings_off_canvas_content_flexbox = [
    'toggle'       => 'off_canvas_content_flexbox',
    'group'        => $group_off_canvas_design,
    'conditions'   => $conditions
  ];


  // Individual Controls - Children
  // ------------------------------

  $control_off_canvas_children = [
    'type'  => 'sortable',
    'group' => $group_off_canvas_children
  ];


  // Individual Controls - Setup
  // ---------------------------

  $control_off_canvas_base_font_size     = cs_recall( 'control_mixin_font_size',  [ 'key' => 'off_canvas_base_font_size'                                                        ] );
  $control_off_canvas_content_text_align = cs_recall( 'control_mixin_text_align', [ 'key' => 'off_canvas_content_text_align'                                                    ] );
  $control_off_canvas_transition         = cs_recall( 'control_mixin_transition', [ 'keys' => [ 'duration' => 'off_canvas_duration', 'timing' => 'off_canvas_timing_function' ] ] );

  $control_off_canvas_body_scroll = [
    'key'     => 'off_canvas_body_scroll',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_body_scroll' ),
    'options' => cs_recall( 'options_choices_body_scroll' ),
  ];

  $control_off_canvas_location = [
    'key'     => 'off_canvas_location',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_location' ),
    'options' => $options_off_canvas_location,
  ];

  $control_off_canvas_content_overflow   = cs_recall( 'control_mixin_overflow',          [ 'key' => 'off_canvas_content_overflow'                                                                 ] );
  $control_off_canvas_content_bg_color   = cs_recall( 'control_mixin_bg_color_solo',     [ 'keys' => [ 'value' => 'off_canvas_content_bg_color' ]                                                 ] );
  $control_off_canvas_content_background = cs_recall( 'control_mixin_bg_color_solo_adv', [ 'keys' => [ 'value' => 'off_canvas_content_bg_color', 'checkbox' => 'off_canvas_content_bg_advanced' ] ] );


  // Individual Controls - Size
  // --------------------------

  $control_off_canvas_content_width      = cs_recall( 'control_mixin_width',      [ 'key' => 'off_canvas_content_width'     ] );
  $control_off_canvas_content_min_width  = cs_recall( 'control_mixin_min_width',  [ 'key' => 'off_canvas_content_min_width' ] );
  $control_off_canvas_content_max_width  = cs_recall( 'control_mixin_max_width',  [ 'key' => 'off_canvas_content_max_width' ] );


  // Individual Controls - Backdrop and Close
  // ----------------------------------------

  $control_off_canvas_bg_color   = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'off_canvas_bg_color' ], 'label' => cs_recall( 'label_backdrop' ) ] );
  $control_off_canvas_close_size = cs_recall( 'control_mixin_font_size', [ 'key' => 'off_canvas_close_font_size', 'label' => cs_recall( 'label_close_size' )            ] );

  $control_off_canvas_close_dimensions = [
    'key'     => 'off_canvas_close_dimensions',
    'type'    => 'select',
    'label'   => cs_recall( 'label_dimensions' ),
    'options' => cs_recall( 'options_choices_close_dimensions' ),
  ];

  $control_off_canvas_close_offset = [
    'key'     => 'off_canvas_close_offset',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_offset' ),
    'options' => $options_off_canvas_close_offset,
  ];

  $control_off_canvas_close_colors = cs_recall( 'control_mixin_color_int', [ 'keys' => [ 'value' => 'off_canvas_close_color', 'alt' => 'off_canvas_close_color_alt' ] ] );


  // Control List - Setup
  // --------------------

  $control_list_setup = [];

  if ( $is_layout_element === false ) {
    $control_list_setup = [
      $control_off_canvas_base_font_size,
      $control_off_canvas_content_max_width,
      $control_off_canvas_body_scroll,
      $control_off_canvas_transition,
      $control_off_canvas_content_bg_color,
    ];
  }

  if ( $is_layout_element === true ) {
    $control_list_setup = [
      $control_off_canvas_base_font_size,
      $control_off_canvas_content_text_align,
      $control_off_canvas_transition,
      $control_off_canvas_body_scroll,
      $control_off_canvas_location,
      $control_off_canvas_content_overflow,
      $control_off_canvas_content_background,
    ];
  }


  // Control List - Size
  // -------------------

  $control_list_size = [];

  if ( $is_layout_element === true ) {
    $control_list_size = [
      $control_off_canvas_content_width,
      $control_off_canvas_content_min_width,
      $control_off_canvas_content_max_width,
    ];
  }


  // Control List - Backdrop and Close
  // ---------------------------------

  $control_list_backdrop_and_close = [
    $control_off_canvas_bg_color,
    $control_off_canvas_close_size,
    $control_off_canvas_close_dimensions,
    $control_off_canvas_close_offset,
    $control_off_canvas_close_colors,
  ];


  // Compose Controls
  // ----------------

  $controls_before = [];
  $controls_after  = [];

  if ( $is_layout_element === true ) {
    $controls_before['controls'][] = $control_off_canvas_children;
  }

  $controls_before['controls'][] = [
    'type'       => 'group',
    'group'      => $group_off_canvas_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_setup
  ];

  $controls_bg = ( $is_layout_element === true ) ? cs_partial_controls( 'bg', [
    'group'     => $group_off_canvas_background_layers,
    'condition' => $condition_off_canvas_content_bg_advanced,
  ] ) : [];

  if ( $is_layout_element === true ) {
    $controls_after['controls'][] = [
      'type'       => 'group',
      'group'      => $group_off_canvas_size,
      'conditions' => $conditions,
      'controls'   => $control_list_size,
    ];
  }

  $controls_after['controls'][] = [
    'type'       => 'group',
    'group'      => $group_off_canvas_backdrop_and_close,
    'conditions' => $conditions,
    'controls'   => $control_list_backdrop_and_close,
  ];

  if ( $is_layout_element === true ) {
    $controls_after['controls'][] = cs_control( 'flexbox', 'off_canvas_content', $settings_off_canvas_content_flexbox );
  }

  $controls_after['controls'][] = cs_control( 'border', 'off_canvas_content', $settings_off_canvas_content );
  $controls_after['controls'][] = cs_control( 'box-shadow', 'off_canvas_content', $settings_off_canvas_content );

  if ( $add_custom_atts ) {
    $controls_after['controls'][] = [
      'key'        => 'off_canvas_custom_atts',
      'type'       => 'attributes',
      'group'      => 'omega:setup',
      'label'      => cs_recall( 'label_off_canvas_custom_attributes' ),
      'conditions' => $conditions,
    ];
  }

  $controls_after['control_nav'] = [
    $group                               => $group_title,
    $group_off_canvas_children           => cs_recall( 'label_children' ),
    $group_off_canvas_setup              => cs_recall( 'label_setup' ),
    $group_off_canvas_background_layers  => cs_recall( 'label_background_layers' ),
    $group_off_canvas_size               => cs_recall( 'label_size' ),
    $group_off_canvas_backdrop_and_close => cs_recall( 'label_backdrop_and_close' ),
    $group_off_canvas_design             => cs_recall( 'label_design' ),
  ];


  // Return Controls
  // ---------------

  return cs_compose_controls( $controls_before, $controls_bg, $controls_after );

}

cs_register_control_partial( 'off-canvas', 'x_control_partial_off_canvas' );
