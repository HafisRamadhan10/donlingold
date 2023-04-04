<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/NAV-LAYERED.PHP
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
  'menu-layered',
  'menu-item',
  [
    'anchor_padding'            => cs_value( '0.75em', 'style' ),
    'anchor_text_margin'        => cs_value( '5px auto 5px 5px', 'style' ),
    'anchor_sub_indicator_icon' => cs_value( 'angle-right', 'markup' ),
  ],
  'omega',
  'omega:toggle-hash'
);



// Style
// =============================================================================

function x_element_tss_nav_layered() {

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
        'name' => 'menu-links',
        'nested' => true
      ]],
    ]
  ];
}


// Render
// =============================================================================
// 01. Output as off canvas in top / bottom header bars and footer bars.
// 02. Output inline in content or left / right header bars.
// All elements after Pro 4.3 output inline via legacy_region_detect

function x_element_render_nav_layered( $data ) {


  if ( $data['legacy_tbf_detect'] ) { // 01

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
        'id' => $data['id'],
        'classes' => [
          $data['_tss']['menu'],
          $data['style_id'],
        ],
        'anchor_classes' => [
          $data['_tss']['menu-links'],
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
        $data['_tss']['menu-links'],
      ],
      '_region'   => $data['_region'],
      'unique_id' => $data['unique_id']
    ]));

  }

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_nav_layered() {
  return cs_compose_controls(
    cs_partial_controls( 'menu', [ 'type' => 'layered' ] ),
    cs_partial_controls( 'off-canvas', cs_recall( 'conditions_tbf_detect' ) ),
    cs_partial_controls( 'anchor', array_merge(
      cs_recall( 'settings_anchor:toggle' ),
      cs_recall( 'conditions_tbf_detect' )
    ) ),
    cs_partial_controls( 'anchor', [
      'type'        => 'menu-item',
      'group'       => 'menu_item_anchor',
      'group_title' => cs_recall( 'label_links' ),
      'is_nested'   => true
    ] ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_toggle_hash' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'nav-layered', [
  'title'   => __( 'Navigation Layered', 'cornerstone' ),
  'values'  => $values,
  'migrations' => [
    [ 'legacy_region_detect' => true ]
  ],
  'components' => [ 'toggle', 'off-canvas', 'effects' ],
  'builder'    => 'x_element_builder_setup_nav_layered',
  // 'style'      => 'x_element_style_nav_layered',
  'tss'        => 'x_element_tss_nav_layered',
  'render'     => 'x_element_render_nav_layered',
  'icon'       => 'native',
] );
