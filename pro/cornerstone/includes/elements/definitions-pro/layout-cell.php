<?php

// =============================================================================
// FRAMEWORK/FUNCTIONS/PRO/BARS/DEFINITIONS/LAYOUT-CELL.PHP
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

    'layout_cell_column_start'          => cs_value( '', 'style', true ),
    'layout_cell_column_end'            => cs_value( '', 'style', true ),
    'layout_cell_row_start'             => cs_value( '', 'style', true ),
    'layout_cell_row_end'               => cs_value( '', 'style', true ),
    'layout_cell_justify_self'          => cs_value( 'auto', 'style', true ),
    'layout_cell_align_self'            => cs_value( 'auto', 'style', true ),

    'layout_cell_base_font_size'        => cs_value( '1em', 'style' ),
    'layout_cell_tag'                   => cs_value( 'div', 'markup' ),
    'layout_cell_text_align'            => cs_value( 'none', 'style' ),
    'layout_cell_overflow'              => cs_value( 'visible', 'style' ),
    'layout_cell_z_index'               => cs_value( 'auto', 'style' ),
    'layout_cell_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'layout_cell_bg_color_alt'          => cs_value( '', 'style:color' ),
    'layout_cell_bg_advanced'           => cs_value( false, 'markup' ),

    'layout_cell_href'                  => cs_value( '', 'markup', true ),
    'layout_cell_blank'                 => cs_value( false, 'markup', true ),
    'layout_cell_nofollow'              => cs_value( false, 'markup', true ),

    'layout_cell_width'                 => cs_value( 'auto', 'style' ),
    'layout_cell_min_width'             => cs_value( '0px', 'style' ),
    'layout_cell_max_width'             => cs_value( 'none', 'style' ),
    'layout_cell_height'                => cs_value( 'auto', 'style' ),
    'layout_cell_min_height'            => cs_value( '0px', 'style' ),
    'layout_cell_max_height'            => cs_value( 'none', 'style' ),

    'layout_cell_flexbox'               => cs_value( false, 'style' ),
    'layout_cell_flex_direction'        => cs_value( 'column', 'style' ),
    'layout_cell_flex_wrap'             => cs_value( true, 'style' ),
    'layout_cell_flex_justify'          => cs_value( 'flex-start', 'style' ),
    'layout_cell_flex_align'            => cs_value( 'flex-start', 'style' ),

    'layout_cell_padding'               => cs_value( '!0px 0px 0px 0px', 'style' ),
    'layout_cell_border_width'          => cs_value( '!0px', 'style' ),
    'layout_cell_border_style'          => cs_value( 'solid', 'style' ),
    'layout_cell_border_color'          => cs_value( 'transparent', 'style:color' ),
    'layout_cell_border_color_alt'      => cs_value( '', 'style:color' ),
    'layout_cell_border_radius'         => cs_value( '!0px', 'style' ),
    'layout_cell_box_shadow_dimensions' => cs_value( '!0px 0px 0px 0px', 'style' ),
    'layout_cell_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
    'layout_cell_box_shadow_color_alt'  => cs_value( '', 'style:color' ),
  ),
  cs_values( 'particle', 'layout_cell_primary' ),
  cs_values( 'particle', 'layout_cell_secondary' ),
  'omega',
  'omega:custom-atts',
  'omega:looper-provider',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_tss_layout_cell() {
  return [
    'modules' => [
      'layout-cell',
      'effects',
      ['particle', [
        'name'  => 'particle-primary',
        'args' => [
          'selector' => '.is-primary',
          'isDirectChild' => true
        ],
        'remap' => [
          'layout_cell_primary_particle' => 'particle',
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
          'layout_cell_secondary_particle' => 'particle',
          'effects_duration' => 'duration',
          'effects_timing_function' => 'timing_function'
        ]
      ]]
    ]
  ];
}



// Render
// =============================================================================

