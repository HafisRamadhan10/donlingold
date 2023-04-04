<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/LAYOUT-SLIDE-CONTAINER.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Values
//   02. Style
//   03. Has Adaptive Height Helper
//   04. Render
//   05. Builder Setup
//   06. Register Element
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  array(
    'layout_slide_container_base_font_size'           => cs_value( '1em', 'style' ),
    'layout_slide_container_tag'                      => cs_value( 'div', 'markup' ),
    'layout_slide_container_overflow'                 => cs_value( 'hidden', 'style' ),

    'layout_slide_container_layout_type'              => cs_value( 'inline', 'markup' ),
    'layout_slide_container_inline_slide_basis'       => cs_value( 'paged', 'markup' ),
    'layout_slide_container_inline_page_count'        => cs_value( '1', 'style' ),
    'layout_slide_container_inline_gap'               => cs_value( '1em', 'style' ),
    'layout_slide_container_inline_align'             => cs_value( 'stretch', 'style' ),
    'layout_slide_container_stacked_align'            => cs_value( 'stretch', 'markup' ),
    'layout_slide_container_inline_justify'           => cs_value( 'start', 'markup' ),

    'layout_slide_container_autoplay'                 => cs_value( 'off', 'markup' ),
    'layout_slide_container_autoplay_duration'        => cs_value( '5000ms', 'markup' ),
    'layout_slide_container_inline_wrap_around'       => cs_value( false, 'markup' ),
    'layout_slide_container_inline_marquee_speed'     => cs_value( 0.1, 'markup' ),
    'layout_slide_container_inline_contain'           => cs_value( false, 'markup' ),
    'layout_slide_container_adaptive_height'          => cs_value( false, 'markup' ),
    'layout_slide_container_inline_interaction'       => cs_value( 'off', 'markup' ),
    'layout_slide_container_stacked_swipe'            => cs_value( '', 'markup' ),
    'layout_slide_container_inline_free_scroll'       => cs_value( false, 'markup' ),
    'layout_slide_container_inline_scroll_by'         => cs_value( 'content', 'markup' ),
    'layout_slide_container_stacked_entrance'         => cs_value( 'fade', 'markup' ),
    'layout_slide_container_stacked_exit'             => cs_value( 'fade', 'markup' ),
    'layout_slide_container_duration'                 => cs_value( '500ms', 'markup' ),
    'layout_slide_container_timing_function'          => cs_value( 'cubic-bezier(0.400, 0.000, 0.200, 1.000)', 'markup' ),

    'layout_slide_container_content_global_container' => cs_value( false, 'markup' ),
    'layout_slide_container_content_width'            => cs_value( '100%', 'style' ),
    'layout_slide_container_content_max_width'        => cs_value( 'none', 'style' ),

    'layout_slide_container_padding'                  => cs_value( '!0px 0px 0px 0px', 'style' ),
  ),
  'omega',
  'omega:custom-atts',
  'omega:looper-provider',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_tss_layout_slide_container() {

  return [
    'modules' => [
      'layout-slide-container',
      'effects',
      ['particle', [
        'name'  => 'particle-primary',
        'args' => [
          'selector' => '.is-primary',
          'isDirectChild' => true
        ],
        'remap' => [
          'layout_slide_container_primary_particle' => 'particle',
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
          'layout_slide_container_secondary_particle' => 'particle',
          'effects_duration' => 'duration',
          'effects_timing_function' => 'timing_function'
        ]
      ]]
    ]
  ];
}



// Has Adaptive Height Helper
// =============================================================================

function x_slide_container_has_adaptive_height( $data ) {

  $has_adaptive_height_on     = $data['layout_slide_container_adaptive_height'] == true;
  $is_stacked_and_not_stretch = ( $data['layout_slide_container_layout_type'] == 'stacked' && $data['layout_slide_container_stacked_align'] != 'stretch' );
  $is_inline_and_not_stretch  = ( $data['layout_slide_container_layout_type'] == 'inline' && $data['layout_slide_container_inline_align'] != 'stretch' );

  return $has_adaptive_height_on && ( $is_stacked_and_not_stretch || $is_inline_and_not_stretch );

}



