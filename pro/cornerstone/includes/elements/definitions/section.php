<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/SECTION.PHP
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
    'section_base_font_size'        => cs_value( '1em' ),
    'section_tag'                   => cs_value( 'div', 'markup' ),
    'section_text_align'            => cs_value( 'none' ),
    'section_overflow'              => cs_value( 'visible' ),
    'section_z_index'               => cs_value( 'auto' ),
    'section_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'section_bg_color_alt'          => cs_value( '', 'style:color' ),
    'section_bg_advanced'           => cs_value( false, 'markup' ),

    'section_href'                  => cs_value( '', 'markup', true ),
    'section_blank'                 => cs_value( false, 'markup', true ),
    'section_nofollow'              => cs_value( false, 'markup', true ),

    'section_margin'                => cs_value( '!0px 0px 0px 0px' ),
    'section_padding'               => cs_value( '65px 0px 65px 0px' ),
    'section_border_width'          => cs_value( '!0px' ),
    'section_border_style'          => cs_value( 'solid' ),
    'section_border_color'          => cs_value( 'transparent', 'style:color' ),
    'section_border_color_alt'      => cs_value( '', 'style:color' ),
    'section_border_radius'         => cs_value( '!0px' ),
    'section_box_shadow_dimensions' => cs_value( '!0px 0px 0px 0px' ),
    'section_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
    'section_box_shadow_color_alt'  => cs_value( '', 'style:color' ),
  ],
  cs_values( 'separator', 'section_top' ),
  cs_values( 'separator', 'section_bottom' ),
  cs_values( 'particle', 'section_primary' ),
  cs_values( 'particle', 'section_secondary' ),
  'omega',
  'omega:style',
  'omega:custom-atts',
  'omega:looper-provider',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_tss_section() {
  return [
    'modules' => [
      'section',
      'effects',
      ['particle', [
        'name'  => 'particle-primary',
        'args' => [
          'selector' => '.is-primary',
          'isDirectChild' => true
        ],
        'remap' => [
          'section_primary_particle' => 'particle',
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
          'section_secondary_particle' => 'particle',
          'effects_duration' => 'duration',
          'effects_timing_function' => 'timing_function'
        ]
      ]]
    ]
  ];
}



// Render
// =============================================================================

