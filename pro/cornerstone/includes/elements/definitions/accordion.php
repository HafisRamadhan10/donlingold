<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/ACCORDION.PHP
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
    'accordion_base_font_size'                  => cs_value( '1em' ),
    'accordion_width'                           => cs_value( '100%' ),
    'accordion_max_width'                       => cs_value( 'none' ),
    'accordion_grouped'                         => cs_value( false, 'markup' ),
    'accordion_group'                           => cs_value( '', 'markup' ),
    'accordion_bg_color'                        => cs_value( 'transparent', 'style:color' ),

    'accordion_margin'                          => cs_value( '!0em' ),
    'accordion_padding'                         => cs_value( '!0em' ),
    'accordion_border_width'                    => cs_value( '!0px' ),
    'accordion_border_style'                    => cs_value( 'solid' ),
    'accordion_border_color'                    => cs_value( 'transparent', 'style:color' ),
    'accordion_border_radius'                   => cs_value( '!0px' ),
    'accordion_box_shadow_dimensions'           => cs_value( '!0em 0em 0em 0em' ),
    'accordion_box_shadow_color'                => cs_value( 'transparent', 'style:color' ),

    'accordion_item_overflow'                   => cs_value( true ),
    'accordion_item_spacing'                    => cs_value( '25px' ),
    'accordion_item_bg_color'                   => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),

    'accordion_item_padding'                    => cs_value( '!0em' ),
    'accordion_item_border_width'               => cs_value( '!0px' ),
    'accordion_item_border_style'               => cs_value( 'solid' ),
    'accordion_item_border_color'               => cs_value( 'transparent', 'style:color' ),
    'accordion_item_border_radius'              => cs_value( '0.35em 0.35em 0.35em 0.35em' ),
    'accordion_item_box_shadow_dimensions'      => cs_value( '0em 0.15em 0.65em 0em' ),
    'accordion_item_box_shadow_color'           => cs_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),

    'accordion_header_text_overflow'            => cs_value( false ),
    'accordion_header_indicator'                => cs_value( true, 'markup' ),
    'accordion_header_content_spacing'          => cs_value( '0.5em' ),
    'accordion_header_content_reverse'          => cs_value( false, 'markup' ),
    'accordion_header_bg_color'                 => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'accordion_header_bg_color_alt'             => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),

    'accordion_header_indicator_type'           => cs_value( 'text', 'markup' ),
    'accordion_header_indicator_text'           => cs_value( '&#x25b8;', 'markup' ),
    'accordion_header_indicator_icon'           => cs_value( 'caret-right', 'markup' ),
    'accordion_header_indicator_font_size'      => cs_value( '1em' ),
    'accordion_header_indicator_width'          => cs_value( 'auto' ),
    'accordion_header_indicator_height'         => cs_value( '1em' ),
    'accordion_header_indicator_rotation_start' => cs_value( '0deg' ),
    'accordion_header_indicator_rotation_end'   => cs_value( '90deg' ),
    'accordion_header_indicator_color'          => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'accordion_header_indicator_color_alt'      => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),

    'accordion_header_margin'                   => cs_value( '!0em' ),
    'accordion_header_padding'                  => cs_value( '15px 20px 15px 20px' ),
    'accordion_header_border_width'             => cs_value( '!0px' ),
    'accordion_header_border_style'             => cs_value( 'solid' ),
    'accordion_header_border_color'             => cs_value( 'transparent', 'style:color' ),
    'accordion_header_border_color_alt'         => cs_value( 'transparent', 'style:color' ),
    'accordion_header_border_radius'            => cs_value( '!0px' ),
    'accordion_header_box_shadow_dimensions'    => cs_value( '!0em 0em 0em 0em' ),
    'accordion_header_box_shadow_color'         => cs_value( 'transparent', 'style:color' ),
    'accordion_header_box_shadow_color_alt'     => cs_value( 'transparent', 'style:color' ),

    'accordion_header_font_family'              => cs_value( 'inherit', 'style:font-family' ),
    'accordion_header_font_weight'              => cs_value( 'inherit:400', 'style:font-weight' ),
    'accordion_header_font_size'                => cs_value( '1em' ),
    'accordion_header_letter_spacing'           => cs_value( '0em' ),
    'accordion_header_line_height'              => cs_value( '1.3' ),
    'accordion_header_font_style'               => cs_value( 'normal' ),
    'accordion_header_text_align'               => cs_value( 'left' ),
    'accordion_header_text_decoration'          => cs_value( 'none' ),
    'accordion_header_text_transform'           => cs_value( 'none' ),
    'accordion_header_text_color'               => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'accordion_header_text_color_alt'           => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'accordion_header_text_shadow_dimensions'   => cs_value( '!0px 0px 0px' ),
    'accordion_header_text_shadow_color'        => cs_value( 'transparent', 'style:color' ),
    'accordion_header_text_shadow_color_alt'    => cs_value( 'transparent', 'style:color' ),

    'accordion_content_bg_color'                => cs_value( 'transparent', 'style:color' ),

    'accordion_content_margin'                  => cs_value( '!0em' ),
    'accordion_content_padding'                 => cs_value( '20px 20px 20px 20px' ),
    'accordion_content_border_width'            => cs_value( '1px 0 0 0' ),
    'accordion_content_border_style'            => cs_value( 'solid' ),
    'accordion_content_border_color'            => cs_value( 'rgba(225, 225, 225, 1) transparent transparent transparent' ),
    'accordion_content_border_radius'           => cs_value( '!0px' ),
    'accordion_content_box_shadow_dimensions'   => cs_value( '!0em 0em 0em 0em' ),
    'accordion_content_box_shadow_color'        => cs_value( 'transparent', 'style:color' ),

    'accordion_content_font_family'             => cs_value( 'inherit', 'style:font-family' ),
    'accordion_content_font_weight'             => cs_value( 'inherit:400', 'style:font-weight' ),
    'accordion_content_font_size'               => cs_value( '1em' ),
    'accordion_content_letter_spacing'          => cs_value( '0em' ),
    'accordion_content_line_height'             => cs_value( '1.6' ),
    'accordion_content_font_style'              => cs_value( 'normal' ),
    'accordion_content_text_align'              => cs_value( 'none' ),
    'accordion_content_text_decoration'         => cs_value( 'none' ),
    'accordion_content_text_transform'          => cs_value( 'none' ),
    'accordion_content_text_color'              => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'accordion_content_text_shadow_dimensions'  => cs_value( '!0px 0px 0px' ),
    'accordion_content_text_shadow_color'       => cs_value( 'transparent', 'style:color' ),
  ],
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_accordion() {
  return [
    'require' => [ 'elements-legacy' ],
    'modules' => [ 'accordion', 'effects' ]
  ];
}



