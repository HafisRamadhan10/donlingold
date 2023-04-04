<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/CARD.PHP
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

$style_headline = [
  'text_text_align'             => cs_value( 'center' ),
  'text_flex_direction'         => cs_value( 'column' ),
  'text_subheadline_text_align' => cs_value( 'center' ),
];

$style_card_face = [
  'bg_color'              => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
  'bg_advanced'           => cs_value( false, 'markup' ),
  'border_width'          => cs_value( '!0px' ),
  'border_style'          => cs_value( 'solid' ),
  'border_color'          => cs_value( 'transparent', 'style:color' ),
  'padding'               => cs_value( '4rem 1.5rem 4rem 1.5rem' ),
  'box_shadow_dimensions' => cs_value( '0em 0.35em 2em 0em' ),
  'box_shadow_color'      => cs_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
];

$values = cs_compose_values(
  [
    'card_base_font_size'  => cs_value( '1em' ),
    'card_width'           => cs_value( '100%' ),
    'card_max_width'       => cs_value( 'none' ),
    'card_interaction'     => cs_value( 'flip-up', 'markup' ),
    'card_perspective'     => cs_value( '1000px' ),
    'card_content_justify' => cs_value( 'center' ),
    'card_margin'          => cs_value( '!0em' ),
    'card_border_radius'   => cs_value( '!0px' ),
  ],


  // Front
  // -----

  cs_values( $style_card_face, 'card_front'),
  cs_values( 'text-headline', 'card_front' ),
  cs_values( $style_headline, 'card_front' ),


  // Back
  // ----

  cs_values( $style_card_face, 'card_back'),
  cs_values( 'text-headline', 'card_back' ),
  cs_values( $style_headline, 'card_back' ),

  'anchor-button',
  [
    'anchor_margin' => cs_value( '1em 0em 0em 0em', 'style' )
  ],
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_card() {
  return [
    'require' => [ 'elements-legacy' ],
    'modules' => [
      'card',
      ['anchor', [
        'nested' => true
      ]],
      ['text-headline', [
        'name'  => 'headline-front',
        'remap' => [ 'card_front_text' => 'text' ],
        'nested' => true
      ]],
      ['text-headline', [
        'name'  => 'headline-back',
        'remap' => [ 'card_back_text' => 'text' ],
        'nested' => true
      ]],
      ['effects', [
        'args' => [
          'selectors'       => ['.x-card-faces'],
          'transition_base' => '750ms'
        ]
      ]]
    ]
    // see below: $data['_tss']['headline-front']
  ];
}

// Render
// =============================================================================

function x_element_render_card( $data ) {

  // Prepare Atts
  // ------------

  $atts = [
    'class' => array_merge( [
      'x-card',
      'is-' . $data['card_interaction'],
      'has-not-flipped',
    ], $data['classes'] )
  ];

  if ( isset( $data['id'] ) && ! empty( $data['id'] ) ) {
    $atts['id'] = $data['id'];
  }

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }

  $atts = cs_apply_effect( $atts, $data );

  $atts = array_merge( $atts, cs_element_js_atts( 'card', [] ) );


  // Data: Partials
  // --------------

  $data_headline_front = cs_extract( $data, [ 'card_front_text' => 'text' ] );

  $data_headline_front['is_headline'] = true;
  $data_headline_front['classes'] = [ $data['_tss']['headline-front'] ];

  $data_headline_back  = cs_extract( $data, [ 'card_back_text' => 'text' ]  );
  $data_headline_back['is_headline']  = true;
  $data_headline_back['classes'] = [ $data['_tss']['headline-back'] ];

  $data_anchor         = cs_extract( $data, [ 'anchor' => '' ] );
  $data_anchor['classes'] = [ $data['_tss']['anchor'] ];


  // Output
  // ------

  return cs_tag( 'div', $atts, $data['custom_atts'], [
    cs_tag( 'div', [ 'class' => 'x-card-faces'], [
      cs_tag( 'div', [ 'class' => 'x-card-face is-front'], [
        cs_get_partial_view( 'text', $data_headline_front ),
        $data['card_front_bg_advanced'] ? cs_make_bg( $data, 'card_front') : ''
      ] ),
      cs_tag( 'div', [ 'class' => 'x-card-face is-back'], [
        cs_get_partial_view( 'text', $data_headline_back ),
        cs_get_partial_view( 'anchor', $data_anchor ),
        $data['card_back_bg_advanced'] ? cs_make_bg( $data, 'card_back') : ''
      ] ),
    ] )
  ] );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_card() {

  $settings_card_front = [
    'label_prefix' => cs_recall( 'label_front' ),
    'group'        => 'card:front',
  ];

  $settings_card_back = [
    'label_prefix' => cs_recall( 'label_back' ),
    'group'        => 'card:back',
  ];


  // Individual Controls (Setup)
  // ---------------------------

  $control_card_base_font_size = cs_recall( 'control_mixin_font_size', [ 'key' => 'card_base_font_size' ] );
  $control_card_width          = cs_recall( 'control_mixin_width',     [ 'key' => 'card_width'          ] );
  $control_card_max_width      = cs_recall( 'control_mixin_max_width', [ 'key' => 'card_max_width'      ] );

  $control_card_interaction = [
    'key'     => 'card_interaction',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_flip_direction' ),
    'options' => [
      'choices' => [
        [ 'value' => 'flip-up',    'label' => '↑' ],
        [ 'value' => 'flip-down',  'label' => '↓' ],
        [ 'value' => 'flip-left',  'label' => '←' ],
        [ 'value' => 'flip-right', 'label' => '→' ],
      ],
    ],
  ];

  $control_card_perspective = [
    'key'     => 'card_perspective',
    'type'    => 'unit-slider',
    'label'   => cs_recall( 'label_perspective' ),
    'options' => [
      'available_units' => [ 'px' ],
      'fallback_value'  => '1000px',
      'ranges'          => [
        'px' => [ 'min' => 500, 'max' => 1500, 'step' => 1 ],
      ],
    ],
  ];

  $control_card_content_justify = [
    'key'     => 'card_content_justify',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_align_vertical' ),
    'options' => [
      'choices' => [
        [ 'value' => 'flex-start', 'label' => cs_recall( 'label_start' )  ],
        [ 'value' => 'center',     'label' => cs_recall( 'label_center' ) ],
        [ 'value' => 'flex-end',   'label' => cs_recall( 'label_end' )    ],
      ],
    ],
  ];


  // Backgrounds
  // -----

  $control_card_front_background  = cs_recall( 'control_mixin_bg_color_solo_adv', [ 'keys' => [ 'value' => 'card_front_bg_color', 'checkbox' => 'card_front_bg_advanced' ] ] );
  $control_card_back_background   = cs_recall( 'control_mixin_bg_color_solo_adv', [ 'keys' => [ 'value' => 'card_back_bg_color', 'checkbox' => 'card_back_bg_advanced' ] ] );



  // Compose Controls
  // ----------------

  return cs_compose_controls(
    [
      'controls' => [
        [
          'type'     => 'group',
          'group'    => 'card:setup',
          'controls' => [
            $control_card_base_font_size,
            $control_card_interaction,
            $control_card_perspective,
            $control_card_content_justify,
          ],
        ],
        [
          'type'     => 'group',
          'group'    => 'card:size',
          'controls' => [
            $control_card_width,
            $control_card_max_width,
          ],
        ],
        cs_control( 'margin',        'card', [ 'group' => 'card:design' ] ),
        cs_control( 'border-radius', 'card', [ 'group' => 'card:design' ] ),
        [
          'type'     => 'group',
          'group'    => 'card:front',
          'controls' => [ $control_card_front_background ]
        ]
      ],
      'control_nav' => [
        'card'                         => cs_recall( 'label_card' ),
        'card:setup'                   => cs_recall( 'label_setup' ),
        'card:size'                    => cs_recall( 'label_size' ),
        'card:design'                  => cs_recall( 'label_design' ),
        'card:front'                   => cs_recall( 'label_front' ),
        'card:front-background-layers' => cs_recall( 'label_front_background_layers' ),
        'card:back'                    => cs_recall( 'label_back' ),
        'card:back-background-layers'  => cs_recall( 'label_back_background_layers' ),
      ]
    ],
    cs_partial_controls( 'bg', [
      'label_prefix' => cs_recall( 'label_front' ),
      'k_pre'        => 'card_front',
      'group'        => 'card:front-background-layers',
      'condition'    => [ 'card_front_bg_advanced' => true ],
    ] ),
    [
      'controls' => [
        cs_control( 'border', 'card_front', $settings_card_front ),
        cs_control( 'padding', 'card_front', $settings_card_front ),
        cs_control( 'box-shadow', 'card_front', $settings_card_front ),
        [
          'type'     => 'group',
          'group'    => 'card:back',
          'controls' => [ $control_card_back_background ]
        ],
      ]
    ],
    cs_partial_controls( 'bg', [
      'label_prefix' => cs_recall( 'label_back' ),
      'k_pre'        => 'card_back',
      'group'        => 'card:back-background-layers',
      'condition'    => [ 'card_back_bg_advanced' => true ],
      'adv'          => true,
    ] ),
    [
      'controls' => [
        cs_control( 'border', 'card_back', $settings_card_back ),
        cs_control( 'padding', 'card_back', $settings_card_back ),
        cs_control( 'box-shadow', 'card_back', $settings_card_back )
      ]
    ],
    cs_partial_controls( 'text', [
      'k_pre'            => 'card_front',
      'group'            => 'card_front_text',
      'group_title'      => cs_recall( 'label_front_content' ),
      'type'             => 'headline'
    ] ),
    cs_partial_controls( 'text', [
      'k_pre'            => 'card_back',
      'group'            => 'card_back_text',
      'group_title'      => cs_recall( 'label_back_content' ),
      'type'             => 'headline'
    ] ),
    cs_partial_controls( 'anchor', [
      'type'             => 'button',
      'has_link_control' => true,
      'group'            => 'button_anchor',
      'group_title'      => cs_recall( 'label_back_button' ),
    ] ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'card', [
  'title'      => __( 'Card', 'cornerstone' ),
  'values'     => $values,
  'components' => [
    [ 'type' => 'effects', 'values' => [ 'effects_duration' => '750ms' ] ],
    [ 'type' => 'bg', 'key_prefix' => 'card_back_bg' ],
    [ 'type' => 'bg', 'key_prefix' => 'card_front_bg' ]
  ],
  'builder'    => 'x_element_builder_setup_card',
  'tss'        => 'x_element_tss_card',
  'render'     => 'x_element_render_card',
  'icon'       => 'native',
] );
