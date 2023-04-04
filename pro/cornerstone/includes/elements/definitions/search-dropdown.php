<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/SEARCH-DROPDOWN.PHP
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
  'search-dropdown',
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_tss_search_dropdown() {
  return [
    'modules' => [
      ['anchor', [ 'args' => [ 'keyPrefix' => 'toggle' ] ]],
      ['dropdown', [ 'nested' => true ]],
      ['search', [ 'nested' => true ]],
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

function x_element_render_search_dropdown( $data ) {
  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', array(
      'controls' => 'dropdown',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Dropdown Content', 'cornerstone' ),
    ), $data['id'], $data['unique_id'] )
  );

  $search_form = cs_get_partial_view( 'search', array_merge( cs_extract( $data, [ 'search' => '' ] ) ), [
    'classes' => [
      $data['_tss']['search'],
      $data['style_id']
    ],
    'style' => $data['style'],
    'custom_atts' => $data['search_custom_atts'],
    'search_id' => $data['unique_id']
  ]);

  cs_defer_partial( 'dropdown', array_merge( cs_extract( $data, [ 'dropdown' => '' ] ), [
    'id' => $data['id'],
    'classes' => [
      $data['_tss']['dropdown'],
      $data['style_id'],
      $data['class']
    ],
    'style' => $data['style'],
    '_region' => $data['_region'],
    'toggleable_id' => $data['unique_id'],
    'dropdown_content' => $search_form
  ] ) );

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

function x_element_builder_setup_search_dropdown() {
  return cs_compose_controls(
    cs_partial_controls( 'dropdown', array( 'add_custom_atts' => true, 'add_toggle_trigger' => true ) ),
    cs_partial_controls( 'anchor',  cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'search', array( 'type' => 'dropdown', 'label_prefix' => __( 'Search', '__x__' ) ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'search-dropdown', [
  'title'      => __( 'Search Dropdown', '__x__' ),
  'values'     => $values,
  'components' => [
    'toggle',
    [
      'type' => 'dropdown',
      'values' => [
        'dropdown_width' => '300px'
      ]
    ],
    'effects'
  ],
  'builder'    => 'x_element_builder_setup_search_dropdown',
  'tss'        => 'x_element_tss_search_dropdown',
  'render'     => 'x_element_render_search_dropdown',
  'icon'       => 'native',
  'group'      => 'deprecated'
]);
