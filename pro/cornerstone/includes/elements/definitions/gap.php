<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/GAP.PHP
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
    'gap_direction'      => cs_value( 'vertical' ),
    'gap_base_font_size' => cs_value( '1em' ),
    'gap_size'           => cs_value( '2em' ),
  ],
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_gap() {
  return [
    'modules' => [ 'gap' ]
  ];
}

// Render
// =============================================================================

function x_element_render_gap( $data ) {

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


  // Output
  // ------

  return cs_tag('hr', $atts, $data['custom_atts'], '');

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_gap() {

  // Individual Controls
  // -------------------

  $control_gap_base_font_size = cs_recall( 'control_mixin_font_size',    [ 'key' => 'gap_base_font_size'                                 ] );
  $control_gap_direction      = cs_recall( 'control_mixin_direction_hv', [ 'key' => 'gap_direction'                                      ] );
  $control_gap_size           = cs_recall( 'control_mixin_font_size',    [ 'key' => 'gap_size', 'label' => cs_recall( 'label_gap_size' ) ] );


  // Compose Controls
  // ----------------

  $controls = [
    [
      'type'       => 'group',
      'label'      => cs_recall( 'label_setup' ),
      'group'      => 'gap:setup',
      'controls'   => [
        $control_gap_base_font_size,
        $control_gap_direction,
        $control_gap_size,
      ],
    ],
  ];

  return cs_compose_controls(
    [
      'controls' => $controls,
      'control_nav' => [
        'gap'       => cs_recall( 'label_gap' ),
        'gap:setup' => cs_recall( 'label_setup' ),
      ]
    ],
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true ] )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'gap', [
  'title'      => __( 'Gap', 'cornerstone' ),
  'values'     => $values,
  'builder'    => 'x_element_builder_setup_gap',
  'tss'        => 'x_element_tss_gap',
  'render'     => 'x_element_render_gap',
  'icon'       => 'native',
  'options'    => [
    'empty_placeholder' => false
  ]
] );
