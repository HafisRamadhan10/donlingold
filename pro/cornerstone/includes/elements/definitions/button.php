<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/BUTTON.PHP
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
// Prefixed: cs_values('effects', 'button')

$values = cs_compose_values(
  'anchor-button',
  'omega',
  'omega:custom-atts',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_tss_button() {
  return [
    'modules' => [
      'anchor',
      ['effects', [
        'args' => [
          'selectors' => ['.x-anchor-text-primary', '.x-anchor-text-secondary', '.x-graphic-child'] // '[data-x-particle]'
        ]
      ]]
    ]
  ];
}

// Render
// =============================================================================

function x_element_render_button( $data ) {
  return cs_get_partial_view( 'anchor', array_merge( cs_extract( $data, [ 'anchor' => '', 'effects' => '' ] ), [
    'id' => $data['id'],
    'classes' => $data['classes'],
    'style' => $data['style'],
    'custom_atts' => $data['custom_atts'],
  ]));
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_button() {
  return cs_compose_controls(
    cs_partial_controls( 'anchor', [
      'type'             => 'button',
      'has_link_control' => true,
      'group'            => 'button_anchor',
      'group_title'      => cs_recall( 'label_button' ),
    ] ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true, 'add_looper_consumer' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'button', [
  'title'      => __( 'Button', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_button',
  'render'     => 'x_element_render_button',
  'tss'        => 'x_element_tss_button',
  'icon'       => 'native',
  'options'    => [
    'inline' => [
      'anchor_text_primary_content' => [
        'selector' => '.x-anchor-text-primary'
      ],
      'anchor_text_secondary_content' => [
        'selector' => '.x-anchor-text-secondary'
      ]
    ]
  ]
] );
