<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-WC-ADD-TO-CART-FORM.PHP
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
    'add_to_cart_form_margin' => cs_value( '0em', 'style' ),
  ],
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_tss_tp_wc_add_to_cart_form() {
  return [
    'require' => [ 'elements-wc' ],
    'modules' => [
      'tp-wc-add-to-cart-form',
      'effects'
    ]
  ];
}



// Render
// =============================================================================

function x_element_render_tp_wc_add_to_cart_form( $data ) {

  // Prepare Atts
  // ------------

  $atts = [
    'class' => array_merge( [ 'x-wc-add-to-cart-form' ], $data['classes'] )
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

  global $product;

  if ( ! empty($product) ) {
    woocommerce_template_single_add_to_cart();
  }


  $form = ob_get_clean();

  return cs_tag('div', $atts, $form );

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_wc_add_to_cart_form() {

  return cs_compose_controls(
    [
      'controls' => [
        cs_control( 'margin', 'add_to_cart_form', [ 'group' => 'add_to_cart_form:design' ] ),
      ],
      'control_nav' => [
        'add_to_cart_form'        => cs_recall( 'label_add_to_cart_form' ),
        'add_to_cart_form:design' => cs_recall( 'label_design' ),
      ],
    ],
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_toggle_hash' => true ] )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'tp-wc-add-to-cart-form', [
  'title'      => __( 'Add to Cart Form', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_tp_wc_add_to_cart_form',
  'tss'        => 'x_element_tss_tp_wc_add_to_cart_form',
  'render'     => 'x_element_render_tp_wc_add_to_cart_form',
  'icon'       => 'native',
  'active'     => class_exists( 'WC_API' ),
  'group'      => 'woocommerce',
] );
