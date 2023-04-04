<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/ICON.PHP
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
  'icon',
  'omega',
  'omega:custom-atts',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_tss_icon() {
  return [
    'modules' => [ 'icon', 'effects' ]
  ];
}

// Render
// =============================================================================

function x_element_render_icon( $data ) {
  return cs_get_partial_view( 'icon', array_merge( cs_extract( $data, [ 'effects' => ''] ), [
    'id' => $data['id'],
    'classes' => $data['classes'],
    'style' => $data['style'],
    'custom_atts' => $data['custom_atts'],
    'icon' => $data['icon']
  ]));
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_icon() {
  return cs_compose_controls(
    cs_partial_controls( 'icon' ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true, 'add_looper_consumer' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'icon', [
  'title'      => __( 'Icon', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_icon',
  'tss'        => 'x_element_tss_icon',
  'render'     => 'x_element_render_icon',
  'icon'       => 'native',
] );
