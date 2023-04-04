<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/LAYOUT-SLIDE.PHP
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
    'layout_slide_base_font_size'        => cs_value( '1em', 'style' ),
    'layout_slide_tag'                   => cs_value( 'div', 'markup' ),
    'layout_slide_text_align'            => cs_value( 'none', 'style' ),
    'layout_slide_overflow'              => cs_value( 'visible', 'style' ),
    'layout_slide_z_index'               => cs_value( 'auto', 'style' ),
    'layout_slide_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'layout_slide_bg_color_alt'          => cs_value( '', 'style:color' ),
    'layout_slide_bg_advanced'           => cs_value( false, 'markup' ),

    'layout_slide_href'                  => cs_value( '', 'markup', true ),
    'layout_slide_blank'                 => cs_value( false, 'markup', true ),
    'layout_slide_nofollow'              => cs_value( false, 'markup', true ),

    'layout_slide_width'                 => cs_value( 'auto', 'style' ),
    'layout_slide_min_width'             => cs_value( '0px', 'style' ),
    'layout_slide_max_width'             => cs_value( 'none', 'style' ),
    'layout_slide_height'                => cs_value( 'auto', 'style' ),
    'layout_slide_min_height'            => cs_value( '0px', 'style' ),
    'layout_slide_max_height'            => cs_value( 'none', 'style' ),

    'layout_slide_flexbox'               => cs_value( false, 'style' ),
    'layout_slide_flex_direction'        => cs_value( 'column', 'style' ),
    'layout_slide_flex_wrap'             => cs_value( true, 'style' ),
    'layout_slide_flex_justify'          => cs_value( 'flex-start', 'style' ),
    'layout_slide_flex_align'            => cs_value( 'flex-start', 'style' ),

    'layout_slide_padding'               => cs_value( '!0px 0px 0px 0px', 'style' ),
    'layout_slide_border_width'          => cs_value( '!0px', 'style' ),
    'layout_slide_border_style'          => cs_value( 'solid', 'style' ),
    'layout_slide_border_color'          => cs_value( 'transparent', 'style:color' ),
    'layout_slide_border_color_alt'      => cs_value( '', 'style:color' ),
    'layout_slide_border_radius'         => cs_value( '!0px', 'style' ),
    'layout_slide_box_shadow_dimensions' => cs_value( '!0px 0px 0px 0px', 'style' ),
    'layout_slide_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
    'layout_slide_box_shadow_color_alt'  => cs_value( '', 'style:color' ),
  ),
  cs_values( 'particle', 'layout_slide_primary' ),
  cs_values( 'particle', 'layout_slide_secondary' ),
  'omega',
  'omega:custom-atts',
  'omega:looper-provider',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_tss_layout_slide() {

  return [
    'modules' => [
      'layout-slide',
      ['effects', [
        'args' => [
          'provided_scroll_transition' => true
        ],
      ]],
      ['particle', [
        'name'  => 'particle-primary',
        'args' => [
          'selector' => '.is-primary',
          'isDirectChild' => true
        ],
        'remap' => [
          'layout_slide_primary_particle' => 'particle',
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
          'layout_slide_secondary_particle' => 'particle',
          'effects_duration' => 'duration',
          'effects_timing_function' => 'timing_function'
        ]
      ]]
    ]
  ];
}




// Render
// =============================================================================

