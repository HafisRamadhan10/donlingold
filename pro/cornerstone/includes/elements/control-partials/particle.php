<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/PARTICLE.PHP
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

function x_control_partial_particle( $settings ) {

  // Setup
  // -----

  $label_prefix     = ( isset( $settings['label_prefix'] )     ) ? $settings['label_prefix']     : '';
  $k_pre            = ( isset( $settings['k_pre'] )            ) ? $settings['k_pre'] . '_'      : '';
  $group            = ( isset( $settings['group'] )            ) ? $settings['group']            : 'general';
  $conditions       = ( isset( $settings['conditions'] )       ) ? $settings['conditions']       : [];
  $has_interactions = ( isset( $settings['has_interactions'] ) ) ? $settings['has_interactions'] : false;


  // Condition
  // ---------

  $condition_particle_enabled = [ $k_pre . 'particle' => true ];


  // Options
  // -------

  $options_shared_available_units = [ 'px', 'em', 'rem', '%' ];
  $options_shared_valid_keywords  = [ 'calc' ];
  $options_shared_ranges          = [
    'px'  => [ 'min' => 0, 'max' => 200, 'step' => 1    ],
    'em'  => [ 'min' => 0, 'max' => 10,  'step' => 0.25 ],
    'rem' => [ 'min' => 0, 'max' => 10,  'step' => 1.25 ],
    '%'   => [ 'min' => 0, 'max' => 100, 'step' => 1    ],
  ];

  $options_particle_location = [
    'choices' => [
      [ 'value' => 'c_c', 'label' => cs_recall( 'label_center' )       ],
      [ 'value' => 't_c', 'label' => cs_recall( 'label_top' )          ],
      [ 'value' => 'c_l', 'label' => cs_recall( 'label_left' )         ],
      [ 'value' => 'c_r', 'label' => cs_recall( 'label_right' )        ],
      [ 'value' => 'b_c', 'label' => cs_recall( 'label_bottom' )       ],
      [ 'value' => 't_l', 'label' => cs_recall( 'label_top_left' )     ],
      [ 'value' => 't_r', 'label' => cs_recall( 'label_top_right' )    ],
      [ 'value' => 'b_l', 'label' => cs_recall( 'label_bottom_left' )  ],
      [ 'value' => 'b_r', 'label' => cs_recall( 'label_bottom_right' ) ],
    ]
  ];

  $options_particle_placement = [
    'choices' => [
      [ 'value' => 'inside',  'label' => cs_recall( 'label_inside' )  ],
      [ 'value' => 'overlap', 'label' => cs_recall( 'label_overlap' ) ],
    ]
  ];

  $options_particle_delay = [
    'unit_mode' => 'time',
  ];

  $options_particle_width = [
    'available_units' => $options_shared_available_units,
    'fallback_value'  => '100%',
    'valid_keywords'  => $options_shared_valid_keywords,
    'ranges'          => $options_shared_ranges,
  ];

  $options_particle_height = [
    'available_units' => $options_shared_available_units,
    'fallback_value'  => '3px',
    'valid_keywords'  => $options_shared_valid_keywords,
    'ranges'          => $options_shared_ranges,
  ];

  $options_particle_border_radius = [
    'available_units' => $options_shared_available_units,
    'fallback_value'  => '0px',
    'valid_keywords'  => $options_shared_valid_keywords,
    'ranges'          => $options_shared_ranges,
  ];

  $options_particle_scale = [
    'choices' => [
      [ 'value' => 'none',      'label' => cs_recall( 'label_off' ) ],
      [ 'value' => 'scale-x',   'label' => cs_recall( 'label_x' )   ],
      [ 'value' => 'scale-y',   'label' => cs_recall( 'label_y' )   ],
      [ 'value' => 'scale-x_y', 'label' => cs_recall( 'label_all' ) ],
    ]
  ];

  $options_particle_transform_origin = [
    'choices' => [
      [ 'value' => '50% 50%',   'label' => cs_recall( 'label_center' )       ],
      [ 'value' => '50% 0%',    'label' => cs_recall( 'label_top' )          ],
      [ 'value' => '0% 50%',    'label' => cs_recall( 'label_left' )         ],
      [ 'value' => '100% 50%',  'label' => cs_recall( 'label_right' )        ],
      [ 'value' => '50% 100%',  'label' => cs_recall( 'label_bottom' )       ],
      [ 'value' => '0% 0%',     'label' => cs_recall( 'label_top_left' )     ],
      [ 'value' => '100% 0%',   'label' => cs_recall( 'label_top_right' )    ],
      [ 'value' => '0% 100%',   'label' => cs_recall( 'label_bottom_left' )  ],
      [ 'value' => '100% 100%', 'label' => cs_recall( 'label_bottom_right' ) ],
    ]
  ];


  // Controls
  // --------

  $control_particle_location = [
    'key'       => $k_pre . 'particle_location',
    'type'      => 'select',
    'label'     => cs_recall( 'label_location' ),
    'condition' => $condition_particle_enabled,
    'options'   => $options_particle_location,
  ];

  $control_particle_placement = [
    'key'       => $k_pre . 'particle_placement',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_placement' ),
    'condition' => $condition_particle_enabled,
    'options'   => $options_particle_placement,
  ];

  $control_particle_width = [
    'key'       => $k_pre . 'particle_width',
    'type'      => 'unit-slider',
    'label'     => cs_recall( 'label_width' ),
    'condition' => $condition_particle_enabled,
    'options'   => $options_particle_width,
  ];

  $control_particle_height = [
    'key'       => $k_pre . 'particle_height',
    'type'      => 'unit-slider',
    'label'     => cs_recall( 'label_height' ),
    'condition' => $condition_particle_enabled,
    'options'   => $options_particle_height,
  ];

  $control_particle_border_radius = [
    'key'       => $k_pre . 'particle_border_radius',
    'type'      => 'unit-slider',
    'label'     => cs_recall( 'label_radius' ),
    'condition' => $condition_particle_enabled,
    'options'   => $options_particle_border_radius,
  ];

  $control_particle_color = [
    'keys'      => [ 'value' => $k_pre . 'particle_color' ],
    'type'      => 'color',
    'label'     => cs_recall( 'label_background' ),
    'condition' => $condition_particle_enabled,
    'options'   => [
      'label' => cs_recall( 'label_select' ),
    ],
  ];

  $control_particle_scale = [
    'key'       => $k_pre . 'particle_scale',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_scale' ),
    'condition' => $condition_particle_enabled,
    'options'   => $options_particle_scale,
  ];

  $control_particle_transform_origin = [
    'key'       => $k_pre . 'particle_transform_origin',
    'type'      => 'select',
    'label'     => cs_recall( 'label_origin' ),
    'condition' => $condition_particle_enabled,
    'options'   => $options_particle_transform_origin,
  ];

  $control_particle_delay = [
    'key'       => $k_pre . 'particle_delay',
    'type'      => 'unit-slider',
    'label'     => cs_recall( 'label_delay' ),
    'condition' => $condition_particle_enabled,
    'options'   => $options_particle_delay,
  ];

  $control_particle_style = [
    'key'       => $k_pre . 'particle_style',
    'type'      => 'textarea',
    'label'     => cs_recall( 'label_inline_css' ),
    'condition' => $condition_particle_enabled,
    'options'   => [
      'height' => 3,
    ],
  ];


  // Output
  // ------

  return [
    'controls' => [
      [
        'key'        => $k_pre . 'particle',
        'type'       => 'group',
        'label_vars' => [ 'prefix' => $label_prefix ],
        'group'      => $group,
        'conditions' => $conditions,
        'controls'   => [
          $control_particle_location,
          $control_particle_placement,
          $control_particle_width,
          $control_particle_height,
          $control_particle_border_radius,
          $control_particle_color,
          $control_particle_scale,
          $control_particle_transform_origin,
          $control_particle_delay,
          $control_particle_style,
        ],
        'options' => array_merge(
          cs_recall( 'options_group_toggle_off_on_bool' ),
          [
            'vertical_label'   => $label_prefix,
            'horizontal_label' => cs_recall( 'label_particle_with_prefix' ),
          ]
        ),
      ],
    ]
  ];
}

cs_register_control_partial( 'particle', 'x_control_partial_particle' );
