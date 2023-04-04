<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/COUNTER.PHP
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
    'counter_base_font_size'                      => cs_value( '1em' ),
    'counter_width'                               => cs_value( 'auto' ),
    'counter_max_width'                           => cs_value( 'none' ),
    'counter_start'                               => cs_value( '0', 'markup', true ),
    'counter_end'                                 => cs_value( '100', 'markup', true ),
    'counter_number_prefix_content'               => cs_value( '', 'markup', true ),
    'counter_number_suffix_content'               => cs_value( '', 'markup', true ),
    'counter_duration'                            => cs_value( '1500ms', 'markup' ),
    'counter_before_after'                        => cs_value( false, 'markup' ),
    'counter_before_content'                      => cs_value( '', 'markup', true ),
    'counter_after_content'                       => cs_value( '', 'markup', true ),
    'counter_margin'                              => cs_value( '!0px' ),
    'counter_number_margin'                       => cs_value( '!0px 0px 0px 0px' ),
    'counter_number_font_family'                  => cs_value( 'inherit', 'style:font-family' ),
    'counter_number_font_weight'                  => cs_value( 'inherit:400', 'style:font-weight' ),
    'counter_number_font_size'                    => cs_value( '1em' ),
    'counter_number_letter_spacing'               => cs_value( '0em' ),
    'counter_number_line_height'                  => cs_value( '1' ),
    'counter_number_font_style'                   => cs_value( 'normal' ),
    'counter_number_text_align'                   => cs_value( 'none' ),
    'counter_number_text_decoration'              => cs_value( 'none' ),
    'counter_number_text_transform'               => cs_value( 'none' ),
    'counter_number_text_color'                   => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'counter_number_text_shadow_dimensions'       => cs_value( '!0px 0px 0px' ),
    'counter_number_text_shadow_color'            => cs_value( 'transparent', 'style:color' ),

    'counter_before_after_font_family'            => cs_value( 'inherit', 'style:font-family' ),
    'counter_before_after_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
    'counter_before_after_font_size'              => cs_value( '1em' ),
    'counter_before_after_letter_spacing'         => cs_value( '0em' ),
    'counter_before_after_line_height'            => cs_value( '1' ),
    'counter_before_after_font_style'             => cs_value( 'normal' ),
    'counter_before_after_text_align'             => cs_value( 'none' ),
    'counter_before_after_text_decoration'        => cs_value( 'none' ),
    'counter_before_after_text_transform'         => cs_value( 'none' ),
    'counter_before_after_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'counter_before_after_text_shadow_dimensions' => cs_value( '!0px 0px 0px' ),
    'counter_before_after_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  ],
  'omega',
  'omega:custom-atts',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_tss_counter() {
  return [
    'require' => [ 'elements-legacy' ],
    'modules' => [ 'counter', 'effects']
  ];
}


// Render
// =============================================================================