// Render
// =============================================================================

function x_element_slide_container_config( $data ) {

  $config = [];


  // Inline Only Properties
  // ----------------------

  if ( $data['layout_slide_container_layout_type'] === 'inline' ) {

    if ( $data['layout_slide_container_inline_justify'] !== 'start' ) {
      $config['justify'] = $data['layout_slide_container_inline_justify'];
    }

    if ( $data['layout_slide_container_inline_slide_basis'] !== 'paged') { // paged / auto
      $config['autoBasis'] = true;
    }

    if ( ! $data['layout_slide_container_inline_free_scroll'] ) {
      $config['snap'] = true;
    }

    if ( $data['layout_slide_container_inline_scroll_by'] === 'slide') { // slide / content
      $config['scrollBySlide'] = true;
    }

    if ( $data['layout_slide_container_inline_wrap_around'] ) {
      $config['wrapAround'] = true;
    }

    if ( $data['layout_slide_container_inline_contain'] ) {
      $config['contain'] = true;
    }

    if ( $data['layout_slide_container_inline_interaction'] !== 'off' ) {
      $config['int'] = $data['layout_slide_container_inline_interaction'];
    }
  }


  // Stacked Only Properties
  // -----------------------

  if ( $data['layout_slide_container_layout_type'] === 'stacked' ) {

    if ( $data['layout_slide_container_stacked_entrance'] !== 'effect' ) {
      $config['enter'] = $data['layout_slide_container_stacked_entrance'];
    }

    if ( $data['layout_slide_container_stacked_exit'] !== 'effect' ) {
      $config['exit'] = $data['layout_slide_container_stacked_exit'];
    }

    if ( $data['layout_slide_container_stacked_swipe'] !== 'off' ) {
      $config['swipe'] = trim($data['layout_slide_container_stacked_swipe']);
    }
  }


  // Global Properties
  // -----------------

  if ( $data['layout_slide_container_autoplay'] !== 'off' ) {
    $config['autoplay'] = $data['layout_slide_container_autoplay'];
  }

  if ( $data['layout_slide_container_autoplay'] === 'marquee' ) {
    $config['speed'] = $data['layout_slide_container_inline_marquee_speed'];
  }

  if ( x_slide_container_has_adaptive_height( $data ) ) {
    $config['adaptiveHeight'] = true;
  }

  if ( $data['layout_slide_container_layout_type'] === 'stacked' ) {
    $config['stacked'] = true;
  }

  return empty( $config ) ? '' : cs_prepare_json_att( $config );

}


