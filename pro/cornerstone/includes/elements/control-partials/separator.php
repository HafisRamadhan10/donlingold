<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/SEPARATOR.PHP
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

function x_control_partial_separator( $settings ) {

  // Setup
  // -----

  $label      = ( isset( $settings['label'] )      ) ? $settings['label']        : '';
  $k_pre      = ( isset( $settings['k_pre'] )      ) ? $settings['k_pre'] . '_'  : '';
  $group      = ( isset( $settings['group'] )      ) ? $settings['group']        : 'design';
  $conditions = ( isset( $settings['conditions'] ) ) ? $settings['conditions']   : [];
  $location   = ( isset( $settings['location'] )   ) ? $settings['location']     : 'top';


  // Individual Controls
  // -------------------

  $control_separator_type = [
    'key'       => $k_pre . 'separator_type',
    'type'      => 'select',
    'label'     => cs_recall( 'label_type' ),
    'condition' => [ $k_pre . 'separator' => true ],
    'options'   => [
      'choices' => [
        [ 'value' => 'angle-in',  'label' => __( 'Angle In', '__x__' )  ],
        [ 'value' => 'angle-out', 'label' => __( 'Angle Out', '__x__' ) ],
        [ 'value' => 'curve-in',  'label' => __( 'Curve In', '__x__' )  ],
        [ 'value' => 'curve-out', 'label' => __( 'Curve Out', '__x__' ) ],
      ],
    ],
  ];

  $control_separator_angle_point = [
    'key'        => $k_pre . 'separator_angle_point',
    'type'       => 'unit-slider',
    'label'      => __( 'Point Align', '__x__' ),
    'conditions' => [ [ $k_pre . 'separator' => true ], [ 'key' => $k_pre . 'separator_type', 'op' => 'IN', 'value' => [ 'angle-in', 'angle-out' ] ] ],
    'options'    => [
      'unit_mode'       => 'unitless',
      'fallback_value'  => '50',
      'min'             => 0,
      'max'             => 100,
      'step'            => 1,
    ],
  ];

  $control_separator_height = [
    'key'     => $k_pre . 'separator_height',
    'type'    => 'unit-slider',
    'label'   => cs_recall( 'label_height' ),
    'options' => [
      'available_units' => [ 'px', 'em', 'rem' ],
      'valid_keywords'  => [ 'calc' ],
      'fallback_value'  => '50px',
      'ranges'          => [
        'px'  => [ 'min' => 50,  'max' => 150, 'step' => 1   ],
        'em'  => [ 'min' => 2.5, 'max' => 10,  'step' => 0.5 ],
        'rem' => [ 'min' => 2.5, 'max' => 10,  'step' => 0.5 ],
      ],
    ],
  ];

  $control_separator_inset = [
    'key'     => $k_pre . 'separator_inset',
    'type'    => 'unit-slider',
    'label'   => cs_recall( 'label_inset' ),
    'options' => [
      'available_units' => [ 'px', 'em', 'rem' ],
      'valid_keywords'  => [ 'calc' ],
      'fallback_value'  => '0px',
      'ranges'          => [
        'px'  => [ 'min' => 0, 'max' => 3,    'step' => 1   ],
        'em'  => [ 'min' => 0, 'max' => 0.15, 'step' => 0.5 ],
        'rem' => [ 'min' => 0, 'max' => 0.15, 'step' => 0.5 ],
      ],
    ],
  ];

  $control_separator_color = [
    'key'       => $k_pre . 'separator_color',
    'type'      => 'color',
    'label'     => cs_recall( 'label_color' ),
    'condition' => [ $k_pre . 'separator' => true ],
    'options'   => [
      'label' => cs_recall( 'label_select' ),
    ],
  ];

  return [
    'controls' => [
      [
        'key'        => $k_pre . 'separator',
        'type'       => 'group',
        'label'      => $label,
        'group'      => $group,
        'options'    => cs_recall( 'options_group_toggle_off_on_bool' ),
        'conditions' => $conditions,
        'controls'   => [
          $control_separator_type,
          $control_separator_angle_point,
          $control_separator_height,
          $control_separator_inset,
          $control_separator_color,
        ],
      ],
    ]
  ];
}

cs_register_control_partial( 'separator', 'x_control_partial_separator' );
