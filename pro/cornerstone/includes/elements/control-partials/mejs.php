<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/MEJS.PHP
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

function x_control_partial_mejs( $settings ) {

  // Setup
  // -----
  // 01. Available types:
  //     -- 'audio'
  //     -- 'video'

  $label_prefix = ( isset( $settings['label_prefix'] ) ) ? $settings['label_prefix'] : '';
  $group        = ( isset( $settings['group'] )        ) ? $settings['group']        : 'mejs';
  $conditions   = ( isset( $settings['conditions'] )   ) ? $settings['conditions']   : [];
  $type         = ( isset( $settings['type'] )         ) ? $settings['type']         : 'audio'; // 01

  $type_label = '';

  if ( $type === 'audio' ) {
    $type_label = cs_recall( 'label_audio' );
  } elseif ( $type === 'video' ) {
    $type_label = cs_recall( 'label_video' );
  }


  // Groups
  // ------

  $group_controls  = $group . ':controls';
  $group_time_rail = $group . ':time-rail';


  // MEJS Key and Control Prep
  // -------------------------

  $keys_mejs_display_and_function = [
    'hide_controls'     => 'mejs_hide_controls',
    'advanced_controls' => 'mejs_advanced_controls',
    'autoplay'          => 'mejs_autoplay',
    'loop'              => 'mejs_loop',
    'muted'             => 'mejs_muted',
  ];

  $options_list_mejs_display_and_function = [
    [ 'key' => 'hide_controls',     'label' => cs_recall( 'label_no_controls' ) ],
    [ 'key' => 'advanced_controls', 'label' => cs_recall( 'label_advanced' )    ],
    [ 'key' => 'autoplay',          'label' => cs_recall( 'label_autoplay' )    ],
    [ 'key' => 'loop',              'label' => cs_recall( 'label_loop' )        ],
    [ 'key' => 'muted',             'label' => cs_recall( 'label_muted' )       ],
  ];

  if ( $type === 'audio' ) {
    array_shift( $keys_mejs_display_and_function );
    array_shift( $options_list_mejs_display_and_function );
    array_pop( $keys_mejs_display_and_function );
    array_pop( $options_list_mejs_display_and_function );
  }


  // Options
  // -------

  $options_mejs_video_controls_margin_lrb = [
    'available_units' => [ 'px', 'em', 'rem' ],
    'fallback_value'  => '10px',
    'valid_keywords'  => [ 'calc' ],
    'ranges'          => [
      'px'  => [ 'min' => 0, 'max' => 20, 'step' => 1    ],
      'em'  => [ 'min' => 0, 'max' => 1,  'step' => 0.01 ],
      'rem' => [ 'min' => 0, 'max' => 1,  'step' => 0.01 ],
    ],
  ];


  // Settings
  // --------

  $settings_mejs_controls = [
    'label_prefix' => cs_recall( 'label_controls' ),
    'group'        => $group_controls,
    'conditions'   => $conditions
  ];

  $settings_mejs_controls_time_rail = [
    'label_prefix' => cs_recall( 'label_time_rail' ),
    'group'        => $group_time_rail,
    'conditions'   => $conditions
  ];

  $settings_mejs_video_controls_margin = [
    'label_prefix' => cs_recall( 'label_controls' ),
    'group'        => $group_controls,
    'conditions'   => $conditions,
    'options'      => [
      'top' => [
        'disabled'       => true,
        'valid_keywords' => [ 'auto' ],
        'fallback_value' => 'auto',
      ],
      'left'   => $options_mejs_video_controls_margin_lrb,
      'right'  => $options_mejs_video_controls_margin_lrb,
      'bottom' => $options_mejs_video_controls_margin_lrb,
    ],
  ];


  // Individual Controls
  // -------------------

  $control_mejs_preload = [
    'key'     => 'mejs_preload',
    'type'    => 'select',
    'label'   => cs_recall( 'label_preload' ),
    'options' => [
      'choices' => [
        [ 'value' => 'none',     'label' => cs_recall( 'label_none' )     ],
        [ 'value' => 'auto',     'label' => cs_recall( 'label_auto' )     ],
        [ 'value' => 'metadata', 'label' => cs_recall( 'label_metadata' ) ],
      ],
    ],
  ];

  $control_mejs_display_and_function = [
    'keys'    => $keys_mejs_display_and_function,
    'type'    => 'checkbox-list',
    'label'   => cs_recall( 'label_options' ),
    'options' => [
      'list' => $options_list_mejs_display_and_function,
    ],
  ];

  $control_mejs_button_color          = cs_recall( 'control_mixin_color_int',     [ 'keys' => [ 'value' => 'mejs_controls_button_color', 'alt' => 'mejs_controls_button_color_alt' ], 'label' => cs_recall( 'label_icons' ) ] );
  $control_mejs_controls_color        = cs_recall( 'control_mixin_color_solo',    [ 'keys' => [ 'value' => 'mejs_controls_color' ], 'label' => cs_recall( 'label_text' )                                                    ] );
  $control_mejs_time_total_bg_color   = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'mejs_controls_time_total_bg_color' ], 'label' => cs_recall( 'label_total' )                                     ] );
  $control_mejs_time_loaded_bg_color  = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'mejs_controls_time_loaded_bg_color' ], 'label' => cs_recall( 'label_loaded' )                                   ] );
  $control_mejs_time_current_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'mejs_controls_time_current_bg_color' ], 'label' => cs_recall( 'label_current' )                                 ] );
  $control_mejs_controls_bg_color     = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'mejs_controls_bg_color' ]                                                                                       ] );


  // Control Lists
  // -------------

  $control_list_mejs_controls = [
    $control_mejs_preload,
    $control_mejs_display_and_function,
    $control_mejs_button_color,
    $control_mejs_controls_color,
    $control_mejs_controls_bg_color,
  ];

  $control_list_mejs_time_rail = [
    $control_mejs_time_total_bg_color,
    $control_mejs_time_loaded_bg_color,
    $control_mejs_time_current_bg_color,
  ];


  // Control Groups
  // --------------

  $control_group_mejs_controls = [
    'type'       => 'group',
    'label_vars' => [ 'prefix' => $label_prefix ],
    'group'      => $group_controls,
    'conditions' => $conditions,
    'controls'   => $control_list_mejs_controls,
    'options'    => [
      'vertical_label'   => '',
      'horizontal_label' => cs_recall( 'label_controls_setup_with_prefix' ),
    ],
  ];

  $control_group_mejs_time_rail = [
    'type'       => 'group',
    'label_vars' => [ 'prefix' => $label_prefix ],
    'group'      => $group_time_rail,
    'conditions' => $conditions,
    'controls'   => $control_list_mejs_time_rail,
    'options'    => [
      'vertical_label'   => '',
      'horizontal_label' => cs_recall( 'label_time_rail_setup_with_prefix' ),
    ],
  ];


  // Compose Controls
  // ----------------

  $controls[] = $control_group_mejs_controls;

  if ( $type === 'video' ) {
    $controls[] = cs_control( 'margin', 'mejs_controls', $settings_mejs_video_controls_margin );
  }

  return [
    'controls' => array_merge( $controls, [
      cs_control( 'padding',       'mejs_controls', $settings_mejs_controls ),
      cs_control( 'border',        'mejs_controls', $settings_mejs_controls ),
      cs_control( 'border-radius', 'mejs_controls', $settings_mejs_controls ),
      cs_control( 'box-shadow',    'mejs_controls', $settings_mejs_controls ),
      $control_group_mejs_time_rail,
      cs_control( 'border-radius', 'mejs_controls_time_rail', $settings_mejs_controls_time_rail ),
      cs_control( 'box-shadow',    'mejs_controls_time_rail', $settings_mejs_controls_time_rail ),
    ] ),
    'control_nav' => [
      $group_controls  => cs_recall( 'label_controls' ),
      $group_time_rail => cs_recall( 'label_time_rail' ),
    ]
  ];
}

cs_register_control_partial( 'mejs', 'x_control_partial_mejs' );
