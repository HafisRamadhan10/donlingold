<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/SEARCH.PHP
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

function x_control_partial_search( $settings ) {

  // Setup
  // -----

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'search';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : cs_recall( 'label_search' );
  $conditions  = ( isset( $settings['conditions'] )  ) ? $settings['conditions']  : [];


  // Groups
  // ------

  $group_search_setup   = $group . ':setup';
  $group_search_size    = $group . ':size';
  $group_search_design  = $group . ':design';
  $group_search_input   = $group . ':input';
  $group_search_submit  = $group . ':submit';
  $group_search_clear   = $group . ':clear';


  // Options
  // -------

  $options_search_icons_stroke_width = [
    'choices' => [
      [ 'value' => 1, 'label' => '1' ],
      [ 'value' => 2, 'label' => '2' ],
      [ 'value' => 3, 'label' => '3' ],
      [ 'value' => 4, 'label' => '4' ],
    ],
  ];

  $options_search_button_dimensions = [
    'available_units' => [ 'px', 'em', 'rem' ],
    'fallback_value'  => '1em',
  ];


  // Settings
  // --------

  $settings_search_design = [
    'group'      => $group_search_design,
    'conditions' => $conditions,
    'alt_color'  => true,
    'options'    => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  ];

  $settings_search_design_no_options = [
    'group'      => $group_search_design,
    'conditions' => $conditions,
  ];

  $settings_search_input = [
    'label_prefix' => cs_recall( 'label_input' ),
    'group'        => $group_search_input,
    'conditions'   => $conditions,
    'alt_color'    => true,
    'options'      => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  ];

  $settings_search_submit = [
    'label_prefix' => cs_recall( 'label_submit' ),
    'group'        => $group_search_submit,
    'conditions'   => $conditions,
    'alt_color'    => true,
    'options'      => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  ];

  $settings_search_clear = [
    'label_prefix' => cs_recall( 'label_clear' ),
    'group'        => $group_search_clear,
    'conditions'   => $conditions,
    'alt_color'    => true,
    'options'      => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  ];


  // Individual Controls (Setup)
  // ---------------------------

  $control_search_base_font_size = cs_recall( 'control_mixin_font_size',    [ 'key' => 'search_base_font_size'                                           ] );
  $control_search_width          = cs_recall( 'control_mixin_width',        [ 'key' => 'search_width'                                                    ] );
  $control_search_max_width      = cs_recall( 'control_mixin_max_width',    [ 'key' => 'search_max_width'                                                ] );
  $control_search_height         = cs_recall( 'control_mixin_height',       [ 'key' => 'search_height'                                                   ] );
  $control_search_bg_color       = cs_recall( 'control_mixin_bg_color_int', [ 'keys' => [ 'value' => 'search_bg_color', 'alt' => 'search_bg_color_alt' ] ] );


  // Individual Controls (Content)
  // -----------------------------

  $control_search_placeholder = [
    'key'   => 'search_placeholder',
    'type'  => 'text',
    'label' => cs_recall( 'label_placeholder' ),
  ];

  $control_search_order_input  = cs_recall( 'control_mixin_1_2_3_placement', [ 'key' => 'search_order_input', 'label' => cs_recall( 'label_input_placement' )   ] );
  $control_search_order_submit = cs_recall( 'control_mixin_1_2_3_placement', [ 'key' => 'search_order_submit', 'label' => cs_recall( 'label_submit_placement' ) ] );
  $control_search_order_clear  = cs_recall( 'control_mixin_1_2_3_placement', [ 'key' => 'search_order_clear', 'label' => cs_recall( 'label_clear_placement' )   ] );


  // Individual Controls (Submit)
  // ----------------------------

  $control_search_submit_font_size = cs_recall( 'control_mixin_font_size', [ 'key' => 'search_submit_font_size' ] );
  $control_search_submit_width     = cs_recall( 'control_mixin_width',     [ 'key' => 'search_submit_width'     ] );
  $control_search_submit_height    = cs_recall( 'control_mixin_height',    [ 'key' => 'search_submit_height'    ] );

  $control_search_submit_stroke_width = [
    'key'     => 'search_submit_stroke_width',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_stroke' ),
    'options' => $options_search_icons_stroke_width,
  ];

  $control_search_submit_colors    = cs_recall( 'control_mixin_color_int',    [ 'keys' => [ 'value' => 'search_submit_color', 'alt' => 'search_submit_color_alt' ]       ] );
  $control_search_submit_bg_colors = cs_recall( 'control_mixin_bg_color_int', [ 'keys' => [ 'value' => 'search_submit_bg_color', 'alt' => 'search_submit_bg_color_alt' ] ] );


  // Individual Controls (Clear)
  // ---------------------------

  $control_search_clear_font_size = cs_recall( 'control_mixin_font_size', [ 'key' => 'search_clear_font_size' ] );
  $control_search_clear_width     = cs_recall( 'control_mixin_width',     [ 'key' => 'search_clear_width'     ] );
  $control_search_clear_height    = cs_recall( 'control_mixin_height',    [ 'key' => 'search_clear_height'    ] );

  $control_search_clear_stroke_width = [
    'key'     => 'search_clear_stroke_width',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_stroke' ),
    'options' => $options_search_icons_stroke_width,
  ];

  $control_search_clear_colors    = cs_recall( 'control_mixin_color_int',    [ 'keys' => [ 'value' => 'search_clear_color', 'alt' => 'search_clear_color_alt' ]       ] );
  $control_search_clear_bg_colors = cs_recall( 'control_mixin_bg_color_int', [ 'keys' => [ 'value' => 'search_clear_bg_color', 'alt' => 'search_clear_bg_color_alt' ] ] );


  // Compose Controls
  // ----------------

  return [
    'controls' => [
      [
        'type'       => 'group',
        'group'      => $group_search_setup,
        'conditions' => $conditions,
        'controls'   => [
          $control_search_base_font_size,
          $control_search_placeholder,
          $control_search_order_input,
          $control_search_order_submit,
          $control_search_order_clear,
          $control_search_bg_color,
        ],
      ],
      [
        'type'       => 'group',
        'group'      => $group_search_size,
        'conditions' => $conditions,
        'controls'   => [
          $control_search_width,
          $control_search_max_width,
          $control_search_height,
        ],
      ],

      cs_control( 'margin', 'search', $settings_search_design_no_options ),
      cs_control( 'border', 'search', $settings_search_design ),
      cs_control( 'border-radius', 'search', $settings_search_design_no_options ),
      cs_control( 'box-shadow', 'search', $settings_search_design ),

      cs_control( 'margin', 'search_input', $settings_search_input ),
      cs_control( 'text-format', 'search_input', $settings_search_input ),


      [
        'type'       => 'group',
        'group'      => $group_search_submit,
        'conditions' => $conditions,
        'controls'   => [
          $control_search_submit_font_size,
          $control_search_submit_width,
          $control_search_submit_height,
          $control_search_submit_stroke_width,
          $control_search_submit_colors,
          $control_search_submit_bg_colors,
        ],
      ],


      cs_control( 'margin', 'search_submit', $settings_search_submit ),
      cs_control( 'border', 'search_submit', $settings_search_submit ),
      cs_control( 'border-radius', 'search_submit', $settings_search_submit ),
      cs_control( 'box-shadow', 'search_submit', $settings_search_submit ),

      [
        'type'       => 'group',
        'group'      => $group_search_clear,
        'conditions' => $conditions,
        'controls'   => [
          $control_search_clear_font_size,
          $control_search_clear_width,
          $control_search_clear_height,
          $control_search_clear_stroke_width,
          $control_search_clear_colors,
          $control_search_clear_bg_colors,
        ],
      ],
      cs_control( 'margin', 'search_clear', $settings_search_clear ),
      cs_control( 'border', 'search_clear', $settings_search_clear ),
      cs_control( 'border-radius', 'search_clear', $settings_search_clear ),
      cs_control( 'box-shadow', 'search_clear', $settings_search_clear ),
      [
        'key'        => 'search_custom_atts',
        'type'       => 'attributes',
        'group'      => 'omega:setup',
        'label'      => cs_recall( 'label_custom_attributes_with_prefix' ),
        'label_vars' => [ 'prefix' => cs_recall( 'label_search' ) ]
      ]
    ],
    'control_nav' => [
      $group               => $group_title,
      $group_search_setup  => cs_recall( 'label_setup' ),
      $group_search_size   => cs_recall( 'label_size' ),
      $group_search_design => cs_recall( 'label_design' ),
      $group_search_input  => cs_recall( 'label_input' ),
      $group_search_submit => cs_recall( 'label_submit' ),
      $group_search_clear  => cs_recall( 'label_clear' ),
    ]
  ];
}

cs_register_control_partial( 'search', 'x_control_partial_search' );
