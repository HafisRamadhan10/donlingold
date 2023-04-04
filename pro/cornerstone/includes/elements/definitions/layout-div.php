<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/LAYOUT-DIV.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Values
//   02. Style
//   03. Render
//   04. Builder Setup
//   05. Register Element
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  [
    'layout_div_base_font_size'        => cs_value( '1em' ),
    'layout_div_tag'                   => cs_value( 'div', 'markup' ),
    'layout_div_text_align'            => cs_value( 'none' ),
    'layout_div_pointer_events'        => cs_value( 'auto', 'markup' ),
    'layout_div_overflow'              => cs_value( 'visible' ),
    'layout_div_z_index'               => cs_value( 'auto' ),
    'layout_div_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'layout_div_bg_color_alt'          => cs_value( '', 'style:color' ),
    'layout_div_bg_advanced'           => cs_value( false, 'markup' ),

    'layout_div_href'                  => cs_value( '', 'markup', true ),
    'layout_div_blank'                 => cs_value( false, 'markup', true ),
    'layout_div_nofollow'              => cs_value( false, 'markup', true ),

    'layout_div_global_container'      => cs_value( false, 'markup' ),
    'layout_div_width'                 => cs_value( 'auto' ),
    'layout_div_min_width'             => cs_value( '0px' ),
    'layout_div_max_width'             => cs_value( 'none' ),
    'layout_div_height'                => cs_value( 'auto' ),
    'layout_div_min_height'            => cs_value( '0px' ),
    'layout_div_max_height'            => cs_value( 'none' ),
    'layout_div_flex'                  => cs_value( '0 1 auto' ),

    'layout_div_position'              => cs_value( 'relative' ),
    'layout_div_top'                   => cs_value( 'auto' ),
    'layout_div_left'                  => cs_value( 'auto' ),
    'layout_div_right'                 => cs_value( 'auto' ),
    'layout_div_bottom'                => cs_value( 'auto' ),
    'layout_div_overflow_x'            => cs_value( 'visible' ),
    'layout_div_overflow_y'            => cs_value( 'visible' ),

    'layout_div_flexbox'               => cs_value( false ),
    'layout_div_flex_direction'        => cs_value( 'column' ),
    'layout_div_flex_wrap'             => cs_value( true ),
    'layout_div_flex_justify'          => cs_value( 'flex-start' ),
    'layout_div_flex_align'            => cs_value( 'flex-start' ),

    'layout_div_margin'                => cs_value( '!0px 0px 0px 0px' ),
    'layout_div_padding'               => cs_value( '!0px 0px 0px 0px' ),
    'layout_div_border_width'          => cs_value( '!0px' ),
    'layout_div_border_style'          => cs_value( 'solid' ),
    'layout_div_border_color'          => cs_value( 'transparent', 'style:color' ),
    'layout_div_border_color_alt'      => cs_value( '', 'style:color' ),
    'layout_div_border_radius'         => cs_value( '!0px' ),
    'layout_div_box_shadow_dimensions' => cs_value( '!0px 0px 0px 0px' ),
    'layout_div_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
    'layout_div_box_shadow_color_alt'  => cs_value( '', 'style:color' ),
  ],
  cs_values( 'particle', 'layout_div_primary' ),
  cs_values( 'particle', 'layout_div_secondary' ),
  'omega',
  'omega:custom-atts',
  'omega:looper-provider',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_tss_layout_div() {

  return [
    'modules' => [
      'layout-div',
      'effects',
      ['particle', [
        'name'  => 'particle-primary',
        'args' => [
          'selector' => '.is-primary',
          'isDirectChild' => true
        ],
        'remap' => [
          'layout_div_primary_particle' => 'particle',
          'effects_duration' => 'duration',
          'effects_timing_function' => 'timing_function'
        ]
      ]],
      ['particle', [
        'name'  => 'particle-secondary',
        'args' => [
          'selector' => '.is-secondary',
          'isDirectChild' => true
        ],
        'remap' => [
          'layout_div_secondary_particle' => 'particle',
          'effects_duration' => 'duration',
          'effects_timing_function' => 'timing_function'
        ]
      ]]
    ]
  ];
}



// Render
// =============================================================================