function x_element_render_layout_slide_container( $data ) {

  // Atts (Viewport)
  // ---------------

  $classes_viewport = [ 'x-slide-container-viewport', 'is-loading' ];

  $atts_viewport = [
    'class'                  => array_merge( $classes_viewport, $data['classes'] ),
    'data-x-slide-container' => x_element_slide_container_config( $data )
  ];

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts_viewport['style'] = $data['style'];
  }

  if ( isset( $data['id'] ) && ! empty( $data['id'] ) ) {
    $atts_viewport['id'] = $data['id'];
  }

  $atts_viewport = cs_apply_effect( $atts_viewport, $data );


  // Atts (Content)
  // --------------

  $classes_content = [ 'x-slide-container-content' ];

  if ( x_slide_container_has_adaptive_height( $data ) ) {
    $classes_content[] = 'has-adaptive-height';
  }

  if ( $data['layout_slide_container_content_global_container'] == true ) {
    $classes_content[] = 'x-container max width';
  }

  $atts_content = [
    'class' => $classes_content
  ];

  $atts_content = cs_apply_effect( $atts_content, $data );


  // Atts (Container)
  // ----------------

  $classes_container = [ 'x-slide-container', 'is-' . $data['layout_slide_container_layout_type'] ];

  if ( $data['layout_slide_container_layout_type'] === 'inline' ) {
    $classes_container[] = 'is-' . $data['layout_slide_container_inline_slide_basis'];
  }

  $atts_container = [
    'class' => $classes_container
  ];


  // Output
  // ------

  return cs_tag( 'div', $atts_viewport, $data['custom_atts'], [
    cs_tag( 'div', $atts_content, [
      cs_tag( $data['layout_slide_container_tag'], $atts_container, cs_render_child_elements( $data, 'x_layout_slide_container' )),
    ])
  ]);

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_layout_slide_container() {

  // Groups
  // ------

  $base_group                            = 'layout_slide_container';
  $group_layout_slide_container_children = $base_group . ':children';
  $group_layout_slide_container_setup    = $base_group . ':setup';
  $group_layout_slide_container_layout   = $base_group . ':layout';
  $group_layout_slide_container_options  = $base_group . ':options';
  $group_layout_slide_container_size     = $base_group . ':size';
  $group_layout_slide_container_design   = $base_group . ':design';


  // Conditions
  // ----------

  $condition_layout_slide_container_layout_type_inline           = [ 'layout_slide_container_layout_type' => 'inline' ];
  $condition_layout_slide_container_layout_type_stacked          = [ 'layout_slide_container_layout_type' => 'stacked' ];
  $condition_layout_slide_container_inline_slide_basis_paged     = [ 'layout_slide_container_inline_slide_basis' => 'paged' ];
  $condition_layout_slide_container_inline_slide_basis_auto      = [ 'layout_slide_container_inline_slide_basis' => 'auto' ];
  $condition_layout_slide_container_inline_align_is_not_stretch  = [ 'key' => 'layout_slide_container_inline_align', 'op' => '!=', 'value' => 'stretch' ];
  $condition_layout_slide_container_stacked_align_is_not_stretch = [ 'key' => 'layout_slide_container_stacked_align', 'op' => '!=', 'value' => 'stretch' ];
  $condition_layout_slide_container_autoplay_not_marquee         = [ 'key' => 'layout_slide_container_autoplay', 'op' => '!=', 'value' => 'marquee' ];
  $condition_layout_slide_container_autoplay_is_marquee          = [ 'layout_slide_container_autoplay' => 'marquee' ];
  $condition_layout_slide_container_autoplay_transition          = [ 'layout_slide_container_autoplay' => 'interval' ];
  $condition_layout_slide_container_inline_no_wrap_around        = [ 'layout_slide_container_inline_wrap_around' => false ];
  $condition_layout_slide_container_inline_interaction_is_drag   = [ 'key' => 'layout_slide_container_inline_interaction', 'op' => 'LIKE', 'value' => 'drag' ];
  $condition_layout_slide_container_content_container_enabled    = [ 'layout_slide_container_content_global_container' => true ];
  $condition_layout_slide_container_content_container_disabled   = [ 'layout_slide_container_content_global_container' => false ];
  $condition_layout_slide_container_stacked_entrance_is_not_none = [ 'key' => 'layout_slide_container_stacked_entrance', 'op' => '!=', 'value' => 'none' ];


  // Individual Controls - Children
  // ------------------------------

  $control_layout_slide_container_children = [
    'type'  => 'sortable',
    'group' => $group_layout_slide_container_children
  ];


  // Individual Controls - Setup
  // ---------------------------

  $control_layout_slide_container_base_font_size = cs_recall( 'control_mixin_font_size',            [ 'key' => 'layout_slide_container_base_font_size' ] );
  $control_layout_slide_container_tag            = cs_recall( 'control_mixin_layout_tag_no_anchor', [ 'key' => 'layout_slide_container_tag'            ] );
  $control_layout_slide_container_overflow       = cs_recall( 'control_mixin_overflow',             [ 'key' => 'layout_slide_container_overflow'       ] );


  // Individual Controls - Layout
  // ----------------------------

  $control_layout_slide_container_layout_type = [
    'key'         => 'layout_slide_container_layout_type',
    'type'        => 'choose',
    'label'       => cs_recall( 'label_type' ),
    'description' => __( 'When using an "Inline" layout only, individual slides can have Scroll Effects applied to augment their entrance and exit states within their slider context.', '__x__' ),
    'options'     => [
      'choices' => [
        [ 'value' => 'inline',  'label' => cs_recall( 'label_inline' )  ],
        [ 'value' => 'stacked', 'label' => cs_recall( 'label_stacked' ) ],
      ],
    ],
  ];

  $control_layout_slide_container_inline_slide_basis = [
    'key'       => 'layout_slide_container_inline_slide_basis',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_slides' ),
    'condition' => $condition_layout_slide_container_layout_type_inline,
    'options'   => [
      'choices' => [
        [ 'value' => 'paged', 'label' => cs_recall( 'label_paged' ) ],
        [ 'value' => 'auto',  'label' => cs_recall( 'label_auto' )  ],
      ],
    ],
  ];

  $control_layout_slide_container_inline_page_count = [
    'key'        => 'layout_slide_container_inline_page_count',
    'type'       => 'unit-slider',
    'label'      => cs_recall( 'label_num_per_page' ),
    'conditions' => [ $condition_layout_slide_container_layout_type_inline, $condition_layout_slide_container_inline_slide_basis_paged ],
    'options'    => [
      'unit_mode' => 'unitless',
      'min'       => 1,
      'max'       => 8,
      'step'      => 1,
    ],
  ];

  $control_layout_slide_container_inline_gap     = cs_recall( 'control_mixin_gap',                            [ 'key' => 'layout_slide_container_inline_gap', 'condition' => $condition_layout_slide_container_layout_type_inline                                                                                                  ] );
  $control_layout_slide_container_inline_align   = cs_recall( 'control_mixin_align_items',                    [ 'key' => 'layout_slide_container_inline_align', 'label' => cs_recall( 'label_align' ), 'condition' => $condition_layout_slide_container_layout_type_inline, 'options' => cs_recall( 'options_align_items_flex' )   ] );
  $control_layout_slide_container_stacked_align  = cs_recall( 'control_mixin_align_items',                    [ 'key' => 'layout_slide_container_stacked_align', 'label' => cs_recall( 'label_align' ), 'condition' => $condition_layout_slide_container_layout_type_stacked, 'options' => cs_recall( 'options_align_items_grid' ) ] );
  $control_layout_slide_container_inline_justify = cs_recall( 'control_mixin_justify_slide_container_inline', [ 'key' => 'layout_slide_container_inline_justify', 'condition' => $condition_layout_slide_container_layout_type_inline                                                                                              ] );


  // Individual Controls - Config
  // ----------------------------

  $control_layout_slide_container_autoplay_inline = [
    'key'       => 'layout_slide_container_autoplay',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_autoplay' ),
    'condition' => $condition_layout_slide_container_layout_type_inline,
    'options'   => [
      'off_value' => 'off',
      'choices'   => [
        [ 'value' => 'interval', 'label' => cs_recall( 'label_interval' ) ],
        [ 'value' => 'marquee',  'label' => cs_recall( 'label_marquee' )  ],
      ],
    ],
  ];

  $control_layout_slide_container_autoplay_stacked = [
    'key'       => 'layout_slide_container_autoplay',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_autoplay' ),
    'condition' => $condition_layout_slide_container_layout_type_stacked,
    'options'   => [
      'choices'   => [
        [ 'value' => 'off',      'label' => cs_recall( 'label_disable' )  ],
        [ 'value' => 'interval', 'label' => cs_recall( 'label_interval' ) ],
      ],
    ],
  ];

  $control_layout_slide_container_autoplay_duration = cs_recall( 'control_mixin_transition', [ 'keys' => [ 'duration' => 'layout_slide_container_autoplay_duration' ], 'label' => cs_recall( 'label_duration' ), 'condition' => $condition_layout_slide_container_autoplay_transition ] );


  $control_layout_slide_container_inline_marquee_speed = [
    'key'     => 'layout_slide_container_inline_marquee_speed',
    'type'    => 'unit-slider',
    'label'   => cs_recall( 'label_speed' ),
    'condition' => $condition_layout_slide_container_autoplay_is_marquee,
    'options' => [
      'unit_mode'      => 'unitless',
      'fallback_value' => 0.1,
      'min'            => -1,
      'max'            => 1,
      'step'           => 0.025,
    ],
  ];


  $control_layout_slide_container_inline_wrap_around = [
    'key'       => 'layout_slide_container_inline_wrap_around',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_wrap' ),
    'condition' => $condition_layout_slide_container_layout_type_inline,
    'options'   => [
      'choices' => [
        [ 'value' => false, 'label' => cs_recall( 'label_reset' )    ],
        [ 'value' => true,  'label' => cs_recall( 'label_carousel' ) ],
      ],
    ],
  ];

  $control_layout_slide_container_inline_contain = [
    'key'        => 'layout_slide_container_inline_contain',
    'type'       => 'choose',
    'label'      => cs_recall( 'label_contain' ),
    'conditions' => [ $condition_layout_slide_container_layout_type_inline, $condition_layout_slide_container_inline_no_wrap_around ],
    'options'    => [
      'choices' => [
        [ 'value' => false, 'label' => cs_recall( 'label_ignore' ) ],
        [ 'value' => true,  'label' => cs_recall( 'label_at_edges' )  ],
      ],
    ],
  ];

  $control_layout_slide_container_adaptive_height_for_inline = [
    'key'        => 'layout_slide_container_adaptive_height',
    'type'       => 'choose',
    'label'      => cs_recall( 'label_height' ),
    'conditions' => [ $condition_layout_slide_container_layout_type_inline, $condition_layout_slide_container_inline_align_is_not_stretch ],
    'options'    => [
      'choices' => [
        [ 'value' => false, 'label' => cs_recall( 'label_static' )   ],
        [ 'value' => true,  'label' => cs_recall( 'label_adaptive' ) ],
      ],
    ],
  ];

  $control_layout_slide_container_adaptive_height_for_stacked = [
    'key'        => 'layout_slide_container_adaptive_height',
    'type'       => 'choose',
    'label'      => cs_recall( 'label_height' ),
    'conditions' => [ $condition_layout_slide_container_layout_type_stacked, $condition_layout_slide_container_stacked_align_is_not_stretch ],
    'options'    => [
      'choices' => [
        [ 'value' => false, 'label' => cs_recall( 'label_static' )   ],
        [ 'value' => true,  'label' => cs_recall( 'label_adaptive' ) ],
      ],
    ],
  ];

  $control_layout_slide_container_inline_interaction = [
    'key'       => 'layout_slide_container_inline_interaction',
    'type'      => 'multi-choose',
    'label'     => cs_recall( 'label_interaction' ),
    'condition' => $condition_layout_slide_container_layout_type_inline,
    'options'   => [
      'off_value' => 'off',
      'choices' => [
        [ 'value' => 'click', 'label' => cs_recall( 'label_click' ) ],
        [ 'value' => 'drag',  'label' => cs_recall( 'label_drag' )  ]
      ],
    ],
  ];

  $control_layout_slide_container_stacked_swipe = [
    'key'       => 'layout_slide_container_stacked_swipe',
    'type'      => 'multi-choose',
    'label'     => cs_recall( 'label_swipe' ),
    'condition' => $condition_layout_slide_container_layout_type_stacked,
    'options'   => [
      'choices'   => [
        [ 'value' => 'x', 'label' => cs_recall( 'label_x' ) ],
        [ 'value' => 'y', 'label' => cs_recall( 'label_y' ) ],
      ],
    ],
  ];

  $control_layout_slide_container_inline_free_scroll = [
    'key'        => 'layout_slide_container_inline_free_scroll',
    'type'       => 'choose',
    'label'      => cs_recall( 'label_scrolling' ),
    'conditions' => [ $condition_layout_slide_container_layout_type_inline, $condition_layout_slide_container_autoplay_not_marquee, $condition_layout_slide_container_inline_interaction_is_drag ],
    'options'    => [
      'choices' => [
        [ 'value' => false, 'label' => cs_recall( 'label_snap' ) ],
        [ 'value' => true,  'label' => cs_recall( 'label_free' ) ],
      ],
    ],
  ];

  $control_layout_slide_container_inline_scroll_by = [
    'key'        => 'layout_slide_container_inline_scroll_by',
    'type'       => 'choose',
    'label'      => cs_recall( 'label_scroll_by' ),
    'conditions' => [ $condition_layout_slide_container_layout_type_inline, $condition_layout_slide_container_autoplay_not_marquee ],
    'options'    => [
      'choices' => [
        [ 'value' => 'content', 'label' => cs_recall( 'label_content' ) ],
        [ 'value' => 'slide',   'label' => cs_recall( 'label_slide' )   ],
      ],
    ],
  ];

  $control_layout_slide_container_stacked_entrance = [
    'key'       => 'layout_slide_container_stacked_entrance',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_entrance' ),
    'condition' => $condition_layout_slide_container_layout_type_stacked,
    'options'   => [
      'choices'   => [
        [ 'value' => 'fade',   'label' => cs_recall( 'label_fade' )   ],
        [ 'value' => 'effect', 'label' => cs_recall( 'label_effect' ) ],
        [ 'value' => 'none',   'label' => cs_recall( 'label_none' )   ],
      ],
    ],
  ];

  $control_layout_slide_container_stacked_exit = [
    'key'        => 'layout_slide_container_stacked_exit',
    'type'       => 'choose',
    'label'      => cs_recall( 'label_exit' ),
    'conditions' => [ $condition_layout_slide_container_layout_type_stacked, $condition_layout_slide_container_stacked_entrance_is_not_none ],
    'options'    => [
      'choices'   => [
        [ 'value' => 'fade',   'label' => cs_recall( 'label_fade' )   ],
        [ 'value' => 'effect', 'label' => cs_recall( 'label_effect' ) ],
        [ 'value' => 'none',   'label' => cs_recall( 'label_none' )   ],
      ],
    ],
  ];

  $control_layout_slide_container_transition = cs_recall( 'control_mixin_transition', [ 'keys' => [ 'duration' => 'layout_slide_container_duration', 'timing' => 'layout_slide_container_timing_function' ], 'conditions' => [ $condition_layout_slide_container_layout_type_inline, array_merge( $condition_layout_slide_container_stacked_entrance_is_not_none, [ 'or' => true ] ) ] ] );


  // Individual Controls - Size
  // --------------------------

  $control_layout_slide_container_content_global_container             = cs_recall( 'control_mixin_global_container',                [ 'key' => 'layout_slide_container_content_global_container'                                                                             ] );
  $control_layout_slide_container_content_global_container_placeholder = cs_recall( 'control_mixin_global_container_placeholder_x2', [ 'key' => 'layout_slide_container_content_global_container', 'condition' => $condition_layout_slide_container_content_container_enabled ] );
  $control_layout_slide_container_content_width                        = cs_recall( 'control_mixin_width',                           [ 'key' => 'layout_slide_container_content_width', 'condition' => $condition_layout_slide_container_content_container_disabled           ] );
  $control_layout_slide_container_content_max_width                    = cs_recall( 'control_mixin_max_width',                       [ 'key' => 'layout_slide_container_content_max_width', 'condition' => $condition_layout_slide_container_content_container_disabled       ] );


  // Control Groups
  // --------------

  $control_group_layout_slide_container_setup = [
    'type'     => 'group',
    'group'    => $group_layout_slide_container_setup,
    'controls' => [
      $control_layout_slide_container_base_font_size,
      $control_layout_slide_container_tag,
      $control_layout_slide_container_overflow,
    ],
  ];

  $control_group_layout_slide_container_layout = [
    'type'     => 'group',
    'group'    => $group_layout_slide_container_layout,
    'controls' => [
      $control_layout_slide_container_layout_type,
      $control_layout_slide_container_inline_slide_basis,
      $control_layout_slide_container_inline_page_count,
      $control_layout_slide_container_inline_gap,
      $control_layout_slide_container_inline_align,
      $control_layout_slide_container_stacked_align,
      $control_layout_slide_container_inline_justify,
    ],
  ];

  $control_group_layout_slide_container_options = [
    'type'     => 'group',
    'group'    => $group_layout_slide_container_options,
    'controls' => [
      $control_layout_slide_container_autoplay_inline,
      $control_layout_slide_container_autoplay_stacked,
      $control_layout_slide_container_autoplay_duration,
      $control_layout_slide_container_inline_marquee_speed,
      $control_layout_slide_container_inline_wrap_around,
      $control_layout_slide_container_inline_contain,
      $control_layout_slide_container_adaptive_height_for_inline,
      $control_layout_slide_container_adaptive_height_for_stacked,
      $control_layout_slide_container_inline_interaction,
      $control_layout_slide_container_stacked_swipe,
      $control_layout_slide_container_inline_free_scroll,
      $control_layout_slide_container_inline_scroll_by,
      $control_layout_slide_container_stacked_entrance,
      $control_layout_slide_container_stacked_exit,
      $control_layout_slide_container_transition,
    ],
  ];

  $control_group_layout_slide_container_content_sizing = [
    'keys'     => [ 'checkbox' => 'layout_slide_container_content_global_container' ],
    'type'     => 'group',
    'group'    => $group_layout_slide_container_size,
    'options'  => [
      'vertical_label'   => cs_recall( 'label_nbsp' ),
      'horizontal_label' => cs_recall( 'label_content_sizing' ),
      'checkbox'         => cs_recall( 'options_group_checkbox_off_on_bool', [ 'label' => cs_recall( 'label_global_container' ) ] )
    ],
    'controls' => [
      $control_layout_slide_container_content_global_container_placeholder,
      $control_layout_slide_container_content_width,
      $control_layout_slide_container_content_max_width,
    ],
  ];


  // Output
  // ------

  return cs_compose_controls(
    [
      'controls' => [
        $control_layout_slide_container_children,
        $control_group_layout_slide_container_setup,
        $control_group_layout_slide_container_layout,
        $control_group_layout_slide_container_options,
      ],
      'control_nav' => [
        $base_group                            => cs_recall( 'label_slide_container' ),
        $group_layout_slide_container_children => cs_recall( 'label_children' ),
        $group_layout_slide_container_setup    => cs_recall( 'label_setup' ),
        $group_layout_slide_container_layout   => cs_recall( 'label_layout' ),
        $group_layout_slide_container_options  => cs_recall( 'label_options' ),
        $group_layout_slide_container_size     => cs_recall( 'label_content_sizing' ),
        $group_layout_slide_container_design   => cs_recall( 'label_design' ),
      ],
    ],
    [
      'controls' => [
        $control_group_layout_slide_container_content_sizing,
        cs_control( 'padding', 'layout_slide_container', [ 'group' => $group_layout_slide_container_design ] ),
      ],
    ],
    cs_partial_controls( 'effects', [ 'has_provider' => true ] ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true, 'add_looper_provider' => true, 'add_looper_consumer' => true ] )
  );
}



