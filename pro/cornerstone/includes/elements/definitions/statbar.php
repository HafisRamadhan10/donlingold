<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/STATBAR.PHP
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
    'statbar_base_font_size'               => cs_value( '1em', 'style' ),
    'statbar_direction'                    => cs_value( 'row', 'style' ),
    'statbar_width_row'                    => cs_value( '100%', 'style' ),
    'statbar_max_width_row'                => cs_value( 'none', 'style' ),
    'statbar_height_row'                   => cs_value( '2em', 'style' ),
    'statbar_max_height_row'               => cs_value( 'none', 'style' ),
    'statbar_width_column'                 => cs_value( '2em', 'style' ),
    'statbar_max_width_column'             => cs_value( 'none', 'style' ),
    'statbar_height_column'                => cs_value( '18em', 'style' ),
    'statbar_max_height_column'            => cs_value( 'none', 'style' ),
    'statbar_bg_color'                     => cs_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'statbar_trigger_offset'               => cs_value( '50%', 'style' ),

    'statbar_margin'                       => cs_value( '!0em', 'style' ),
    'statbar_padding'                      => cs_value( '!0em', 'style' ),
    'statbar_border_width'                 => cs_value( '!0px', 'style' ),
    'statbar_border_style'                 => cs_value( 'solid', 'style' ),
    'statbar_border_color'                 => cs_value( 'transparent', 'style:color' ),
    'statbar_border_radius'                => cs_value( '3px 3px 3px 3px', 'style' ),
    'statbar_box_shadow_dimensions'        => cs_value( '!0em 0em 0em 0em', 'style' ),
    'statbar_box_shadow_color'             => cs_value( 'transparent', 'style:color' ),

    'statbar_bar_length'                   => cs_value( '92%', 'markup', true ),
    'statbar_bar_bg_color'                 => cs_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'statbar_bar_border_radius'            => cs_value( '3px 3px 3px 3px', 'style' ),
    'statbar_bar_box_shadow_dimensions'    => cs_value( '!0em 0em 0em 0em', 'style' ),
    'statbar_bar_box_shadow_color'         => cs_value( 'transparent', 'style:color' ),

    'statbar_label'                        => cs_value( true, 'markup' ),
    'statbar_label_custom_text'            => cs_value( false, 'markup' ),
    'statbar_label_always_show'            => cs_value( false, 'markup' ),
    'statbar_label_text_content'           => cs_value( __( 'HTML &amp; CSS', '__x__' ), 'markup', true ),
    'statbar_label_justify'                => cs_value( 'flex-end', 'markup' ),
    'statbar_label_bg_color'               => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'statbar_label_width'                  => cs_value( 'auto', 'style' ),
    'statbar_label_height'                 => cs_value( 'auto', 'style' ),
    'statbar_label_translate_x'            => cs_value( '-0.5em', 'style' ),
    'statbar_label_translate_y'            => cs_value( '0em', 'style' ),

    'statbar_label_padding'                => cs_value( '0.35em 0.5em 0.35em 0.5em', 'style' ),
    'statbar_label_border_width'           => cs_value( '!0px', 'style' ),
    'statbar_label_border_style'           => cs_value( 'solid', 'style' ),
    'statbar_label_border_color'           => cs_value( 'transparent', 'style:color' ),
    'statbar_label_border_radius'          => cs_value( '2px 2px 2px 2px', 'style' ),
    'statbar_label_box_shadow_dimensions'  => cs_value( '!0em 0em 0em 0em', 'style' ),
    'statbar_label_box_shadow_color'       => cs_value( 'transparent', 'style:color' ),

    'statbar_label_font_family'            => cs_value( 'inherit', 'style:font-family' ),
    'statbar_label_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
    'statbar_label_font_size'              => cs_value( '0.75em', 'style' ),
    'statbar_label_letter_spacing'         => cs_value( '0em', 'style' ),
    'statbar_label_line_height'            => cs_value( '1', 'style' ),
    'statbar_label_font_style'             => cs_value( 'normal', 'style' ),
    'statbar_label_text_align'             => cs_value( 'none', 'style' ),
    'statbar_label_text_decoration'        => cs_value( 'none', 'style' ),
    'statbar_label_text_transform'         => cs_value( 'none', 'style' ),
    'statbar_label_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'statbar_label_text_shadow_dimensions' => cs_value( '!0px 0px 0px', 'style' ),
    'statbar_label_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  ],
  'omega',
  'omega:custom-atts',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_tss_statbar() {
  return [
    'require' => [ 'elements-legacy' ],
    'modules' => [
      'statbar',
      ['effects', [
        'args' => [
          'selectors' => ['.x-statbar-bar', '.x-statbar-label'],
          // 'transition_base' => '750ms'
        ]
      ]]
    ]
  ];
}


