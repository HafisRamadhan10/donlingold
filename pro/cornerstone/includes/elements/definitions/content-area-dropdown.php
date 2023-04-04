<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/CONTENT-AREA-DROPDOWN.PHP
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
  cs_values( 'content-area:dynamic', 'dropdown' ),
  'omega',
  'omega:toggle-hash',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_tss_content_area_dropdown() {
  return [
    'modules' => [
      ['anchor', [ 'args' => [ 'keyPrefix' => 'toggle' ] ]],
      ['dropdown', [ 'nested' => true ]],
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

function x_element_render_content_area_dropdown( $data ) {
  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', array(
      'controls' => 'dropdown',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Dropdown Content', 'cornerstone' ),
    ), $data['id'], $data['unique_id'] )
  );

  $data_dropdown = array_merge( cs_extract( $data, [ 'dropdown' => '' ] ), [
    'id' => $data['id'],
    'classes' => [
      $data['_tss']['dropdown'],
      $data['style_id'],
      $data['class']
    ],
    '_region' => $data['_region'],
    'toggleable_id' => $data['unique_id'],
    'dropdown_content' => cs_dynamic_content( $data['dropdown_content'] ),
    'atts' => []
  ] );

  if ( isset( $data['dropdown_content_dynamic_rendering'] ) && $data['dropdown_content_dynamic_rendering'] ) {
    $data_dropdown['atts']['data-rvt-offscreen-reset'] = '';
  }

  cs_defer_partial( 'dropdown', $data_dropdown );

  $data_toggle = array_merge( cs_extract( $data, [ 'toggle_anchor' => 'anchor', 'toggle' => '', 'effects' => '' ] ), [
    'id' => $data['id'],
    'classes' => $data['classes'],
    '_region' => $data['_region'],
    'unique_id' => $data['unique_id'],
    'toggle_trigger' => $data['dropdown_toggle_trigger']
  ]);


  return cs_get_partial_view( 'anchor', $data_toggle );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_content_area_dropdown() {
  return cs_compose_controls(
    cs_partial_controls( 'content-area', array(
      'type'         => 'dropdown',
      'k_pre'        => 'dropdown',
      'label_prefix' => __( 'Dropdown', '__x__' )
    ) ),
    cs_partial_controls( 'dropdown', array( 'add_custom_atts' => true, 'add_toggle_trigger' => true ) ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_toggle_hash' => true, 'add_looper_consumer' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'content-area-dropdown', [
  'title'      => __( 'Content Area Dropdown', '__x__' ),
  'values'     => $values,
  'components' => [ 'toggle', 'dropdown', 'effects' ],
  'builder'    => 'x_element_builder_setup_content_area_dropdown',
  'tss'        => 'x_element_tss_content_area_dropdown',
  'render'     => 'x_element_render_content_area_dropdown',
  'icon'       => 'native',
  'group'      => 'deprecated'
] );
