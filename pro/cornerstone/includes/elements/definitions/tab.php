<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TAB.PHP
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
  [
    'tab_label_content'       => cs_value( __( 'Tab', 'cornerstone' ), 'markup:seo', true ),
    'tab_content'             => cs_value( __( 'This is the tab body content. It is typically best to keep this area short and to the point so it isn\'t too overwhelming.', '__x__' ), 'markup:seo', true ),
    'tab_label_custom_atts'   => cs_value( '', 'markup' ),
    'tab_content_custom_atts' => cs_value( '', 'markup' ),
  ],
  'omega',
  'omega:toggle-hash'
);


// Builder Setup
// =============================================================================

function x_element_builder_setup_tab() {

  $control_setup = [
    'type'     => 'group',
    'title'    => cs_recall( 'label_content' ),
    'group'    => 'tab:setup',
    'controls' => [
      [
        'key'     => 'tab_label_content',
        'type'    => 'text-editor',
        'label'   => cs_recall( 'label_label' ),
        'options' => [
          'height' => 1,
        ],
      ],
      [
        'key'     => 'tab_content',
        'type'    => 'text-editor',
        'label'   => cs_recall( 'label_content' ),
        'options' => [
          'height' => 5,
        ],
      ],
    ],
  ];

  return cs_compose_controls(
    [
      'controls' => [
        $control_setup,
        [
          'key'        => 'tab_label_custom_atts',
          'type'       => 'attributes',
          'group'      => 'omega:setup',
          'label'      => cs_recall( 'label_custom_attributes_with_prefix' ),
          'label_vars' => [ 'prefix' => cs_recall( 'label_label' ) ]
        ],
        [
          'key'        => 'tab_content_custom_atts',
          'type'       => 'attributes',
          'group'      => 'omega:setup',
          'label'      => cs_recall( 'label_custom_attributes_with_prefix' ),
          'label_vars' => [ 'prefix' => cs_recall( 'label_content' ) ]
        ]
      ],
      'control_nav' => [
        'tab'       => cs_recall( 'label_tab' ),
        'tab:setup' => cs_recall( 'label_setup' )
      ]
    ],
    cs_partial_controls( 'omega', [ 'add_toggle_hash' => true ] )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'tab', [
  'title'   => __( 'Tab', 'cornerstone' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_tab',
  'icon'    => 'native',
  'options' => [
    'shadow_parent' => true,
    'library'       => false,
    'label_key'     => 'tab_label_content',
  ]
] );
