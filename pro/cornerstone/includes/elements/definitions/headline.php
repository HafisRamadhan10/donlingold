<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/HEADLINE.PHP
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
  'text-headline',
  'omega',
  'omega:custom-atts',
  'omega:looper-consumer'
);



// Style
// =============================================================================
// 01. These data points were setup as flags initially to distinguish between
//     non-alt/interactive Elements (e.g. Headline) and alt/interactive
//     Elements (e.g. Anchors) with graphics. Since these were setup as
//     "virtual" controls and cannot be changed at a control level, this meant
//     that all old Headline Elements are stuck in a `false` state for these
//     values.
//
//     As of Pro v4.0.0, X v8.0.0, and Cornerstone v5.0.0, we are using
//     graphics with alt/interactive values for both of these Elements to allow
//     for custom transitions everywhere, and need to flag these on for them to
//     work as expected. At this time, we didn't want to rip all of that old
//     breakout code out, and this will allow us to not have to rename anything
//     at a base level or introduce any breaking changes.

function x_element_preprocess_css_data_headline( $data ) {
  $data['text_graphic_has_alt']          = true; // 01
  $data['text_graphic_has_interactions'] = true; // 01

  return $data;
}

function x_element_tss_headline() {
  return [
    'require' => [ 'elements-legacy' ],
    'modules' => [
      'text-headline',
      ['effects', [
        'args' => [
          'selectors' => ['.x-text-content-text-primary', '.x-text-content-text-subheadline', '.x-text-typing', '.x-typed-cursor', '.x-graphic-child']
        ]
      ]
    ]]
  ];
}


// Render
// =============================================================================
// 01. See notes above.

function x_element_render_headline( $data ) {

  return cs_get_partial_view( 'text', array_merge( cs_extract( $data, [ 'text' => '', 'effects' => '' ] ), [
    'id' => $data['id'],
    'classes' => $data['classes'],
    'style' => $data['style'],
    'text_graphic_has_alt' => true, // 01
    'text_graphic_has_interactions' => true, // 01
    'is_headline' => true,
    'custom_atts' => $data['custom_atts']
  ]));

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_headline() {
  return cs_compose_controls(
    cs_partial_controls( 'text', [ 'type' => 'headline', 'group_title' => cs_recall( 'label_headline' ) ] ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true, 'add_looper_consumer' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'headline', [
  'title'      => __( 'Headline', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_headline',
  'tss'        => 'x_element_tss_headline',
  'render'     => 'x_element_render_headline',
  'icon'       => 'native',
  'options'    => [
    'inline' => [
      'text_content' => [
        'selector' => '.x-text-content-text-primary'
      ],
      'text_subheadline_content' => [
        'selector' => '.x-text-content-text-subheadline'
      ],
    ]
  ],

  'preprocess_css_data' => 'x_element_preprocess_css_data_headline',
] );
