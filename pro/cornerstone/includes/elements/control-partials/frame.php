<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/FRAME.PHP
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

function x_control_partial_frame( $settings ) {

  // Setup
  // -----

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'frame';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : cs_recall( 'label_frame' );
  $conditions  = ( isset( $settings['conditions'] )  ) ? $settings['conditions']  : [];


  // Groups
  // ------

  $group_frame_setup  = $group . ':setup';
  $group_frame_size   = $group . ':size';
  $group_frame_design = $group . ':design';


  // Conditions
  // ----------

  $conditions_frame_border_color = array_merge( $conditions, [ [ 'key' => 'frame_border_width', 'op' => 'NOT EMPTY' ], [ 'key' => 'frame_border_width', 'op' => 'NOT EMPTY' ] ] );


  // Options
  // -------

  $options_frame_content_sizing = [
    'choices' => [
      [ 'value' => 'aspect-ratio', 'label' => cs_recall( 'label_ratio' ) ],
      [ 'value' => 'fixed-height', 'label' => cs_recall( 'label_unit' ) ],
    ],
  ];


  // Settings
  // --------

  $settings_frame = [
    'group'      => $group_frame_design,
    'conditions' => $conditions,
  ];


  // Individual Controls (Setup)
  // ---------------------------

  $control_frame_base_font_size = cs_recall( 'control_mixin_font_size', [ 'key' => 'frame_base_font_size'               ] );
  $control_frame_bg_color       = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'frame_bg_color' ] ] );


  // Individual Controls (Size)
  // --------------------------

  $control_frame_content_sizing = [
    'key'     => 'frame_content_sizing',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_content_height' ),
    'options' => $options_frame_content_sizing,
  ];

  $control_frame_width          = cs_recall( 'control_mixin_width',     [ 'key' => 'frame_width'                                                                                                         ] );
  $control_frame_max_width      = cs_recall( 'control_mixin_max_width', [ 'key' => 'frame_max_width'                                                                                                     ] );
  $control_frame_content_height = cs_recall( 'control_mixin_max_width', [ 'key' => 'frame_content_height', 'label' => cs_recall( 'label_height' ), 'condition' => [ 'frame_content_sizing' => 'fixed-height' ] ] );

  $control_frame_content_aspect_ratio = [
    'keys' => [
      'width'  => 'frame_content_aspect_ratio_width',
      'height' => 'frame_content_aspect_ratio_height',
    ],
    'type'      => 'aspect-ratio',
    'label'     => cs_recall( 'label_ratio' ),
    'condition' => [ 'frame_content_sizing' => 'aspect-ratio' ]
  ];


  // Compose Controls
  // ----------------

  return [
    'controls' => [
      [
        'type'       => 'group',
        'group'      => $group_frame_setup,
        'conditions' => $conditions,
        'controls'   => [
          $control_frame_base_font_size,
          $control_frame_bg_color,
        ],
      ],
      [
        'type'       => 'group',
        'group'      => $group_frame_size,
        'conditions' => $conditions,
        'controls'   => [
          $control_frame_content_sizing,
          $control_frame_width,
          $control_frame_max_width,
          $control_frame_content_height,
          $control_frame_content_aspect_ratio,
        ],
      ],
      cs_control( 'margin', 'frame', $settings_frame ),
      cs_control( 'padding', 'frame', $settings_frame ),
      cs_control( 'border', 'frame', $settings_frame ),
      cs_control( 'border-radius', 'frame', $settings_frame ),
      cs_control( 'box-shadow', 'frame', $settings_frame )
    ],
    'control_nav' => [
      $group              => $group_title,
      $group_frame_setup  => cs_recall( 'label_setup' ),
      $group_frame_size   => cs_recall( 'label_size' ),
      $group_frame_design => cs_recall( 'label_design' ),
    ]
  ];
}

cs_register_control_partial( 'frame', 'x_control_partial_frame' );
