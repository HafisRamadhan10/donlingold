<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TEXT.PHP
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
  'text-standard',
  'omega',
  'omega:custom-atts',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_tss_text() {
  return [
    'require' => [ 'elements-legacy' ],
    'modules' => [ 'text-standard', 'effects' ]
  ];
}



// Render
// =============================================================================

function x_element_render_text( $data ) {
  return cs_get_partial_view( 'text', array_merge( cs_extract( $data, [ 'text' => '', 'effects' => '' ] ), [
    'id' => $data['id'],
    'classes' => $data['classes'],
    'style' => $data['style'],
    'custom_atts' => $data['custom_atts'],
  ]));
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_text() {
  return cs_compose_controls(
    cs_partial_controls( 'text', [ 'type' => 'standard' ] ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true, 'add_looper_consumer' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'text', [
  'title'      => __( 'Text', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_text',
  'tss'        => 'x_element_tss_text',
  'render'     => 'x_element_render_text',
  'icon'       => 'native',
  'options'    => [
    'inline' => [
      'text_content' => [
        'selector' => 'root'
      ],
    ]
  ]
] );
