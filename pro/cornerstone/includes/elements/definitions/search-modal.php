<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/SEARCH-MODAL.PHP
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
  'search-modal',
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_tss_search_modal() {
  return [
    'modules' => [
      ['anchor', [ 'args' => [ 'keyPrefix' => 'toggle' ] ]],
      ['modal', [ 'nested' => true ]],
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

function x_element_render_search_modal( $data ) {
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
    'modal_content' => cs_get_partial_view( 'search', array_merge( cs_extract( $data, [ 'search' => '' ] ) ), [
      'classes' => [
        $data['_tss']['search'],
        $data['style_id']
      ],
      'custom_atts' => $data['search_custom_atts'],
      'search_id' => $data['unique_id']
    ])
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

function x_element_builder_setup_search_modal() {
  return cs_compose_controls(
    cs_partial_controls( 'modal' ),
    cs_partial_controls( 'anchor',  cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'search', array( 'type' => 'modal', 'label_prefix' => __( 'Search', '__x__' ) ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'search-modal', [
  'title'      => __( 'Search Modal', '__x__' ),
  'values'     => $values,
  'components' => [ 'toggle', 'modal', 'effects' ],
  'builder'    => 'x_element_builder_setup_search_modal',
  'tss'        => 'x_element_tss_search_modal',
  'render'     => 'x_element_render_search_modal',
  'icon'       => 'native',
  'group'      => 'deprecated'
]);