// Grid Presets
// =============================================================================

function x_layout_slider_presets() {

  // Template Management
  // 1. Inspect a Slide Container element
  // 2. Dev Toolkit > Tools > Elements > Prefab Values
  // 3. Paste resulting PHP to template property below

  return [
    'option-01' => [
      'title'            => __( 'Inline, 1 Slide Per Page', 'cornerstone' ),
      'previewCellCount' =>  4, // 1 + 3
      'values'           => [
        '_type'                                   => 'layout-slide-container',
        '_bp_base'                                => '4_4',
        'layout_slide_container_inline_scroll_by' => 'slide',
        '_modules' => [
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
        ],
      ],
    ],
    'option-02' => [
      'title'            => __( 'Inline, 2 Slides Per Page', 'cornerstone' ),
      'previewCellCount' =>  5, // 2 + 3
      'values'           => [
        '_type'                                      => 'layout-slide-container',
        '_bp_base'                                   => '4_4',
        '_bp_data4_4'                                => [
          'layout_slide_container_inline_page_count' => [
            null,
            '1',
            null,
            null,
            null
          ],
        ],
        'layout_slide_container_inline_page_count' => '2',
        'layout_slide_container_inline_scroll_by'  => 'slide',
        '_modules'                                 => [
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
        ],
      ],
    ],
    'option-03' => [
      'title'            => __( 'Inline, 3 Slides Per Page', 'cornerstone' ),
      'previewCellCount' =>  6, // 3 + 3
      'values'           => [
        '_type'                                      => 'layout-slide-container',
        '_bp_base'                                   => '4_4',
        '_bp_data4_4'                                => [
          'layout_slide_container_inline_page_count' => [
            '1',
            null,
            '2',
            null,
            null
          ],
        ],
        'layout_slide_container_inline_page_count' => '3',
        'layout_slide_container_inline_scroll_by'  => 'slide',
        '_modules'                                 => [
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
        ],
      ],
    ],
    'option-04' => [
      'title'            => __( 'Inline, 4 Slides Per Page', 'cornerstone' ),
      'previewCellCount' =>  7, // 4 + 3
      'values'           => [
        '_type'                                      => 'layout-slide-container',
        '_bp_base'                                   => '4_4',
        '_bp_data4_4'                                => [
          'layout_slide_container_inline_page_count' => [
            '1',
            null,
            '2',
            null,
            null
          ]
        ],
        'layout_slide_container_inline_page_count' => '4',
        'layout_slide_container_inline_scroll_by'  => 'slide',
        '_modules'                                 => [
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
        ],
      ],
    ],
    'option-05' => [
      'title'            => __( 'Stacked', 'cornerstone' ),
      'previewCellCount' =>  1,
      'values'           => [
        '_type'                              => 'layout-slide-container',
        '_bp_base'                           => '4_4',
        'layout_slide_container_layout_type' => 'stacked',
        '_modules'                           => [
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
          [ '_type' => 'layout-slide', '_bp_base' => '4_4' ],
        ],
      ],
    ],
  ];

}



