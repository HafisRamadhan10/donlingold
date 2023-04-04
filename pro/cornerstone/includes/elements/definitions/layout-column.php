<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/LAYOUT-COLUMN.PHP
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
    'layout_column_base_font_size'        => cs_value( '1em', 'style' ),
    'layout_column_tag'                   => cs_value( 'div', 'markup' ),
    'layout_column_text_align'            => cs_value( 'none', 'style' ),
    'layout_column_overflow'              => cs_value( 'visible', 'style' ),
    'layout_column_z_index'               => cs_value( 'auto', 'style' ),
    'layout_column_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'layout_column_bg_color_alt'          => cs_value( '', 'style:color' ),
    'layout_column_bg_advanced'           => cs_value( false, 'markup' ),

    'layout_column_href'                  => cs_value( '', 'markup', true ),
    'layout_column_blank'                 => cs_value( false, 'markup', true ),
    'layout_column_nofollow'              => cs_value( false, 'markup', true ),

    'layout_column_width'                 => cs_value( 'auto', 'style' ),
    'layout_column_min_width'             => cs_value( '0px', 'style' ),
    'layout_column_max_width'             => cs_value( 'none', 'style' ),
    'layout_column_height'                => cs_value( 'auto', 'style' ),
    'layout_column_min_height'            => cs_value( '0px', 'style' ),
    'layout_column_max_height'            => cs_value( 'none', 'style' ),

    'layout_column_flexbox'               => cs_value( false, 'style' ),
    'layout_column_flex_direction'        => cs_value( 'column', 'style' ),
    'layout_column_flex_wrap'             => cs_value( true, 'style' ),
    'layout_column_flex_justify'          => cs_value( 'flex-start', 'style' ),
    'layout_column_flex_align'            => cs_value( 'flex-start', 'style' ),

    'layout_column_padding'               => cs_value( '!0px 0px 0px 0px', 'style' ),
    'layout_column_border_width'          => cs_value( '!0px', 'style' ),
    'layout_column_border_style'          => cs_value( 'solid', 'style' ),
    'layout_column_border_color'          => cs_value( 'transparent', 'style:color' ),
    'layout_column_border_color_alt'      => cs_value( '', 'style:color' ),
    'layout_column_border_radius'         => cs_value( '!0px', 'style' ),
    'layout_column_box_shadow_dimensions' => cs_value( '!0px 0px 0px 0px', 'style' ),
    'layout_column_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
    'layout_column_box_shadow_color_alt'  => cs_value( '', 'style:color' ),
  ),
  cs_values( 'particle', 'layout_column_primary' ),
  cs_values( 'particle', 'layout_column_secondary' ),
  'omega',
  'omega:custom-atts',
  'omega:looper-provider',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_tss_layout_column() {

  return [
    'modules' => [
      'layout-column',
      'effects',
      ['particle', [
        'name'  => 'particle-primary',
        'args' => [
          'selector' => '.is-primary',
          'isDirectChild' => true
        ],
        'remap' => [
          'layout_column_primary_particle' => 'particle',
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
          'layout_column_secondary_particle' => 'particle',
          'effects_duration' => 'duration',
          'effects_timing_function' => 'timing_function'
        ]
      ]]
    ]
  ];
}




// Render
// =============================================================================

