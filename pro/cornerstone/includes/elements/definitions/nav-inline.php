<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/NAV-INLINE.PHP
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
  'menu-inline',
  'menu-item',
  cs_values( 'menu-item', 'sub' ),
  [
    'anchor_padding'          => cs_value( '0.75em' ),
    'sub_anchor_padding'      => cs_value( '0.75em' ),
    'sub_anchor_text_margin'  => cs_value( '5px auto 5px 5px' ),
    'sub_anchor_flex_justify' => cs_value( 'flex-start' )
  ],
  'omega'
);



// Style
// =============================================================================

function x_element_tss_nav_inline() {
  return [
    'modules' => [
      'menu',
      'effects',
      ['dropdown',[
        'args' => [
          'selector' => '.x-dropdown'
        ]
      ]],
      ['anchor',[
        'name' => 'top-links',
        'nested' => true
      ]],
      ['anchor',[
        'name' => 'sub-links',
        'nested' => true,
        'remap' => [ 'sub_anchor' => 'anchor' ]
      ]]
    ]
  ];
}



// Render
// =============================================================================

function x_element_render_nav_inline( $data ) {

  return cs_get_partial_view( 'menu', array_merge( cs_extract( $data, [ 'menu' => '', 'anchor' => '', 'sub_anchor' => '', 'effects' => '' ] ), [
    'id' => $data['id'],
    'classes' => $data['classes'],
    'style' => $data['style'],
    'anchor_classes' => [
      $data['_tss']['top-links'],
    ],
    'sub_anchor_classes' => [
      $data['_tss']['sub-links']
    ],
    '_region'   => $data['_region'],
    'unique_id' => $data['unique_id']
  ]));
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_nav_inline() {
  return cs_compose_controls(
    cs_partial_controls( 'menu', [ 'type' => 'inline' ] ),
    cs_partial_controls( 'anchor', [
      'type'        => 'menu-item',
      'group'       => 'top_menu_item_anchor',
      'group_title' => cs_recall( 'label_top_links' ),
      'is_nested'   => true
    ] ),
    cs_partial_controls( 'dropdown' ),
    cs_partial_controls( 'anchor', [
      'type'        => 'menu-item',
      'k_pre'       => 'sub',
      'group'       => 'sub_menu_item_anchor',
      'group_title' => cs_recall( 'label_sub_links' ),
      'is_nested'   => true
    ] ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega' )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'nav-inline', [
  'title'      => __( 'Navigation Inline', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'dropdown', 'effects' ],
  'builder'    => 'x_element_builder_setup_nav_inline',
  'tss'        => 'x_element_tss_nav_inline',
  'render'     => 'x_element_render_nav_inline',
  'icon'       => 'native',
] );
