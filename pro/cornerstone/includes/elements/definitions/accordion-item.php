<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/ACCORDION-ITEM.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Values
//   02. Render
//   03. Builder Setup
//   04. Register Element
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  [
    'accordion_item_starts_open'    => cs_value( false, 'markup' ),
    'accordion_item_header_content' => cs_value( __( 'Accordion Item', 'cornerstone' ), 'markup:seo', true ),
    'accordion_item_content'        => cs_value( __( 'This is the accordion body content. It is typically best to keep this area short and to the point so it isn\'t too overwhelming.', '__x__' ), 'markup:seo', true ),
  ],
  'omega',
  'omega:toggle-hash'
);



// Render
// =============================================================================

function x_element_render_accordion_item( $data ) {

  extract( $data );
  $unique_id = ( isset( $unique_id ) ) ? $unique_id : '';
  $style_id  = ( isset( $style_id ) ) ? $style_id : '';
  $class     = ( isset( $class )  ) ? $class  : '';

  // Atts: Accordion Item
  // --------------------


  $atts_accordion_item = [ 'class' => [ $style_id, 'x-acc-item', $class ] ];

  if (isset($id) && $id) {
    $atts_accordion_item['id'] = $id;
  }

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts_accordion_item['style'] = $data['style'];
  }

  // Atts: Accordion Header
  // ----------------------

  $accordion_item_header_class = [ 'x-acc-header' ];

  if ( $accordion_item_starts_open ) {
    $accordion_item_header_class[] = 'x-active';
  }

  $atts_accordion_header = [
    'id'                => 'tab-' . $unique_id,
    'class'             => $accordion_item_header_class,
    'role'              => 'tab',
    'type'              => 'button',
    'aria-selected'     => ( $accordion_item_starts_open ) ? 'true' : 'false',
    'aria-expanded'     => ( $accordion_item_starts_open ) ? 'true' : 'false',
    'aria-controls'     => 'panel-' . $unique_id,
    'data-x-toggle'     => 'collapse',
    'data-x-toggleable' => $unique_id,
  ];

  if ( $accordion_grouped ) {
    if ( ! empty( $accordion_group ) ) {
      $atts_accordion_header['data-x-toggle-group'] = $accordion_group;
    } else {
      $atts_accordion_header['data-x-toggle-group'] = $p_unique_id;
    }
  }

  if ( ! empty( $toggle_hash ) ) {
    $atts_accordion_header['data-x-toggle-hash'] = $toggle_hash;
  }


  // Atts: Accordion Collapse
  // ------------------------

  $atts_accordion_collapse = [
    'id'                     => 'panel-' . $unique_id,
    'role'                   => 'tabpanel',
    'aria-hidden'            => ( $accordion_item_starts_open ) ? 'false' : 'true',
    'aria-labelledby'        => 'tab-' . $unique_id,
    'data-x-toggleable'      => $unique_id,
    'data-x-toggle-collapse' => true,
  ];

  if ( ! $accordion_item_starts_open ) {
    $atts_accordion_collapse['class'] = 'x-collapsed';
  }


  // Header Indicator
  // ----------------

  $accordion_header_indicator_content = '';

  if ( $accordion_header_indicator === true ) {

    $accordion_header_indicator_content = ( $accordion_header_indicator_type === 'text' )
      ? $accordion_header_indicator_text
      : cs_get_partial_view( 'icon', cs_extract( $data, [ 'accordion_header_indicator_icon' => 'icon' ] ) );

    $accordion_header_indicator_content = '<span class="x-acc-header-indicator">' . $accordion_header_indicator_content . '</span>';
  }


  // Output
  // ------

  return cs_tag('div', $atts_accordion_item, $custom_atts, [
    cs_tag('button', $atts_accordion_header, [
      cs_tag('span', ['class'=> 'x-acc-header-content'],[
        $accordion_header_indicator_content,
        cs_tag('span', ['class'=> 'x-acc-header-text'], $accordion_item_header_content)
      ])
    ]),
    cs_tag('div', $atts_accordion_collapse, [
      cs_tag('div', ['class'=> 'x-acc-content'], $accordion_item_content)
    ])
  ]);

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_accordion_item() {

  $control_setup = [
    'type'     => 'group',
    'title'    => cs_recall( 'label_content' ),
    'group'    => 'accordion_item:setup',
    'controls' => [
      [
        'key'     => 'accordion_item_starts_open',
        'type'    => 'choose',
        'label'   => cs_recall( 'label_starts_open' ),
        'options' => cs_recall( 'options_choices_off_on_bool' ),
      ],
      [
        'key'     => 'accordion_item_header_content',
        'type'    => 'text-editor',
        'label'   => cs_recall( 'label_header' ),
        'options' => [
          'height' => 1,
        ],
      ],
      [
        'key'     => 'accordion_item_content',
        'type'    => 'text-editor',
        'label'   => cs_recall( 'label_content' ),
        'options' => [
          'height' => 4,
        ],
      ],
    ],
  ];

  return cs_compose_controls(
    [
      'controls'             => [ $control_setup ],
      'control_nav'          => [
        'accordion_item'       => cs_recall( 'label_accordion_item' ),
        'accordion_item:setup' => cs_recall( 'label_setup' ),
      ]
    ],
    cs_partial_controls( 'omega', [ 'add_toggle_hash' => true, 'add_custom_atts' => true ] )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'accordion-item', [
  'title'   => __( 'Accordion Item', 'cornerstone' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_accordion_item',
  'render'  => 'x_element_render_accordion_item',
  'icon'    => 'native',
  'options' => [
    'library'        => false,
    'shadow_parent'  => true,
    'alt_breadcrumb' => __( 'Item', 'cornerstone' ),
    'label_key'      => 'accordion_item_header_content',
    'inline'         => [
      'accordion_item_content' => [
        'selector' => '.x-acc-content'
      ],
      'accordion_item_header_content' => [
        'selector'       => '.x-acc-header',
        'editing_target' => '.x-acc-header-text'
      ]
    ]
  ]
] );
