<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/COLUMN.PHP
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
    '_active'                      => cs_value( false, 'markup' ),
    'size'                         => cs_value( '1/1', 'markup' ),
    'column_base_font_size'        => cs_value( '1em' ),
    'column_z_index'               => cs_value( 'auto' ),
    'column_fade'                  => cs_value( false, 'markup' ),
    'column_fade_duration'         => cs_value( '0.5s', 'markup' ),
    'column_fade_animation'        => cs_value( 'in', 'markup' ),
    'column_fade_animation_offset' => cs_value( '50px', 'markup' ),
    'column_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'column_bg_advanced'           => cs_value( false, 'markup' ),
    'column_text_align'            => cs_value( 'none' ),
    'column_padding'               => cs_value( '!0em' ),
    'column_border_width'          => cs_value( '!0px' ),
    'column_border_style'          => cs_value( 'solid' ),
    'column_border_color'          => cs_value( 'transparent', 'style:color' ),
    'column_border_radius'         => cs_value( '!0px' ),
    'column_box_shadow_dimensions' => cs_value( '!0em 0em 0em 0em' ),
    'column_box_shadow_color'      => cs_value( 'transparent', 'style:color' )
  ),
  'omega',
  'omega:style',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_column() {
  return [
    'require' => [ 'elements-legacy' ],
    'modules' => [ 'classic-column-v2' ]
  ];
}


// Render
// =============================================================================

