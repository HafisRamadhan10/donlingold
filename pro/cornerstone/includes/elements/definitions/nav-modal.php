<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/NAV-MODAL.PHP
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
  'menu-modal',
  'menu-item',
  [
    'anchor_padding'            => cs_value( '0.75em', 'style' ),
    'anchor_sub_indicator_icon' => cs_value( 'angle-right', 'markup' ),
  ],
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_tss_nav_modal() {
  return [
    'modules' => [
      ['anchor', [ 'args' => [ 'keyPrefix' => 'toggle' ] ]],
      ['modal', [ 'nested' => true ]],
      ['menu', [ 'nested' => true ]],
      ['anchor', [
        'name' => 'menu-links',
        'nested' => true
      ]],
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

function x_element_render_nav_modal( $data ) {
  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', [
      'controls' => 'modal',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Modal Content', 'cornerstone' ),
    ], $data['id'], $data['unique_id'] )
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
    'modal_content' => cs_get_partial_view( 'menu', array_merge( cs_extract( $data, [ 'menu' => '', 'anchor' => '' ] ), [
      'id' => $data['id'],
      'classes' => [
        $data['_tss']['menu']
      ],
      'anchor_classes' => [
        $data['_tss']['menu-links'],
      ],
      '_region'   => $data['_region'],
      'unique_id' => $data['unique_id']
    ]))
  ] ) );

  $data_toggle = array_merge( cs_extract( $data, [ 'toggle_anchor' => 'anchor', 'toggle' => '', 'effects' => '' ] ), [
    'id' => $data['id'],
    'classes' => $data['classes'],
    'style' => $data['style'],
    '_region' => $data['_region'],
    'unique_id' => $data['unique_id'],
  ]);

  return cs_get_partial_view( 'anchor', $data_toggle );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_nav_modal() {
  return cs_compose_controls(
    cs_partial_controls( 'menu', [ 'type' => 'modal' ] ),
    cs_partial_controls( 'modal' ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'anchor', [
      'type'        => 'menu-item',
      'group'       => 'menu_item_anchor',
      'group_title' => cs_recall( 'label_links' ),
      'is_nested'   => true
    ] ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega' )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'nav-modal', [
  'title'      => __( 'Navigation Modal', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'toggle', 'modal', 'effects' ],
  'builder'    => 'x_element_builder_setup_nav_modal',
  'tss'        => 'x_element_tss_nav_modal',
  'render'     => 'x_element_render_nav_modal',
  'icon'       => 'native',
  'group'      => 'deprecated'
] );
