<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-WC-SHOP-NOTICES.PHP
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
    'shop_notices_margin' => cs_value( '0em', 'style' ),
  ],
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_tss_style_tp_wc_notices() {
  return [
    'require' => [ 'elements-wc' ],
    'modules' => [
      'tp-wc-shop-notices',
      'effects'
    ]
  ];
}


// Render
// =============================================================================

function x_element_render_tp_wc_notices( $data ) {

  // Prepare Atts
  // ------------

  $atts = [
    'class' => array_merge( [ 'x-wc-shop-notices' ], $data['classes'] )
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
  woocommerce_output_all_notices();
  $content = ob_get_clean();

  return cs_tag('div', $atts, $content);

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_wc_notices() {

  return cs_compose_controls(
    [
      'controls' => [
        cs_control( 'margin', 'shop_notices', [ 'group' => 'shop_notices:design' ] ),
      ],
      'control_nav' => [
        'shop_notices'        => cs_recall( 'label_shop_notices' ),
        'shop_notices:setup'  => cs_recall( 'label_setup' ),
        'shop_notices:design' => cs_recall( 'label_design' ),
      ],
    ],
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_toggle_hash' => true ] )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'tp-wc-shop-notices', [
  'title'      => __( 'Shop Notices', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_tp_wc_notices',
  'tss'        => 'x_element_tss_style_tp_wc_notices',
  'render'     => 'x_element_render_tp_wc_notices',
  'icon'       => 'native',
  'active'     => class_exists( 'WC_API' ),
  'group'      => 'woocommerce',
] );
