<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/POST-NAV.PHP
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
  'pagination:post-nav',
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_post_nav() {
  return [
    'require' => [ 'elements-wp' ],
    'modules' => [
      'pagination',
      ['effects', [
        'args' => [
          'selectors' => [ '.x-paginate-inner > *' ]
        ]
      ]]
    ]
  ];
}



// Render
// =============================================================================

function x_element_render_post_nav( $data ) {
  return cs_get_partial_view( 'pagination', array_merge( cs_extract( $data, [ 'pagination' => '', 'effects' => '' ] ), [
    'id' => $data['id'],
    'classes' => $data['classes'],
    'style' => $data['style'],
    'custom_atts' => $data['custom_atts'],
  ]));
}




// Builder Setup
// =============================================================================

function x_element_builder_setup_post_nav() {
  return cs_compose_controls(
    cs_partial_controls( 'pagination', [ 'type' => 'post-nav' ] ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'post-nav', [
  'title'      => __( 'Post Navigation', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_post_nav',
  'tss'        => 'x_element_tss_post_nav',
  'render'     => 'x_element_render_post_nav',
  'icon'       => 'native',
] );
