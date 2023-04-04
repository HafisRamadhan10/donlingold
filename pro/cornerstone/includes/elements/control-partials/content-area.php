<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/CONTENT-AREA.PHP
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

function x_control_partial_content_area( $settings ) {

  // Setup
  // -----

  // 01. Available types:
  //     -- 'standard'
  //     -- 'dropdown'
  //     -- 'modal'
  //     -- 'off-canvas'

  $label_prefix = ( isset( $settings['label_prefix'] ) ) ? $settings['label_prefix'] : '';
  $k_pre        = ( isset( $settings['k_pre'] )        ) ? $settings['k_pre'] . '_'  : '';
  $group        = ( isset( $settings['group'] )        ) ? $settings['group']        : 'content_area';
  $group_title  = ( isset( $settings['group_title'] )  ) ? $settings['group_title']  : cs_recall( 'label_content_area' );
  $condition    = ( isset( $settings['condition'] )    ) ? $settings['condition']    : [];
  $type         = ( isset( $settings['type'] )         ) ? $settings['type']         : 'standard'; // 01


  // Groups
  // ------

  $group_content_area_setup  = $group . ':setup';
  $group_content_area_design = $group . ':design';


  // Individual Controls
  // -------------------

  $control_content_area_content = [
    'key'     => $k_pre . 'content',
    'type'    => 'text-editor',
    'label'   => cs_recall( 'label_content' ),
    'group'   => $group_content_area_setup,
    'options' => [
      'mode'   => 'html',
      'height' => $type != 'standard' ? 4 : 5,
    ],
  ];

  $control_content_area_dynamic_rendering = [
    'keys' => [
      'dynamic_rendering' => $k_pre . 'content_dynamic_rendering',
    ],
    'type'    => 'checkbox-list',
    'label'   => cs_recall( 'label_dynamic_rendering' ),
    'group'   => $group_content_area_setup,
    'options' => [
      'list' => [
        [ 'key' => 'dynamic_rendering', 'label' => cs_recall( 'label_load_reset_on_element_toggle' ), 'full' => true ],
      ],
    ],
  ];


  // Control Groups
  // --------------

  $controls_content_area = [];

  if ( $type != 'standard' ) {

    $controls_content_area[] = [
      'type'       => 'group',
      'label'      => cs_recall( 'label_content_with_prefix' ),
      'label_vars' => [ 'prefix' => $label_prefix ],
      'group'      => $group_content_area_setup,
      'controls'   => [
        $control_content_area_content,
        $control_content_area_dynamic_rendering,
      ],
    ];

  } else {

    $controls_content_area[] = $control_content_area_content;
    $controls_content_area[] = cs_control( 'margin', 'content', [ 'group' => $group_content_area_design ] );

  }


  // Control Nav
  // -----------

  $control_nav_content_area = [
    $group                     => $group_title,
    $group_content_area_setup  => cs_recall( 'label_setup' ),
    $group_content_area_design => cs_recall( 'label_design' ),
  ];

  if ( $type == 'standard' ) {
    $control_nav_content_area[$group_content_area_design] = cs_recall( 'label_design' );
  }


  // Compose Controls
  // ----------------

  return [
    'controls'    => $controls_content_area,
    'control_nav' => $control_nav_content_area
  ];
}

cs_register_control_partial( 'content-area', 'x_control_partial_content_area' );
