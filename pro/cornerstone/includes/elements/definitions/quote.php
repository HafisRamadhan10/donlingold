<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/QUOTE.PHP
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
    'quote_content'                     => cs_value( __( 'You are never too old to set another goal or to dream a new dream.', 'cornerstone' ), 'markup:seo', true ),
    'quote_cite_content'                => cs_value( __( 'C.S. Lewis', 'cornerstone' ), 'markup:seo', true ),

    'quote_base_font_size'              => cs_value( '1em' ),
    'quote_width'                       => cs_value( 'auto' ),
    'quote_max_width'                   => cs_value( 'none' ),
    'quote_bg_color'                    => cs_value( 'transparent', 'style:color' ),

    'quote_margin'                      => cs_value( '!0em' ),
    'quote_padding'                     => cs_value( '!0em' ),
    'quote_border_width'                => cs_value( '!0px' ),
    'quote_border_style'                => cs_value( 'solid' ),
    'quote_border_color'                => cs_value( 'transparent', 'style:color' ),
    'quote_border_radius'               => cs_value( '!0px' ),
    'quote_box_shadow_dimensions'       => cs_value( '!0em 0em 0em 0em' ),
    'quote_box_shadow_color'            => cs_value( 'transparent', 'style:color' ),

    'quote_text_font_family'            => cs_value( 'inherit', 'style:font-family' ),
    'quote_text_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
    'quote_text_font_size'              => cs_value( '1em' ),
    'quote_text_letter_spacing'         => cs_value( '0em' ),
    'quote_text_line_height'            => cs_value( '1.4' ),
    'quote_text_font_style'             => cs_value( 'normal' ),
    'quote_text_text_align'             => cs_value( 'center' ),
    'quote_text_text_decoration'        => cs_value( 'none' ),
    'quote_text_text_transform'         => cs_value( 'none' ),
    'quote_text_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'quote_text_text_shadow_dimensions' => cs_value( '!0px 0px 0px' ),
    'quote_text_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),

    'quote_marks_graphic_direction'     => cs_value( 'row' ),
    'quote_marks_graphic_opening_align' => cs_value( 'flex-start' ),
    'quote_marks_graphic_closing_align' => cs_value( 'flex-start' ),
  ],
  cs_values( 'graphic', 'quote_marks_opening' ),
  cs_values( [
    'graphic_margin'         => cs_value( '0em 1em 0em 0em' ),
    'graphic_icon_font_size' => cs_value( '1em' ),
    'graphic_icon'           => cs_value( 'quote-left', 'markup' ),
  ], 'quote_marks_opening' ),
  cs_values( 'graphic', 'quote_marks_closing' ),
  cs_values( [
    'graphic_margin'         => cs_value( '0em 0em 0em 1em' ),
    'graphic_icon_font_size' => cs_value( '1em' ),
    'graphic_icon'           => cs_value( 'quote-right', 'markup' ),
  ], 'quote_marks_closing'),
  [
    'quote_cite_position'               => cs_value( 'after' ),
    'quote_cite_bg_color'               => cs_value( 'transparent', 'style:color' ),

    'quote_cite_flex_direction'         => cs_value( 'row' ),
    'quote_cite_flex_wrap'              => cs_value( false ),
    'quote_cite_flex_justify'           => cs_value( 'center' ),
    'quote_cite_flex_align'             => cs_value( 'center' ),

    'quote_cite_margin'                 => cs_value( '0.75em 0em 0em 0em' ),
    'quote_cite_padding'                => cs_value( '!0em' ),
    'quote_cite_border_width'           => cs_value( '!0px' ),
    'quote_cite_border_style'           => cs_value( 'solid' ),
    'quote_cite_border_color'           => cs_value( 'transparent', 'style:color' ),
    'quote_cite_border_radius'          => cs_value( '!0px' ),
    'quote_cite_box_shadow_dimensions'  => cs_value( '!0em 0em 0em 0em' ),
    'quote_cite_box_shadow_color'       => cs_value( 'transparent', 'style:color' ),

    'quote_cite_font_family'            => cs_value( 'inherit', 'style:font-family' ),
    'quote_cite_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
    'quote_cite_font_size'              => cs_value( '0.75em' ),
    'quote_cite_letter_spacing'         => cs_value( '0.25em' ),
    'quote_cite_line_height'            => cs_value( '1.3' ),
    'quote_cite_font_style'             => cs_value( 'normal' ),
    'quote_cite_text_align'             => cs_value( 'center' ),
    'quote_cite_text_decoration'        => cs_value( 'none' ),
    'quote_cite_text_transform'         => cs_value( 'uppercase' ),
    'quote_cite_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'quote_cite_text_shadow_dimensions' => cs_value( '!0px 0px 0px' ),
    'quote_cite_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),

  ],
  cs_values( 'graphic', 'quote_cite' ),
  cs_values( [
    'graphic_margin'         => cs_value( '0em 0.5em 0em 0em' ),
    'graphic_icon_font_size' => cs_value( '1em' ),
    'graphic_icon'           => cs_value( 'angle-right', 'markup' ),
  ], 'quote_cite' ),
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_quote() {
  return [
    'require' => [ 'elements-legacy' ],
    'modules' => [
      'quote',
      'effects',
      ['graphic', [
        'name' => 'opening-graphic',
        'nested' => true,
        'args' => [
          'noBase' => true
        ],
        'remap' => [
          'quote_marks_opening_graphic' => 'graphic'
        ],
        'conditions' => [
          [ 'key' => 'quote_marks_opening_graphic', 'value' => true ]
        ]
      ]],
      ['graphic', [
        'name' => 'closing-graphic',
        'nested' => true,
        'args' => [
          'noBase' => true
        ],
        'remap' => [
          'quote_marks_closing_graphic' => 'graphic'
        ],
        'conditions' => [
          [ 'key' => 'quote_marks_closing_graphic', 'value' => true ]
        ]
      ]]
    ]
  ];
}



