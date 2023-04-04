<?php

// =============================================================================
// FRAMEWORK/FUNCTIONS/PRO/BARS/DEFINITIONS/CONTAINER.PHP
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
    'container_base_font_size'        => cs_value( '1em', 'style' ),
    'container_text_align'            => cs_value( 'none', 'style' ),
    'container_overflow'              => cs_value( 'visible', 'style' ),
    'container_z_index'               => cs_value( 'auto', 'style' ),
    'container_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'container_bg_advanced'           => cs_value( false, 'markup' ),

    'container_width'                 => cs_value( 'auto', 'style' ),
    'container_min_width'             => cs_value( '0px', 'style' ),
    'container_max_width'             => cs_value( 'none', 'style' ),
    'container_height'                => cs_value( 'auto', 'style' ),
    'container_min_height'            => cs_value( '0px', 'style' ),
    'container_max_height'            => cs_value( 'none', 'style' ),

    'container_flex'                  => cs_value( '0 1 auto', 'style' ),
    'container_row_flex_direction'    => cs_value( 'row', 'style' ),
    'container_row_flex_wrap'         => cs_value( false, 'style' ),
    'container_row_flex_justify'      => cs_value( 'space-between', 'style' ),
    'container_row_flex_align'        => cs_value( 'center', 'style' ),
    'container_col_flex_direction'    => cs_value( 'column', 'style' ),
    'container_col_flex_wrap'         => cs_value( false, 'style' ),
    'container_col_flex_justify'      => cs_value( 'space-between', 'style' ),
    'container_col_flex_align'        => cs_value( 'center', 'style' ),
    'container_margin'                => cs_value( '!0px 0px 0px 0px', 'style' ),
    'container_padding'               => cs_value( '!0px 0px 0px 0px', 'style' ),
    'container_border_width'          => cs_value( '!0px', 'style' ),
    'container_border_style'          => cs_value( 'none', 'style' ),
    'container_border_color'          => cs_value( 'transparent', 'style:color' ),
    'container_border_radius'         => cs_value( '!0px', 'style' ),
    'container_box_shadow_dimensions' => cs_value( '!0px 0px 0px 0px', 'style' ),
    'container_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  ],
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_container() {
  return [
    'modules' => [
      'container',
      'effects'
    ]
  ];
}



// Render
// =============================================================================