// Render
// =============================================================================

function x_element_render_accordion( $data ) {

  $atts = [
    'class' => array_merge( [ 'x-acc' ], $data['classes'] ),
    'role'  => 'tablist',
  ];

  if ( isset( $data['id'] ) && ! empty( $data['id'] ) ) {
    $atts['id'] = $data['id'];
  } else {
    $atts['id'] = 'x-acc-' . $data['unique_id'];
  }

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }

  $atts = cs_apply_effect( $atts, $data );

  return cs_tag('div', $atts, $data['custom_atts'], cs_render_child_elements( $data ));

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_accordion() {

  // Groups
  // ------

  $group_accordion                        = 'accordion';
  $group_accordion_children               = $group_accordion . ':children';
  $group_accordion_setup                  = $group_accordion . ':setup';
  $group_accordion_size                   = $group_accordion . ':size';
  $group_accordion_design                 = $group_accordion . ':design';

  $group_accordion_items                  = 'accordion_items';
  $group_accordion_items_setup            = $group_accordion_items . ':setup';
  $group_accordion_items_design           = $group_accordion_items . ':design';

  $group_accordion_item_header            = 'accordion_item_header';
  $group_accordion_item_header_setup      = $group_accordion_item_header . ':setup';
  $group_accordion_item_header_indicator  = $group_accordion_item_header . ':indicator';
  $group_accordion_item_header_design     = $group_accordion_item_header . ':design';
  $group_accordion_item_header_text       = $group_accordion_item_header . ':text';

  $group_accordion_item_content           = 'accordion_item_content';
  $group_accordion_item_content_setup     = $group_accordion_item_content . ':setup';
  $group_accordion_item_content_design    = $group_accordion_item_content . ':design';
  $group_accordion_item_content_text      = $group_accordion_item_content . ':text';


  // Condition
  // ---------

  $condition_header_indicator       = [ 'accordion_header_indicator' => true ];
  $conditions_header_indicator_text = [ $condition_header_indicator, [ 'accordion_header_indicator_type' => 'text' ] ];
  $conditions_header_indicator_icon = [ $condition_header_indicator, [ 'accordion_header_indicator_type' => 'icon' ] ];


  // Options
  // -------

  $options_accordion_header_indicator_rotation = [
    'unit_mode'       => 'angle',
    'available_units' => [ 'deg' ],
    'fallback_value'  => '0deg',
    'ranges'          => [
      'deg' => [ 'min' => 0, 'max' => 360, 'step' => 1 ],
    ],
  ];


  // Settings
  // --------

  $settings_accordion_item_design = [
    'group' => $group_accordion_items_design,
  ];

  $settings_accordion_header_design = [
    'group'     => $group_accordion_item_header_design,
    'alt_color' => true,
    'options'   => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  ];

  $settings_accordion_header_text = [
    'group'     => $group_accordion_item_header_text,
    'alt_color' => true,
    'options'   => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  ];

  $settings_accordion_content_design = [
    'group' => $group_accordion_item_content_design,
  ];

  $settings_accordion_content_text = [
    'k_pre' => 'accordion_content',
    'group' => $group_accordion_item_content_text,
  ];


  // Individual Controls - Children
  // ------------------------------

  $control_accordion_items_sortable = [
    'type'  => 'sortable',
    'group' => $group_accordion_children,
  ];


  // Individual Controls - Setup
  // ---------------------------

  $control_accordion_base_font_size = cs_recall( 'control_mixin_font_size', [ 'key' => 'accordion_base_font_size' ] );

  $control_accordion_grouped = [
    'key'     => 'accordion_grouped',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_grouped' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  ];

  $control_accordion_group = [
    'key'       => 'accordion_group',
    'type'      => 'text',
    'label'     => cs_recall( 'label_name' ),
    'condition' => [ 'accordion_grouped' => true ],
  ];

  $control_accordion_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'accordion_bg_color' ] ] );


  // Individual Controls - Size
  // --------------------------

  $control_accordion_width     = cs_recall( 'control_mixin_width',     [ 'key' => 'accordion_width'     ] );
  $control_accordion_max_width = cs_recall( 'control_mixin_max_width', [ 'key' => 'accordion_max_width' ] );


  // Individual Controls - Item
  // --------------------------

  $control_accordion_item_overflow = [
    'key'     => 'accordion_item_overflow',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_overflow' ),
    'options' => cs_recall( 'options_choices_layout_overflow_labels_bool' ),
  ];

  $control_accordion_item_spacing  = cs_recall( 'control_mixin_gap',           [ 'keys' => [ 'value' => 'accordion_item_spacing' ], 'label' => cs_recall( 'label_gap_height' ) ] );
  $control_accordion_item_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'accordion_item_bg_color' ]                                            ] );


  // Individual Controls - Header
  // ----------------------------

  $control_accordion_header_text_overflow = cs_recall( 'control_mixin_text_overflow', [ 'key' => 'accordion_header_text_overflow'                                                      ] );
  $control_accordion_header_bg_colors     = cs_recall( 'control_mixin_bg_color_int',  [ 'keys' => [ 'value' => 'accordion_header_bg_color', 'alt' => 'accordion_header_bg_color_alt' ] ] );


  // Individual Controls - Indicator
  // -------------------------------

  $control_accordion_header_indicator_font_size = cs_recall( 'control_mixin_font_size', [ 'key' => 'accordion_header_indicator_font_size' ] );

  $control_accordion_header_indicator_type = [
    'key'       => 'accordion_header_indicator_type',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_type' ),
    'condition' => $condition_header_indicator,
    'options'   => [
      'choices' => [
        [ 'value' => 'text', 'label' => cs_recall( 'label_text' ) ],
        [ 'value' => 'icon', 'label' => cs_recall( 'label_icon' ) ],
      ],
    ],
  ];

  $control_accordion_header_indicator_text = [
    'key'        => 'accordion_header_indicator_text',
    'type'       => 'text',
    'label'      => cs_recall( 'label_indicator' ),
    'conditions' => $conditions_header_indicator_text,
  ];

  $control_accordion_header_indicator_icon = [
    'key'        => 'accordion_header_indicator_icon',
    'type'       => 'icon',
    'label'      => cs_recall( 'label_indicator' ),
    'conditions' => $conditions_header_indicator_icon,
    'options'    => [
      'label' => cs_recall( 'label_select' ),
    ],
  ];

  $control_accordion_header_indicator_placement = [
    'key'       => 'accordion_header_content_reverse',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_placement' ),
    'condition' => $condition_header_indicator,
    'options'   => cs_recall( 'options_choices_before_after_inverse' ),
  ];

  $control_accordion_header_indicator_width   = cs_recall( 'control_mixin_width',  [ 'key' => 'accordion_header_indicator_width'                                                          ] );
  $control_accordion_header_indicator_height  = cs_recall( 'control_mixin_height', [ 'key' => 'accordion_header_indicator_height'                                                         ] );
  $control_accordion_header_indicator_spacing = cs_recall( 'control_mixin_gap',    [ 'keys' => [ 'value' => 'accordion_header_content_spacing' ], 'label' => cs_recall( 'label_spacing' ) ] );

  $control_accordion_header_indicator_rotation_start = [
    'key'     => 'accordion_header_indicator_rotation_start',
    'type'    => 'unit-slider',
    'label'   => cs_recall( 'label_start_rotation' ),
    'options' => $options_accordion_header_indicator_rotation,
  ];

  $control_accordion_header_indicator_rotation_end = [
    'key'     => 'accordion_header_indicator_rotation_end',
    'type'    => 'unit-slider',
    'label'   => cs_recall( 'label_end_rotation' ),
    'options' => $options_accordion_header_indicator_rotation,
  ];

  $control_accordion_header_indicator_colors = cs_recall( 'control_mixin_color_int', [ 'keys' => [ 'value' => 'accordion_header_indicator_color', 'alt' => 'accordion_header_indicator_color_alt' ] ] );


  // Individual Controls - Indicator
  // -------------------------------

  $control_accordion_content_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'accordion_content_bg_color' ] ] );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    [
      'controls' => [
        $control_accordion_items_sortable,
        [
          'type'     => 'group',
          'group'    => $group_accordion_setup,
          'controls' => [
            $control_accordion_base_font_size,
            $control_accordion_grouped,
            $control_accordion_group,
            $control_accordion_bg_color,
          ],
        ],
        [
          'type'     => 'group',
          'group'    => $group_accordion_size,
          'controls' => [
            $control_accordion_width,
            $control_accordion_max_width,
          ],
        ],

        cs_control( 'margin', 'accordion', [ 'group' => $group_accordion_design ] ),
        cs_control( 'padding', 'accordion', [ 'group' => $group_accordion_design ] ),
        cs_control( 'border', 'accordion', [ 'group' => $group_accordion_design ] ),
        cs_control( 'border-radius', 'accordion', [ 'group' => $group_accordion_design ] ),
        cs_control( 'box-shadow', 'accordion', [ 'group' => $group_accordion_design ] ),

        [
          'type'     => 'group',
          'group'    => $group_accordion_items_setup,
          'controls' =>[
            $control_accordion_item_overflow,
            $control_accordion_item_spacing,
            $control_accordion_item_bg_color,
          ],
        ],

        cs_control( 'padding', 'accordion_item', $settings_accordion_item_design ),
        cs_control( 'border', 'accordion_item', $settings_accordion_item_design ),
        cs_control( 'border-radius', 'accordion_item', $settings_accordion_item_design ),
        cs_control( 'box-shadow', 'accordion_item', $settings_accordion_item_design ),

        [
          'type'     => 'group',
          'group'    => $group_accordion_item_header_setup,
          'controls' => [
            $control_accordion_header_text_overflow,
            $control_accordion_header_indicator,
            $control_accordion_header_bg_colors,
          ],
        ],
        [
          'key'      => 'accordion_header_indicator',
          'type'     => 'group',
          'group'    => $group_accordion_item_header_indicator,
          'options'  => cs_recall( 'options_group_toggle_off_on_bool' ),
          'controls' => [
            $control_accordion_header_indicator_font_size,
            $control_accordion_header_indicator_type,
            $control_accordion_header_indicator_text,
            $control_accordion_header_indicator_icon,
            $control_accordion_header_indicator_placement,
            $control_accordion_header_indicator_width,
            $control_accordion_header_indicator_height,
            $control_accordion_header_indicator_spacing,
            $control_accordion_header_indicator_rotation_start,
            $control_accordion_header_indicator_rotation_end,
            $control_accordion_header_indicator_colors,
          ],
        ],

        cs_control( 'margin', 'accordion_header', $settings_accordion_header_design ),
        cs_control( 'padding', 'accordion_header', $settings_accordion_header_design ),
        cs_control( 'border', 'accordion_header', $settings_accordion_header_design ),
        cs_control( 'border-radius', 'accordion_header', $settings_accordion_header_design ),
        cs_control( 'box-shadow', 'accordion_header', $settings_accordion_header_design ),

        cs_control( 'text-format', 'accordion_header', $settings_accordion_header_text ),
        cs_control( 'text-shadow', 'accordion_header', $settings_accordion_header_text ),

        [
          'type'     => 'group',
          'group'    => $group_accordion_item_content_setup,
          'controls' => [
            $control_accordion_content_bg_color
          ],
        ],

        cs_control( 'margin', 'accordion_content', $settings_accordion_content_design ),
        cs_control( 'padding', 'accordion_content', $settings_accordion_content_design ),
        cs_control( 'border', 'accordion_content', $settings_accordion_content_design ),
        cs_control( 'border-radius', 'accordion_content', $settings_accordion_content_design ),
        cs_control( 'box-shadow', 'accordion_content', $settings_accordion_content_design ),

        cs_control( 'text-format', 'accordion_content', $settings_accordion_content_text ),
        cs_control( 'text-shadow', 'accordion_content', $settings_accordion_content_text )

      ],
      'control_nav' => [
        $group_accordion                       => cs_recall( 'label_accordion' ),
        $group_accordion_children              => cs_recall( 'label_children' ),
        $group_accordion_setup                 => cs_recall( 'label_setup' ),
        $group_accordion_size                  => cs_recall( 'label_size' ),
        $group_accordion_design                => cs_recall( 'label_design' ),

        $group_accordion_items                 => cs_recall( 'label_items' ),
        $group_accordion_items_setup           => cs_recall( 'label_setup' ),
        $group_accordion_items_design          => cs_recall( 'label_design' ),

        $group_accordion_item_header           => cs_recall( 'label_header' ),
        $group_accordion_item_header_setup     => cs_recall( 'label_setup' ),
        $group_accordion_item_header_indicator => cs_recall( 'label_indicator' ),
        $group_accordion_item_header_design    => cs_recall( 'label_design' ),
        $group_accordion_item_header_text      => cs_recall( 'label_text' ),

        $group_accordion_item_content          => cs_recall( 'label_content' ),
        $group_accordion_item_content_setup    => cs_recall( 'label_setup' ),
        $group_accordion_item_content_design   => cs_recall( 'label_design' ),
        $group_accordion_item_content_text     => cs_recall( 'label_text' ),
      ],
    ],
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'accordion', [
  'title'      => __( 'Accordion', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_accordion',
  'render'     => 'x_element_render_accordion',
  'tss'        => 'x_element_tss_accordion',
  'icon'       => 'native',
  'options'    => [
    'valid_children'   => [ 'accordion-item' ],
    'add_new_element'  => [ '_type' => 'accordion-item' ],
    'default_children' => [
      [ '_type' => 'accordion-item', 'accordion_item_header_content' => __( 'Accordion Item 1', 'cornerstone' ) ],
      [ '_type' => 'accordion-item', 'accordion_item_header_content' => __( 'Accordion Item 2', 'cornerstone' ) ],
    ]
  ]
] );
