<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/IMAGE.PHP
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

function x_control_partial_image( $settings ) {

  // Setup
  // -----
  // 01. Available types:
  //     -- 'standard'
  //     -- 'scaling'

  $label_prefix = ( isset( $settings['label_prefix'] ) ) ? $settings['label_prefix'] : '';
  $k_pre        = ( isset( $settings['k_pre'] )        ) ? $settings['k_pre'] . '_'  : '';
  $group        = ( isset( $settings['group'] )        ) ? $settings['group']        : 'image';
  $group_title  = ( isset( $settings['group_title'] )  ) ? $settings['group_title']  : cs_recall( 'label_image' );
  $conditions   = ( isset( $settings['conditions'] )   ) ? $settings['conditions']   : [];
  $is_retina    = ( isset( $settings['is_retina'] )    ) ? $settings['is_retina']    : true;
  $width        = ( isset( $settings['width'] )        ) ? $settings['width']        : true;
  $height       = ( isset( $settings['height'] )       ) ? $settings['height']       : true;
  $has_link     = ( isset( $settings['has_link'] )     ) ? $settings['has_link']     : true;
  $alt_text     = ( isset( $settings['alt_text'] )     ) ? $settings['alt_text']     : true;
  $has_object   = ( isset( $settings['has_object'] )   ) ? $settings['has_object']   : true;


  // Groups
  // ------

  $group_image_source = $group . ':source';
  $group_image_setup  = $group . ':setup';
  $group_image_size   = $group . ':size';
  $group_image_design = $group . ':design';


  // Conditions
  // ----------

  $conditions_standard = array_merge( $conditions, [ [ 'image_type' => 'standard' ] ] );


  // Individual Controls - Setup
  // ---------------------------

  $control_image_font_size = cs_recall( 'control_mixin_font_size', [ 'key' => 'image_font_size' ] );

  $control_image_type = [
    'key'       => 'image_type',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_type' ),
    'condition' => [ '_region' => 'top' ],
    'options'   => [
      'choices' => [
        [ 'value' => 'standard', 'label' => cs_recall( 'label_standard' ) ],
        [ 'value' => 'scaling',  'label' => cs_recall( 'label_scaling' )  ],
      ],
    ],
  ];

  $control_image_display = [
    'key'     => 'image_display',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_display' ),
    'options' => cs_recall( 'options_choices_display' ),
  ];

  $control_image_bg_colors = cs_recall( 'control_mixin_bg_color_int', [
    'keys'       => [ 'value' => 'image_bg_color', 'alt' => 'image_bg_color_alt' ],
    'conditions' => $conditions_standard,
  ] );


  // Individual Controls - Size
  // --------------------------

  $control_image_styled_width      = cs_recall( 'control_mixin_width',      [ 'key' => 'image_styled_width', 'conditions' => $conditions_standard      ] );
  $control_image_styled_max_width  = cs_recall( 'control_mixin_max_width',  [ 'key' => 'image_styled_max_width', 'conditions' => $conditions_standard  ] );
  $control_image_styled_height     = cs_recall( 'control_mixin_height',     [ 'key' => 'image_styled_height', 'conditions' => $conditions_standard     ] );
  $control_image_styled_max_height = cs_recall( 'control_mixin_max_height', [ 'key' => 'image_styled_max_height', 'conditions' => $conditions_standard ] );


  // Image Keys
  // ----------

  $settings_image_keys = [
    'img_source' => $k_pre . 'image_src',
  ];

  if ( $is_retina === true ) {
    $settings_image_keys['is_retina'] = $k_pre . 'image_retina';
  }

  if ( $width === true ) {
    $settings_image_keys['width'] = $k_pre . 'image_width';
  }

  if ( $height === true ) {
    $settings_image_keys['height'] = $k_pre . 'image_height';
  }

  if ( $alt_text === true ) {
    $settings_image_keys['alt_text'] = $k_pre . 'image_alt';
  }

  if ( $has_object === true ) {
    $settings_image_keys['object_fit']      = $k_pre . 'image_object_fit';
    $settings_image_keys['object_position'] = $k_pre . 'image_object_position';
  }


  // Compose Controls
  // ----------------

  $controls = [
    [
      'keys'       => $settings_image_keys,
      'type'       => 'image',
      'label_vars' => [ 'prefix' => $label_prefix ],
      'group'      => $group_image_source,
      'conditions' => $conditions,
    ],
    [
      'type'       => 'group',
      'group'      => $group_image_setup,
      'conditions' => $conditions,
      'controls'   => [
        $control_image_font_size,
        $control_image_type,
        $control_image_display,
        $control_image_bg_colors,
      ],
    ],
  ];

  if ( $has_link === true ) {
    $controls[] = [
      'keys' => [
        'url'      => $k_pre . 'image_href',
        'new_tab'  => $k_pre . 'image_blank',
        'nofollow' => $k_pre . 'image_nofollow',
        'toggle'   => $k_pre . 'image_link'
      ],
      'type'       => 'link',
      'label'      => cs_recall( 'label_link_with_prefix' ),
      'label_vars' => [ 'prefix' => $label_prefix ],
      'options'    => cs_recall('options_group_toggle_off_on_bool'),
      'group'      => $group_image_setup,
      'conditions' => $conditions,
    ];
  }

  $controls = array_merge(
    $controls,
    [
      [
        'type'       => 'group',
        'group'      => $group_image_size,
        'conditions' => $conditions,
        'controls'   => [
          $control_image_styled_width,
          $control_image_styled_max_width,
          $control_image_styled_height,
          $control_image_styled_max_height,
        ],
      ],
      cs_control( 'margin', 'image', [
        'group'      => $group_image_design,
        'conditions' => $conditions_standard,
      ] ),
      cs_control( 'padding', 'image', [
        'group'      => $group_image_design,
        'conditions' => $conditions_standard,
      ] ),
      cs_control( 'border', 'image', [
        'group'      => $group_image_design,
        'conditions' => $conditions_standard,
        'alt_color'  => true,
        'options'    => cs_recall( 'options_color_swatch_base_interaction_labels' ),
      ] ),
      cs_control( 'border-radius', 'image_outer', [
        'label_prefix'      => cs_recall( 'label_outer' ),
        'group'             => $group_image_design,
        'conditions'        => $conditions_standard,
        'prefix_horizontal' => true
      ] ),
      cs_control( 'border-radius', 'image_inner', [
        'label_prefix'      => cs_recall( 'label_inner' ),
        'group'             => $group_image_design,
        'conditions'        => $conditions_standard,
        'prefix_horizontal' => true
      ] ),
      cs_control( 'box-shadow', 'image', [
        'group'      => $group_image_design,
        'conditions' => $conditions_standard,
        'alt_color'  => true,
        'options'    => cs_recall( 'options_color_swatch_base_interaction_labels' ),
      ] )
    ]
  );

  return [
    'controls'    => $controls,
    'control_nav' => [
      $group              => $group_title,
      $group_image_source => cs_recall( 'label_source' ),
      $group_image_setup  => cs_recall( 'label_setup' ),
      $group_image_size   => cs_recall( 'label_size' ),
      $group_image_design => cs_recall( 'label_design' ),
    ]
  ];
}

cs_register_control_partial( 'image', 'x_control_partial_image' );