function x_element_render_layout_cell( $data ) {

  // Prepare Attr Values
  // -------------------

  $classes = [ 'x-cell' ];

  // Particles
  // ---------

  $particles = cs_make_particles( $data, 'layout_cell' );

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

  if ( $data['layout_cell_tag'] === 'a' ) {
    $atts = cs_apply_link( $atts, $data, 'layout_cell' );
  }

  $atts = cs_apply_effect( $atts, $data );


  // Output
  // ------

  return cs_tag( $data['layout_cell_tag'], $atts, $data['custom_atts'], [
    $data['layout_cell_bg_advanced'] ? cs_make_bg( $data ) : '',
    cs_render_child_elements( $data, 'x_layout_cell' ),
    $particles
  ]);

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_layout_cell() {

  // Helpers
  // -------

  $base_group                          = 'layout_cell';
  $group_layout_cell_children          = $base_group . ':children';
  $group_layout_cell_setup             = $base_group . ':setup';
  $group_layout_cell_layout            = $base_group . ':layout';
  $group_layout_cell_background_layers = $base_group . ':background-layers';
  $group_layout_cell_link              = $base_group . ':link';
  $group_layout_cell_size              = $base_group . ':size';
  $group_layout_cell_design            = $base_group . ':design';
  $group_layout_cell_particles         = $base_group . ':particles';

  $condition_layout_cell_is_anchor     = array( 'layout_cell_tag' => 'a' );
  $condition_layout_cell_is_not_anchor = array( 'key' => 'layout_cell_tag', 'op' => '!=', 'value' => 'a' );


  // Settings
  // --------

  $settings_layout_cell_design_no_color = array(
    'group' => $group_layout_cell_design,
  );

  $settings_layout_cell_design_flexbox = array(
    'group'     => $group_layout_cell_design,
    'toggle'    => 'layout_cell_flexbox'
  );

  $settings_layout_cell_design_with_color = array(
    'group'     => $group_layout_cell_design,
    'alt_color' => true,
    'options'   => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  );


  // Individual Controls - Children
  // ------------------------------

  $control_layout_cell_children = array(
    'type'  => 'sortable',
    'group' => $group_layout_cell_children,
  );


  // Individual Controls - Setup
  // ---------------------------

  $control_layout_cell_base_font_size = cs_recall( 'control_mixin_font_size',        [ 'key' => 'layout_cell_base_font_size'                                                                                         ] );
  $control_layout_cell_tag            = cs_recall( 'control_mixin_layout_tag',       [ 'key' => 'layout_cell_tag'                                                                                                    ] );
  $control_layout_cell_text_align     = cs_recall( 'control_mixin_text_align',       [ 'key' => 'layout_cell_text_align'                                                                                             ] );
  $control_layout_cell_overflow       = cs_recall( 'control_mixin_overflow',         [ 'key' => 'layout_cell_overflow'                                                                                               ] );
  $control_layout_cell_z_index        = cs_recall( 'control_mixin_z_index',          [ 'key' => 'layout_cell_z_index'                                                                                                ] );
  $control_layout_cell_background     = cs_recall( 'control_mixin_bg_color_int_adv', [ 'keys' => [ 'value' => 'layout_cell_bg_color', 'alt' => 'layout_cell_bg_color_alt', 'checkbox' => 'layout_cell_bg_advanced' ] ] );


  // Individual Controls - Link
  // --------------------------

  $control_layout_cell_link = array(
    'keys' => array(
      'url'      => 'layout_cell_href',
      'new_tab'  => 'layout_cell_blank',
      'nofollow' => 'layout_cell_nofollow',
    ),
    'type'      => 'link',
    'group'     => $group_layout_cell_link,
    'condition' => $condition_layout_cell_is_anchor,
  );


  // Individual Controls - Layout
  // ----------------------------

  $control_layout_cell_layout = array(
    'keys' => array(
      'column_start' => 'layout_cell_column_start',
      'column_end'   => 'layout_cell_column_end',
      'row_start'    => 'layout_cell_row_start',
      'row_end'      => 'layout_cell_row_end',
      'justify_self' => 'layout_cell_justify_self',
      'align_self'   => 'layout_cell_align_self',
    ),
    'type'  => 'layout-cell',
    'group' => $group_layout_cell_layout,
  );


  // Individual Controls - Size
  // --------------------------

  $control_layout_cell_width      = cs_recall( 'control_mixin_width',      [ 'key' => 'layout_cell_width'      ] );
  $control_layout_cell_min_width  = cs_recall( 'control_mixin_min_width',  [ 'key' => 'layout_cell_min_width'  ] );
  $control_layout_cell_max_width  = cs_recall( 'control_mixin_max_width',  [ 'key' => 'layout_cell_max_width'  ] );
  $control_layout_cell_height     = cs_recall( 'control_mixin_height',     [ 'key' => 'layout_cell_height'     ] );
  $control_layout_cell_min_height = cs_recall( 'control_mixin_min_height', [ 'key' => 'layout_cell_min_height' ] );
  $control_layout_cell_max_height = cs_recall( 'control_mixin_max_height', [ 'key' => 'layout_cell_max_height' ] );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls' => array(
        $control_layout_cell_children,
        array(
          'type'     => 'group',
          'group'    => $group_layout_cell_setup,
          'controls' => array(
            $control_layout_cell_base_font_size,
            $control_layout_cell_tag,
            $control_layout_cell_text_align,
            $control_layout_cell_overflow,
            $control_layout_cell_z_index,
            $control_layout_cell_background,
          ),
        ),
        $control_layout_cell_layout,
      ),
      'control_nav' => [
        $base_group                          => cs_recall( 'label_cell' ),
        $group_layout_cell_children          => cs_recall( 'label_children' ),
        $group_layout_cell_setup             => cs_recall( 'label_setup' ),
        $group_layout_cell_layout            => cs_recall( 'label_layout' ),
        $group_layout_cell_background_layers => cs_recall( 'label_background_layers' ),
        $group_layout_cell_link              => cs_recall( 'label_link' ),
        $group_layout_cell_size              => cs_recall( 'label_size' ),
        $group_layout_cell_design            => cs_recall( 'label_design' ),
        $group_layout_cell_particles         => cs_recall( 'label_particles' ),
      ],
    ),
    cs_partial_controls( 'bg', array(
      'group'     => $group_layout_cell_background_layers,
      'condition' => array( 'layout_cell_bg_advanced' => true ),
    ) ),
    array(
      'controls' => array(
        $control_layout_cell_link,
        array(
          'type'     => 'group',
          'group'    => $group_layout_cell_size,
          'controls' => array(
            $control_layout_cell_width,
            $control_layout_cell_min_width,
            $control_layout_cell_max_width,
            $control_layout_cell_height,
            $control_layout_cell_min_height,
            $control_layout_cell_max_height,
          ),
        ),
        cs_control( 'flexbox', 'layout_cell', $settings_layout_cell_design_flexbox ),
        cs_control( 'padding', 'layout_cell', $settings_layout_cell_design_no_color ),
        cs_control( 'border', 'layout_cell', $settings_layout_cell_design_with_color ),
        cs_control( 'border-radius', 'layout_cell', $settings_layout_cell_design_no_color ),
        cs_control( 'box-shadow', 'layout_cell', $settings_layout_cell_design_with_color )
      )
    ),
    cs_partial_controls( 'particle', [
      'label_prefix' => cs_recall( 'label_primary' ),
      'k_pre'        => 'layout_cell_primary',
      'group'        => $group_layout_cell_particles,
    ] ),
    cs_partial_controls( 'particle', [
      'label_prefix' => cs_recall( 'label_secondary' ),
      'k_pre'        => 'layout_cell_secondary',
      'group'        => $group_layout_cell_particles,
    ] ),
    cs_partial_controls( 'effects', [ 'has_provider' => true ] ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true, 'add_looper_provider' => true, 'add_looper_consumer' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'layout-cell', [
  'title'      => __( 'Cell', 'cornerstone' ),
  'values'     => $values,
  'migrations' => [
    [
      'layout_cell_padding'               => '!0px',
      'layout_cell_box_shadow_dimensions' => '!0em 0em 0em 0em',
    ],
  ],
  'components' => [ 'bg', 'effects' ],
  'builder'    => 'x_element_builder_setup_layout_cell',
  'tss'        => 'x_element_tss_layout_cell',
  'render'     => 'x_element_render_layout_cell',
  'icon'       => 'native',
  'children'   => 'x_layout_cell',
  'options'    => [
    'valid_children'    => [ '*' ],
    'index_labels'      => true,
    'library'           => false,
    'empty_placeholder' => false,
    'is_draggable'      => false,
    'tag_key'           => 'layout_cell_tag',
    'dropzone'          => [
      'enabled'     => true,
      'z_index_key' => 'layout_cell_z_index'
    ],
    'contrast_keys' => [
      'bg:layout_cell_bg_advanced',
      'layout_cell_bg_color'
    ],
    'side_effects' => [
      [
        'observe'    => 'layout_cell_bg_advanced',
        'conditions' => [
          ['key' => 'layout_cell_bg_advanced', 'op' => '==', 'value' => true ],
          ['key' => 'layout_cell_z_index',     'op' => '==', 'value' => 'auto' ]
        ],
        'apply' => [
          'layout_cell_z_index' => '1'
        ]
      ]
    ]
  ],
] );