function x_element_render_container( $data ) {

  // Prepare Attr Values
  // -------------------

  $classes = [ 'x-bar-container' ];

  // Atts
  // ----

  $atts = [
    'class' => array_merge( $classes, $data['classes'] )
  ];

  if ( isset( $data['id'] ) && ! empty( $data['id'] ) ) {
    $atts['id'] = $data['id'];
  }

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }

  $atts = cs_apply_effect( $atts, $data );


  // Output
  // ------

  return cs_tag( 'div', $atts, $data['custom_atts'], [
    $data['container_bg_advanced'] ? cs_make_bg( $data ) : '',
    cs_render_child_elements( $data, 'x_bar_container' )
  ]);

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_container() {

  // Individual Controls - Children
  // ------------------------------

  $control_container_children = [
    'type'  => 'sortable',
    'group' => 'container:children'
  ];


  // Individual Controls - Setup
  // ---------------------------

  $control_container_base_font_size = cs_recall( 'control_mixin_font_size',         [ 'key' => 'container_base_font_size'                                                  ] );
  $control_container_text_align     = cs_recall( 'control_mixin_text_align',        [ 'key' => 'container_text_align'                                                      ] );
  $control_container_overflow       = cs_recall( 'control_mixin_overflow',          [ 'key' => 'container_overflow'                                                        ] );
  $control_container_z_index        = cs_recall( 'control_mixin_z_index',           [ 'key' => 'container_z_index'                                                         ] );
  $control_container_background     = cs_recall( 'control_mixin_bg_color_solo_adv', [ 'keys' => [ 'value' => 'container_bg_color', 'checkbox' => 'container_bg_advanced' ] ] );


  // Individual Controls - Size
  // --------------------------

  $control_container_width      = cs_recall( 'control_mixin_width',      [ 'key' => 'container_width'      ] );
  $control_container_min_width  = cs_recall( 'control_mixin_min_width',  [ 'key' => 'container_min_width'  ] );
  $control_container_max_width  = cs_recall( 'control_mixin_max_width',  [ 'key' => 'container_max_width'  ] );
  $control_container_height     = cs_recall( 'control_mixin_height',     [ 'key' => 'container_height'     ] );
  $control_container_min_height = cs_recall( 'control_mixin_min_height', [ 'key' => 'container_min_height' ] );
  $control_container_max_height = cs_recall( 'control_mixin_max_height', [ 'key' => 'container_max_height' ] );

  $control_container_flex = [
    'key'   => 'container_flex',
    'label' => cs_recall( 'label_self_flex' ),
    'type'  => 'flex',
  ];


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    [
      'controls' => [
        $control_container_children,
        [
          'type'     => 'group',
          'group'    => 'container:setup',
          'controls' => [
            $control_container_base_font_size,
            $control_container_text_align,
            $control_container_overflow,
            $control_container_z_index,
            $control_container_background,
          ],
        ],
      ],
      'control_nav' => [
        'container'                   => cs_recall( 'label_container' ),
        'container:children'          => cs_recall( 'label_children' ),
        'container:setup'             => cs_recall( 'label_setup' ),
        'container:background-layers' => cs_recall( 'label_background_layers' ),
        'container:size'              => cs_recall( 'label_size' ),
        'container:design'            => cs_recall( 'label_design' ),
      ]
    ],
    cs_partial_controls( 'bg', [
      'group'     => 'container:background-layers',
      'condition' => [ 'container_bg_advanced' => true ]
    ] ),
    [
      'controls' => [
        [
          'type'     => 'group',
          'group'    => 'container:size',
          'controls' => [
            $control_container_width,
            $control_container_min_width,
            $control_container_max_width,
            $control_container_height,
            $control_container_min_height,
            $control_container_max_height,
            [
              'type'     => 'sub-group',
              'label'    => cs_recall( 'label_grow_and_shrink' ),
              'options'  => [ 'height' => 1 ],
              'controls' => [
                $control_container_flex,
              ],
            ],
          ],
        ],
        cs_control( 'flexbox', 'container', [
          'group'      => 'container:design',
          'layout_pre' => 'row',
          'conditions' => [ [ 'key' => '_region', 'op' => 'IN', 'value' => [ 'top', 'bottom', 'footer' ] ] ]
        ] ),
        cs_control( 'flexbox', 'container', [
          'group'      => 'container:design',
          'layout_pre' => 'col',
          'conditions' => [ [ 'key' => '_region', 'op' => 'IN', 'value' => [ 'left', 'right' ] ] ]
        ] ),
        cs_control( 'margin',        'container', [ 'group' => 'container:design' ] ),
        cs_control( 'padding',       'container', [ 'group' => 'container:design' ] ),
        cs_control( 'border',        'container', [ 'group' => 'container:design' ] ),
        cs_control( 'border-radius', 'container', [ 'group' => 'container:design' ] ),
        cs_control( 'box-shadow',    'container', [ 'group' => 'container:design' ] )
      ]
    ],
    cs_partial_controls( 'effects', [ 'has_provider' => false ] ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'container', [
  'title'      => __( 'Container', 'cornerstone' ),
  'values'     => $values,
  'migrations' => [
    [ 'container_z_index' => '1' ],
    [
      'container_margin'                => '!0px',
      'container_padding'               => '!0px',
      'container_box_shadow_dimensions' => '!0em 0em 0em 0em',
    ],
  ],
  'components' => [ 'bg', 'effects' ],
  'builder'    => 'x_element_builder_setup_container',
  'tss' => 'x_element_tss_container',
  'render'     => 'x_element_render_container',
  'icon'       => 'native',
  'children'   => 'x_bar_container',
  'options'    => [
    'valid_children'    => [ '*' ],
    'index_labels'      => true,
    'library'           => false,
    'empty_placeholder' => false,
    'is_draggable'      => false,
    'dropzone'          => [ 'enabled' => true ],
    'contrast_keys'     => [ 'bg:container_bg_advanced', 'container_bg_color' ],
    'side_effects'      => [
      [
        'observe' => 'container_bg_advanced',
        'conditions' => [
          [ 'key' => 'container_bg_advanced', 'op' => '==', 'value' => true   ],
          [ 'key' => 'container_z_index',     'op' => '==', 'value' => 'auto' ],
        ],
        'apply' => [
          'container_z_index' => '1',
        ]
      ]
    ]
  ]
] );