function x_element_render_counter( $data ) {

  extract($data);

  // Prepare Attr Values
  // -------------------

  $counter_data = array(
    'to'   => cs_dynamic_content($counter_end),
    'speed' => cs_dynamic_content($counter_duration)
  );


  // Prepare Atts
  // ------------

  $atts = [
    'class' => array_merge( ['x-counter'], $classes ),
  ];

  if ( isset( $id ) && ! empty( $id ) ) {
    $atts['id'] = $id;
  }

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }

  $atts = cs_apply_effect( $atts, $data );

  $atts = array_merge( $atts, cs_element_js_atts( 'counter', $counter_data, true ) );


  // Content
  // -------

  $counter_before_content        = ( $counter_before_after === true && ! empty( $counter_before_content ) ) ? '<div class="x-counter-before">' . cs_dynamic_content($counter_before_content) . '</div>' : '';
  $counter_after_content         = ( $counter_before_after === true && ! empty( $counter_after_content )  ) ? '<div class="x-counter-after">' . cs_dynamic_content($counter_after_content) . '</div>' : '';
  $counter_number_prefix_content = ( ! empty( $counter_number_prefix_content ) ) ? '<span class="x-counter-number-prefix">' . cs_dynamic_content($counter_number_prefix_content) . '</span>' : '';
  $counter_number_suffix_content = ( ! empty( $counter_number_suffix_content ) ) ? '<span class="x-counter-number-suffix">' . cs_dynamic_content($counter_number_suffix_content) . '</span>' : '';

  $counter_content = $counter_before_content
                    . '<div class="x-counter-number-wrap">'
                      . $counter_number_prefix_content
                      . '<span class="x-counter-number">' . cs_dynamic_content($counter_start) . '</span>'
                      . $counter_number_suffix_content
                    . '</div>'
                  . $counter_after_content;


  // Output
  // ------

  return cs_tag( 'div', $atts, $custom_atts, $counter_content );

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_counter() {

  $options_counter_number_margin_tb = [
    'available_units' => [ 'px', 'em', 'rem' ],
    'fallback_value'  => '10px',
    'valid_keywords'  => [ 'calc' ],
    'ranges'          => [
      'px'  => [ 'min' => 0, 'max' => 32, 'step' => 1   ],
      'em'  => [ 'min' => 0, 'max' => 3,  'step' => 0.1 ],
      'rem' => [ 'min' => 0, 'max' => 3,  'step' => 0.1 ],
    ],
  ];

  $options_counter_number_margin_lr = [
    'disabled'       => true,
    'fallback_value' => '0px',
  ];

  $options_counter_number_margin = [
    'top'    => $options_counter_number_margin_tb,
    'left'   => $options_counter_number_margin_lr,
    'right'  => $options_counter_number_margin_lr,
    'bottom' => $options_counter_number_margin_tb,
  ];


  // Settings
  // --------

  $settings_counter = [
    'label_prefix' => cs_recall( 'label_counter' ),
    'group'        => 'counter:design',
  ];

  $settings_counter_number = [
    'label_prefix' => cs_recall( 'label_number' ),
    'group'        => 'counter:number',
  ];

  $settings_counter_before_after = [
    'label_prefix' => cs_recall( 'label_above_and_below' ),
    'group'        => 'counter:text',
    'conditions'   => [ [ 'counter_before_after' => true ] ],
  ];


  // Individual Controls - Setup
  // ---------------------------

  $control_counter_base_font_size = cs_recall( 'control_mixin_font_size', [ 'key' => 'counter_base_font_size' ] );

  $control_counter_start = [
    'key'     => 'counter_start',
    'type'    => 'text',
    'options' => [
      'dynamic_content' => 'scalar',
      'fallback_value'  => 0,
    ],
  ];

  $control_counter_end = [
    'key'     => 'counter_end',
    'type'    => 'text',
    'options' => [
      'dynamic_content' => 'scalar',
      'fallback_value'  => 100,
    ],
  ];

  $control_counter_start_and_end = [
    'type'     => 'group',
    'label'    => cs_recall( 'label_number_start_and_end' ),
    'controls' => [
      $control_counter_start,
      $control_counter_end,
    ],
  ];

  $control_counter_number_prefix_content = [
    'key'  => 'counter_number_prefix_content',
    'type' => 'text',
  ];

  $control_counter_number_suffix_content = [
    'key'  => 'counter_number_suffix_content',
    'type' => 'text',
  ];

  $control_counter_number_prefix_and_suffix_content = [
    'type'     => 'group',
    'label'    => cs_recall( 'label_prefix_and_suffix' ),
    'controls' => [
      $control_counter_number_prefix_content,
      $control_counter_number_suffix_content,
    ],
  ];

  $control_counter_duration = [
    'key'     => 'counter_duration',
    'type'    => 'unit-slider',
    'label'   => cs_recall( 'label_duration' ),
    'options' => [
      'unit_mode'       => 'time',
      'available_units' => [ 's', 'ms' ],
      'fallback_value'  => '0.5s',
      'ranges'          => [
        's'  => [ 'min' => 0, 'max' => 5,    'step' => 0.1 ],
        'ms' => [ 'min' => 0, 'max' => 5000, 'step' => 100 ],
      ],
    ],
  ];

  $control_counter_before_content = [
    'key'       => 'counter_before_content',
    'type'      => 'text',
    'label'     => cs_recall( 'label_above' ),
    'condition' => [ 'counter_before_after' => true ],
  ];

  $control_counter_after_content = [
    'key'       => 'counter_after_content',
    'type'      => 'text',
    'label'     => cs_recall( 'label_below' ),
    'condition' => [ 'counter_before_after' => true ],
  ];


  // Individual Controls - Size
  // --------------------------

  $control_counter_width     = cs_recall( 'control_mixin_width',     [ 'key' => 'counter_width'     ] );
  $control_counter_max_width = cs_recall( 'control_mixin_max_width', [ 'key' => 'counter_max_width' ] );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    [
      'controls' => [
        [
          'type'     => 'group',
          'group'    => 'counter:setup',
          'controls' => [
            $control_counter_base_font_size,
            $control_counter_start_and_end,
            $control_counter_number_prefix_and_suffix_content,
            $control_counter_duration,
          ],
        ],
        [
          'key'      => 'counter_before_after',
          'type'     => 'group',
          'label'    => cs_recall( 'label_above_and_below_text' ),
          'group'    => 'counter:setup',
          'options'  => cs_recall( 'options_group_toggle_off_on_bool' ),
          'controls' => [
            $control_counter_before_content,
            $control_counter_after_content,
          ],
        ],
        [
          'type'     => 'group',
          'group'    => 'counter:size',
          'controls' => [
            $control_counter_width,
            $control_counter_max_width,
          ],
        ],

        cs_control( 'margin', 'counter', $settings_counter ),
        cs_control( 'margin', 'counter_number', [
          'k_pre'        => 'counter_number',
          'label_prefix' => cs_recall( 'label_number' ),
          'group'        => 'counter:number',
          'options'      => $options_counter_number_margin,
        ] ),

        cs_control( 'text-format', 'counter_number', $settings_counter_number ),
        cs_control( 'text-shadow', 'counter_number', $settings_counter_number ),
        cs_control( 'text-format', 'counter_before_after', $settings_counter_before_after ),
        cs_control( 'text-shadow', 'counter_before_after', $settings_counter_before_after )

      ],
      'control_nav' => [
        'counter'        => cs_recall( 'label_counter' ),
        'counter:setup'  => cs_recall( 'label_setup' ),
        'counter:size'   => cs_recall( 'label_size' ),
        'counter:design' => cs_recall( 'label_design' ),
        'counter:number' => cs_recall( 'label_number' ),
        'counter:text'   => cs_recall( 'label_text' ),
      ],
    ],
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true, 'add_looper_consumer' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'counter', [
  'title'      => __( 'Counter', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_counter',
  'tss'        => 'x_element_tss_counter',
  'render'     => 'x_element_render_counter',
  'icon'       => 'native',
] );