function x_element_render_layout_div( $data ) {

  // Prepare Attr Values
  // -------------------

  $classes = [ 'x-div' ];

  if ( $data['layout_div_global_container'] == true ) {
    $classes[] = 'x-container max width';
  }


  // Particles
  // ---------

  $particles = cs_make_particles( $data, 'layout_div' );

  if ( ! empty( $particles ) ) {
    $classes[] = 'has-particle';
  }


  // Atts
  // ----

  $atts = [
    'class' => array_merge( $classes, $data['classes'] )
  ];

  if ( isset( $data['id'] ) && ! empty( $data['id'] ) ) {
    $atts['id'] = $data['id'];
  }

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }

  if ( $data['layout_div_tag'] === 'a' ) {
    $atts = cs_apply_link( $atts, $data, 'layout_div' );
  }

  $atts = cs_apply_effect( $atts, $data );

  return cs_tag( $data['layout_div_tag'], $atts, $data['custom_atts'], [
    $data['layout_div_bg_advanced'] ? cs_make_bg( $data ) : '',
    cs_render_child_elements( $data, 'x_layout_div' ),
    $particles
  ]);
}




// Builder Setup
// =============================================================================

function x_element_builder_setup_layout_div() {

  // Conditions
  // ----------

  $condition_layout_div_is_anchor          = [ 'layout_div_tag' => 'a' ];
  $condition_layout_div_is_not_anchor      = [ 'key' => 'layout_div_tag', 'op' => '!=', 'value' => 'a' ];
  $condition_layout_div_container_enabled  = [ 'layout_div_global_container' => true ];
  $condition_layout_div_container_disabled = [ 'layout_div_global_container' => false ];


  // Groups
  // ------

  $group                   = 'layout_div';
  $group_children          = $group . ':children';
  $group_setup             = $group . ':setup';
  $group_background_layers = $group . ':background-layers';
  $group_link              = $group . ':link';
  $group_size              = $group . ':size';
  $group_position          = $group . ':position';
  $group_design            = $group . ':design';
  $group_particles         = $group . ':particles';


  // Settings
  // --------

  $settings_layout_div_design_no_color = [
    'group'  => $group_design,
  ];

  $settings_layout_div_design_with_color = [
    'group'     => $group_design,
    'alt_color' => true,
    'options'   => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  ];

  $settings_layout_div_design_flexbox = [
    'group'   => $group_design,
    'toggle'  => 'layout_div_flexbox',
    'self_flex'  => true
  ];


  // Conditions
  // ----------

  $condition_layout_div_position_not_static = [ 'key' => 'layout_div_position', 'op' => '!=', 'value' => 'static' ];


  // Individual Controls - Children
  // ------------------------------

  $control_layout_div_children = [
    'type'  => 'sortable',
    'group' => $group_children,
  ];


  // Individual Controls - Setup
  // ---------------------------

  $control_layout_div_base_font_size = cs_recall( 'control_mixin_font_size',  [ 'key' => 'layout_div_base_font_size' ] );
  $control_layout_div_tag            = cs_recall( 'control_mixin_layout_tag', [ 'key' => 'layout_div_tag'            ] );
  $control_layout_div_text_align     = cs_recall( 'control_mixin_text_align', [ 'key' => 'layout_div_text_align'     ] );

  $control_layout_div_overflow_x = [
    'key'     => 'layout_div_overflow_x',
    'type'    => 'select',
    'label'   => cs_recall( 'label_x_overflow' ),
    'options' => cs_recall( 'options_choices_layout_overflow_full_list' ),
  ];

  $control_layout_div_overflow_y = [
    'key'     => 'layout_div_overflow_y',
    'type'    => 'select',
    'label'   => cs_recall( 'label_y_overflow' ),
    'options' => cs_recall( 'options_choices_layout_overflow_full_list' ),
  ];

  $control_layout_div_pointer_events = [
    'key'     => 'layout_div_pointer_events',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_no_pointer_events' ),
    'options' => [
      'off_value' => 'auto',
      'choices'   => [
        [ 'value' => 'none-self', 'label' => cs_recall( 'label_self_only' )   ],
        [ 'value' => 'none-all',  'label' => cs_recall( 'label_all_content' ) ],
      ],
    ],
  ];

  $control_layout_div_z_index    = cs_recall( 'control_mixin_z_index',          [ 'key' => 'layout_div_z_index'                                                                                              ] );
  $control_layout_div_background = cs_recall( 'control_mixin_bg_color_int_adv', [ 'keys' => [ 'value' => 'layout_div_bg_color', 'alt' => 'layout_div_bg_color_alt', 'checkbox' => 'layout_div_bg_advanced' ] ] );


  // Individual Controls - Link
  // --------------------------

  $control_layout_div_link = [
    'keys' => [
      'url'      => 'layout_div_href',
      'new_tab'  => 'layout_div_blank',
      'nofollow' => 'layout_div_nofollow',
    ],
    'type'      => 'link',
    'group'     => $group_link,
    'condition' => $condition_layout_div_is_anchor,
  ];


  // Controls - Size
  // ---------------

  $control_layout_div_global_container_placeholder = cs_recall( 'control_mixin_global_container_placeholder_x2', [ 'key' => 'layout_div_global_container', 'condition' => $condition_layout_div_container_enabled ] );
  $control_layout_div_width                        = cs_recall( 'control_mixin_width',                           [ 'key' => 'layout_div_width', 'condition' => $condition_layout_div_container_disabled           ] );
  $control_layout_div_min_width                    = cs_recall( 'control_mixin_min_width',                       [ 'key' => 'layout_div_min_width'                                                                ] );
  $control_layout_div_max_width                    = cs_recall( 'control_mixin_max_width',                       [ 'key' => 'layout_div_max_width', 'condition' => $condition_layout_div_container_disabled       ] );
  $control_layout_div_height                       = cs_recall( 'control_mixin_height',                          [ 'key' => 'layout_div_height'                                                                   ] );
  $control_layout_div_min_height                   = cs_recall( 'control_mixin_min_height',                      [ 'key' => 'layout_div_min_height'                                                               ] );
  $control_layout_div_max_height                   = cs_recall( 'control_mixin_max_height',                      [ 'key' => 'layout_div_max_height'                                                               ] );

  $control_layout_div_flex = [
    'key'   => 'layout_div_flex',
    'label' => cs_recall( 'label_self_flex' ),
    'type'  => 'flex',
  ];


  // Controls - Position
  // -------------------

  $control_layout_div_position = [
    'key'     => 'layout_div_position',
    'label'   => cs_recall( 'label_select' ),
    'type'    => 'select',
    'options' => cs_recall( 'options_choices_position' ),
  ];

  $control_layout_div_top    = cs_recall( 'control_mixin_inset', [ 'key' => 'layout_div_top', 'label' => cs_recall( 'label_top' ), 'condition' => $condition_layout_div_position_not_static     ] );
  $control_layout_div_right  = cs_recall( 'control_mixin_inset', [ 'key' => 'layout_div_right', 'label' => cs_recall( 'label_right' ), 'condition' => $condition_layout_div_position_not_static ] );
  $control_layout_div_bottom = cs_recall( 'control_mixin_inset', [ 'key' => 'layout_div_bottom', 'label' => cs_recall( 'label_bttm' ), 'condition' => $condition_layout_div_position_not_static ] );
  $control_layout_div_left   = cs_recall( 'control_mixin_inset', [ 'key' => 'layout_div_left', 'label' => cs_recall( 'label_left' ), 'condition' => $condition_layout_div_position_not_static   ] );


  // Control Groups
  // --------------

  return cs_compose_controls(
    [
      'controls' => [
        $control_layout_div_children,
        [
          'type'     => 'group',
          'group'    => $group_setup,
          'controls' => [
            $control_layout_div_base_font_size,
            $control_layout_div_tag,
            $control_layout_div_text_align,
            $control_layout_div_overflow_x,
            $control_layout_div_overflow_y,
            $control_layout_div_pointer_events,
            $control_layout_div_z_index,
            $control_layout_div_background,
          ],
        ],
      ],
    ],
    cs_partial_controls( 'bg', [
      'group'     => $group_background_layers,
      'condition' => [ 'layout_div_bg_advanced' => true ],
    ] ),
    [
      'controls' => [
        $control_layout_div_link,
        [
          'keys'     => [ 'checkbox' => 'layout_div_global_container' ],
          'type'     => 'group',
          'group'    => $group_size,
          'options'  => [
            'vertical_label'   => cs_recall( 'label_nbsp' ),
            'horizontal_label' => cs_recall( 'label_size' ),
            'checkbox'         => cs_recall( 'options_group_checkbox_off_on_bool', [ 'label' => cs_recall( 'label_global_container' ) ] )
          ],
          'controls' => [
            $control_layout_div_global_container_placeholder,
            $control_layout_div_width,
            $control_layout_div_min_width,
            $control_layout_div_max_width,
            $control_layout_div_height,
            $control_layout_div_min_height,
            $control_layout_div_max_height,
            [
              'type'       => 'sub-group',
              'label'      => cs_recall( 'label_grow_and_shrink' ),
              'options'    => [ 'height' => 1 ],
              'controls'   => [
                $control_layout_div_flex,
              ],
            ],
          ],
        ],
        [
          'type'     => 'group',
          'group'    => $group_position,
          'controls' => [
            $control_layout_div_position,
            $control_layout_div_top,
            $control_layout_div_right,
            $control_layout_div_bottom,
            $control_layout_div_left,
          ],
        ],
      ],
      'control_nav' => [
        $group                   => cs_recall( 'label_div' ),
        $group_children          => cs_recall( 'label_children' ),
        $group_setup             => cs_recall( 'label_setup' ),
        $group_background_layers => cs_recall( 'label_background_layers' ),
        $group_link              => cs_recall( 'label_link' ),
        $group_size              => cs_recall( 'label_size' ),
        $group_position          => cs_recall( 'label_position' ),
        $group_design            => cs_recall( 'label_design' ),
        $group_particles         => cs_recall( 'label_particles' ),
      ]
    ],
    [
      'controls' => [
        cs_control( 'flexbox', 'layout_div', $settings_layout_div_design_flexbox ),
        cs_control( 'margin', 'layout_div', $settings_layout_div_design_no_color ),
        cs_control( 'padding', 'layout_div', $settings_layout_div_design_no_color ),
        cs_control( 'border', 'layout_div', $settings_layout_div_design_with_color ),
        cs_control( 'border-radius', 'layout_div', $settings_layout_div_design_no_color ),
        cs_control( 'box-shadow', 'layout_div', $settings_layout_div_design_with_color )
      ]
    ],
    cs_partial_controls( 'particle', [
      'label_prefix' => cs_recall( 'label_primary' ),
      'k_pre'        => 'layout_div_primary',
      'group'        => $group_particles,
    ] ),
    cs_partial_controls( 'particle', [
      'label_prefix' => cs_recall( 'label_secondary' ),
      'k_pre'        => 'layout_div_secondary',
      'group'        => $group_particles,
    ] ),
    cs_partial_controls( 'effects', [ 'has_provider' => true ] ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true, 'add_looper_provider' => true, 'add_looper_consumer' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'layout-div', [
  'title'      => __( 'Div', 'cornerstone' ),
  'values'     => $values,
  'migrations' => [
    [
      'layout_div_margin'                => '!0px',
      'layout_div_padding'               => '!0px',
      'layout_div_box_shadow_dimensions' => '!0em 0em 0em 0em',
    ],
  ],
  'components' => [ 'bg', 'effects' ],
  'builder'    => 'x_element_builder_setup_layout_div',
  'tss'        => 'x_element_tss_layout_div',
  'render'     => 'x_element_render_layout_div',
  'icon'       => 'native',
  'children'   => 'x_layout_div',
  'options'    => [
    'valid_children'    => [ '*' ],
    'index_labels'      => false,
    'library'           => true,
    'empty_placeholder' => false,
    'is_draggable'      => false,
    'dropzone'          => [
      'enabled'            => true,
      'z_index_key'        => 'layout_div_z_index',
      'pointer_events_key' => 'layout_div_pointer_events',
    ],
    'contrast_keys' => [
      'bg:layout_div_bg_advanced',
      'layout_div_bg_color',
    ],
    'side_effects' => [
      [
        'observe'    => 'layout_div_bg_advanced',
        'conditions' => [
          ['key' => 'layout_div_bg_advanced', 'op' => '==', 'value' => true   ],
          ['key' => 'layout_div_z_index',     'op' => '==', 'value' => 'auto' ],
        ],
        'apply' => [
          'layout_div_z_index' => '1',
        ],
      ],
    ],
  ],
] );
