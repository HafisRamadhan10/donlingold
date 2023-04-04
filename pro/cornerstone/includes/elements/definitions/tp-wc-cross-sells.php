<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-WC-CROSS-SELLS.PHP
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
  'products',
  'omega',
  'omega:toggle-hash',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_tp_wc_cross_sells() {
  return [
    'require' => [ 'elements-wc' ],
    'modules' => [ 'products', 'effects' ]
  ];
}


// Render
// =============================================================================

function x_element_render_tp_wc_cross_sells( $data ) {

  return cs_get_partial_view( 'products', array_merge( cs_extract( $data, [ 'products' => '', 'effects' => '' ] ), [
    'id' => $data['id'],
    'classes' => $data['classes'],
    'style' => $data['style'],
    'custom_atts' => $data['custom_atts'],
    'products_type' => 'cross-sells'
  ]));
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_wc_cross_sells() {
  return cs_compose_controls(
    cs_partial_controls( 'products', [ 'type' => 'cross-sells' ] ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_toggle_hash' => true, 'add_custom_atts' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'tp-wc-cross-sells', [
  'title'      => __( 'Cross Sells', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_tp_wc_cross_sells',
  'tss'        => 'x_element_tss_tp_wc_cross_sells',
  'render'     => 'x_element_render_tp_wc_cross_sells',
  'icon'       => 'native',
  'active'     => class_exists( 'WC_API' ),
  'group'      => 'woocommerce',
] );