function x_element_render_column( $data ) {

  // Prepare Attr Values
  // -------------------

  $classes = [
    'x-column',
    'x-sm',
    'x-' . str_replace( '/', '-', $data['size'] )
  ];


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

  if ( $data['column_fade'] ) {

    $atts['data-fade'] = true;
    $atts = array_merge( $atts, cs_element_js_atts( 'column', array( 'fade' => true ) ) ); // 02

    switch ( $data['column_fade_animation'] ) {
      case 'in' :
        $column_fade_animation_offset = '';
        break;
      case 'in-from-top' :
        $column_fade_animation_offset = ' transform: translate(0, -' . $column_fade_animation_offset . '); ';
        break;
      case 'in-from-left' :
        $column_fade_animation_offset = ' transform: translate(-' . $column_fade_animation_offset . ', 0); ';
        break;
      case 'in-from-right' :
        $column_fade_animation_offset = ' transform: translate(' . $column_fade_animation_offset . ', 0); ';
        break;
      case 'in-from-bottom' :
        $column_fade_animation_offset = ' transform: translate(0, ' . $column_fade_animation_offset . '); ';
        break;
    }

    $column_fade_style = 'opacity: 0;' . $column_fade_animation_offset . 'transition-duration: ' . $data['column_fade_duration'] . ';';

    if ( isset( $atts['style'] ) ) {
      $atts['style'] .= ' ' . $column_fade_style;
    } else {
      $atts['style'] = $column_fade_style;
    }

  }


  // Output
  // ------

  return cs_tag('div', $atts, $data['custom_atts'], [
    $data['column_bg_advanced'] ? cs_make_bg( $data ) : '',
    cs_render_child_elements( $data, 'x_column' )
  ]);

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_column() {

  $control_column_base_font_size = array(
    'key'     => 'column_base_font_size',
    'type'    => 'unit',
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

  $control_column_z_index = array(
    'key'     => 'column_z_index',
    'type'    => 'unit',
    'options' => array(
      'unit_mode'      => 'unitless',
      'valid_keywords' => array( 'auto' ),
      'fallback_value' => 'auto',
    ),
  );

  $control_column_base_font_size_and_z_index = array(
    'type'     => 'group',
    'label'    => __( 'Font Size &amp; Z-Index', '__x__' ),
    'controls' => array(
      $control_column_base_font_size,
      $control_column_z_index
    ),
  );

  $control_column_fade = array(
    'key'     => 'column_fade',
    'type'    => 'choose',
    'label'   => __( 'Fade In Effect', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_column_fade_duration = array(
    'key'     => 'column_fade_duration',
    'type'    => 'unit',
    'options' => array(
      'unit_mode'       => 'time',
      'available_units' => array( 's', 'ms' ),
      'fallback_value'  => '0.5s',
      'ranges'          => array(
        's'  => array( 'min' => 0, 'max' => 5,    'step' => 0.1 ),
        'ms' => array( 'min' => 0, 'max' => 5000, 'step' => 100 ),
      ),
    ),
  );

  $control_column_fade_animation = array(
    'key'     => 'column_fade_animation',
    'type'    => 'select',
    'options' => array(
      'choices' => array(
        array( 'value' => 'in',             'label' => __( 'In', '__x__' ) ),
        array( 'value' => 'in-from-top',    'label' => __( 'In From Top', '__x__' ) ),
        array( 'value' => 'in-from-left',   'label' => __( 'In From Left', '__x__' ) ),
        array( 'value' => 'in-from-right',  'label' => __( 'In From Right', '__x__' ) ),
        array( 'value' => 'in-from-bottom', 'label' => __( 'In From Bottom', '__x__' ) ),
      ),
    ),
  );

  $control_column_fade_duration_and_animation = array(
    'type'      => 'group',
    'label'     => __( 'Duration &amp; Animation', '__x__' ),
    'condition' => array( 'column_fade' => true ),
    'controls'  => array(
      $control_column_fade_duration,
      $control_column_fade_animation,
    ),
  );

  $control_column_fade_animation_offset = array(
    'key'        => 'column_fade_animation_offset',
    'type'       => 'unit-slider',
    'label'      => __( 'Animation Offset', '__x__' ),
    'conditions' => array( array( 'column_fade' => true ), array( 'key' => 'column_fade_animation', 'op' => 'NOT IN', 'value' => 'in' ) ),
    'options'    => array(
    'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
    'fallback_value'  => '50px',
    'ranges'          => array(
      'px'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
      'em'  => array( 'min' => 0, 'max' => 15,  'step' => 0.25 ),
      'rem' => array( 'min' => 0, 'max' => 15,  'step' => 0.25 ),
      '%'   => array( 'min' => 0, 'max' => 200, 'step' => 5    ),
      'vw'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
      'vh'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
    ),
  ),
  );

  $control_column_bg_color = array(
    'key'     => 'column_bg_color',
    'type'    => 'color',
    'label'   => __( 'Background', '__x__' )
  );

  $control_column_bg_advanced = array(
    'keys' => array(
      'bg_advanced' => 'column_bg_advanced',
    ),
    'type'    => 'checkbox-list',
    'options' => array(
      'list' => array(
        array( 'key' => 'bg_advanced', 'label' => __( 'Advanced', '__x__' ) ),
      ),
    ),
  );

  $control_column_background = array(
    'type'     => 'group',
    'label'    => __( 'Background', '__x__' ),
    'controls' => array(
      $control_column_bg_color,
      $control_column_bg_advanced,
    ),
  );

  $control_column_text_align = array(
    'key'   => 'column_text_align',
    'type'  => 'text-align',
    'label' => __( 'Text Align', '__x__' ),
  );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls' => array(
        array(
          'type'     => 'group',
          'label'    => __( 'Setup', '__x__' ),
          'group'    => 'column:setup',
          'controls' => array(
            $control_column_base_font_size_and_z_index,
            $control_column_fade,
            $control_column_fade_duration_and_animation,
            $control_column_fade_animation_offset,
            $control_column_background,
          ),
        ),
      ),
      'control_nav' => array(
        'column'        => __( 'Column', '__x__' ),
        'column:setup'  => __( 'Setup', '__x__' ),
        'column:design' => __( 'Design', '__x__' ),
      )
    ),
    cs_partial_controls( 'bg', array(
      'group'     => 'column:design',
      'condition' => array( 'column_bg_advanced' => true ),
    ) ),
    array(
      'controls' => array(
        array(
          'type'     => 'group',
          'label'    => __( 'Formatting', '__x__' ),
          'group'    => 'column:design',
          'controls' => array(
            $control_column_text_align,
          ),
        ),
        cs_control( 'padding', 'column', array( 'group' => 'column:design' ) ),
        cs_control( 'border', 'column', array( 'group' => 'column:design' ) ),
        cs_control( 'border-radius', 'column', array( 'group' => 'column:design' ) ),
        cs_control( 'box-shadow', 'column', array( 'group' => 'column:design' ) )
      )
    ),
    cs_partial_controls( 'omega', array( 'add_style' => true, 'add_custom_atts' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'column', [
  'title'    => __( 'Classic Column (v2)', '__x__' ),
  'values'   => $values,
  'migrations' => [
    [ 'column_z_index' => '1' ]
  ],
  'components' => [ 'bg' ],
  'builder'  => 'x_element_builder_setup_column',
  'tss'      => 'x_element_tss_column',
  'render'   => 'x_element_render_column',
  'icon'     => 'native',
  'children' => 'x_column',
  'options'  => [
    'valid_children'    => [ '*' ],
    'library'           => false,
    'empty_placeholder' => false,
    'is_draggable'      => false,
    'fallback_content'  => '&nbsp;',
    'dropzone'          => [
      'enabled'     => true,
      'z_index_key' => 'column_z_index'
    ],
    'contrast_keys' => [
      'bg:column_bg_advanced',
      'column_bg_color'
    ],
    'side_effects' => [
      [
        'observe' => 'column_bg_advanced',
        'conditions' => [
          ['key' => 'column_bg_advanced', 'op' => '==', 'value' => true ],
          ['key' => 'column_z_index',     'op' => '==', 'value' => 'auto' ]
        ],
        'apply' => [
          'column_z_index' => '1'
        ]
      ]
    ]
  ],
] );
