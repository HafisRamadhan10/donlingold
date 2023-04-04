<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/NAV-DROPDOWN.PHP
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
  'menu-dropdown',
  'menu-item',
  [
    'anchor_padding'      => cs_value( '0.75em' ),
    'anchor_text_margin'  => cs_value( '5px auto 5px 5px' ),
    'anchor_flex_justify' => cs_value( 'flex-start' )
  ],
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_tss_nav_dropdown() {
  return [
    'modules' => [
      ['anchor', [ 'args' => [ 'keyPrefix' => 'toggle' ] ]],
      ['dropdown', [
        'name' => 'base-dropdown',
        'nested' => true
      ]],
      ['dropdown', [
        'name' => 'menu-dropdown',
        'args' => [
          'selector' => '.x-dropdown'
        ],
        'nested' => true
      ]],
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

function x_element_render_nav_dropdown( $data ) {
  $data = array_merge(
    $data,
    cs_make_aria_atts(
      'toggle_anchor',
      [
        'controls' => 'dropdown',
        'haspopup' => 'true',
        'expanded' => 'false',
        'label'    => __( 'Toggle Dropdown Content', 'cornerstone' ),
      ],
      $data['id'],
      $data['unique_id']
    )
  );

  cs_defer_partial( 'menu', array_merge( cs_extract( $data, [ 'menu' => '', 'anchor' => '' ] ), [
    'id' => $data['id'],
    'classes'   => [
      $data['_tss']['base-dropdown'],
      $data['_tss']['menu-dropdown'],
      $data['_tss']['menu'],
      $data['style_id'],
      $data['class']
    ],
    'style' => $data['style'],
    'anchor_classes' => [
      $data['_tss']['menu-links']
    ],
    '_region'   => $data['_region'],
    'unique_id' => $data['unique_id']
  ]));

  $data_toggle = array_merge( cs_extract( $data, [ 'toggle_anchor' => 'anchor', 'toggle' => '', 'effects' => '' ] ), [
    'id' => $data['id'],
    'classes' => $data['classes'],
    'style' => $data['style'],
    '_region' => $data['_region'],
    'unique_id' => $data['unique_id'],
    'toggle_trigger' => $data['dropdown_toggle_trigger']
  ]);

  return cs_get_partial_view( 'anchor', $data_toggle );

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_nav_dropdown() {
  return cs_compose_controls(
    cs_partial_controls( 'menu', [ 'type' => 'dropdown' ] ),
    cs_partial_controls( 'dropdown', [ 'add_toggle_trigger' => true ] ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'anchor', [
      'type'             => 'menu-item',
      'group'            => 'menu_item_anchor',
      'group_title'      => cs_recall( 'label_links' ),
      'is_nested'        => true
    ] ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_toggle_hash' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'nav-dropdown', [
  'title'      => __( 'Navigation Dropdown', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'toggle', 'dropdown', 'effects' ],
  'builder'    => 'x_element_builder_setup_nav_dropdown',
  'tss'        => 'x_element_tss_nav_dropdown',
  'render'     => 'x_element_render_nav_dropdown',
  'icon'       => 'native'
] );
