<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/TOGGLE.PHP
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

function x_control_partial_toggle( $settings ) {

  // Setup
  // -----

  $label_prefix     = ( isset( $settings['label_prefix'] )     ) ? $settings['label_prefix']     : '';
  $k_pre            = ( isset( $settings['k_pre'] )            ) ? $settings['k_pre'] . '_'      : '';
  $group            = ( isset( $settings['group'] )            ) ? $settings['group']            : 'general';
  $conditions       = ( isset( $settings['conditions'] )       ) ? $settings['conditions']       : [];


  // Conditions
  // ----------

  $condition_toggle_is_burger = [ 'key' => $k_pre . 'toggle_type', 'op' => 'IN', 'value' => [ 'burger-1' ]             ];
  $condition_toggle_is_grid   = [ 'key' => $k_pre . 'toggle_type', 'op' => 'IN', 'value' => [ 'grid-1' ]               ];
  $condition_toggle_is_more   = [ 'key' => $k_pre . 'toggle_type', 'op' => 'IN', 'value' => [ 'more-h-1', 'more-v-1' ] ];


  // Options
  // -------

  $options_toggle_type = [
    'choices' => [
      [ 'value' => 'burger-1', 'label' => cs_recall( 'label_burger' )          ],
      [ 'value' => 'grid-1',   'label' => cs_recall( 'label_grid' )            ],
      [ 'value' => 'more-h-1', 'label' => cs_recall( 'label_more_horizontal' ) ],
      [ 'value' => 'more-v-1', 'label' => cs_recall( 'label_more_vertical' )   ],
    ],
  ];

  $options_toggle_size = [
    'available_units' => [ 'px', 'em', 'rem' ],
    'ranges'          => [
      'px'  => [ 'min' => 1,   'max' => 10, 'step' => 1     ],
      'em'  => [ 'min' => 0.1, 'max' => 1,  'step' => 0.001 ],
      'rem' => [ 'min' => 0.1, 'max' => 1,  'step' => 0.001 ],
    ],
  ];

  $options_toggle_spacing = [
    'available_units' => [ 'px', 'em', 'rem' ],
    'ranges'          => [
      'px'  => [ 'min' => 1, 'max' => 15, 'step' => 1   ],
      'em'  => [ 'min' => 1, 'max' => 10, 'step' => 0.1 ],
      'rem' => [ 'min' => 1, 'max' => 10, 'step' => 0.1 ],
    ],
  ];

  $options_toggle_burger_width = [
    'available_units' => [ 'px', 'em', 'rem' ],
    'ranges'          => [
      'px'  => [ 'min' => 1, 'max' => 50, 'step' => 1   ],
      'em'  => [ 'min' => 1, 'max' => 20, 'step' => 0.1 ],
      'rem' => [ 'min' => 1, 'max' => 20, 'step' => 0.1 ],
    ],
  ];


  // Individual Controls - Type
  // --------------------------

  $control_toggle_type = [
    'key'     => $k_pre . 'toggle_type',
    'type'    => 'select',
    'label'   => cs_recall( 'label_type' ),
    'options' => $options_toggle_type,
  ];


  // Individual Controls - Burger
  // ----------------------------

  $control_toggle_burger_size = [
    'key'       => $k_pre . 'toggle_burger_size',
    'type'      => 'unit-slider',
    'label'     => cs_recall( 'label_size' ),
    'condition' => $condition_toggle_is_burger,
    'options'   => $options_toggle_size,
  ];

  $control_toggle_burger_spacing = [
    'key'       => $k_pre . 'toggle_burger_spacing',
    'type'      => 'unit-slider',
    'label'     => cs_recall( 'label_spacing' ),
    'condition' => $condition_toggle_is_burger,
    'options'   => $options_toggle_spacing,
  ];

  $control_toggle_burger_width = [
    'key'       => $k_pre . 'toggle_burger_width',
    'type'      => 'unit-slider',
    'label'     => cs_recall( 'label_width' ),
    'condition' => $condition_toggle_is_burger,
    'options'   => $options_toggle_burger_width,
  ];


  // Individual Controls - Grid
  // --------------------------

  $control_toggle_grid_size = [
    'key'       => $k_pre . 'toggle_grid_size',
    'type'      => 'unit-slider',
    'label'     => cs_recall( 'label_size' ),
    'condition' => $condition_toggle_is_grid,
    'options'   => $options_toggle_size,
  ];

  $control_toggle_grid_spacing = [
    'key'       => $k_pre . 'toggle_grid_spacing',
    'type'      => 'unit-slider',
    'label'     => cs_recall( 'label_spacing' ),
    'condition' => $condition_toggle_is_grid,
    'options'   => $options_toggle_spacing,
  ];


  // Individual Controls - More
  // --------------------------

  $control_toggle_more_size = [
    'key'       => $k_pre . 'toggle_more_size',
    'type'      => 'unit-slider',
    'label'     => cs_recall( 'label_size' ),
    'condition' => $condition_toggle_is_more,
    'options'   => $options_toggle_size,
  ];

  $control_toggle_more_spacing = [
    'key'       => $k_pre . 'toggle_more_spacing',
    'type'      => 'unit-slider',
    'label'     => cs_recall( 'label_spacing' ),
    'condition' => $condition_toggle_is_more,
    'options'   => $options_toggle_spacing,
  ];


  // Individual Controls - Colors
  // ----------------------------

  $control_toggle_color = cs_recall( 'control_mixin_color_int', [ 'keys' => [ 'value' => $k_pre . 'toggle_color', 'alt' => $k_pre . 'toggle_color_alt' ] ] );


  // Compose Controls
  // ----------------

  return [
    'controls' => [
      [
        'type'       => 'group',
        'label'      => cs_recall( 'label_toggle_with_prefix' ),
        'label_vars' => [ 'prefix' => $label_prefix ],
        'group'      => $group,
        'conditions' => $conditions,
        'controls'   => [
          $control_toggle_type,
          $control_toggle_burger_size,
          $control_toggle_burger_spacing,
          $control_toggle_burger_width,
          $control_toggle_grid_size,
          $control_toggle_grid_spacing,
          $control_toggle_more_size,
          $control_toggle_more_spacing,
          $control_toggle_color,
        ],
      ],
    ]
  ];
}

cs_register_control_partial( 'toggle', 'x_control_partial_toggle' );
