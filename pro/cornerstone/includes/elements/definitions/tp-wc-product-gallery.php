<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-WC-PRODUCT-GALLERY.PHP
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
    'product_gallery_base_font_size'        => cs_value( '1em', 'style' ),
    'product_gallery_overflow'              => cs_value( 'visible', 'style' ),
    'product_gallery_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'product_gallery_max_width'             => cs_value( 'none', 'style' ),
    'product_gallery_margin'                => cs_value( '!0em', 'style' ),
    'product_gallery_padding'               => cs_value( '!0em', 'style' ),
    'product_gallery_border_width'          => cs_value( '!0px', 'style' ),
    'product_gallery_border_style'          => cs_value( 'solid', 'style' ),
    'product_gallery_border_color'          => cs_value( 'transparent', 'style:color' ),
    'product_gallery_border_radius'         => cs_value( '!0px', 'style' ),
    'product_gallery_box_shadow_dimensions' => cs_value( '!0em 0em 0em 0em', 'style' ),
    'product_gallery_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  ],
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_tss_tp_wc_product_gallery() {
  return [
    'require' => [ 'elements-wc' ],
    'modules' => [
      'tp-wc-product-gallery',
      'effects'
    ]
  ];
}



// Render
// =============================================================================

function x_tp_wc_product_gallery_update_class( $classes ) {
	array_unshift( $classes, 'x-preview-woocommerce-product-gallery');
	return array_filter( $classes, function( $class ) {
    return $class !== 'woocommerce-product-gallery';
  });
}

function x_element_render_tp_wc_product_gallery( $data ) {

  $is_preview = apply_filters( 'cs_is_preview', false );

  if ( $is_preview ) {
    add_filter( 'woocommerce_single_product_image_gallery_classes', 'x_tp_wc_product_gallery_update_class' );
  }

  ob_start();
  global $product;

  if ( $product ) {
    woocommerce_show_product_images();
  }

  $gallery_content = ob_get_clean();

  if ( $is_preview ) {
    remove_filter( 'woocommerce_single_product_image_gallery_classes', 'x_tp_wc_product_gallery_update_class' );
  }

  $atts = [
    'class' => array_merge( [ 'x-wc-product-gallery' ], $data['classes'] ),
    'id'    => empty( $data['id'] ) ? false : $data['id']
  ];

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }

  return cs_tag( 'div', cs_apply_effect( $atts, $data ), $gallery_content );

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_wc_product_gallery() {

  // Groups
  // ------

  $group        = 'product_gallery';
  $group_setup  = $group . ':setup';
  $group_size   = $group . ':size';
  $group_design = $group . ':design';


  // Controls
  // --------

  $control_product_gallery_base_font_size = cs_recall( 'control_mixin_font_size',     [ 'key' => 'product_gallery_base_font_size'           ] );
  $control_product_gallery_max_width      = cs_recall( 'control_mixin_max_width',     [ 'key' => 'product_gallery_max_width'                ] );
  $control_product_gallery_overflow       = cs_recall( 'control_mixin_overflow',      [ 'key' => 'product_gallery_overflow'                 ] );
  $control_product_gallery_bg_color       = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'product_gallery_bg_color' ] ] );


  // Settings
  // --------

  $settings_product_gallery_design = [
    'group' => $group_design,
  ];


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    [
      'controls' => [
        [
          'type'     => 'group',
          'group'    => $group_setup,
          'controls' => [
            $control_product_gallery_base_font_size,
            $control_product_gallery_overflow,
            $control_product_gallery_bg_color,
          ],
        ],
        [
          'type'     => 'group',
          'group'    => $group_size,
          'controls' => [
            $control_product_gallery_max_width,
          ],
        ],
        cs_control( 'margin', 'product_gallery', $settings_product_gallery_design ),
        cs_control( 'padding', 'product_gallery', $settings_product_gallery_design ),
        cs_control( 'border', 'product_gallery', $settings_product_gallery_design ),
        cs_control( 'border-radius', 'product_gallery', $settings_product_gallery_design ),
        cs_control( 'box-shadow', 'product_gallery', $settings_product_gallery_design ),
      ],
      'control_nav'                => [
        $group        => cs_recall( 'label_product_gallery' ),
        $group_setup  => cs_recall( 'label_setup' ),
        $group_size   => cs_recall( 'label_size' ),
        $group_design => cs_recall( 'label_design' ),
      ],
    ],
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_toggle_hash' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'tp-wc-product-gallery', [
  'title'      => __( 'Product Gallery', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_tp_wc_product_gallery',
  'tss'        => 'x_element_tss_tp_wc_product_gallery',
  'render'     => 'x_element_render_tp_wc_product_gallery',
  'icon'       => 'native',
  'active'     => class_exists( 'WC_API' ),
  'group'      => 'woocommerce',
] );
