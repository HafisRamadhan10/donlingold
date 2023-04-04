<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/CONTENT-AREA-OFF-CANVAS.PHP
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
  'omega',
  'omega:toggle-hash',
  'omega:looper-provider',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_tss_layout_off_canvas() {
  return [
    'modules' => [
      ['anchor', [ 'args' => [ 'keyPrefix' => 'toggle' ] ]],
      ['off-canvas', [ 'nested' => true, 'args' => [ 'isLayoutElement' => true ] ]],
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

function x_element_render_layout_off_canvas( $data ) {
  $data = array_merge(
    $data,
    cs_make_aria_atts( 'toggle_anchor', [
      'controls' => 'off-canvas',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Off Canvas Content', 'cornerstone' ),
    ], $data['id'], $data['unique_id'] )
  );

  cs_defer_partial( 'off-canvas', array_merge( cs_extract( $data, [ 'off_canvas' => '' ] ), [
    'id' => $data['id'],
    'classes' => [
      $data['_tss']['off-canvas'],
      $data['style_id'],
      $data['class']
    ],
    'style' => $data['style'],
    'toggleable_id' => $data['unique_id'],
    'off_canvas_content' => [
      cs_render_child_elements( $data, 'x_layout_off_canvas' ),
      $data['off_canvas_content_bg_advanced'] ? cs_make_bg( $data ) : ''
    ]
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

function x_element_builder_setup_layout_off_canvas() {
  return cs_compose_controls(
    cs_partial_controls( 'off-canvas', [ 'is_layout_element' => true, 'add_custom_atts' => true, 'add_toggle_trigger' => true ] ),
    cs_partial_controls( 'anchor', cs_recall( 'settings_anchor:toggle' ) ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_toggle_hash' => true, 'add_looper_provider' => true, 'add_looper_consumer' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'layout-off-canvas', [
  'title'      => __( 'Off Canvas', '__x__' ),
  'values'     => $values,
  'components' => [ 'toggle', 'off-canvas', 'bg', 'effects' ],
  'builder'    => 'x_element_builder_setup_layout_off_canvas',
  'tss'        => 'x_element_tss_layout_off_canvas',
  'render'     => 'x_element_render_layout_off_canvas',
  'icon'       => 'native',
  'children'   => 'x_layout_off_canvas',
  'options'    => [
    'valid_children' => [ '*' ],
    'index_labels'   => false,
    'library'        => true,
    'dropzone'       => [
      'enabled'  => true,
      'offscreen' => true,
      'selector' => '.x-off-canvas-content'
    ],
    'toggle_on_create' => [
      'enabled' => true
    ]
  ]
] );
