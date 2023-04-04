<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/RATING.PHP
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
  'rating',
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_rating() {
  return [
    'require' => [ 'elements-extra' ],
    'modules' => [ 'rating', 'effects' ]
  ];
}

// Render
// =============================================================================

function x_element_render_rating( $data ) {
  return cs_get_partial_view( 'rating', array_merge( cs_extract( $data, [ 'rating' => '', 'effects' => '' ] ), [
    'id' => $data['id'],
    'classes' => $data['classes'],
    'style' => $data['style'],
    'custom_atts' => $data['custom_atts'],
  ]));
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_rating() {
  return cs_compose_controls(
    cs_partial_controls( 'rating' ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'rating', [
  'title'      => __( 'Rating', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_rating',
  'style'      => 'x_element_style_rating',
  'tss'        => 'x_element_tss_rating',
  'render'     => 'x_element_render_rating',
  'icon'       => 'native',
] );
