<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/LAYOUT-ROW.PHP
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
  array(

    'layout_row_layout'                => cs_value( '100%', 'style' ),

    'layout_row_gap_column'            => cs_value( '20px', 'style' ),
    'layout_row_gap_row'               => cs_value( '20px', 'style' ),
    'layout_row_flex_justify'          => cs_value( 'flex-start', 'style' ),
    'layout_row_flex_align'            => cs_value( 'stretch', 'style' ),
    'layout_row_reverse'               => cs_value( false, 'style' ),
    'layout_row_grow'                  => cs_value( false, 'style' ),

    'layout_row_base_font_size'        => cs_value( '1em', 'style' ),
    'layout_row_tag'                   => cs_value( 'div', 'markup' ),
    'layout_row_text_align'            => cs_value( 'none', 'style' ),
    'layout_row_overflow'              => cs_value( 'visible', 'style' ),
    'layout_row_z_index'               => cs_value( '1', 'style' ),
    'layout_row_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'layout_row_bg_color_alt'          => cs_value( '', 'style:color' ),
    'layout_row_bg_advanced'           => cs_value( false, 'markup' ),

    'layout_row_href'                  => cs_value( '', 'markup', true ),
    'layout_row_blank'                 => cs_value( false, 'markup', true ),
    'layout_row_nofollow'              => cs_value( false, 'markup', true ),

    'layout_row_global_container'      => cs_value( false, 'markup' ),
    'layout_row_width'                 => cs_value( 'auto', 'style' ),
    'layout_row_max_width'             => cs_value( 'none', 'style' ),

    'layout_row_margin'                => cs_value( '!0px auto 0px auto', 'style' ),
    'layout_row_padding'               => cs_value( '!0px 0px 0px 0px', 'style' ),
    'layout_row_border_width'          => cs_value( '!0px', 'style' ),
    'layout_row_border_style'          => cs_value( 'solid', 'style' ),
    'layout_row_border_color'          => cs_value( 'transparent', 'style:color' ),
    'layout_row_border_color_alt'      => cs_value( '', 'style:color' ),
    'layout_row_border_radius'         => cs_value( '!0px', 'style' ),
    'layout_row_box_shadow_dimensions' => cs_value( '!0px 0px 0px 0px', 'style' ),
    'layout_row_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
    'layout_row_box_shadow_color_alt'  => cs_value( '', 'style:color' ),
  ),
  cs_values( 'particle', 'layout_row_primary' ),
  cs_values( 'particle', 'layout_row_secondary' ),
  'omega',
  'omega:custom-atts',
  'omega:looper-provider',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_tss_layout_row() {

  return [
    'modules' => [
      'layout-row',
      'effects',
      ['particle', [
        'name'  => 'particle-primary',
        'args' => [
          'selector' => '.is-primary',
          'isDirectChild' => true
        ],
        'remap' => [
          'layout_row_primary_particle' => 'particle',
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
          'layout_row_secondary_particle' => 'particle',
          'effects_duration' => 'duration',
          'effects_timing_function' => 'timing_function'
        ]
      ]]
    ]
  ];
}


// Render
// =============================================================================

