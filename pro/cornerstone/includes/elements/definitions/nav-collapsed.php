<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/NAV-COLLAPSED.PHP
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
    'legacy_region_detect' => cs_value( false, 'markup' )
  ],
  'menu-collapsed',
  'menu-item',
  cs_values( 'menu-item', 'sub' ),
  [
    'anchor_padding'         => cs_value( '0.75em' ),
    'anchor_text_margin'     => cs_value( '5px auto 5px 5px' ),
    'sub_anchor_padding'     => cs_value( '0.75em' ),
    'sub_anchor_text_margin' => cs_value( '5px auto 5px 5px' ),
  ],
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_tss_nav_collapsed() {
  return [
    'modules' => [

      // TBF
      ['anchor', [
        'name' => 'toggle-anchor',
        'args' => [ 'keyPrefix' => 'toggle' ],
        'nested' => true,
        'conditions' => [
          [ 'key' => 'legacy_tbf_detect', 'value' => true ]
        ]
      ]],

      ['off-canvas', [
        'nested' => true,
        'conditions' => [
          [ 'key' => 'legacy_tbf_detect', 'value' => true ]
        ]
      ]],

      ['effects',[
        'name' => 'toggle-effects',
        'args' => [
          'selectors' => ['.x-anchor-text-primary', '.x-anchor-text-secondary', '.x-graphic-child']
        ],
        'nested' => true,
        'conditions' => [
          [ 'key' => 'legacy_tbf_detect', 'value' => true ]
        ]
      ]],

      // Standard
      ['effects',[
        'conditions' => [
          [ 'key' => 'legacy_tbf_detect', 'value' => false ]
        ]
      ]],

      // Always
      'menu',
      ['anchor',[
        'name' => 'top-links',
      ]],
      ['anchor',[
        'name' => 'sub-links',
        'remap' => [ 'sub_anchor' => 'anchor' ],
      ]],
    ]
  ];
}


// Render
// =============================================================================
// 01. Output as off canvas in top / bottom header bars and footer bars
// 02. Output inline in content or left / right header bars.
// All elements after Pro 4.3 output inline via legacy_region_detect

function x_element_render_nav_collapsed( $data ) {

  if ( isset($data['legacy_tbf_detect']) && $data['legacy_tbf_detect'] ) { // 01

    $data = array_merge( $data, cs_make_aria_atts( 'toggle_anchor', [
      'controls' => 'off-canvas',
      'haspopup' => 'true',
      'expanded' => 'false',
      'label'    => __( 'Toggle Off Canvas Content', 'cornerstone' ),
    ], $data['id'], $data['unique_id'] ) );


    cs_defer_partial( 'off-canvas', array_merge( cs_extract( $data, [ 'off_canvas' => '' ] ), [
      'id' => $data['id'],
      'classes' => [
        $data['_tss']['off-canvas'],
        $data['style_id'],
        $data['class']
      ],
      'style' => $data['style'],
      'toggleable_id' => $data['unique_id'],
      'off_canvas_content' => cs_get_partial_view( 'menu', array_merge( cs_extract( $data, [ 'menu' => '', 'anchor' => '', 'sub_anchor' => '' ] ), [
        'classes' => [
          $data['_tss']['menu'],
          $data['style_id'],
        ],
        'anchor_classes' => [
          $data['_tss']['top-links']
        ],
        'sub_anchor_classes' => [
          $data['_tss']['sub-links']
        ],
        '_region'   => $data['_region'],
        'unique_id' => $data['unique_id']
      ]))
    ] ) );

    $data_toggle = array_merge( cs_extract( $data, [ 'toggle_anchor' => 'anchor', 'toggle' => '', 'effects' => '' ] ), [
      'id' => $data['id'],
      'classes' => [
        $data['_tss']['toggle-anchor'],
        isset($data['_tss']['toggle-effects']) ? $data['_tss']['toggle-effects'] : '',
        $data['style_id'],
        $data['class'],
      ],
      'style' => $data['style'],
      '_region' => $data['_region'],
      'unique_id' => $data['unique_id']
    ]);

    return cs_get_partial_view( 'anchor', $data_toggle );

  } else { // 02

    return cs_get_partial_view( 'menu', array_merge( cs_extract( $data, [ 'menu' => '', 'anchor' => '', 'sub_anchor' => '', 'effects' => '' ] ), [
      'id' => $data['id'],
      'classes' => $data['classes'],
      'style' => $data['style'],
      'anchor_classes' => [
        $data['_tss']['top-links']
      ],
      'sub_anchor_classes' => [
        $data['_tss']['sub-links']
      ],
      '_region'   => $data['_region'],
      'unique_id' => $data['unique_id']
    ] ) );

  }
}



// Builder Setup
// =============================================================================
// add off canvas conditions
// add anchor togggle conditions

function x_element_builder_setup_nav_collapsed() {
  return cs_compose_controls(
    cs_partial_controls( 'menu', [ 'type' => 'collapsed' ] ),
    cs_partial_controls( 'off-canvas', cs_recall( 'conditions_tbf_detect' ) ),
    cs_partial_controls( 'anchor', array_merge(
      cs_recall( 'settings_anchor:toggle' ),
      cs_recall( 'conditions_tbf_detect' )
    ) ),
    cs_partial_controls( 'anchor', [
      'type'             => 'menu-item',
      'group'            => 'top_menu_item_anchor',
      'group_title'      => cs_recall( 'label_top_links' ),
      'is_nested'        => true
    ] ),
    cs_partial_controls( 'anchor', [
      'type'             => 'menu-item',
      'k_pre'            => 'sub',
      'group'            => 'sub_menu_item_anchor',
      'group_title'      => cs_recall( 'label_sub_links' ),
      'is_nested'        => true
    ] ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega' )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'nav-collapsed', [
  'title'      => __( 'Navigation Collapsed', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'toggle', 'off-canvas', 'effects' ],
  'builder'    => 'x_element_builder_setup_nav_collapsed',
  'tss'        => 'x_element_tss_nav_collapsed',
  'render'     => 'x_element_render_nav_collapsed',
  'icon'       => 'native',
  'migrations' => [
    [ 'legacy_region_detect' => true ]
  ],
] );
