<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/CREATIVE-CTA.PHP
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
  'anchor-button',
  'anchor:interactive-content',
  [
    'anchor_base_font_size'            => cs_value( '1.5em' ),
    'anchor_width'                     => cs_value( '100%' ),
    'anchor_bg_color'                  => cs_value( 'rgba(0, 0, 0, 0.05)', 'style:color' ),
    'anchor_bg_color_alt'              => cs_value( 'rgba(0, 0, 0, 0)', 'style:color' ),
    'anchor_padding'                   => cs_value( '2em 1em 2em 1em' ),
    'anchor_flex_direction'            => cs_value( 'column' ),
    'anchor_box_shadow_dimensions'     => cs_value( '!0em 0em 0em 0em' ),
    'anchor_box_shadow_dimensions_alt' => cs_value( '!0em 0em 0em 0em' ),
    'anchor_box_shadow_color'          => cs_value( 'transparent', 'style:color' ),
    'anchor_box_shadow_color_alt'      => cs_value( 'transparent', 'style:color' ),
    'anchor_text_primary_content'      => cs_value( __( 'Got Questions?', '__x__' ), 'markup:seo', true ),
    'anchor_primary_text_align'        => cs_value( 'center' ),
    'anchor_primary_text_color'        => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'anchor_primary_text_color_alt'    => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'anchor_secondary_text_align'      => cs_value( 'center' ),
    'anchor_secondary_text_color'      => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'anchor_secondary_text_color_alt'  => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'anchor_graphic'                   => cs_value( true, 'markup' ),
    'anchor_graphic_icon_font_size'    => cs_value( '1.5em' ),
    'anchor_graphic_icon'              => cs_value( 'l-hand-pointer', 'markup', true ),
    'anchor_graphic_icon_alt'          => cs_value( 'l-hand-pointer', 'markup', true ),
    'anchor_graphic_icon_color'        => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'anchor_graphic_icon_color_alt'    => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  ],
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_creative_cta() {
  return [
    'modules' => [
      'anchor',
      ['effects', [
        'args' => [
          'selectors' => ['.x-anchor-text-primary', '.x-anchor-text-secondary', '.x-graphic-child']
        ]
      ]]
    ]
  ];
}


// Render
// =============================================================================

function x_element_render_creative_cta( $data ) {
  return cs_get_partial_view( 'anchor', array_merge( cs_extract( $data, [ 'anchor' => '', 'effects' => '' ] ), [
    'id'          => $data['id'],
    'classes'     => $data['classes'],
    'style'       => $data['style'],
    'custom_atts' => $data['custom_atts'],
    // 'has_interactive_content' => true,
  ]));
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_creative_cta() {
  return cs_compose_controls(
    cs_partial_controls( 'anchor', [
      'type'                    => 'button',
      'has_link_control'        => true,
      'has_interactive_content' => true,
      'group'                   => 'button_anchor',
      'group_title'             => cs_recall( 'label_creative_cta' ),
    ] ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'creative-cta', [
  'title'      => __( 'Creative CTA', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_creative_cta',
  'tss'        => 'x_element_tss_creative_cta',
  'render'     => 'x_element_render_creative_cta',
  'icon'       => 'native',
] );