function x_element_render_layout_column( $data ) {

  // Prepare Attr Values
  // -------------------

  $classes = [ 'x-col' ];


  // Particles
  // ---------

  $particles = cs_make_particles( $data, 'layout_column' );

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

  if ( $data['layout_column_tag'] === 'a' ) {
    $atts = cs_apply_link( $atts, $data, 'layout_column' );
  }

  $atts = cs_apply_effect( $atts, $data );


  // Output
  // ------

  return cs_tag( $data['layout_column_tag'], $atts, $data['custom_atts'], [
    $data['layout_column_bg_advanced'] ? cs_make_bg( $data ) : '',
    cs_render_child_elements( $data, 'x_layout_column' ),
    $particles
  ]);

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_layout_column() {

  // Helpers
  // -------

  $base_group                            = 'layout_column';
  $group_layout_column_children          = $base_group . ':children';
  $group_layout_column_setup             = $base_group . ':setup';
  $group_layout_column_background_layers = $base_group . ':background-layers';
  $group_layout_column_link              = $base_group . ':link';
  $group_layout_column_size              = $base_group . ':size';
  $group_layout_column_design            = $base_group . ':design';
  $group_layout_column_particles         = $base_group . ':particles';

  $condition_layout_column_is_anchor     = array( 'layout_column_tag' => 'a' );
  $condition_layout_column_is_not_anchor = array( 'key' => 'layout_column_tag', 'op' => '!=', 'value' => 'a' );


  // Settings
  // --------

  $settings_layout_column_design_no_color = array(
    'group' => $group_layout_column_design,
  );

  $settings_layout_column_design_flexbox = array(
    'group'     => $group_layout_column_design,
    'toggle'    => 'layout_column_flexbox'
  );

  $settings_layout_column_design_with_color = array(
    'group'     => $group_layout_column_design,
    'alt_color' => true,
    'options'   => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  );


  // Individual Controls - Children
  // ------------------------------

  $control_layout_column_children = array(
    'type'  => 'sortable',
    'group' => $group_layout_column_children
  );


  // Individual Controls - Setup
  // ---------------------------

  $control_layout_column_base_font_size = cs_recall( 'control_mixin_font_size',        [ 'key' => 'layout_column_base_font_size'                                                                                             ] );
  $control_layout_column_tag            = cs_recall( 'control_mixin_layout_tag',       [ 'key' => 'layout_column_tag'                                                                                                        ] );
  $control_layout_column_text_align     = cs_recall( 'control_mixin_text_align',       [ 'key' => 'layout_column_text_align'                                                                                                 ] );
  $control_layout_column_overflow       = cs_recall( 'control_mixin_overflow',         [ 'key' => 'layout_column_overflow'                                                                                                   ] );
  $control_layout_column_z_index        = cs_recall( 'control_mixin_z_index',          [ 'key' => 'layout_column_z_index'                                                                                                    ] );
  $control_layout_column_background     = cs_recall( 'control_mixin_bg_color_int_adv', [ 'keys' => [ 'value' => 'layout_column_bg_color', 'alt' => 'layout_column_bg_color_alt', 'checkbox' => 'layout_column_bg_advanced' ] ] );


  // Individual Controls - Link
  // --------------------------

  $control_layout_column_link = array(
    'keys' => array(
      'url'      => 'layout_column_href',
      'new_tab'  => 'layout_column_blank',
      'nofollow' => 'layout_column_nofollow',
    ),
    'type'      => 'link',
    'group'     => $group_layout_column_link,
    'condition' => $condition_layout_column_is_anchor,
  );


  // Individual Controls - Size
  // --------------------------

  $control_layout_column_width      = cs_recall( 'control_mixin_width',      [ 'key' => 'layout_column_width'      ] );
  $control_layout_column_min_width  = cs_recall( 'control_mixin_min_width',  [ 'key' => 'layout_column_min_width'  ] );
  $control_layout_column_max_width  = cs_recall( 'control_mixin_max_width',  [ 'key' => 'layout_column_max_width'  ] );
  $control_layout_column_height     = cs_recall( 'control_mixin_height',     [ 'key' => 'layout_column_height'     ] );
  $control_layout_column_min_height = cs_recall( 'control_mixin_min_height', [ 'key' => 'layout_column_min_height' ] );
  $control_layout_column_max_height = cs_recall( 'control_mixin_max_height', [ 'key' => 'layout_column_max_height' ] );


  // Control Groups
  // --------------

  return cs_compose_controls(
    array(
      'controls' => array(
        $control_layout_column_children,
        array(
          'type'     => 'group',
          'group'    => $group_layout_column_setup,
          'controls' => array(
            $control_layout_column_base_font_size,
            $control_layout_column_tag,
            $control_layout_column_text_align,
            $control_layout_column_overflow,
            $control_layout_column_z_index,
            $control_layout_column_background,
          ),
        ),
      ),
      'control_nav' => [
        $base_group                            => cs_recall( 'label_column' ),
        $group_layout_column_children          => cs_recall( 'label_children' ),
        $group_layout_column_setup             => cs_recall( 'label_setup' ),
        $group_layout_column_background_layers => cs_recall( 'label_background_layers' ),
        $group_layout_column_link              => cs_recall( 'label_link' ),
        $group_layout_column_size              => cs_recall( 'label_size' ),
        $group_layout_column_design            => cs_recall( 'label_design' ),
        $group_layout_column_particles         => cs_recall( 'label_particles' ),
      ],
    ),
    cs_partial_controls( 'bg', array(
      'group'     => $group_layout_column_background_layers,
      'condition' => array( 'layout_column_bg_advanced' => true ),
    ) ),
    array(
      'controls' => array(
        $control_layout_column_link,
        array(
          'type'     => 'group',
          'group'    => $group_layout_column_size,
          'controls' => array(
            $control_layout_column_width,
            $control_layout_column_min_width,
            $control_layout_column_max_width,
            $control_layout_column_height,
            $control_layout_column_min_height,
            $control_layout_column_max_height,
          ),
        ),
        cs_control( 'flexbox', 'layout_column', $settings_layout_column_design_flexbox ),
        cs_control( 'padding', 'layout_column', $settings_layout_column_design_no_color ),
        cs_control( 'border', 'layout_column', $settings_layout_column_design_with_color ),
        cs_control( 'border-radius', 'layout_column', $settings_layout_column_design_no_color ),
        cs_control( 'box-shadow', 'layout_column', $settings_layout_column_design_with_color )
      )
    ),
    cs_partial_controls( 'particle', [
      'label_prefix' => cs_recall( 'label_primary' ),
      'k_pre'        => 'layout_column_primary',
      'group'        => $group_layout_column_particles,
    ] ),
    cs_partial_controls( 'particle', [
      'label_prefix' => cs_recall( 'label_secondary' ),
      'k_pre'        => 'layout_column_secondary',
      'group'        => $group_layout_column_particles,
    ] ),
    cs_partial_controls( 'effects', [ 'has_provider' => true ] ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true, 'add_looper_provider' => true, 'add_looper_consumer' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'layout-column', [
  'title'   => __( 'Column', 'cornerstone' ),
  'values'  => $values,
  'migrations' => [
    [ 'layout_column_z_index' => '1' ],
    [
      'layout_column_padding'               => '!0px',
      'layout_column_box_shadow_dimensions' => '!0em 0em 0em 0em',
    ],
  ],
  'components' => [ 'bg', 'effects' ],
  'builder'    => 'x_element_builder_setup_layout_column',
  'tss'        => 'x_element_tss_layout_column',
  'render'     => 'x_element_render_layout_column',
  'icon'       => 'native',
  'children'   => 'x_layout_column',

  'options'    => [
    'valid_children'    => [ '*' ],
    'spacing_keys'      => [ 'layout_column_padding' ],
    'index_labels'      => true,
    'library'           => false,
    'empty_placeholder' => false,
    'is_draggable'      => false,
    'tag_key'           => 'layout_column_tag',
    'dropzone'          => [
      'enabled'     => true,
      'z_index_key' => 'layout_column_z_index'
    ],
    'contrast_keys' => [
      'bg:layout_column_bg_advanced',
      'layout_column_bg_color'
    ],
    'side_effects' => [
      [
        'observe'    => 'layout_column_bg_advanced',
        'conditions' => [
          ['key' => 'layout_column_bg_advanced', 'op' => '==', 'value' => true ],
          ['key' => 'layout_column_z_index',     'op' => '==', 'value' => 'auto' ]
        ],
        'apply' => [
          'layout_column_z_index' => '1'
        ]
      ]
    ]
  ]
] );
