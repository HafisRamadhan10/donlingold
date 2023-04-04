<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TESTIMONIAL.PHP
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
    'testimonial_content'                       => cs_value( __( 'You are never too old to set another goal or to dream a new dream.', 'cornerstone' ), 'markup:seo', true ),
    'testimonial_cite_content'                  => cs_value( __( 'C.S. Lewis', 'cornerstone' ), 'markup:seo', true ),
    'testimonial_rating'                        => cs_value( false, 'markup', true ),

    'testimonial_base_font_size'                => cs_value( '1em' ),
    'testimonial_width'                         => cs_value( 'auto' ),
    'testimonial_max_width'                     => cs_value( 'none' ),
    'testimonial_bg_color'                      => cs_value( 'transparent', 'style:color' ),

    'testimonial_margin'                        => cs_value( '!0em' ),
    'testimonial_padding'                       => cs_value( '!0em' ),
    'testimonial_border_width'                  => cs_value( '!0px' ),
    'testimonial_border_style'                  => cs_value( 'solid' ),
    'testimonial_border_color'                  => cs_value( 'transparent', 'style:color' ),
    'testimonial_border_radius'                 => cs_value( '!0px' ),
    'testimonial_box_shadow_dimensions'         => cs_value( '!0em 0em 0em 0em' ),
    'testimonial_box_shadow_color'              => cs_value( 'transparent', 'style:color' ),

    'testimonial_content_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'testimonial_content_margin'                => cs_value( '!0em' ),
    'testimonial_content_padding'               => cs_value( '!0em' ),
    'testimonial_content_border_width'          => cs_value( '!0px' ),
    'testimonial_content_border_style'          => cs_value( 'solid' ),
    'testimonial_content_border_color'          => cs_value( 'transparent', 'style:color' ),
    'testimonial_content_border_radius'         => cs_value( '!0px' ),
    'testimonial_content_box_shadow_dimensions' => cs_value( '!0em 0em 0em 0em' ),
    'testimonial_content_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),

    'testimonial_text_font_family'              => cs_value( 'inherit', 'style:font-family' ),
    'testimonial_text_font_weight'              => cs_value( 'inherit:400', 'style:font-weight' ),
    'testimonial_text_font_size'                => cs_value( '1.25em' ),
    'testimonial_text_letter_spacing'           => cs_value( '0em' ),
    'testimonial_text_line_height'              => cs_value( '1.4' ),
    'testimonial_text_font_style'               => cs_value( 'normal' ),
    'testimonial_text_text_align'               => cs_value( 'none' ),
    'testimonial_text_text_decoration'          => cs_value( 'none' ),
    'testimonial_text_text_transform'           => cs_value( 'none' ),
    'testimonial_text_text_color'               => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'testimonial_text_text_shadow_dimensions'   => cs_value( '!0px 0px 0px' ),
    'testimonial_text_text_shadow_color'        => cs_value( 'transparent', 'style:color' ),

    'testimonial_cite_position'                 => cs_value( 'after' ),
    'testimonial_cite_align_self'               => cs_value( 'stretch' ),
    'testimonial_cite_spacing'                  => cs_value( '0.75em' ),
    'testimonial_cite_bg_color'                 => cs_value( 'transparent', 'style:color' ),

    'testimonial_cite_padding'                  => cs_value( '!0em' ),
    'testimonial_cite_border_width'             => cs_value( '!0px' ),
    'testimonial_cite_border_style'             => cs_value( 'solid' ),
    'testimonial_cite_border_color'             => cs_value( 'transparent', 'style:color' ),
    'testimonial_cite_border_radius'            => cs_value( '!0px' ),
    'testimonial_cite_box_shadow_dimensions'    => cs_value( '!0em 0em 0em 0em' ),
    'testimonial_cite_box_shadow_color'         => cs_value( 'transparent', 'style:color' ),

    'testimonial_cite_font_family'              => cs_value( 'inherit', 'style:font-family' ),
    'testimonial_cite_font_weight'              => cs_value( 'inherit:400', 'style:font-weight' ),
    'testimonial_cite_font_size'                => cs_value( '0.8em' ),
    'testimonial_cite_letter_spacing'           => cs_value( '0em' ),
    'testimonial_cite_line_height'              => cs_value( '1' ),
    'testimonial_cite_font_style'               => cs_value( 'normal' ),
    'testimonial_cite_text_align'               => cs_value( 'none' ),
    'testimonial_cite_text_decoration'          => cs_value( 'none' ),
    'testimonial_cite_text_transform'           => cs_value( 'none' ),
    'testimonial_cite_text_color'               => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'testimonial_cite_text_shadow_dimensions'   => cs_value( '!0px 0px 0px' ),
    'testimonial_cite_text_shadow_color'        => cs_value( 'transparent', 'style:color' ),

    'testimonial_graphic_position'              => cs_value( 'outer', 'markup' ),
    'testimonial_graphic_flex_direction'        => cs_value( 'row' ),
    'testimonial_graphic_flex_align'            => cs_value( 'flex-start' ),

    'testimonial_rating_position'               => cs_value( 'after', 'markup' ),
  ],
  cs_values( 'graphic', 'testimonial' ),
  cs_values( [
    'graphic'                => cs_value( true, 'markup' ),
    'graphic_margin'         => cs_value( '0em 0.8em 0em 0em' ),
    'graphic_icon_font_size' => cs_value( '2em' ),
    'graphic_icon'           => cs_value( 'user-circle', 'markup' ),
  ], 'testimonial' ),
  cs_values( 'rating', 'testimonial' ),
  cs_values( [
    'rating'                 => cs_value( false, 'markup' ),
    'rating_base_font_size'  => cs_value( '0.8em' ),
    'rating_width'           => cs_value( '100%' ),
    'rating_graphic_spacing' => cs_value( '1px' ),
    'rating_margin'          => cs_value( '0.75em 0em 0em 0em' ),
    'rating_line_height'     => cs_value( '1' ),
  ], 'testimonial' ),
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_testimonial() {
  return [
    'require' => [ 'elements-legacy', 'elements-extra' ],
    'modules' => [
      'testimonial',
      'effects',
      ['graphic', [
        'nested' => true,
        'args' => [
          'noBase' => true
        ],
        'remap' => [
          'testimonial_graphic' => 'graphic'
        ],
        'conditions' => [
          [ 'key' => 'testimonial_graphic', 'value' => true ]
        ]
      ]],
      ['rating', [
        'nested' => true,
        'remap' => [
          'testimonial_rating' => 'rating'
        ],
        'conditions' => [
          [ 'key' => 'testimonial_rating', 'value' => true ]
        ]
      ]]
    ]
  ];
}