function x_element_render_layout_slide( $data ) {

  // Classes
  // -------

  $classes = [ 'x-slide' ];


  // Particles
  // ---------

  $particles = cs_make_particles( $data, 'layout_slide' );

  if ( ! empty( $particles ) ) {
    $classes[] = 'has-particle';
  }


  // Atts
  // ----

  $atts = [
    'class' => array_merge( $classes, $data['classes'] ),
    'data-x-slide' => ''
  ];

  if ( isset( $data['id'] ) && ! empty( $data['id'] ) ) {
    $atts['id'] = $data['id'];
  }

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }

  if ( $data['layout_slide_tag'] === 'a' ) {
    $atts = cs_apply_link( $atts, $data, 'layout_slide' );
  }

  $atts = cs_apply_effect( $atts, $data );


  // Output
  // ------

  return cs_tag( $data['layout_slide_tag'], $atts, $data['custom_atts'], [
    $data['layout_slide_bg_advanced'] ? cs_make_bg( $data ) : '',
    cs_render_child_elements( $data, 'x_layout_slide' ),
    $particles
  ]);

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_layout_slide() {

  // Helpers
  // -------

  $base_group                           = 'layout_slide';
  $group_layout_slide_children          = $base_group . ':children';
  $group_layout_slide_setup             = $base_group . ':setup';
  $group_layout_slide_background_layers = $base_group . ':background-layers';
  $group_layout_slide_link              = $base_group . ':link';
  $group_layout_slide_size              = $base_group . ':size';
  $group_layout_slide_design            = $base_group . ':design';
  $group_layout_slide_particles         = $base_group . ':particles';

  $condition_layout_slide_is_anchor     = array( 'layout_slide_tag' => 'a' );
  $condition_layout_slide_is_not_anchor = array( 'key' => 'layout_slide_tag', 'op' => '!=', 'value' => 'a' );


  // Settings
  // --------

  $settings_layout_slide_design_no_color = array(
    'group' => $group_layout_slide_design,
  );

  $settings_layout_slide_design_flexbox = array(
    'group'     => $group_layout_slide_design,
    'toggle'    => 'layout_slide_flexbox'
  );

  $settings_layout_slide_design_with_color = array(
    'group'     => $group_layout_slide_design,
    'alt_color' => true,
    'options'   => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  );


  // Individual Controls - Children
  // ------------------------------

  $control_layout_slide_children = array(
    'type'  => 'sortable',
    'group' => $group_layout_slide_children
  );


  // Individual Controls - Setup
  // ---------------------------

  $control_layout_slide_base_font_size = cs_recall( 'control_mixin_font_size',        [ 'key' => 'layout_slide_base_font_size'                                                                                           ] );
  $control_layout_slide_tag            = cs_recall( 'control_mixin_layout_tag',       [ 'key' => 'layout_slide_tag'                                                                                                      ] );
  $control_layout_slide_text_align     = cs_recall( 'control_mixin_text_align',       [ 'key' => 'layout_slide_text_align'                                                                                               ] );
  $control_layout_slide_overflow       = cs_recall( 'control_mixin_overflow',         [ 'key' => 'layout_slide_overflow'                                                                                                 ] );
  $control_layout_slide_z_index        = cs_recall( 'control_mixin_z_index',          [ 'key' => 'layout_slide_z_index'                                                                                                  ] );
  $control_layout_slide_background     = cs_recall( 'control_mixin_bg_color_int_adv', [ 'keys' => [ 'value' => 'layout_slide_bg_color', 'alt' => 'layout_slide_bg_color_alt', 'checkbox' => 'layout_slide_bg_advanced' ] ] );


  // Individual Controls - Link
  // --------------------------

  $control_layout_slide_link = array(
    'keys' => array(
      'url'      => 'layout_slide_href',
      'new_tab'  => 'layout_slide_blank',
      'nofollow' => 'layout_slide_nofollow',
    ),
    'type'      => 'link',
    'group'     => $group_layout_slide_link,
    'condition' => $condition_layout_slide_is_anchor,
  );


  // Individual Controls - Size
  // --------------------------

  $control_layout_slide_width      = cs_recall( 'control_mixin_width',      [ 'key' => 'layout_slide_width'      ] );
  $control_layout_slide_min_width  = cs_recall( 'control_mixin_min_width',  [ 'key' => 'layout_slide_min_width'  ] );
  $control_layout_slide_max_width  = cs_recall( 'control_mixin_max_width',  [ 'key' => 'layout_slide_max_width'  ] );
  $control_layout_slide_height     = cs_recall( 'control_mixin_height',     [ 'key' => 'layout_slide_height'     ] );
  $control_layout_slide_min_height = cs_recall( 'control_mixin_min_height', [ 'key' => 'layout_slide_min_height' ] );
  $control_layout_slide_max_height = cs_recall( 'control_mixin_max_height', [ 'key' => 'layout_slide_max_height' ] );


  // Control Groups
  // --------------

  return cs_compose_controls(
    array(
      'controls' => array(
        $control_layout_slide_children,
        array(
          'type'     => 'group',
          'group'    => $group_layout_slide_setup,
          'controls' => array(
            $control_layout_slide_base_font_size,
            $control_layout_slide_tag,
            $control_layout_slide_text_align,
            $control_layout_slide_overflow,
            $control_layout_slide_z_index,
            $control_layout_slide_background,
          ),
        ),
      ),
      'control_nav' => [
        $base_group                           => cs_recall( 'label_slide' ),
        $group_layout_slide_children          => cs_recall( 'label_children' ),
        $group_layout_slide_setup             => cs_recall( 'label_setup' ),
        $group_layout_slide_background_layers => cs_recall( 'label_background_layers' ),
        $group_layout_slide_link              => cs_recall( 'label_link' ),
        $group_layout_slide_size              => cs_recall( 'label_size' ),
        $group_layout_slide_design            => cs_recall( 'label_design' ),
        $group_layout_slide_particles         => cs_recall( 'label_particles' ),
      ],
    ),
    cs_partial_controls( 'bg', array(
      'group'     => $group_layout_slide_background_layers,
      'condition' => array( 'layout_slide_bg_advanced' => true ),
    ) ),
    array(
      'controls' => array(
        $control_layout_slide_link,
        array(
          'type'     => 'group',
          'group'    => $group_layout_slide_size,
          'controls' => array(
            $control_layout_slide_width,
            $control_layout_slide_min_width,
            $control_layout_slide_max_width,
            $control_layout_slide_height,
            $control_layout_slide_min_height,
            $control_layout_slide_max_height,
          ),
        ),
        cs_control( 'flexbox', 'layout_slide', $settings_layout_slide_design_flexbox ),
        cs_control( 'padding', 'layout_slide', $settings_layout_slide_design_no_color ),
        cs_control( 'border', 'layout_slide', $settings_layout_slide_design_with_color ),
        cs_control( 'border-radius', 'layout_slide', $settings_layout_slide_design_no_color ),
        cs_control( 'box-shadow', 'layout_slide', $settings_layout_slide_design_with_color )
      )
    ),
    cs_partial_controls( 'particle', [
      'label_prefix' => cs_recall( 'label_primary' ),
      'k_pre'        => 'layout_slide_primary',
      'group'        => $group_layout_slide_particles,
    ] ),
    cs_partial_controls( 'particle', [
      'label_prefix' => cs_recall( 'label_secondary' ),
      'k_pre'        => 'layout_slide_secondary',
      'group'        => $group_layout_slide_particles,
    ] ),
    cs_partial_controls( 'effects', [ 'has_provider' => true, 'no_scroll_offset_behavior_or_transition' => true ] ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true, 'add_looper_provider' => true, 'add_looper_consumer' => true, 'add_hide_during_breakpoints' => false ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'layout-slide', [
  'title'      => __( 'Slide', 'cornerstone' ),
  'values'     => $values,
  'components' => [
    'bg',
    [ 'type' => 'effects', 'values' => [ 'effects_transform_enter' => '', 'effects_transform_exit' => '' ] ],
  ],
  'builder'    => 'x_element_builder_setup_layout_slide',
  'tss'        => 'x_element_tss_layout_slide',
  'render'     => 'x_element_render_layout_slide',
  'icon'       => 'native',
  'children'   => 'x_layout_slide',
  'options'    => [
    'valid_children'    => [ '*' ],
    'index_labels'      => true,
    'library'           => false,
    'empty_placeholder' => false,
    'is_draggable'      => false,
    'tag_key'           => 'layout_slide_tag',
    'dropzone'          => [
      'enabled'     => true,
      'z_index_key' => 'layout_slide_z_index'
    ],
    'contrast_keys' => [
      'bg:layout_slide_bg_advanced',
      'layout_slide_bg_color'
    ],
    'side_effects' => [
      [
        'observe'    => 'layout_slide_bg_advanced',
        'conditions' => [
          ['key' => 'layout_slide_bg_advanced', 'op' => '==', 'value' => true ],
          ['key' => 'layout_slide_z_index',     'op' => '==', 'value' => 'auto' ]
        ],
        'apply' => [
          'layout_slide_z_index' => '1'
        ]
      ]
    ]
  ]
] );