// Render
// =============================================================================

function x_element_render_quote( $data ) {

  // Prepare Atts
  // ------------

  $atts = [
    'class' => array_merge( [ 'x-quote' ], $data['classes'] )
  ];

  if ( isset( $data['id'] ) && ! empty( $data['id'] ) ) {
    $atts['id'] = $data['id'];
  }

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }

  $atts = cs_apply_effect( $atts, $data );


  // Quote Marks
  // -----------

  $the_opening_mark = '';
  $the_closing_mark = '';

  if ( $data['quote_marks_opening_graphic'] === true ) {
    $the_opening_mark = cs_get_partial_view( 'graphic',
      array_merge(
        cs_extract( $data, [ 'quote_marks_opening_graphic' => 'graphic' ] ),
        [ 'classes' => [ 'x-quote-mark-opening', $data['_tss']['opening-graphic'] ] ]
      )
    );
  }

  if ( $data['quote_marks_closing_graphic'] === true ) {
    $the_closing_mark = cs_get_partial_view( 'graphic',
      array_merge(
        cs_extract( $data, [ 'quote_marks_closing_graphic' => 'graphic' ] ),
        [ 'classes' => [ 'x-quote-mark-closing', $data['_tss']['closing-graphic'] ] ]
      )
    );
  }

  // Quote
  // -----

  $the_quote = '<div class="x-quote-text">' . $data['quote_content'] . '</div>';


  // Cite
  // ----

  $the_cite = "";

  if ( isset( $data['quote_cite_content'] ) && ! empty( $data['quote_cite_content'] ) ) {

    $quote_cite_content = '<span class="x-quote-cite-text">' . $data['quote_cite_content'] . '</span>';

    $the_cite = '<footer class="x-quote-cite">';

    if ( $data['quote_cite_graphic'] === true ) {

      $the_cite_mark = cs_get_partial_view( 'graphic',
        array_merge(
          cs_extract( $data, [ 'quote_cite_graphic' => 'graphic' ] ),
          [ 'classes' => [ 'x-quote-cite-mark' ] ]
        )
      );

      $the_cite      .= $the_cite_mark . $quote_cite_content;

    } else {
      $the_cite .= $quote_cite_content;
    }

    $the_cite .= '</footer>';

  }


  // Output
  // ------

  return cs_tag( 'blockquote', $atts, $data['custom_atts'], [
    $the_opening_mark,
    cs_tag( 'div', [ 'class' => 'x-quote-content' ], [
      $the_quote,
      $the_cite
    ]),
    $the_closing_mark
  ]);

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_quote() {

  $condition_cite         = [ 'key' => 'quote_cite_content', 'op' => 'NOT IN', 'value' => [ '' ] ];
  $condition_opening_mark = [ 'quote_marks_opening_graphic' => true ];
  $condition_closing_mark = [ 'quote_marks_closing_graphic' => true ];


  // Options
  // -------

  $options_quote_marks_graphic_align = [
    'choices' => [
      [ 'value' => 'flex-start', 'label' => cs_recall( 'label_start' )  ],
      [ 'value' => 'center',     'label' => cs_recall( 'label_center' ) ],
      [ 'value' => 'flex-end',   'label' => cs_recall( 'label_end' )    ],
    ],
  ];


  // Settings
  // --------

  $settings_quote_mark_opening = [
    'label_prefix'        => cs_recall( 'label_opening' ),
    'k_pre'               => 'quote_marks_opening',
    'has_alt'             => false,
    'has_interactions'    => false,
    'has_sourced_content' => false,
    'has_toggle'          => false,
    'group'               => 'quote_marks:opening'
  ];

  $settings_quote_mark_closing = [
    'label_prefix'        => cs_recall( 'label_closing' ),
    'k_pre'               => 'quote_marks_closing',
    'has_alt'             => false,
    'has_interactions'    => false,
    'has_sourced_content' => false,
    'has_toggle'          => false,
    'group'               => 'quote_marks:closing',
  ];

  $settings_quote_cite_design = [
    'group'      => 'quote_cite:design',
    'conditions' => [ $condition_cite ],
  ];

  $settings_quote_cite_text = [
    'group'      => 'quote_cite:text',
    'conditions' => [ $condition_cite ],
  ];

  $settings_quote_cite_graphic = [
    'k_pre'               => 'quote_cite',
    'has_alt'             => false,
    'has_interactions'    => false,
    'has_sourced_content' => false,
    'has_toggle'          => false,
    'conditions'          => [ $condition_cite ],
    'group'               => 'quote_cite:graphic',
  ];


  // Individual Controls (Setup)
  // ---------------------------

  $control_quote_base_font_size = cs_recall( 'control_mixin_font_size', [ 'key' => 'quote_base_font_size' ] );

  $control_quote_content = [
    'key'     => 'quote_content',
    'type'    => 'text-editor',
    'label'   => cs_recall( 'label_content' ),
    'options' => [
      'height' => 3,
    ],
  ];

  $control_quote_cite_content = [
    'key'   => 'quote_cite_content',
    'type'  => 'text',
    'label' => cs_recall( 'label_citation' ),
  ];

  $control_quote_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'quote_bg_color' ] ] );


  // Individual Controls (Size)
  // --------------------------

  $control_quote_width     = cs_recall( 'control_mixin_width',     [ 'key' => 'quote_width'     ] );
  $control_quote_max_width = cs_recall( 'control_mixin_max_width', [ 'key' => 'quote_max_width' ] );


  // Individual Controls (Marks)
  // ---------------------------

  $control_quote_marks_graphic_direction = cs_recall( 'control_mixin_direction_rc', [ 'key' => 'quote_marks_graphic_direction' ] );

  $control_quote_marks_graphic_options = [
    'keys' => [
      'opening' => 'quote_marks_opening_graphic',
      'closing' => 'quote_marks_closing_graphic',
    ],
    'type'    => 'checkbox-list',
    'label'   => cs_recall( 'label_enable' ),
    'options' => [
      'list' => [
        [ 'key' => 'opening', 'label' => cs_recall( 'label_opening' ) ],
        [ 'key' => 'closing', 'label' => cs_recall( 'label_closing' ) ],
      ]
    ],
  ];

  $control_quote_marks_graphic_opening_align = [
    'key'       => 'quote_marks_graphic_opening_align',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_opening_mark_align' ),
    'options'   => $options_quote_marks_graphic_align,
    'condition' => $condition_opening_mark,
  ];

  $control_quote_marks_graphic_closing_align = [
    'key'       => 'quote_marks_graphic_closing_align',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_closing_mark_align' ),
    'options'   => $options_quote_marks_graphic_align,
    'condition' => $condition_closing_mark,
  ];


  // Individual Controls (Cite)
  // --------------------------

  $control_quote_cite_position = [
    'key'     => 'quote_cite_position',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_position' ),
    'options' => cs_recall( 'options_choices_before_after_strings' ),
  ];

  $control_quote_cite_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'quote_cite_bg_color' ] ] );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    [
      'controls' => [
        [
          'type'     => 'group',
          'group'    => 'quote:setup',
          'controls' => [
            $control_quote_base_font_size,
            $control_quote_content,
            $control_quote_cite_content,
            $control_quote_bg_color,
          ],
        ],
        [
          'type'       => 'group',
          'group'      => 'quote:size',
          'controls'   => [
            $control_quote_width,
            $control_quote_max_width,
          ],
        ],

        cs_control( 'margin',        'quote', [ 'group' => 'quote:design' ] ),
        cs_control( 'padding',       'quote', [ 'group' => 'quote:design' ] ),
        cs_control( 'border',        'quote', [ 'group' => 'quote:design' ] ),
        cs_control( 'border-radius', 'quote', [ 'group' => 'quote:design' ] ),
        cs_control( 'box-shadow',    'quote', [ 'group' => 'quote:design' ] ),

        cs_control( 'text-format', 'quote_text', [ 'group' => 'quote:text' ] ),
        cs_control( 'text-shadow', 'quote_text', [ 'group' => 'quote:text' ] ),

        [
          'type'     => 'group',
          'group'    => 'quote_marks:setup',
          'controls' => [
            $control_quote_marks_graphic_direction,
            $control_quote_marks_graphic_options,
            $control_quote_marks_graphic_opening_align,
            $control_quote_marks_graphic_closing_align,
          ],
        ]
      ],
      'control_nav' => [
        'quote'               => cs_recall( 'label_quote' ),
        'quote:setup'         => cs_recall( 'label_setup' ),
        'quote:size'          => cs_recall( 'label_size' ),
        'quote:design'        => cs_recall( 'label_design' ),
        'quote:text'          => cs_recall( 'label_text' ),

        'quote_marks'         => cs_recall( 'label_marks' ),
        'quote_marks:setup'   => cs_recall( 'label_setup' ),
        'quote_marks:opening' => cs_recall( 'label_opening' ),
        'quote_marks:closing' => cs_recall( 'label_closing' ),

        'quote_cite'          => cs_recall( 'label_citation' ),
        'quote_cite:setup'    => cs_recall( 'label_setup' ),
        'quote_cite:design'   => cs_recall( 'label_design' ),
        'quote_cite:text'     => cs_recall( 'label_text' ),
        'quote_cite:graphic'  => cs_recall( 'label_graphic' ),
      ]
    ],
    cs_partial_controls( 'graphic', $settings_quote_mark_opening ),
    cs_partial_controls( 'graphic', $settings_quote_mark_closing ),
    [
      'controls' => [

        [
          'type'      => 'group',
          'label'     => cs_recall( 'label_setup' ),
          'group'     => 'quote_cite:setup',
          'condition' => $condition_cite,
          'controls'  => [
            $control_quote_cite_position,
            $control_quote_cite_bg_color,
          ],
        ],

        cs_control( 'flexbox', 'quote_cite', [
          'k_pre'      => 'quote_cite',
          'group'      => 'quote_cite:setup',
          'conditions' => [ $condition_cite ]
        ] ),

        cs_control( 'margin', 'quote_cite', $settings_quote_cite_design ),
        cs_control( 'padding', 'quote_cite', $settings_quote_cite_design ),
        cs_control( 'border', 'quote_cite', $settings_quote_cite_design ),
        cs_control( 'border-radius', 'quote_cite', $settings_quote_cite_design ),
        cs_control( 'box-shadow', 'quote_cite', $settings_quote_cite_design ),

        cs_control( 'text-format', 'quote_cite', $settings_quote_cite_text ),
        cs_control( 'text-shadow', 'quote_cite', $settings_quote_cite_text )

      ]
    ],
    cs_partial_controls( 'graphic', $settings_quote_cite_graphic ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true ] )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'quote', [
  'title'      => __( 'Quote', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_quote',
  'tss'        => 'x_element_tss_quote',
  'render'     => 'x_element_render_quote',
  'icon'       => 'native',
  'options'    => [
    'inline' => [
      'quote_content' => [
        'selector' => '.x-quote-text'
      ],
      'quote_cite_content' => [
        'selector' => '.x-quote-cite-text'
      ]
    ]
  ]
] );
