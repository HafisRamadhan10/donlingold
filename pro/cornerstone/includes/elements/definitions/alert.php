<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/ALERT.PHP
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
    'alert_close'                  => cs_value( false, 'markup' ),
    'alert_width'                  => cs_value( 'auto' ),
    'alert_max_width'              => cs_value( 'none' ),
    'alert_content'                => cs_value( __( 'This is where the content for your alert goes. Best to keep it short and sweet!', '__x__' ), 'markup:seo', true ),
    'alert_bg_color'               => cs_value( 'transparent', 'style:color' ),

    'alert_close_font_size'        => cs_value( '1em' ),
    'alert_close_location'         => cs_value( 'right' ),
    'alert_close_offset_top'       => cs_value( '1.25em' ),
    'alert_close_offset_side'      => cs_value( '1em' ),
    'alert_close_color'            => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'alert_close_color_alt'        => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),

    'alert_margin'                 => cs_value( '!0em' ),
    'alert_padding'                => cs_value( '1em 2.75em 1em 1.15em' ),
    'alert_border_width'           => cs_value( '1px' ),
    'alert_border_style'           => cs_value( 'solid' ),
    'alert_border_color'           => cs_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
    'alert_border_radius'          => cs_value( '3px' ),
    'alert_box_shadow_dimensions'  => cs_value( '0em 0.15em 0.25em 0em' ),
    'alert_box_shadow_color'       => cs_value( 'rgba(0, 0, 0, 0.05)', 'style:color' ),

    'alert_font_family'            => cs_value( 'inherit', 'style:font-family' ),
    'alert_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
    'alert_font_size'              => cs_value( '1em' ),
    'alert_line_height'            => cs_value( '1.5' ),
    'alert_letter_spacing'         => cs_value( '0em' ),
    'alert_font_style'             => cs_value( 'normal' ),
    'alert_text_align'             => cs_value( 'none' ),
    'alert_text_decoration'        => cs_value( 'none' ),
    'alert_text_transform'         => cs_value( 'none' ),
    'alert_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'alert_text_shadow_dimensions' => cs_value( '!0px 0px 0px' ),
    'alert_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  ],
  'omega',
  'omega:custom-atts',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_tss_alert() {
  return [
    'require' => [ 'elements-legacy' ],
    'modules' => [ 'alert', 'effects' ]
  ];
}



// Render
// =============================================================================