// Render
// =============================================================================

function x_element_render_testimonial( $data ) {

  extract( $data );

  // Conditions
  // ----------

  $has_cite    = isset( $testimonial_cite_content ) && ! empty( $testimonial_cite_content );
  $has_graphic = isset( $testimonial_graphic ) && $testimonial_graphic === true;
  $has_rating  = isset( $testimonial_rating ) && $testimonial_rating === true;


  // Prepare Atts
  // ------------

  $atts = [
    'class' => array_merge( [ 'x-testimonial' ], $data['classes'] )
  ];

  if ( isset( $id ) && ! empty( $id ) ) {
    $atts['id'] = $id;
  }

  if ( isset( $style ) && ! empty( $style ) ) {
    $atts['style'] = $style;
  }

  $atts = cs_apply_effect( $atts, $data );


  // Graphic
  // -------

  $the_graphic = "";

  if ( $has_graphic && $testimonial_graphic_position === 'outer') {
    $the_graphic = cs_get_partial_view( 'graphic', array_merge( cs_extract( $data, [ 'testimonial_graphic' => 'graphic' ] ), [
      'classes' => [ $data['_tss']['graphic'] ]
    ]));
  }


  // Testimonial
  // -----------

  $the_testimonial = '<div class="x-testimonial-text">' . $testimonial_content . '</div>';


  // Rating
  // ------

  $the_rating = "";

  if ( $has_rating ) {
    $the_rating = cs_get_partial_view( 'rating', array_merge( cs_extract( $data, [ 'testimonial_rating' => 'rating' ] ), [
      'classes' => [ $data['_tss']['rating'] ]
    ] ));
  }


  // Citation
  // --------

  $the_citation = "";

  if ( $has_cite || $has_graphic || $has_rating ) {

    $the_cite_text            = ( $has_cite                                 ) ? '<span class="x-testimonial-cite-text">' . $testimonial_cite_content . '</span>'    : '';
    $the_cite_content_ordered = ( $testimonial_rating_position === 'before' ) ? $the_rating . $the_cite_text                                                        : $the_cite_text . $the_rating;
    $the_cite_content         = ( $has_cite || $has_rating                  ) ? '<span class="x-testimonial-cite-content">' . $the_cite_content_ordered . '</span>' : '';
    $the_citation             = '<span class="x-testimonial-cite">';

    if ( $has_graphic && $testimonial_graphic_position === 'cite' ) {
      $the_citation .= $the_graphic . $the_cite_content;
    } else {
      $the_citation .= $the_cite_content;
    }

    $the_citation .= '</span>';

  }


  // Output
  // ------

  return cs_tag('blockquote', $atts, $custom_atts, [
    $the_graphic,
    cs_tag('div', ['class' => 'x-testimonial-content'], [
      $the_testimonial,
      $the_citation
    ])
  ]);

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_testimonial() {

  // $condition_cite                     = [ 'key' => 'testimonial_cite_content', 'op' => 'NOT IN', 'value' => [ '' ] ];
  $condition_cite                     = [];
  $condition_graphic_position_outer   = [ 'testimonial_graphic_position' => 'outer' ];
  $condition_graphic_position_cite    = [ 'testimonial_graphic_position' => 'cite' ];
  $condition_graphic_flex_direction_h = [ 'key' => 'testimonial_graphic_flex_direction', 'op' => 'IN', 'value' => [ 'row', 'row-reverse' ] ];
  $condition_graphic_flex_direction_v = [ 'key' => 'testimonial_graphic_flex_direction', 'op' => 'IN', 'value' => [ 'column', 'column-reverse' ] ];
  $condition_rating                   = [ 'testimonial_rating' => true ];


  // Individual Controls (Setup)
  // ---------------------------

  $control_testimonial_base_font_size = cs_recall( 'control_mixin_font_size', [ 'key' => 'testimonial_base_font_size' ] );

  $control_testimonial_content = [
    'key'     => 'testimonial_content',
    'type'    => 'text-editor',
    'label'   => cs_recall( 'label_content' ),
    'options' => [
      'height' => 3,
    ],
  ];

  $control_testimonial_cite_content = [
    'key'   => 'testimonial_cite_content',
    'type'  => 'text',
    'label' => cs_recall( 'label_citation' ),
  ];

  $control_testimonial_options = [
    'keys' => [
      'graphic' => 'testimonial_graphic',
      'rating'  => 'testimonial_rating',
    ],
    'type'    => 'checkbox-list',
    'label'   => cs_recall( 'label_enable' ),
    'options' => [
      'list' => [
        [ 'key' => 'graphic', 'label' => cs_recall( 'label_graphic' ) ],
        [ 'key' => 'rating',  'label' => cs_recall( 'label_rating' )  ],
      ]
    ],
  ];

  $control_testimonial_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'testimonial_bg_color' ] ] );


  // Individual Controls (Size)
  // --------------------------

  $control_testimonial_width     = cs_recall( 'control_mixin_width',     [ 'key' => 'testimonial_width'     ] );
  $control_testimonial_max_width = cs_recall( 'control_mixin_max_width', [ 'key' => 'testimonial_max_width' ] );


  // Individual Controls (Content)
  // -----------------------------

  $control_testimonial_content_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'testimonial_content_bg_color' ] ] );


  // Individual Controls (Cite)
  // --------------------------

  $control_testimonial_cite_position = [
    'key'     => 'testimonial_cite_position',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_position' ),
    'options' => cs_recall( 'options_choices_before_after_strings' ),
  ];

  $control_testimonial_cite_placement = [
    'key'     => 'testimonial_cite_align_self',
    'type'    => 'placement',
    'label'   => cs_recall( 'label_align_horizontal' ),
    'options' => [ 'display' => 'flex', 'axis' => 'cross', 'context' => 'items', 'icon_direction' => 'x' ],
  ];

  $control_testimonial_cite_spacing  = cs_recall( 'control_mixin_gap',           [ 'key' => 'testimonial_cite_spacing', 'label' => cs_recall( 'label_spacing' ) ] );
  $control_testimonial_cite_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'testimonial_cite_bg_color' ]                         ] );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    [
      'controls' => [
        [
          'type'     => 'group',
          'group'    => 'testimonial:setup',
          'controls' => [
            $control_testimonial_base_font_size,
            $control_testimonial_content,
            $control_testimonial_cite_content,
            $control_testimonial_options,
            $control_testimonial_bg_color,
          ],
        ],
        [
          'type'     => 'group',
          'group'    => 'testimonial:size',
          'controls' => [
            $control_testimonial_width,
            $control_testimonial_max_width,
          ],
        ],
        cs_control( 'margin',        'testimonial',      [ 'group' => 'testimonial:design' ] ),
        cs_control( 'padding',       'testimonial',      [ 'group' => 'testimonial:design' ] ),
        cs_control( 'border',        'testimonial',      [ 'group' => 'testimonial:design' ] ),
        cs_control( 'border-radius', 'testimonial',      [ 'group' => 'testimonial:design' ] ),
        cs_control( 'box-shadow',    'testimonial',      [ 'group' => 'testimonial:design' ] ),

        cs_control( 'text-format', 'testimonial_text', [ 'group' => 'testimonial:text' ] ),
        cs_control( 'text-shadow', 'testimonial_text', [ 'group' => 'testimonial:text' ] ),


        [
          'type'     => 'group',
          'group'    => 'testimonial_content:setup',
          'controls' => [
            $control_testimonial_content_bg_color,
          ],
        ],
        cs_control( 'margin',        'testimonial_content', [ 'group' => 'testimonial_content:design' ] ),
        cs_control( 'padding',       'testimonial_content', [ 'group' => 'testimonial_content:design' ] ),
        cs_control( 'border',        'testimonial_content', [ 'group' => 'testimonial_content:design' ] ),
        cs_control( 'border-radius', 'testimonial_content', [ 'group' => 'testimonial_content:design' ] ),
        cs_control( 'box-shadow',    'testimonial_content', [ 'group' => 'testimonial_content:design' ] ),


        [
          'type'      => 'group',
          'group'     => 'testimonial_cite:setup',
          'condition' => $condition_cite,
          'controls'  => [
            $control_testimonial_cite_position,
            $control_testimonial_cite_placement,
            $control_testimonial_cite_spacing,
            $control_testimonial_cite_bg_color,
          ],
        ],
        cs_control( 'padding',       'testimonial_cite', [ 'group' => 'testimonial_cite:design', 'conditions' => [ $condition_cite ] ] ),
        cs_control( 'border',        'testimonial_cite', [ 'group' => 'testimonial_cite:design', 'conditions' => [ $condition_cite ] ] ),
        cs_control( 'border-radius', 'testimonial_cite', [ 'group' => 'testimonial_cite:design', 'conditions' => [ $condition_cite ] ] ),
        cs_control( 'box-shadow',    'testimonial_cite', [ 'group' => 'testimonial_cite:design', 'conditions' => [ $condition_cite ] ] ),
        cs_control( 'text-format',   'testimonial_cite', [ 'group' => 'testimonial_cite:text',   'conditions' => [ $condition_cite ] ] ),
        cs_control( 'text-shadow',   'testimonial_cite', [ 'group' => 'testimonial_cite:text',   'conditions' => [ $condition_cite ] ] )
      ],
      'control_nav' => [
        'testimonial'                => cs_recall( 'label_testimonial' ),
        'testimonial:setup'          => cs_recall( 'label_setup' ),
        'testimonial:size'           => cs_recall( 'label_size' ),
        'testimonial:design'         => cs_recall( 'label_design' ),
        'testimonial:text'           => cs_recall( 'label_text' ),

        'testimonial_content'        => cs_recall( 'label_content' ),
        'testimonial_content:setup'  => cs_recall( 'label_setup' ),
        'testimonial_content:design' => cs_recall( 'label_design' ),

        'testimonial_cite'           => cs_recall( 'label_citation' ),
        'testimonial_cite:setup'     => cs_recall( 'label_setup' ),
        'testimonial_cite:design'    => cs_recall( 'label_design' ),
        'testimonial_cite:text'      => cs_recall( 'label_text' ),

        'testimonial_graphic'        => cs_recall( 'label_graphic' ),
        'testimonial_graphic:setup'  => cs_recall( 'label_setup' ),

        'testimonial_rating'         => cs_recall( 'label_rating' ),
      ],
    ],
    cs_partial_controls( 'graphic', [
      'k_pre'               => 'testimonial',
      'has_alt'             => false,
      'has_interactions'    => false,
      'has_sourced_content' => false,
      'has_toggle'          => false,
      'group'               => 'testimonial_graphic:setup',
      'controls_setup' => [
        [
          'key'     => 'testimonial_graphic_position',
          'type'    => 'choose',
          'label'   => cs_recall( 'label_position' ),
          'options' => [
            'choices' => [
              [ 'value' => 'outer', 'label' => cs_recall( 'label_outside' )  ],
              [ 'value' => 'cite',  'label' => cs_recall( 'label_citation' ) ],
            ],
          ],
        ],
        [
          'key'     => 'testimonial_graphic_flex_direction',
          'type'    => 'choose',
          'label'   => cs_recall( 'label_placement' ),
          'options' => [
            'choices' => [
              [ 'value' => 'column',         'icon' => 'long-arrow-alt-up'    ],
              [ 'value' => 'row-reverse',    'icon' => 'long-arrow-alt-right' ],
              [ 'value' => 'column-reverse', 'icon' => 'long-arrow-alt-down'  ],
              [ 'value' => 'row',            'icon' => 'long-arrow-alt-left'  ],
            ],
          ],
        ],
        [
          'key'       => 'testimonial_graphic_flex_align',
          'type'      => 'placement',
          'label'     => cs_recall( 'label_align' ),
          'options'   => [ 'display' => 'flex', 'axis' => 'cross', 'context' => 'items', 'icon_direction' => 'x' ],
          'condition' => $condition_graphic_flex_direction_v,
        ],
        [
          'key'       => 'testimonial_graphic_flex_align',
          'type'      => 'placement',
          'label'     => cs_recall( 'label_align' ),
          'options'   => [ 'display' => 'flex', 'axis' => 'cross', 'context' => 'items', 'icon_direction' => 'y' ],
          'condition' => $condition_graphic_flex_direction_h,
        ]
      ],
    ] ),
    cs_partial_controls( 'rating', [
      'k_pre'          => 'testimonial',
      'group'          => 'testimonial_rating',
      'allow_enable'   => true,
      'condition'      => $condition_rating,
      'controls_setup' => [
        [
          'key'     => 'testimonial_rating_position',
          'type'    => 'choose',
          'label'   => cs_recall( 'label_position' ),
          'options' => cs_recall( 'options_choices_before_after_strings' ),
        ]
      ],
    ] ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true ] )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'testimonial', [
  'title'      => __( 'Testimonial', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_testimonial',
  'tss'        => 'x_element_tss_testimonial',
  'render'     => 'x_element_render_testimonial',
  'icon'       => 'native',
  'options'    => [
    'inline' => [
      'testimonial_content' => [
        'selector' => '.x-testimonial-text'
      ],
      'testimonial_cite_content' => [
        'selector' => '.x-testimonial-cite-text'
     ]
    ]
  ]
] );
