<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/WIDGET-AREA.PHP
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
    'widget_area_sidebar'               => cs_value( '', 'markup', true ),
    'widget_area_base_font_size'        => cs_value( '1rem', 'style' ),
    'widget_area_spacing'               => cs_value( '2.5rem', 'style' ),
    'widget_area_headline_spacing'      => cs_value( '0.5em', 'style' ),
    'widget_area_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'widget_area_margin'                => cs_value( '!0em', 'style' ),
    'widget_area_padding'               => cs_value( '!0em', 'style' ),
    'widget_area_border_width'          => cs_value( '!0px', 'style' ),
    'widget_area_border_style'          => cs_value( 'solid', 'style' ),
    'widget_area_border_color'          => cs_value( 'transparent', 'style:color' ),
    'widget_area_border_radius'         => cs_value( '!0px', 'style' ),
    'widget_area_box_shadow_dimensions' => cs_value( '!0em 0em 0em 0em', 'style' ),
    'widget_area_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  ],
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_widget_area() {
  return [
    'require' => [ 'elements-wp' ],
    'modules' => [ 'widget-area', 'effects' ]
  ];
}



// Render
// =============================================================================

function x_element_render_widget_area( $data ) {

  $classes = [ 'x-widget-area' ];

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

  ob_start();
  dynamic_sidebar( $data['widget_area_sidebar'] );
  $content = ob_get_clean();

  return cs_tag( 'div', $atts, $data['custom_atts'], $content );

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_widget_area() {

  $control_widget_area_base_font_size = cs_recall( 'control_mixin_font_size', [ 'key' => 'widget_area_base_font_size' ] );

  $control_widget_area_sidebar = [
    'key'   => 'widget_area_sidebar',
    'type'  => 'sidebar',
    'label' => cs_recall( 'label_select' ),
  ];

  $control_widget_area_spacing          = cs_recall( 'control_mixin_gap',           [ 'key' => 'widget_area_spacing', 'label' => cs_recall( 'label_widget_spacing' )            ] );
  $control_widget_area_headline_spacing = cs_recall( 'control_mixin_gap',           [ 'key' => 'widget_area_headline_spacing', 'label' => cs_recall( 'label_headline_spacing' ) ] );
  $control_layout_cell_bg_color         = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'widget_area_bg_color' ]                                           ] );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    [
      'controls' => [
        [
          'type'     => 'group',
          'group'    => 'widget_area:setup',
          'controls' => [
            $control_widget_area_base_font_size,
            $control_widget_area_sidebar,
            $control_widget_area_spacing,
            $control_widget_area_headline_spacing,
            $control_widget_area_bg_color,
          ],
        ],
        cs_control( 'margin',        'widget_area', [ 'group' => 'widget_area:design' ] ),
        cs_control( 'padding',       'widget_area', [ 'group' => 'widget_area:design' ] ),
        cs_control( 'border',        'widget_area', [ 'group' => 'widget_area:design' ] ),
        cs_control( 'border-radius', 'widget_area', [ 'group' => 'widget_area:design' ] ),
        cs_control( 'box-shadow',    'widget_area', [ 'group' => 'widget_area:design' ] )
      ],
      'control_nav' => [
        'widget_area'        => cs_recall( 'label_widget_area' ),
        'widget_area:setup'  => cs_recall( 'label_setup' ),
        'widget_area:design' => cs_recall( 'label_design' ),
      ],
    ],
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true ] )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'widget-area', [
  'title'      => __( 'Widget Area', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_widget_area',
  'tss'        => 'x_element_tss_widget_area',
  'render'     => 'x_element_render_widget_area',
  'icon'       => 'native',
] );