function x_element_render_alert( $data ) {

  // Prepare Attr Values
  // -------------------

  $classes = [ 'x-alert' ];

  if ( $data['alert_close'] === true ) {
    $classes[] = 'fade';
    $classes[] = 'in';
  } else {
    $classes[] = 'x-alert-block';
  }

  // Prepare Atts
  // ------------

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

  // Content
  // -------

  $alert_close_content = NULL;

  if ( $data['alert_close'] === true ) {
    $alert_close_content = '<button type="button" class="close" data-dismiss="alert">&times;</button>';
  }


  // Output
  // ------

  return cs_tag( 'div', $atts, $data['custom_atts'], [
    $alert_close_content,
    cs_tag( 'div', [ 'class' => 'x-alert-content'], $data['alert_content'])
  ]);

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_alert() {

  // Conditions
  // ----------

  $condition_alert_close = [ 'alert_close' => true ];


  // Individual Controls - Setup
  // ---------------------------

  $control_alert_content = [
    'key'     => 'alert_content',
    'type'    => 'text-editor',
    'label'   => cs_recall( 'label_content' ),
    'options' => [
      'mode'   => 'html',
      'height' => 4,
    ],
  ];

  $control_alert_options = [
    'keys' => [
      'close' => 'alert_close',
    ],
    'type'    => 'checkbox-list',
    'label'   => cs_recall( 'label_nbsp' ),
    'options' => [
      'list' => [
        [ 'key' => 'close', 'label' => cs_recall( 'label_enable_close_button' ), 'full' => true ],
      ],
    ],
  ];

  $control_alert_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'alert_bg_color' ] ] );


  // Individual Controls - Size
  // --------------------------

  $control_alert_width     = cs_recall( 'control_mixin_width',     [ 'key' => 'alert_width'     ] );
  $control_alert_max_width = cs_recall( 'control_mixin_max_width', [ 'key' => 'alert_max_width' ] );


  // Individual Controls - Close
  // ---------------------------

  $control_alert_close_font_size = cs_recall( 'control_mixin_font_size', [ 'key' => 'alert_close_font_size', 'condition' => $condition_alert_close ] );

  $control_alert_close_location = [
    'key'       => 'alert_close_location',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_location' ),
    'condition' => $condition_alert_close,
    'options'   => [
      'choices' => [
        [ 'value' => 'left',  'label' => cs_recall( 'label_left' ) ],
        [ 'value' => 'right', 'label' => cs_recall( 'label_right' ) ],
      ],
    ],
  ];

  $control_alert_close_offset_top = [
    'key'       => 'alert_close_offset_top',
    'type'      => 'unit-slider',
    'label'     => cs_recall( 'label_offset_top' ),
    'condition' => $condition_alert_close,
    'options'   => $options_alert_close_offset,
  ];

  $control_alert_close_offset_side = [
    'key'       => 'alert_close_offset_side',
    'type'      => 'unit-slider',
    'label'     => cs_recall( 'label_offset_side' ),
    'condition' => $condition_alert_close,
    'options'   => $options_alert_close_offset,
  ];

  $control_alert_close_colors = cs_recall( 'control_mixin_color_int', [ 'keys' => [ 'value' => 'alert_close_color', 'alt' => 'alert_close_color_alt' ], 'condition' => $condition_alert_close ] );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    [
      'controls' => [
        [
          'type'     => 'group',
          'group'    => 'alert:setup',
          'controls' => [
            $control_alert_content,
            $control_alert_options,
            $control_alert_bg_color,
          ],
        ],
        [
          'type'     => 'group',
          'group'    => 'alert:close',
          'controls' => [
            $control_alert_close_font_size,
            $control_alert_close_location,
            $control_alert_close_offset_top,
            $control_alert_close_offset_side,
            $control_alert_close_colors,
          ],
        ],
        [
          'type'     => 'group',
          'group'    => 'alert:size',
          'controls' => [
            $control_alert_width,
            $control_alert_max_width,
          ],
        ],

        cs_control( 'margin',        'alert', [ 'group' => 'alert:design' ] ),
        cs_control( 'padding',       'alert', [ 'group' => 'alert:design' ] ),
        cs_control( 'border',        'alert', [ 'group' => 'alert:design' ] ),
        cs_control( 'border-radius', 'alert', [ 'group' => 'alert:design' ] ),
        cs_control( 'box-shadow',    'alert', [ 'group' => 'alert:design' ] ),

        cs_control( 'text-format', 'alert', [ 'group' => 'alert:text' ] ),
        cs_control( 'text-shadow', 'alert', [ 'group' => 'alert:text' ] ),
      ],
      'control_nav' => [
        'alert'        => cs_recall( 'label_alert' ),
        'alert:setup'  => cs_recall( 'label_setup' ),
        'alert:close'  => cs_recall( 'label_close' ),
        'alert:size'   => cs_recall( 'label_size' ),
        'alert:design' => cs_recall( 'label_design' ),
        'alert:text'   => cs_recall( 'label_text' ),
      ],
    ],
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true, 'add_looper_consumer' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'alert', [
  'title'      => __( 'Alert', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_alert',
  'tss'        => 'x_element_tss_alert',
  'render'     => 'x_element_render_alert',
  'icon'       => 'native',
  'options'    => [
    'inline' => [
      'alert_content' => [
        'selector' => '.x-alert-content'
      ]
    ]
  ]
] );
