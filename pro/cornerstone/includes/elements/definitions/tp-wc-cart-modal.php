<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TP-WC-CART-MODAL.PHP
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
  'cart-nested',
  'cart-button',
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_tss_tp_wc_cart_modal() {
  return [
    'require' => [ 'elements-wc' ],
    'modules' => [
      ['anchor', [ 'args' => [ 'keyPrefix' => 'toggle' ] ]],
      ['anchor', [
        'name' => 'cart-anchor',
        'nested' => true,
        'args' => [
          'selector' => '.buttons .x-anchor'
        ],
        'remap' => [ 'cart_anchor' => 'anchor' ]
      ]],
      ['modal', [ 'nested' => true ] ],
      ['mini-cart', [
        'nested' => true,
        'args' => [
          'isNested' => true
        ]
      ] ],
      ['effects', [
        'args' => [
          'selectors' => ['.x-anchor-text-primary', '.x-anchor-text-secondary', '.x-graphic-child']
        ]
      ]]
    ]
  ];
}

// Render
// =============================================================================

function x_element_render_tp_wc_cart_modal( $data ) {
  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', array(
      'controls' => 'modal',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Modal Content', 'cornerstone' ),
    ), $data['id'], $data['unique_id'] )
  );

  cs_defer_partial( 'modal', array_merge( cs_extract( $data, [ 'modal' => '' ] ), [
    'id' => $data['id'],
    'classes' => [
      $data['_tss']['modal'],
      $data['style_id'],
      $data['class']
    ],
    'style' => $data['style'],
    'toggleable_id' => $data['unique_id'],
    'modal_content' => cs_get_partial_view( 'mini-cart', array_merge(
      cs_extract( $data, [ 'cart' => '' ] ),
      [
        'show_title' => true,
        'classes' => [ $data['_tss']['mini-cart'], $data['_tss']['cart-anchor'] ],
        'custom_atts' => $data['cart_custom_atts']
      ]
    ))
  ] ) );

  $data_toggle = array_merge( cs_extract( $data, [ 'toggle_anchor' => 'anchor', 'toggle' => '', 'effects' => '' ] ), [
    'id' => $data['id'],
    'classes' => $data['classes'],
    'style' => $data['style'],
    '_region' => $data['_region'],
    'unique_id' => $data['unique_id']
  ]);

  return cs_get_partial_view( 'anchor', $data_toggle );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_tp_wc_cart_modal() {
  return cs_compose_controls(
    cs_partial_controls( 'modal' ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'cart', array( 'is_nested' => true ) ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:cart-button' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'tp-wc-cart-modal', [
  'title'      => __( 'Cart Modal', '__x__' ),
  'values'     => $values,
  'components' => [
    [
      'type' => 'toggle',
      'values' => [
        'toggle_anchor_graphic_type'            => 'icon',
        'toggle_anchor_graphic_icon_alt_enable' => false,
        'toggle_anchor_graphic_icon_font_size'  => '1em',
        'toggle_anchor_graphic_icon'            => 'shopping-cart',
        'toggle_anchor_graphic_icon_alt'        => 'shopping-cart',
      ]
    ],
    'cart',
    'modal',
    'effects'
  ],
  'builder'    => 'x_element_builder_setup_tp_wc_cart_modal',
  'tss'        => 'x_element_tss_tp_wc_cart_modal',
  'render'     => 'x_element_render_tp_wc_cart_modal',
  'icon'       => 'native',
  'active'     => class_exists( 'WC_API' ),
  'group'      => 'deprecated',
  'options'    => [
    'wc_fragments' => true
  ],
] );