// Register Element
// =============================================================================

cs_register_element( 'layout-slide-container', [
  'title'      => __( 'Slide Container', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'bg', 'effects' ],
  'builder'    => 'x_element_builder_setup_layout_slide_container',
  'tss'        => 'x_element_tss_layout_slide_container',
  'render'     => 'x_element_render_layout_slide_container',
  'icon'       => 'native',
  'children'   => 'x_layout_slide_container',
  'options'    => [
    'valid_children'    => [ 'layout-slide' ],
    'index_labels'      => true,
    'is_draggable'      => false,
    'empty_placeholder' => false,
    'dropzone'          => [
      'proxy'       => true,
      'z_index_key' => 'layout_slide_container_z_index'
    ],
    'add_new_element' => [ '_type' => 'layout-slide' ],
    'tag_key'         => 'layout_slide_container_tag',
    'contrast_keys'   => [
      'bg:layout_slide_container_bg_advanced',
      'layout_slide_container_bg_color'
    ],
    'side_effects' => [
      [
        'observe'    => 'layout_slide_container_bg_advanced',
        'conditions' => [
          ['key' => 'layout_slide_container_bg_advanced', 'op' => '==', 'value' => true ],
          ['key' => 'layout_slide_container_z_index',     'op' => '==', 'value' => 'auto' ]
        ],
        'apply' => [
          'layout_slide_container_z_index' => '1'
        ]
      ]
    ]
  ]
] );
