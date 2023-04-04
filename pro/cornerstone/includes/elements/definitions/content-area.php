<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/CONTENT-AREA.PHP
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
  'content-area',
  'content-area-margin',
  'omega',
  'omega:custom-atts',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_tss_content_area() {
  return [
    'require' => [ 'elements-legacy' ],
    'modules' => [ 'content-area', 'effects']
  ];
}


// Render
// =============================================================================

function x_element_render_content_area( $data ) {

  // Prepare Atts
  // ------------

  $atts = [
    'class' => array_merge( [ 'x-content-area' ], $data['classes'] )
  ];

  if ( isset( $data['id'] ) && ! empty( $data['id'] ) ) {
    $atts['id'] = $data['id'];
  }

  $atts = cs_apply_effect( $atts, $data );

  // Output
  // ------

  return cs_tag('div', $atts, $data['custom_atts'], cs_dynamic_content( $data['content'] ) );

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_content_area() {
  return cs_compose_controls(
    cs_partial_controls( 'content-area', array( 'type' => 'standard' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_custom_atts' => true, 'add_looper_consumer' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'content-area', [
  'title'      => __( 'Content Area', '__x__' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_content_area',
  'tss'        => 'x_element_tss_content_area',
  'render'     => 'x_element_render_content_area',
  'icon'       => 'native',
  'group'      => 'deprecated',
  'options'    => [
    'inline'       => [
      'content' => [
        'selector' => 'root'
      ],
    ]
  ]
] );
