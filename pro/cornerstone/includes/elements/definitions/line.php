<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/LINE.PHP
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
    'line_direction'             => cs_value( 'horizontal', 'markup' ),
    'line_base_font_size'        => cs_value( '1em' ),
    'line_width'                 => cs_value( '100%' ),
    'line_max_width'             => cs_value( 'none' ),
    'line_height'                => cs_value( '10em' ),
    'line_max_height'            => cs_value( 'none' ),
    'line_size'                  => cs_value( '1em' ),
    'line_color'                 => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'line_style'                 => cs_value( 'solid' ),
    'line_margin'                => cs_value( '!0px' ),
    'line_border_radius'         => cs_value( '!0px' ),
    'line_box_shadow_dimensions' => cs_value( '!0em 0em 0em 0em' ),
    'line_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  ],
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_line() {
  return [
    'modules' => [ 'line', 'effects' ]
  ];
}


// Render
// =============================================================================

function x_element_render_line( $data ) {

  // Prepare Atts
  // ------------

  $atts = [
    'class' => array_merge( [ 'x-line' ], $data['classes'] )
  ];

  if ( isset( $data['id'] ) && ! empty( $data['id'] ) ) {
    $atts['id'] = $data['id'];
  }

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }

  $atts = cs_apply_effect( $atts, $data );

  // Output
  // ------

  return cs_tag( 'hr', $atts, $data['custom_atts'], '');

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_line() {

  $control_line_base_font_size = cs_recall( 'control_mixin_font_size',    [ 'key' => 'line_base_font_size'                                                                                    ] );
  $control_line_direction      = cs_recall( 'control_mixin_direction_hv', [ 'key' => 'line_direction'                                                                                         ] );
  $control_line_width          = cs_recall( 'control_mixin_width',        [ 'key' => 'line_width', 'condition' => [ 'line_direction' => 'horizontal' ]                                        ] );
  $control_line_max_width      = cs_recall( 'control_mixin_max_width',    [ 'key' => 'line_max_width', 'condition' => [ 'line_direction' => 'horizontal' ]                                    ] );
  $control_line_height         = cs_recall( 'control_mixin_height',       [ 'key' => 'line_height', 'condition' => [ 'line_direction' => 'vertical' ]                                         ] );
  $control_line_max_height     = cs_recall( 'control_mixin_max_height',   [ 'key' => 'line_max_height', 'condition' => [ 'line_direction' => 'vertical' ]                                     ] );
  $control_line_size_width     = cs_recall( 'control_mixin_width',        [ 'key' => 'line_size', 'label' => cs_recall( 'label_width' ), 'condition' => [ 'line_direction' => 'vertical' ]    ] );
  $control_line_size_height    = cs_recall( 'control_mixin_height',       [ 'key' => 'line_size', 'label' => cs_recall( 'label_height' ), 'condition' => [ 'line_direction' => 'horizontal' ] ] );

  $control_line_style = [
    'key'     => 'line_style',
    'type'    => 'select',
    'label'   => cs_recall( 'label_style' ),
    'options' => cs_recall( 'options_choices_border_styles' ),
  ];

  $control_line_color = cs_recall( 'control_mixin_color_solo', [ 'keys' => [ 'value' => 'line_color' ] ] );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    [
      'controls' => [
        [
          'type'     => 'group',
          'group'    => 'line:setup',
          'controls' => [
            $control_line_base_font_size,
            $control_line_direction,
            $control_line_style,
            $control_line_color,
          ],
        ],
        [
          'type'     => 'group',
          'group'    => 'line:size',
          'controls' => [
            $control_line_size_width,
            $control_line_width,
            $control_line_max_width,
            $control_line_height,
            $control_line_max_height,
            $control_line_size_height,
          ],
        ],
        cs_control( 'margin', 'line', [ 'group' => 'line:design' ] ),
        cs_control( 'border-radius', 'line', [ 'group' => 'line:design' ] ),
        cs_control( 'box-shadow', 'line', [ 'group' => 'line:design' ] )
      ],
      'control_nav' => [
        'line'        => cs_recall( 'label_line' ),
        'line:setup'  => cs_recall( 'label_setup' ),
        'line:size'   => cs_recall( 'label_size' ),
        'line:design' => cs_recall( 'label_design' ),
      ]
    ],
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true ] )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'line', [
  'title'      => __( 'Line', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_line',
  'tss'        => 'x_element_tss_line',
  'render'     => 'x_element_render_line',
  'icon'       => 'native',
] );
