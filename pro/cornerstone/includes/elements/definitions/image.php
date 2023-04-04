<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/IMAGE.PHP
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
  'image',
  'image:src',
  'image:retina',
  'image:dimensions',
  'image:link',
  'image:alt',
  'image:object',
  'omega',
  'omega:custom-atts',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_tss_image() {
  return [
    'modules' => [ 'image', 'effects' ]
  ];
}


// Render
// =============================================================================

function x_element_render_image( $data ) {
  return cs_get_partial_view( 'image', array_merge( cs_extract( $data, [ 'image' => '', 'effects' => '' ] ), [
    'id' => $data['id'],
    'classes' => $data['classes'],
    'style' => $data['style'],
    '_region' => $data['_region'],
    'custom_atts' => $data['custom_atts'],
  ]));
  return cs_get_partial_view( 'image', $data );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_image() {
  return cs_compose_controls(
    cs_partial_controls( 'image' ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true, 'add_looper_consumer' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'image', [
  'title'      => __( 'Image', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_image',
  'tss'        => 'x_element_tss_image',
  'render'     => 'x_element_render_image',
  'icon'       => 'native',
] );