function x_element_render_layout_row( $data ) {

  // Prepare Attr Values
  // -------------------

  $classes = [ 'x-row' ];

  if ( $data['layout_row_global_container'] == true ) {
    $classes[] = 'x-container max width';
  }


  // Particles
  // ---------

  $particles = cs_make_particles( $data, 'layout_row' );

  if ( ! empty( $particles ) ) {
    $classes[] = 'has-particle';
  }

  // Atts
  // ----

  $atts = [
    'class' => array_merge( $classes, $data['classes'] )
  ];

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }

  if ( isset( $data['id'] ) && ! empty( $data['id'] ) ) {
    $atts['id'] = $data['id'];
  }

  if ( $data['layout_row_tag'] === 'a' ) {
    $atts = cs_apply_link( $atts, $data, 'layout_row' );
  }

  $atts = cs_apply_effect( $atts, $data );


  // Output
  // ------

  return cs_tag( $data['layout_row_tag'], $atts, $data['custom_atts'], [
    $data['layout_row_bg_advanced'] ? cs_make_bg( $data ) : '',
    cs_tag('div', ['class'=> 'x-row-inner'], cs_render_child_elements( $data, 'x_layout_row' )),
    $particles
  ]);

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_layout_row() {

  // Helpers
  // -------

  $base_group                         = 'layout_row';
  $group_layout_row_children          = $base_group . ':children';
  $group_layout_row_setup             = $base_group . ':setup';
  $group_layout_row_layout            = $base_group . ':layout';
  $group_layout_row_background_layers = $base_group . ':background-layers';
  $group_layout_row_link              = $base_group . ':link';
  $group_layout_row_size              = $base_group . ':size';
  $group_layout_row_design            = $base_group . ':design';
  $group_layout_row_particles         = $base_group . ':particles';

  $condition_layout_row_is_anchor          = array( 'layout_row_tag' => 'a' );
  $condition_layout_row_is_not_anchor      = array( 'key' => 'layout_row_tag', 'op' => '!=', 'value' => 'a' );
  $condition_layout_row_container_enabled  = array( 'layout_row_global_container' => true );
  $condition_layout_row_container_disabled = array( 'layout_row_global_container' => false );


  // Settings
  // --------

  $settings_layout_row_design_no_color = array(
    'group' => $group_layout_row_design,
  );

  $settings_layout_row_design_margin = array(
    'group' => $group_layout_row_design,
    'options' => array(
      'left'  => array( 'disabled' => true, 'fallback_value' => 'auto' ),
      'right' => array( 'disabled' => true, 'fallback_value' => 'auto' ),
    ),
  );

  $settings_layout_row_design_with_color = array(
    'group'     => $group_layout_row_design,
    'alt_color' => true,
    'options'   => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  );


  // Individual Controls - Children
  // ------------------------------

  $control_layout_row_children = array(
    'type'  => 'sortable',
    'group' => $group_layout_row_children
  );


  // Individual Controls - Setup
  // ---------------------------

  $control_layout_row_base_font_size = cs_recall( 'control_mixin_font_size',    [ 'key' => 'layout_row_base_font_size'                                                                                           ] );
  $control_layout_row_tag            = cs_recall( 'control_mixin_layout_tag',   [ 'key' => 'layout_row_tag'                                                                                                      ] );
  $control_layout_row_text_align     = cs_recall( 'control_mixin_text_align',   [ 'key' => 'layout_row_text_align'                                                                                               ] );
  $control_layout_row_overflow       = cs_recall( 'control_mixin_overflow',     [ 'key' => 'layout_row_overflow'                                                                                                 ] );
  $control_layout_row_z_index        = cs_recall( 'control_mixin_z_index',      [ 'key' => 'layout_row_z_index'                                                                                                  ] );
  $control_layout_row_background     = cs_recall( 'control_mixin_bg_color_int_adv', [ 'keys' => [ 'value' => 'layout_row_bg_color', 'alt' => 'layout_row_bg_color_alt', 'checkbox' => 'layout_row_bg_advanced' ] ] );


  // Individual Controls - Link
  // --------------------------

  $control_layout_row_link = array(
    'keys' => array(
      'url'      => 'layout_row_href',
      'new_tab'  => 'layout_row_blank',
      'nofollow' => 'layout_row_nofollow',
    ),
    'type'      => 'link',
    'group'     => $group_layout_row_link,
    'condition' => $condition_layout_row_is_anchor,
  );


  // Individual Controls - Layout
  // ----------------------------

  $control_layout_row_layout = array(
    'key'   => 'layout_row_layout',
    'type'  => 'layout-row',
    'label' => cs_recall( 'label_template' ),
    'description' => 'Click to manage breakpoints'
  );

  $control_layout_row_reverse = array(
    'key'     => 'layout_row_reverse',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_direction' ),
    'options' => [
      'choices' => [
        [ 'value' => false, 'label' => cs_recall( 'label_standard' ) ],
        [ 'value' => true,  'label' => cs_recall( 'label_reverse' )  ],
      ],
    ]
  );

  $control_layout_row_grow = array(
    'key'     => 'layout_row_grow',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_column_fill' ),
    'options' => [
      'choices' => [
        [ 'value' => false, 'label' => cs_recall( 'label_auto' ) ],
        [ 'value' => true,  'label' => cs_recall( 'label_grow' ) ],
      ],
    ]
  );

  $control_layout_row_gap_column       = cs_recall( 'control_mixin_gap', [ 'key' => 'layout_row_gap_column', 'label' => cs_recall( 'label_gap_width' )                                                                          ] );
  $control_layout_row_gap_row          = cs_recall( 'control_mixin_gap', [ 'key' => 'layout_row_gap_row', 'label' => cs_recall( 'label_gap_height' )                                                                            ] );
  $control_layout_row_align_axis_main  = cs_recall( 'control_mixin_justify_content', [ 'key' => 'layout_row_flex_justify', 'label' => cs_recall( 'label_horizontal' ), 'options' => cs_recall( 'options_justify_content_flex' ) ] );
  $control_layout_row_align_axis_cross = cs_recall( 'control_mixin_align_items',     [ 'key' => 'layout_row_flex_align', 'label' => cs_recall( 'label_vertical' ), 'options' => cs_recall( 'options_align_items_flex' )         ] );

  $control_layout_row_options = [
    'keys' => [
      'reverse' => 'layout_row_reverse',
      'grow'    => 'layout_row_grow',
    ],
    'type'    => 'checkbox-list',
    'label'   => cs_recall( 'label_options' ),
    'options' => [
      'list'   => [
        [ 'key' => 'reverse', 'label' => cs_recall( 'label_reverse' ), 'full' => true ],
        [ 'key' => 'grow',    'label' => cs_recall( 'label_grow' ),    'full' => true ],
      ],
    ],
  ];


  // Individual Controls - Size
  // --------------------------

  $control_layout_row_global_container_placeholder = cs_recall( 'control_mixin_global_container_placeholder_x2', [ 'key' => 'layout_row_global_container', 'condition' => $condition_layout_row_container_enabled ] );
  $control_layout_row_width                        = cs_recall( 'control_mixin_width',                           [ 'key' => 'layout_row_width', 'condition' => $condition_layout_row_container_disabled           ] );
  $control_layout_row_max_width                    = cs_recall( 'control_mixin_max_width',                       [ 'key' => 'layout_row_max_width', 'condition' => $condition_layout_row_container_disabled       ] );


  // Control Groups
  // --------------

  $control_group_layout_row_layout = [
    'type'     => 'group',
    'group'    => $group_layout_row_layout,
    'controls' => [
      $control_layout_row_layout,
      $control_layout_row_gap_column,
      $control_layout_row_gap_row,
      $control_layout_row_reverse,
      $control_layout_row_align_axis_main,
      $control_layout_row_align_axis_cross,
      $control_layout_row_grow,
    ],
  ];

  $control_group_layout_row_setup = array(
    'type'     => 'group',
    'group'    => $group_layout_row_setup,
    'controls' => array(
      $control_layout_row_base_font_size,
      $control_layout_row_tag,
      $control_layout_row_text_align,
      $control_layout_row_overflow,
      $control_layout_row_z_index,
      $control_layout_row_background,
    ),
  );

  $control_group_layout_row_size = array(
    'keys'     => [ 'checkbox' => 'layout_row_global_container' ],
    'type'     => 'group',
    'group'    => $group_layout_row_size,
    'options'  => [
      'vertical_label'   => cs_recall( 'label_nbsp' ),
      'horizontal_label' => cs_recall( 'label_size' ),
      'checkbox'         => cs_recall( 'options_group_checkbox_off_on_bool', [ 'label' => cs_recall( 'label_global_container' ) ] )
    ],
    'controls' => array(
      $control_layout_row_global_container_placeholder,
      $control_layout_row_width,
      $control_layout_row_max_width,
    ),
  );

  return cs_compose_controls(
    array(
      'controls' => array(
        $control_layout_row_children,
        $control_group_layout_row_setup,
        $control_group_layout_row_layout,
      ),
      'control_nav' => [
        $base_group                         => cs_recall( 'label_row' ),
        $group_layout_row_children          => cs_recall( 'label_children' ),
        $group_layout_row_setup             => cs_recall( 'label_setup' ),
        $group_layout_row_layout            => cs_recall( 'label_layout' ),
        $group_layout_row_background_layers => cs_recall( 'label_background_layers' ),
        $group_layout_row_link              => cs_recall( 'label_link' ),
        $group_layout_row_size              => cs_recall( 'label_size' ),
        $group_layout_row_design            => cs_recall( 'label_design' ),
        $group_layout_row_particles         => cs_recall( 'label_particles' ),
      ],
    ),
    cs_partial_controls( 'bg', array(
      'group'     => $group_layout_row_background_layers,
      'condition' => array( 'layout_row_bg_advanced' => true ),
    ) ),
    array(
      'controls' => array(
        $control_layout_row_link,
        $control_group_layout_row_size,
        cs_control( 'margin', 'layout_row', $settings_layout_row_design_margin ),
        cs_control( 'padding', 'layout_row', $settings_layout_row_design_no_color ),
        cs_control( 'border', 'layout_row', $settings_layout_row_design_with_color ),
        cs_control( 'border-radius', 'layout_row', $settings_layout_row_design_no_color ),
        cs_control( 'box-shadow', 'layout_row', $settings_layout_row_design_with_color )
      ),
    ),
    cs_partial_controls( 'particle', [
      'label_prefix' => cs_recall( 'label_primary' ),
      'k_pre'        => 'layout_row_primary',
      'group'        => $group_layout_row_particles,
    ] ),
    cs_partial_controls( 'particle', [
      'label_prefix' => cs_recall( 'label_secondary' ),
      'k_pre'        => 'layout_row_secondary',
      'group'        => $group_layout_row_particles,
    ] ),
    cs_partial_controls( 'effects', [ 'has_provider' => true ] ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true, 'add_looper_provider' => true, 'add_looper_consumer' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'layout-row', [
  'title'      => __( 'Row', 'cornerstone' ),
  'values'     => $values,
  'migrations' => [
    [ 'layout_row_z_index' => 'auto' ],
    [
      'layout_row_gap_column'            => '1rem',
      'layout_row_gap_row'               => '1rem',
      'layout_row_padding'               => '!0px',
      'layout_row_box_shadow_dimensions' => '!0em 0em 0em 0em',
    ],
  ],
  'components' => [ 'bg', 'effects' ],
  'builder'    => 'x_element_builder_setup_layout_row',
  'tss'        => 'x_element_tss_layout_row',
  'render'     => 'x_element_render_layout_row',
  'icon'       => 'native',
  'children'   => 'x_layout_row',
  'options'    => [
    'valid_children'    => [ 'layout-column' ],
    'index_labels'      => true,
    'is_draggable'      => false,
    'empty_placeholder' => false,
    'dropzone'          => [
      'proxy'       => true,
      'z_index_key' => 'layout_row_z_index'
    ],
    'spacing_keys' => [ 'layout_row_margin', 'layout_row_padding', 'layout_row_global_container', 'layout_row_width', 'layout_row_max_width', 'layout_row_gap_column', 'layout_row_gap_row' ],
    'add_new_element' => [ '_type' => 'layout-column' ],
    'tag_key'         => 'layout_row_tag',
    'contrast_keys'   => [
      'bg:layout_row_bg_advanced',
      'layout_row_bg_color'
    ],
    'side_effects' => [
      [
        'observe'    => 'layout_row_bg_advanced',
        'conditions' => [
          ['key' => 'layout_row_bg_advanced', 'op' => '==', 'value' => true ],
          ['key' => 'layout_row_z_index',     'op' => '==', 'value' => 'auto' ]
        ],
        'apply' => [
          'layout_row_z_index' => '1'
        ]
      ]
    ]
  ]
] );
