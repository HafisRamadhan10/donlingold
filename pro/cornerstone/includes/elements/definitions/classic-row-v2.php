<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/ROW.PHP
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
  array(
    'row_base_font_size'        => cs_value( '1em', 'style' ),
    'row_z_index'               => cs_value( 'auto', 'style' ),
    'row_width'                 => cs_value( 'auto', 'style' ),
    'row_max_width'             => cs_value( 'none', 'style' ),
    'row_inner_container'       => cs_value( false, 'markup' ),
    'row_marginless_columns'    => cs_value( false, 'markup' ),
    'row_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'row_bg_advanced'           => cs_value( false, 'markup' ),
    'row_text_align'            => cs_value( 'none', 'style' ),
    'row_margin'                => cs_value( '!0em auto 0em auto', 'style' ),
    'row_padding'               => cs_value( '!0em', 'style' ),
    'row_border_width'          => cs_value( '!0px', 'style' ),
    'row_border_style'          => cs_value( 'solid', 'style' ),
    'row_border_color'          => cs_value( 'transparent', 'style:color' ),
    'row_border_radius'         => cs_value( '!0px', 'style' ),
    'row_box_shadow_dimensions' => cs_value( '!0em 0em 0em 0em', 'style' ),
    'row_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  ),
  'omega',
  'omega:style',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_row() {
  return [
    'require' => [ 'elements-legacy' ],
    'modules' => [ 'classic-row-v2' ]
  ];
}





// Render
// =============================================================================

function x_element_render_row( $data ) {

  // Prepare Attr Values
  // -------------------

  $classes = [ 'x-container' ];

  if ( $data['row_inner_container'] ) {
    $classes[] = 'max';
    $classes[] = 'width';
  }

  if ( $data['row_marginless_columns'] ) {
    $classes[] = 'marginless-columns';
  }

  // Atts
  // ----

  $atts = [
    'class' => array_merge( $classes, $data['classes'] )
  ];

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }

  if ( isset( $data['id'] ) && ! empty( $data['id'] ) ) {
    $atts['id'] = $data['id'];
  }



  // Output
  // ------

  return cs_tag('div', $atts, $data['custom_atts'], [
    $data['row_bg_advanced'] ? cs_make_bg( $data ) : '',
    cs_render_child_elements( $data, 'x_row' )
  ]);

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_row() {

  // Individual Controls
  // -------------------

  $control_row_columns = array(
    'type'    => '_columns',
    'label'   => __( 'Columns', '__x__' ),
    'group'   => 'row:setup'
  );

  $control_row_base_font_size = array(
    'key'     => 'row_base_font_size',
    'type'    => 'unit',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '16px',
      'ranges'          => array(
        'px'  => array( 'min' => 10,  'max' => 24,  'step' => 1    ),
        'em'  => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
        'rem' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
      ),
    ),
  );

  $control_row_z_index = array(
    'key'     => 'row_z_index',
    'type'    => 'unit',
    'label'   => __( 'Z-Index', '__x__' ),
    'options' => array(
      'unit_mode'      => 'unitless',
      'valid_keywords' => array( 'auto' ),
      'fallback_value' => 'auto',
    ),
  );

  $control_row_font_size_and_z_index =array(
    'type'     => 'group',
    'label'    => __( 'Font Size &amp; Z-Index', '__x__' ),
    'controls' => array(
      $control_row_base_font_size,
      $control_row_z_index,
    ),
  );

  $control_row_inner_container = array(
    'key'     => 'row_inner_container',
    'type'    => 'choose',
    'label'   => __( 'Inner Container', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_row_width = array(
    'key'       => 'row_width',
    'type'      => 'unit',
    'options'   => array(
      'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
      'valid_keywords'  => array( 'calc', 'auto' ),
      'fallback_value'  => 'auto',
      'ranges'          => array(
        'px'  => array( 'min' => 0, 'max' => 1500, 'step' => 10  ),
        'em'  => array( 'min' => 0, 'max' => 40,   'step' => 0.5 ),
        'rem' => array( 'min' => 0, 'max' => 40,   'step' => 0.5 ),
        '%'   => array( 'min' => 0, 'max' => 100,  'step' => 1   ),
        'vw'  => array( 'min' => 0, 'max' => 100,  'step' => 1   ),
        'vh'  => array( 'min' => 0, 'max' => 100,  'step' => 1   ),
      ),
    ),
    'condition' => array( 'row_inner_container' => false ),
  );

  $control_row_max_width = array(
    'key'       => 'row_max_width',
    'type'      => 'unit',
    'options'   => array(
      'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
      'valid_keywords'  => array( 'calc', 'none' ),
      'fallback_value'  => 'none',
      'ranges'          => array(
        'px'  => array( 'min' => 0, 'max' => 1500, 'step' => 10  ),
        'em'  => array( 'min' => 0, 'max' => 40,  'step' => 0.5  ),
        'rem' => array( 'min' => 0, 'max' => 40,  'step' => 0.5  ),
        '%'   => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
        'vw'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
        'vh'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
      ),
    ),
    'condition' => array( 'row_inner_container' => false ),
  );

  $control_row_width_and_max_width = array(
    'type'      => 'group',
    'label'     => __( 'Width &amp; Max Width', '__x__' ),
    'condition' => array( 'row_inner_container' => false ),
    'controls'  => array(
      $control_row_width,
      $control_row_max_width,
    ),
  );

  $control_row_marginless_columns = array(
    'key'     => 'row_marginless_columns',
    'type'    => 'choose',
    'label'   => __( 'Marginless Columns', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_row_bg_color = array(
    'keys'    => array( 'value' => 'row_bg_color' ),
    'type'    => 'color',
    'label'   => __( 'Background', '__x__' )
  );

  $control_row_bg_advanced = array(
    'keys' => array(
      'bg_advanced' => 'row_bg_advanced',
    ),
    'type'    => 'checkbox-list',
    'options' => array(
      'list' => array(
        array( 'key' => 'bg_advanced', 'label' => __( 'Advanced', '__x__' ) ),
      ),
    ),
  );

  $control_row_background = array(
    'type'     => 'group',
    'label'    => __( 'Background', '__x__' ),
    'controls' => array(
      $control_row_bg_color,
      $control_row_bg_advanced
    ),
  );

  $control_row_text_align = array(
    'key'   => 'row_text_align',
    'type'  => 'text-align',
    'label' => __( 'Text Align', '__x__' ),
  );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls' => array(
        $control_row_columns,
        array(
          'type'     => 'group',
          'label'    => __( 'Setup', '__x__' ),
          'group'    => 'row:setup',
          'controls' => array(
            $control_row_font_size_and_z_index,
            $control_row_inner_container,
            $control_row_width_and_max_width,
            $control_row_marginless_columns,
            $control_row_background
          ),
        )
      ),
      'control_nav' => array(
        'row'        => __( 'Row', '__x__' ),
        'row:setup'  => __( 'Setup', '__x__' ),
        'row:design' => __( 'Design', '__x__' ),
      )
    ),
    cs_partial_controls( 'bg', array(
      'group' => 'row:design',
      'condition' => array( 'row_bg_advanced' => true )
    ) ),
    array(
      'controls' => array(
        array(
          'type'     => 'group',
          'group'   => 'row:design',
          'label'    => __( 'Formatting', '__x__' ),
          'controls' => array(
            $control_row_text_align
          ),
        ),

        cs_control( 'margin', 'row', array(
          'group'   => 'row:design',
          'options' => array(
            'left'  => array( 'disabled' => true, 'fallback_value' => 'auto' ),
            'right' => array( 'disabled' => true, 'fallback_value' => 'auto' ),
          ),
        ) ),
        cs_control( 'padding', 'row', array( 'group' => 'row:design' ) ),
        cs_control( 'border', 'row', array( 'group' => 'row:design' ) ),
        cs_control( 'border-radius', 'row', array( 'group' => 'row:design' ) ),
        cs_control( 'box-shadow', 'row', array( 'group' => 'row:design' ) )
      )
    ),
    cs_partial_controls( 'omega', array( 'add_style' => true, 'add_custom_atts' => true ) )
  );

}



// Register Element
// =============================================================================

$default_child = [ '_type' => 'column', '_active' => true ];

cs_register_element( 'row', [
  'title'    => __( 'Classic Row (v2)', '__x__' ),
  'values'   => $values,
  'migrations' => [
    [ 'row_z_index' => '1' ]
  ],
  'components' => [ 'bg' ],
  'builder'  => 'x_element_builder_setup_row',
  'tss'      => 'x_element_tss_row',
  'render'   => 'x_element_render_row',
  'icon'     => 'native',
  'children' => 'x_row',
  'options' => [
    'valid_children'    => [ 'column' ],
    'index_labels'      => true,
    'is_draggable'      => false,
    'library'           => false,
    'empty_placeholder' => false,
    'default_children' => [ $default_child ],
    'add_new_element'  => $default_child,
    'contrast_keys' => [
      'bg:row_bg_advanced',
      'row_bg_color'
    ],
    'side_effects' => [
      [
        'observe' => 'row_bg_advanced',
        'conditions' => [
          ['key' => 'row_bg_advanced', 'op' => '==', 'value' => true ],
          ['key' => 'row_z_index',     'op' => '==', 'value' => 'auto' ]
        ],
        'apply' => [
          'row_z_index' => '1'
        ]
      ]
    ]
  ]
] );
