<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-WC-SHOP-SORT.PHP
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
    'shop_sort_margin' => cs_value( '0em', 'style' ),
  ],
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_tss_tp_wc_shop_sort() {
  return [
    'require' => [ 'elements-wc' ],
    'modules' => [
      'tp-wc-shop-sort',
      'effects'
    ]
  ];
}



// Render
// =============================================================================

function x_element_render_tp_wc_shop_sort( $data ) {


  // Prepare Atts
  // ------------

  $atts = [
    'class' => array_merge( [ 'x-wc-shop-sort' ], $data['classes'] )
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

  ob_start();
  woocommerce_catalog_ordering();
  woocommerce_result_count();
  $content = ob_get_clean();

  return cs_tag( 'div', $atts, $content);

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_wc_shop_sort() {

  return cs_compose_controls(
    [
      'controls' => [
        cs_control( 'margin', 'shop_sort', [ 'group' => 'shop_sort:design' ] ),
      ],
      'control_nav' => [
        'shop_sort'        => cs_recall( 'label_shop_sort' ),
        'shop_sort:design' => cs_recall( 'label_design' ),
      ],
    ],
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_toggle_hash' => true ] )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'tp-wc-shop-sort', [
  'title'      => __( 'Shop Sort', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_tp_wc_shop_sort',
  'tss'        => 'x_element_tss_tp_wc_shop_sort',
  'render'     => 'x_element_render_tp_wc_shop_sort',
  'icon'       => 'native',
  'active'     => class_exists( 'WC_API' ),
  'group'      => 'woocommerce',
] );