// Render
// =============================================================================

function x_element_render_statbar( $data ) {

  // Prepare Atts
  // ------------

  $atts = [
    'class' => array_merge( [ 'x-statbar' ], $data['classes'] ),
  ];

  if ( isset( $data['id'] ) && ! empty( $data['id'] ) ) {
    $atts['id'] = $data['id'];
  }

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }

  $atts = cs_apply_effect( $atts, $data );

  $atts = array_merge( $atts, cs_element_js_atts( 'statbar', [ 'triggerOffset' => $data['statbar_trigger_offset'] ], true ) );


  // Label
  // -----

  $statbar_label_content = NULL;

  if ( $data['statbar_label'] === true ) {

    $statbar_label_content_atts  = [
      'class' => ( $data['statbar_label_always_show'] === true ) ? 'x-statbar-label x-active' : 'x-statbar-label'
    ];

    $statbar_label_content = cs_tag( 'div', $statbar_label_content_atts, cs_tag('span', [
      $data['statbar_label_custom_text'] === true ? $data['statbar_label_text_content'] : $data['statbar_bar_length']
    ]));

  }


  // Output
  // ------

  return cs_tag('div', $atts, $data['custom_atts'], [
    cs_tag('div', [ 'class' => 'x-statbar-bar'], $statbar_label_content )
  ]);

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_statbar() {

  $options_statbar_label_translate = [
    'available_units' => [ 'px', 'em', 'rem', '%' ],
    'valid_keywords'  => [ 'calc' ],
    'fallback_value'  => '0px',
    'ranges'          => [
      'px'  => [ 'min' => -50,  'max' => 50,  'step' => 1    ],
      'em'  => [ 'min' => -2.5, 'max' => 2.5, 'step' => 0.25 ],
      'rem' => [ 'min' => -2.5, 'max' => 2.5, 'step' => 0.25 ],
      '%'   => [ 'min' => -100, 'max' => 100, 'step' => 1    ],
    ],
  ];


  // Conditions
  // ----------

  $condition_statbar_row    = [ [ 'key' => 'statbar_direction', 'op' => 'NOT IN', 'value' => [ 'column', 'column-reverse' ] ] ];
  $condition_statbar_column = [ [ 'key' => 'statbar_direction', 'op' => 'NOT IN', 'value' => [ 'row', 'row-reverse' ]       ] ];


  // Individual Controls - Setup
  // ---------------------------

  $control_statbar_base_font_size = cs_recall( 'control_mixin_font_size', [ 'key' => 'statbar_base_font_size' ] );

  $control_statbar_direction = [
    'key'     => 'statbar_direction',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_direction' ),
    'options' => [
      'choices' => [
        [ 'value' => 'column-reverse', 'label' => '↑' ],
        [ 'value' => 'column',         'label' => '↓' ],
        [ 'value' => 'row-reverse',    'label' => '←' ],
        [ 'value' => 'row',            'label' => '→' ],
      ],
    ],
  ];

  $control_statbar_trigger_offset = [
    'key'     => 'statbar_trigger_offset',
    'type'    => 'unit-slider',
    'label'   => cs_recall( 'label_offset_trigger' ),
    'options' => [
      'available_units' => [ '%' ],
      'fallback_value'  => '75%',
      'ranges'          => [
        '%' => [ 'min' => 0, 'max' => 100, 'step' => 1 ],
      ],
    ],
  ];

  $control_statbar_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'statbar_bg_color' ] ] );


  // Individual Controls - Size, Row
  // -------------------------------

  $control_statbar_width_row      = cs_recall( 'control_mixin_width',      [ 'key' => 'statbar_width_row', 'conditions' => $condition_statbar_row      ] );
  $control_statbar_max_width_row  = cs_recall( 'control_mixin_max_width',  [ 'key' => 'statbar_max_width_row', 'conditions' => $condition_statbar_row  ] );
  $control_statbar_height_row     = cs_recall( 'control_mixin_height',     [ 'key' => 'statbar_height_row', 'conditions' => $condition_statbar_row     ] );
  $control_statbar_max_height_row = cs_recall( 'control_mixin_max_height', [ 'key' => 'statbar_max_height_row', 'conditions' => $condition_statbar_row ] );


  // Individual Controls - Size, Column
  // ----------------------------------

  $control_statbar_width_column      = cs_recall( 'control_mixin_width',      [ 'key' => 'statbar_width_column', 'conditions' => $condition_statbar_column      ] );
  $control_statbar_max_width_column  = cs_recall( 'control_mixin_max_width',  [ 'key' => 'statbar_max_width_column', 'conditions' => $condition_statbar_column  ] );
  $control_statbar_height_column     = cs_recall( 'control_mixin_height',     [ 'key' => 'statbar_height_column', 'conditions' => $condition_statbar_column     ] );
  $control_statbar_max_height_column = cs_recall( 'control_mixin_max_height', [ 'key' => 'statbar_max_height_column', 'conditions' => $condition_statbar_column ] );


  // Individual Controls - Bar
  // -------------------------

  $control_statbar_bar_length = [
    'key'     => 'statbar_bar_length',
    'type'    => 'unit-slider',
    'label'   => cs_recall( 'label_length' ),
    'options' => [
      'available_units' => [ '%' ],
      'fallback_value'  => '90%',
      'ranges'          => [
        '%' => [ 'min' => 0, 'max' => 100, 'step' => 1 ],
      ],
    ],
  ];

  $control_statbar_bar_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'statbar_bar_bg_color' ] ] );


  // Individual Controls - Label
  // ---------------------------

  $control_statbar_label_justify = [
    'key'       => 'statbar_label_justify',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_justify' ),
    'condition' => [ 'statbar_label' => true ],
    'options'   => [
      'choices' => [
        [ 'value' => 'flex-start', 'label' => cs_recall( 'label_start' )  ],
        [ 'value' => 'center',     'label' => cs_recall( 'label_center' ) ],
        [ 'value' => 'flex-end',   'label' => cs_recall( 'label_end' )    ],
      ],
    ],
  ];

  $control_statbar_label_options = [
    'keys' => [
      'label_custom_text' => 'statbar_label_custom_text',
      'label_always_show' => 'statbar_label_always_show',
    ],
    'type'      => 'checkbox-list',
    'label'     => cs_recall( 'label_options' ),
    'condition' => [ 'statbar_label' => true ],
    'options'   => [
      'list' => [
        [ 'key' => 'label_custom_text', 'label' => cs_recall( 'label_custom_text' ) ],
        [ 'key' => 'label_always_show', 'label' => cs_recall( 'label_always_show' ) ],
      ],
    ],
  ];

  $control_statbar_label_text_content = [
    'key'        => 'statbar_label_text_content',
    'type'       => 'text',
    'label'      => cs_recall( 'label_content' ),
    'conditions' => [ [ 'statbar_label' => true ], [ 'statbar_label_custom_text' => true ] ],
  ];

  $control_statbar_label_translate_x = [
    'key'     => 'statbar_label_translate_x',
    'type'    => 'unit-slider',
    'label'   => cs_recall( 'label_x_translate' ),
    'options' => $options_statbar_label_translate,
  ];

  $control_statbar_label_translate_y = [
    'key'     => 'statbar_label_translate_y',
    'type'    => 'unit-slider',
    'label'   => cs_recall( 'label_y_translate' ),
    'options' => $options_statbar_label_translate,
  ];

  $control_statbar_label_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'statbar_label_bg_color' ], 'condition' => [ 'statbar_label' => true ] ] );


  // Individual Controls - Label, Size
  // ---------------------------------

  $control_statbar_label_width  = cs_recall( 'control_mixin_width',  [ 'key' => 'statbar_label_width'  ] );
  $control_statbar_label_height = cs_recall( 'control_mixin_height', [ 'key' => 'statbar_label_height' ] );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    [
      'controls' => [
        [
          'type'     => 'group',
          'group'    => 'statbar:setup',
          'controls' => [
            $control_statbar_base_font_size,
            $control_statbar_direction,
            $control_statbar_trigger_offset,
            $control_statbar_bg_color,
          ],
        ],
        [
          'type'     => 'group',
          'group'    => 'statbar:size',
          'controls' => [
            $control_statbar_width_row,
            $control_statbar_height_row,
            $control_statbar_max_width_row,
            $control_statbar_max_height_row,
            $control_statbar_width_column,
            $control_statbar_height_column,
            $control_statbar_max_width_column,
            $control_statbar_max_height_column,
          ],
        ],

        cs_control( 'margin',        'statbar', [ 'group' => 'statbar:design' ] ),
        cs_control( 'padding',       'statbar', [ 'group' => 'statbar:design' ] ),
        cs_control( 'border',        'statbar', [ 'group' => 'statbar:design' ] ),
        cs_control( 'border-radius', 'statbar', [ 'group' => 'statbar:design' ] ),
        cs_control( 'box-shadow',    'statbar', [ 'group' => 'statbar:design' ] ),

        [
          'type'     => 'group',
          'group'    => 'statbar_bar:setup',
          'controls' => [
            $control_statbar_bar_length,
            $control_statbar_bar_bg_color,
          ],
        ],

        cs_control( 'border-radius', 'statbar_bar', [ 'group' => 'statbar_bar:design' ] ),
        cs_control( 'box-shadow',    'statbar_bar', [ 'group' => 'statbar_bar:design' ] ),

        [
          'key'      => 'statbar_label',
          'type'     => 'group',
          'group'    => 'statbar_label:setup',
          'options'  => cs_recall( 'options_group_toggle_off_on_bool' ),
          'controls' => [
            $control_statbar_label_justify,
            $control_statbar_label_options,
            $control_statbar_label_text_content,
            $control_statbar_label_translate_x,
            $control_statbar_label_translate_y,
            $control_statbar_label_bg_color,
          ],
        ],
        [
          'type'      => 'group',
          'group'     => 'statbar_label:size',
          'condition' => [ 'statbar_label' => true ],
          'controls'  => [
            $control_statbar_label_width,
            $control_statbar_label_height,
          ],
        ],

        cs_control( 'padding',       'statbar_label', [ 'group' => 'statbar_label:design', 'conditions' => [ [ 'statbar_label' => true ] ] ] ),
        cs_control( 'border',        'statbar_label', [ 'group' => 'statbar_label:design', 'conditions' => [ [ 'statbar_label' => true ] ] ] ),
        cs_control( 'border-radius', 'statbar_label', [ 'group' => 'statbar_label:design', 'conditions' => [ [ 'statbar_label' => true ] ] ] ),
        cs_control( 'box-shadow',    'statbar_label', [ 'group' => 'statbar_label:design', 'conditions' => [ [ 'statbar_label' => true ] ] ] ),

        cs_control( 'text-format', 'statbar_label', [ 'group' => 'statbar_label:text', 'conditions' => [ [ 'statbar_label' => true ] ] ] ),
        cs_control( 'text-shadow', 'statbar_label', [ 'group' => 'statbar_label:text', 'conditions' => [ [ 'statbar_label' => true ] ] ] )

      ],
      'control_nav' => [
        'statbar'              => cs_recall( 'label_statbar' ),
        'statbar:setup'        => cs_recall( 'label_setup' ),
        'statbar:size'         => cs_recall( 'label_size' ),
        'statbar:design'       => cs_recall( 'label_design' ),

        'statbar_bar'          => cs_recall( 'label_bar' ),
        'statbar_bar:setup'    => cs_recall( 'label_setup' ),
        'statbar_bar:design'   => cs_recall( 'label_design' ),

        'statbar_label'        => cs_recall( 'label_label' ),
        'statbar_label:setup'  => cs_recall( 'label_setup' ),
        'statbar_label:size'   => cs_recall( 'label_size' ),
        'statbar_label:design' => cs_recall( 'label_design' ),
        'statbar_label:text'   => cs_recall( 'label_text' ),
      ]
    ],
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true, 'add_looper_consumer' => true ] )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'statbar', [
  'title'      => __( 'Statbar', 'cornerstone' ),
  'values'     => $values,
  'builder'    => 'x_element_builder_setup_statbar',
  'tss'        => 'x_element_tss_statbar',
  'render'     => 'x_element_render_statbar',
  'icon'       => 'native',
  'components' => [
    [ 'type' => 'effects', 'values' => [ 'effects_duration' => '750ms' ] ]
  ],
] );
