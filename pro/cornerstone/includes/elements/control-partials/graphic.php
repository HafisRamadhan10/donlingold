<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/GRAPHIC.PHP
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

function x_control_partial_graphic( $settings ) {

  // Setup
  // -----

  $label_prefix        = ( isset( $settings['label_prefix'] )        ) ? $settings['label_prefix']        : '';
  $k_pre               = ( isset( $settings['k_pre'] )               ) ? $settings['k_pre'] . '_'         : '';
  $group               = ( isset( $settings['group'] )               ) ? $settings['group']               : 'general';
  $conditions          = ( isset( $settings['conditions'] )          ) ? $settings['conditions']          : [];
  $has_interactions    = ( isset( $settings['has_interactions'] )    ) ? $settings['has_interactions']    : false;
  $has_alt             = ( isset( $settings['has_alt'] )             ) ? $settings['has_alt']             : false;
  $has_sourced_content = ( isset( $settings['has_sourced_content'] ) ) ? $settings['has_sourced_content'] : false;
  $has_toggle          = ( isset( $settings['has_toggle'] )          ) ? $settings['has_toggle']          : false;
  $controls_setup      = ( isset( $settings['controls_setup'] )      ) ? $settings['controls_setup']      : [];


  // Conditions
  // ----------

  $conditions_graphic_main      = array_merge( $conditions, [ [ $k_pre . 'graphic' => true ] ] );
  $conditions_graphic_icon      = array_merge( $conditions, [ [ $k_pre . 'graphic' => true ] ], [ [ $k_pre . 'graphic_type' => 'icon' ] ] );
  $conditions_graphic_icon_alt  = array_merge( $conditions, [ [ $k_pre . 'graphic' => true ] ], [ [ $k_pre . 'graphic_type' => 'icon' ] ], [ [ $k_pre . 'graphic_icon_alt_enable' => 'icon' ] ] );
  $conditions_graphic_image     = array_merge( $conditions, [ [ $k_pre . 'graphic' => true ] ], [ [ $k_pre . 'graphic_type' => 'image' ] ] );
  $conditions_graphic_image_alt = array_merge( $conditions, [ [ $k_pre . 'graphic' => true ] ], [ [ $k_pre . 'graphic_type' => 'image' ] ], [ [ $k_pre . 'graphic_image_alt_enable' => true ] ] );
  $conditions_graphic_toggle    = array_merge( $conditions, [ [ $k_pre . 'graphic' => true ] ], [ [ $k_pre . 'graphic_type' => 'toggle' ] ] );


  // Options
  // -------

  $options_graphic_type_choices = [
    [ 'value' => 'icon',  'icon' => 'ui:flag'  ],
    [ 'value' => 'image', 'icon' => 'ui:image' ],
  ];

  if ( $has_toggle ) {
    $options_graphic_type_choices[] = [ 'value' => 'toggle', 'icon' => 'ui:hamburger' ];
  }


  // Settings
  // --------

  $settings_graphic_icon_border_radius = [
    'label_prefix' => sprintf( cs_recall( 'label_graphic_icon_with_sprintf_prefix' ), $label_prefix ),
    'group'        => $group,
    'conditions'   => $conditions_graphic_icon,
  ];

  $settings_graphic_icon_variable_alt_color = [
    'label_prefix'     => sprintf( cs_recall( 'label_graphic_icon_with_sprintf_prefix' ), $label_prefix ),
    'group'            => $group,
    'conditions'       => $conditions_graphic_icon,
    'alt_color'        => $has_alt,
    'options'          => cs_recall( 'options_color_swatch_base_interaction_labels' )
  ];


  // Individual Controls - Setup
  // ---------------------------

  $control_graphic_type = [
    'key'        => $k_pre . 'graphic_type',
    'type'       => 'choose',
    'label'      => cs_recall( 'label_type' ),
    'conditions' => $conditions_graphic_main,
    'options'    => [
      'choices'  => $options_graphic_type_choices,
    ],
  ];

  $control_graphic_interaction = [
    'key'        => $k_pre . 'graphic_interaction',
    'type'       => 'select',
    'label'      => cs_recall( 'label_interaction' ),
    'conditions' => $conditions_graphic_main,
    'options'    => [
      'choices' => [
        [ 'value' => 'none',                'label' => cs_recall( 'label_none' )       ],
        [ 'value' => 'x-anchor-scale-up',   'label' => cs_recall( 'label_scale_up' )   ],
        [ 'value' => 'x-anchor-scale-down', 'label' => cs_recall( 'label_scale_down' ) ],
        [ 'value' => 'x-anchor-flip-x',     'label' => cs_recall( 'label_flip_x' )     ],
        [ 'value' => 'x-anchor-flip-y',     'label' => cs_recall( 'label_flip_y' )     ],
      ]
    ],
  ];


  // Individual Controls - Icon
  // --------------------------

  $control_graphic_icon_font_size = cs_recall( 'control_mixin_font_size',    [ 'key' => $k_pre . 'graphic_icon_font_size', 'label' => cs_recall( 'label_size' )                                                                                             ] );
  $control_graphic_icon_width     = cs_recall( 'control_mixin_width',        [ 'key' => $k_pre . 'graphic_icon_width', 'options' => cs_recall( 'options_graphic_icon' )                                                                                     ] );
  $control_graphic_icon_height    = cs_recall( 'control_mixin_height',       [ 'key' => $k_pre . 'graphic_icon_height', 'options' => array_merge( [ 'horizontal_offset' => 3 ], cs_recall( 'options_graphic_icon' ) )                                                                 ] );


  if ($has_alt) {
    $control_graphic_icon_color     = cs_recall( 'control_mixin_color_int',    [ 'keys' => [ 'value' => $k_pre . 'graphic_icon_color', 'alt' => $k_pre . 'graphic_icon_color_alt' ], 'options' => cs_recall( 'options_swatch_base_interaction_labels' )       ] );
    $control_graphic_icon_bg_color  = cs_recall( 'control_mixin_bg_color_int', [ 'keys' => [ 'value' => $k_pre . 'graphic_icon_bg_color', 'alt' => $k_pre . 'graphic_icon_bg_color_alt' ], 'options' => cs_recall( 'options_swatch_base_interaction_labels' ) ] );
  } else {
    $control_graphic_icon_color     = cs_recall( 'control_mixin_color_solo',    [ 'keys' => [ 'value' => $k_pre . 'graphic_icon_color' ] ] );
    $control_graphic_icon_bg_color  = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => $k_pre . 'graphic_icon_bg_color' ] ] );
  }



  // Individual Controls - Image
  // ---------------------------

  $control_graphic_image_max_width       = cs_recall( 'control_mixin_max_width', [ 'key' => $k_pre . 'graphic_image_max_width', 'options' => cs_recall( 'options_graphic_image' ) ] );
  $control_graphic_local_image_secondary = [
    'key'        => $k_pre . 'graphic_image_src_alt',
    'type'       => 'image-source',
    'label'      => cs_recall( 'label_source' ),
    'conditions' => $conditions_graphic_image_alt,
    'options'    => [
      'height' => 4,
    ],
  ];

  $control_graphic_local_image_secondary_alt_text = [
    'key'        => $k_pre . 'graphic_image_alt_alt',
    'type'       => 'text',
    'label'      => cs_recall( 'label_alt_text' ),
    'conditions' => $conditions_graphic_image_alt,
    'options'    => [
      'placeholder' => cs_recall( 'label_describe_your_image' ),
    ],
  ];


  // Controls & Control Groups for Icons / Images
  // --------------------------------------------
  // 01. Variable controls and groups that differ depending on various
  //     conditions such as having sourced content, having secondary icons or
  //     images, et cetera.
  // 02. Content is provided from an external source, such as the WordPress
  //     menu system.
  // 03. Content provided locally from within the builders, such as the
  //     individual icon or image controls.

  $control_graphic_local_icon_primary              = NULL;
  $control_graphic_local_icon_secondary            = NULL; // 01
  $control_graphic_local_image_primary             = NULL; // 01
  $control_group_graphic_local_image_secondary     = NULL; // 01
  $control_group_graphic_sourced_images            = NULL; // 01

  foreach ( $controls_setup as $i => $control ) {
    $controls_setup[ $i ][ 'conditions' ] = $conditions_graphic_main;
  }

  $control_list_graphic_setup = array_merge(
    [ $control_graphic_type ],
    $controls_setup
  );

  if ( $has_interactions ) {
    $control_list_graphic_setup[] = $control_graphic_interaction;
  }

  if ( $has_sourced_content ) { // 02

    $control_list_graphic_sourced_images_controls = [
      [
        'key'     => $k_pre . 'graphic_image_retina',
        'type'    => 'choose',
        'label'   => cs_recall( 'label_retina_ready' ),
        'options' => cs_recall( 'options_choices_off_on_bool' ),
      ],
    ];

    if ($has_alt) {
      $control_list_graphic_sourced_images_controls[] = [
        'key'     => $k_pre . 'graphic_image_alt_enable',
        'type'    => 'choose',
        'label'   => cs_recall( 'label_secondary' ),
        'options' => cs_recall( 'options_choices_off_on_bool' ),
      ];
    }

    $control_group_graphic_sourced_images = [
      'type'       => 'group',
      'label'      => cs_recall( 'label_graphic_image_with_prefix' ),
      'label_vars' => [ 'prefix' => $label_prefix ],
      'group'      => $group,
      'conditions' => $conditions_graphic_image,
      'controls'   => $control_list_graphic_sourced_images_controls,
    ];

  } else { // 03


    // Icon Primary
    // ------------

    $control_graphic_local_icon_primary = [
      'key'        => $k_pre . 'graphic_icon',
      'type'       => 'icon',
      'group'      => $group,
      'label'      => cs_recall( 'label_icon' ),
      'conditions' => $conditions_graphic_icon,
      'options'    => [ 'label' => cs_recall( 'label_select' ) ],
    ];

    $control_graphic_local_image_primary = [
      'keys' => [
        'img_source' => $k_pre . 'graphic_image_src',
        'is_retina'  => $k_pre . 'graphic_image_retina',
        'width'      => $k_pre . 'graphic_image_width',
        'height'     => $k_pre . 'graphic_image_height',
        'alt_text'   => $k_pre . 'graphic_image_alt',
      ],
      'type'       => 'image',
      'label'      => cs_recall( 'label_primary_graphic_image_with_prefix' ),
      'label_vars' => [ 'prefix' => $label_prefix ],
      'group'      => $group,
      'conditions' => $conditions_graphic_image,
    ];


    // Icon Secondary
    // --------------
    if ($has_alt) {

      $control_graphic_local_icon_secondary = [
        'key'        => $k_pre . 'graphic_icon_alt',
        'type'       => 'icon',
        'group'      => $group,
        'label'      => cs_recall( 'label_nbsp' ),
        'conditions' => $conditions_graphic_icon_alt,
        'options'    => [ 'label' => cs_recall( 'label_select' ) ],
      ];


      $control_group_graphic_local_image_secondary = [
        'key'        => $k_pre . 'graphic_image_alt_enable',
        'type'       => 'group',
        'label'      => cs_recall( 'label_secondary_graphic_image_with_prefix' ),
        'label_vars' => [ 'prefix' => $label_prefix ],
        'group'      => $group,
        'options'    => cs_recall( 'options_group_toggle_off_on_bool' ),
        'conditions' => $conditions_graphic_image,
        'controls'   => [
          $control_graphic_local_image_secondary,
          $control_graphic_local_image_secondary_alt_text
        ]
      ];
    }
  }


  // Compose Controls
  // ----------------

  $graphic_controls = [
    [
      'type'     => 'group',
      'group'    => $group,
      'controls' => $control_list_graphic_setup,
    ],
    cs_control( 'margin', $k_pre . 'graphic', [
      'label_prefix' => sprintf( cs_recall( 'label_graphic_with_sprintf_prefix' ), $label_prefix ),
      'group'        => $group,
      'conditions'   => $conditions_graphic_main,
    ] ),
    [
      'keys'       => $has_alt ? [ 'checkbox' => $k_pre . 'graphic_icon_alt_enable' ] : [],
      'type'       => 'group',
      'label'      => cs_recall( 'label_graphic_icon_with_prefix' ),
      'label_vars' => [ 'prefix' => $label_prefix ],
      'group'      => $group,
      'options'    => $has_alt ? [ 'checkbox' => cs_recall( 'options_group_checkbox_off_on_bool', [ 'label' => cs_recall( 'label_secondary' ) ] ) ] : [],
      'conditions' => $conditions_graphic_icon,
      'controls'   => [
        $control_graphic_icon_font_size,
        $control_graphic_icon_width,
        $control_graphic_icon_height,
        $control_graphic_local_icon_primary,
        $control_graphic_local_icon_secondary,
        $control_graphic_icon_color,
        $control_graphic_icon_bg_color,
      ],
    ],
    cs_control( 'border',        $k_pre . 'graphic_icon', $settings_graphic_icon_variable_alt_color ),
    cs_control( 'border-radius', $k_pre . 'graphic_icon', $settings_graphic_icon_border_radius      ),
    cs_control( 'box-shadow',    $k_pre . 'graphic_icon', $settings_graphic_icon_variable_alt_color ),
    cs_control( 'text-shadow',   $k_pre . 'graphic_icon', $settings_graphic_icon_variable_alt_color ),
    [
      'type'       => 'group',
      'label'      => cs_recall( 'label_graphic_image_with_prefix' ),
      'label_vars' => [ 'prefix' => $label_prefix ],
      'group'      => $group,
      'conditions' => $conditions_graphic_image,
      'controls'   => [
        $control_graphic_image_max_width,
      ],
    ],
    $control_graphic_local_image_primary,
    $control_group_graphic_local_image_secondary,
    $control_group_graphic_sourced_images
  ];

  if ( $has_toggle ) {
    return cs_compose_controls(
      [
        'controls' => $graphic_controls
      ],
      cs_partial_controls( 'toggle', [
        'label_prefix' => sprintf( cs_recall( 'label_graphic_with_sprintf_prefix' ), $label_prefix ),
        'group'        => $group,
        'conditions'   => $conditions_graphic_toggle,
      ] )
    );
  }

  return [ 'controls' => $graphic_controls ];

}

cs_register_control_partial( 'graphic', 'x_control_partial_graphic' );