function x_element_render_section( $data ) {


  // Prepare Attr Values
  // -------------------

  $classes = [ 'x-section' ];


  // Separators
  // ----------

  $section_top_separator_content = null;
  $section_bottom_separator_content = null;

  if ( $data['section_top_separator'] === true ) {
    $section_top_separator_content = cs_get_partial_view( 'separator',
      array_merge( cs_extract( x_preview_props( [
        'section_top_separator_angle_point',
        'section_top_separator_height',
        'section_top_separator_inset',
        'section_top_separator_color',
      ], $data) , [ 'section_top_separator' => 'separator' ] ), [
        'separator_location' => 'top'
      ])
    );
  }

  if ( $data['section_bottom_separator'] === true ) {
    $section_bottom_separator_content = cs_get_partial_view( 'separator',
      array_merge(  cs_extract( x_preview_props( [
        'section_bottom_separator_angle_point',
        'section_bottom_separator_height',
        'section_bottom_separator_inset',
        'section_bottom_separator_color',
      ], $data) , [ 'section_bottom_separator' => 'separator' ] ), [
        'separator_location' => 'bottom'
      ])
    );
  }



  // Particles
  // ---------

  $particles = cs_make_particles( $data, 'section' );

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

  if ( $data['section_tag'] === 'a' ) {
    $atts = cs_apply_link( $atts, $data, 'section' );
  }

  $atts = cs_apply_effect( $atts, $data );


  // Output
  // ------

  return cs_tag( $data['section_tag'], $atts, $data['custom_atts'], [
    $section_top_separator_content,
    $data['section_bg_advanced'] ? cs_make_bg( $data ) : '',
    cs_render_child_elements( $data, 'x_section' ),
    $particles,
    $section_bottom_separator_content
  ]);

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_section() {

  // Helpers
  // -------

  $base_group                      = 'section';
  $group_section_setup             = $base_group . ':setup';
  $group_section_children          = $base_group . ':layout';
  $group_section_background_layers = $base_group . ':background-layers';
  $group_section_link              = $base_group . ':link';
  $group_section_separators        = $base_group . ':separators';
  $group_section_design            = $base_group . ':design';
  $group_section_particles         = $base_group . ':particles';

  $condition_section_is_anchor     = [ 'section_tag' => 'a' ];
  $condition_section_is_not_anchor = [ 'key' => 'section_tag', 'op' => '!=', 'value' => 'a' ];


  // Settings
  // --------

  $settings_section_design_no_color = [
    'group' => $group_section_design,
  ];

  $settings_section_design_with_color = [
    'group'     => $group_section_design,
    'alt_color' => true,
    'options'   => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  ];


  // Individual Controls - Children
  // ------------------------------

  $control_section_children = [
    'type'    => 'sortable',
    'group'   => $group_section_children,
    'options' => [ 'horizontal_label' => cs_recall( 'label_children' ) ],
  ];


  // Individual Controls - Setup
  // ---------------------------

  $control_section_base_font_size = cs_recall( 'control_mixin_font_size',        [ 'key' => 'section_base_font_size'                                                                                 ] );
  $control_section_tag            = cs_recall( 'control_mixin_layout_tag',       [ 'key' => 'section_tag'                                                                                            ] );
  $control_section_text_align     = cs_recall( 'control_mixin_text_align',       [ 'key' => 'section_text_align'                                                                                     ] );
  $control_section_overflow       = cs_recall( 'control_mixin_overflow',         [ 'key' => 'section_overflow'                                                                                       ] );
  $control_section_z_index        = cs_recall( 'control_mixin_z_index',          [ 'key' => 'section_z_index'                                                                                        ] );
  $control_section_background     = cs_recall( 'control_mixin_bg_color_int_adv', [ 'keys' => [ 'value' => 'section_bg_color', 'alt' => 'section_bg_color_alt', 'checkbox' => 'section_bg_advanced' ] ] );


  // Individual Controls - Link
  // --------------------------

  $control_section_link = [
    'keys' => [
      'url'      => 'section_href',
      'new_tab'  => 'section_blank',
      'nofollow' => 'section_nofollow',
    ],
    'type'      => 'link',
    'group'     => $group_section_link,
    'condition' => $condition_section_is_anchor,
  ];


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    [
      'controls' => [
        $control_section_children,
        [
          'type'     => 'group',
          'group'    => $group_section_setup,
          'controls' => [
            $control_section_base_font_size,
            $control_section_tag,
            $control_section_text_align,
            $control_section_overflow,
            $control_section_z_index,
            $control_section_background,
          ],
        ],
      ],
      'control_nav' => [
        'section'                        => cs_recall( 'label_section' ),
        $group_section_children          => cs_recall( 'label_children' ),
        $group_section_setup             => cs_recall( 'label_setup' ),
        $group_section_background_layers => cs_recall( 'label_background_layers' ),
        $group_section_link              => cs_recall( 'label_link' ),
        $group_section_separators        => cs_recall( 'label_separators' ),
        $group_section_design            => cs_recall( 'label_design' ),
        $group_section_particles         => cs_recall( 'label_particles' ),
      ],
    ],
    cs_partial_controls( 'bg', [
      'group'     => $group_section_background_layers,
      'condition' => [ 'section_bg_advanced' => true ],
    ] ),
    [
      'controls' => [
        $control_section_link,
      ],
    ],
    cs_partial_controls( 'separator', [
      'k_pre'    => 'section_top',
      'label'    => cs_recall( 'label_top' ),
      'group'    => $group_section_separators,
      'location' => 'top'
    ] ),
    cs_partial_controls( 'separator', [
      'k_pre'    => 'section_bottom',
      'label'    => cs_recall( 'label_bottom' ),
      'group'    => $group_section_separators,
      'location' => 'bottom'
    ] ),
    [
      'controls' => [
        cs_control( 'margin', 'section', $settings_section_design_no_color ),
        cs_control( 'padding', 'section', $settings_section_design_no_color ),
        cs_control( 'border', 'section', $settings_section_design_with_color ),
        cs_control( 'border-radius', 'section', $settings_section_design_no_color ),
        cs_control( 'box-shadow', 'section', $settings_section_design_with_color )
      ],
    ],
    cs_partial_controls( 'particle', [
      'label_prefix' => cs_recall( 'label_primary' ),
      'k_pre'        => 'section_primary',
      'group'        => $group_section_particles,
    ] ),
    cs_partial_controls( 'particle', [
      'label_prefix' => cs_recall( 'label_secondary' ),
      'k_pre'        => 'section_secondary',
      'group'        => $group_section_particles,
    ] ),
    cs_partial_controls( 'effects', [ 'has_provider' => true ] ),
    cs_partial_controls( 'omega', [ 'add_style' => true, 'add_custom_atts' => true, 'add_looper_provider' => true, 'add_looper_consumer' => true ] )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'section', [
  'title'      => __( 'Section', 'cornerstone' ),
  'values'     => $values,
  'migrations' => [
    [ 'section_z_index' => '1' ],
    [
      'section_margin'                => '!0em',
      'section_padding'               => '45px 0px 45px 0px',
      'section_box_shadow_dimensions' => '!0em 0em 0em 0em',
    ],
  ],
  'components' => [ 'bg', 'effects' ],
  'builder'    => 'x_element_builder_setup_section',
  'tss'        => 'x_element_tss_section',
  'render'     => 'x_element_render_section',
  'icon'       => 'native',
  'children'   => 'x_section',
  'options'    => [
    'valid_children'    => [ 'row', 'layout-row', 'layout-grid', 'layout-div', 'layout-slide-container', 'global-block' ],
    'spacing_keys'      => [ 'section_margin', 'section_padding' ],
    'index_labels'      => true,
    'library'           => false,
    'empty_placeholder' => false,
    'is_draggable'      => false,
    'default_children'  => [ [ '_type' => 'layout-row' ] ],
    'dropzone'          => [
      'proxy'       => true,
      'z_index_key' => 'section_z_index'
    ],
    'add_new_element' => [ '_type' => 'layout-row' ],
    'tag_key'         => 'section_tag',
    'contrast_keys'   => [
      'bg:section_bg_advanced',
      'section_bg_color'
    ],
    'side_effects' => [
      [
        'observe'    => 'section_bg_advanced',
        'conditions' => [
          ['key' => 'section_bg_advanced', 'op' => '==', 'value' => true   ],
          ['key' => 'section_z_index',     'op' => '==', 'value' => 'auto' ]
        ],
        'apply' => [
          'section_z_index' => '1'
        ]
      ],
      [
        'observe'    => 'section_top_separator',
        'conditions' => [
          ['key' => 'section_top_separator', 'op' => '==', 'value' => true   ],
          ['key' => 'section_z_index',       'op' => '==', 'value' => 'auto' ]
        ],
        'apply' => [
          'section_z_index' => '1'
        ]
      ],
      [
        'observe' => 'section_bottom_separator',
        'conditions' => [
          ['key' => 'section_bottom_separator', 'op' => '==', 'value' => true   ],
          ['key' => 'section_z_index',          'op' => '==', 'value' => 'auto' ]
        ],
        'apply' => [
          'section_z_index' => '1'
        ]
      ]
    ]
  ]
] );
