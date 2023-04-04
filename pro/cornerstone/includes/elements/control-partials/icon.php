<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/ICON.PHP
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

function x_control_partial_icon( $settings ) {

  // Setup
  // -----
  // 01. Available types:
  //     -- 'standard'
  //     -- 'graphic'

  $label_prefix = ( isset( $settings['label_prefix'] ) ) ? $settings['label_prefix'] : '';
  $k_pre        = ( isset( $settings['k_pre'] )        ) ? $settings['k_pre'] . '_'  : '';
  $group        = ( isset( $settings['group'] )        ) ? $settings['group']        : 'icon';
  $group_title  = ( isset( $settings['group_title'] )  ) ? $settings['group_title']  : cs_recall( 'label_icon' );
  $conditions   = ( isset( $settings['conditions'] )   ) ? $settings['conditions']   : [];
  $type         = ( isset( $settings['type'] )         ) ? $settings['type']         : 'standard'; // 01


  // Groups
  // ------

  $group_icon_setup   = $group . ':setup';
  $group_icon_size    = $group . ':size';
  $group_icon_design  = $group . ':design';


  // Settings
  // --------

  $settings_icon_design = [
    'group'      => $group_icon_design,
    'conditions' => $conditions,
    'alt_color'  => true,
    'options'    => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  ];


  // Individual Controls - Setup
  // ---------------------------

  $control_icon = [
    'key'   => $k_pre . 'icon',
    'type'  => 'icon',
    'label' => cs_recall( 'label_icon' ),
  ];

  $control_icon_font_size = cs_recall( 'control_mixin_font_size',    [ 'key' => $k_pre . 'icon_font_size'                                                       ] );
  $control_icon_color     = cs_recall( 'control_mixin_color_int',    [ 'keys' => [ 'value' => $k_pre . 'icon_color', 'alt' => $k_pre . 'icon_color_alt' ]       ] );
  $control_icon_bg_color  = cs_recall( 'control_mixin_bg_color_int', [ 'keys' => [ 'value' => $k_pre . 'icon_bg_color', 'alt' => $k_pre . 'icon_bg_color_alt' ] ] );


  // Individual Controls - Size
  // --------------------------

  $control_icon_width  = cs_recall( 'control_mixin_width',  [ 'key' => $k_pre . 'icon_width'  ] );
  $control_icon_height = cs_recall( 'control_mixin_height', [ 'key' => $k_pre . 'icon_height' ] );


  // Compose Controls
  // ----------------

  return [
    'controls' => [
      [
        'type'       => 'group',
        'group'      => $group_icon_setup,
        'conditions' => $conditions,
        'controls'   => [
          $control_icon_font_size,
          $control_icon,
          $control_icon_color,
          $control_icon_bg_color
        ],
      ],
      [
        'type'       => 'group',
        'group'      => $group_icon_size,
        'conditions' => $conditions,
        'controls'   => [
          $control_icon_width,
          $control_icon_height,
        ],
      ],
      cs_control( 'margin',        $k_pre . 'icon', $settings_icon_design ),
      cs_control( 'border',        $k_pre . 'icon', $settings_icon_design ),
      cs_control( 'border-radius', $k_pre . 'icon', $settings_icon_design ),
      cs_control( 'box-shadow',    $k_pre . 'icon', $settings_icon_design ),
      cs_control( 'text-shadow',   $k_pre . 'icon', $settings_icon_design )
    ],
    'control_nav' => [
      $group             => $group_title,
      $group_icon_setup  => cs_recall( 'label_setup' ) ,
      $group_icon_size   => cs_recall( 'label_size' ),
      $group_icon_design => cs_recall( 'label_design' ),
    ]
  ];
}

cs_register_control_partial( 'icon', 'x_control_partial_icon' );
