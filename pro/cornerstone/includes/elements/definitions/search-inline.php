<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/SEARCH-INLINE.PHP
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
  'search-inline',
  'omega'
);



// Style
// =============================================================================

function x_element_tss_search_inline() {
  return [
    'modules' => [
      'search',
      'effects'
    ]
  ];
}



// Render
// =============================================================================

function x_element_render_search_inline( $data ) {
  return cs_get_partial_view( 'search', array_merge( cs_extract( $data, [ 'search' => '', 'effects' => '' ] ), [
    'id' => $data['id'],
    'classes' => $data['classes'],
    'style' => $data['style'],
    'search_id' => $data['unique_id'],
    'custom_atts' => $data['search_custom_atts']
  ]) );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_search_inline() {
  return cs_compose_controls(
    cs_partial_controls( 'search', [ 'type' => 'inline' ] ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_toggle_hash' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'search-inline', [
  'title'      => __( 'Search', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_search_inline',
  'tss'        => 'x_element_tss_search_inline',
  'render'     => 'x_element_render_search_inline',
  'icon'       => 'native',
] );
