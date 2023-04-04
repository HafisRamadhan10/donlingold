<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-WC-PRODUCT-PAGINATION.PHP
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
  'pagination:product',
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_product_pagination() {
  return [
    'require' => [ 'elements-wp' ],
    'modules' => [
      'pagination',
      ['effects', [
        'args' => [
          'selectors' => [ '.x-paginate-inner > *' ]
        ]
      ]]
    ]
  ];
}


// Render
// =============================================================================

function x_element_render_product_pagination( $data ) {
  return cs_get_partial_view( 'pagination', array_merge( cs_extract( $data, [ 'pagination' => '', 'effects' => '' ] ), [
    'id' => $data['id'],
    'classes' => $data['classes'],
    'style' => $data['style'],
    'custom_atts' => $data['custom_atts'],
  ]));
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_product_pagination() {
  return cs_compose_controls(
    cs_partial_controls( 'pagination', [ 'type' => 'product' ] ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'tp-wc-product-pagination', [
  'title'      => __( 'Product Pagination', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_product_pagination',
  'tss'        => 'x_element_tss_product_pagination',
  'render'     => 'x_element_render_product_pagination',
  'icon'       => 'native',
  'active'     => class_exists( 'WC_API' ),
  'group'      => 'woocommerce',
] );
