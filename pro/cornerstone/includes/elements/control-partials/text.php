<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/TEXT.PHP
// -----------------------------------------------------------------------------
// Element Controls
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
// =============================================================================

// Controls
// =============================================================================

function x_control_partial_text( $settings ) {

  // Setup
  // -----

  // 01. Available types:
  //     -- 'standard'
  //     -- 'headline'

  $label_prefix      = ( isset( $settings['label_prefix'] )     ) ? $settings['label_prefix']     : '';
  $k_pre             = ( isset( $settings['k_pre'] )            ) ? $settings['k_pre'] . '_'      : '';
  $group             = ( isset( $settings['group'] )            ) ? $settings['group']            : 'text';
  $group_title       = ( isset( $settings['group_title'] )      ) ? $settings['group_title']      : cs_recall( 'label_text' );
  $conditions        = ( isset( $settings['conditions'] )       ) ? $settings['conditions']       : [];
  $type              = ( isset( $settings['type'] )             ) ? $settings['type']             : 'standard'; // 01
  $is_headline       = $type === 'headline';


  // Groups
  // ------

  $group_text_setup       = $group . ':setup';
  $group_text_typing      = $group . ':typing';
  $group_text_columns     = $group . ':columns';
  $group_text_size        = $group . ':size';
  $group_text_design      = $group . ':design';
  $group_text_graphic     = $group . ':graphic';
  $group_text_text        = $group . ':text';
  $group_text_subheadline = $group . ':subheadline';


  // Conditions
  // ----------

  $conditions_text_columns               = array_merge( $conditions, [ [ $k_pre . 'text_columns' => true ]       ] );
  $conditions_text_typing_on             = array_merge( $conditions, [ [ $k_pre . 'text_typing' => true ]        ] );
  $conditions_text_typing_cursor_enabled = array_merge( $conditions, [ [ $k_pre . 'text_typing_cursor' => true ] ] );
  $conditions_text_typing_off            = array_merge( $conditions, [ [ $k_pre . 'text_typing' => false ]       ] );
  $conditions_text_subheadline           = array_merge( $conditions, [ [ $k_pre . 'text_subheadline' => true ]   ] );


  // Settings
  // --------

  $settings_text_design = [
    'group'      => $group_text_design,
    'conditions' => $conditions,
    'alt_color'  => true,
    'options'    => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  ];

  $settings_text_text = [
    'group'      => $group_text_text,
    'conditions' => $conditions,
    'alt_color'  => true,
    'options'    => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  ];

  $settings_text_flexbox = [
    'label_prefix' => sprintf( cs_recall( 'label_content_with_sprintf_prefix' ), $label_prefix ),
    'group'        => $group_text_design,
    'conditions'   => $conditions
  ];

  $settings_text_content_margin = [
    'label_prefix' => sprintf( cs_recall( 'label_text_with_sprintf_prefix' ), $label_prefix ),
    'group'        => $group_text_text,
    'conditions'   => $conditions,
  ];

  $settings_text_subheadline_text = [
    'label_prefix' => sprintf( cs_recall( 'label_subheadline_with_sprintf_prefix' ), $label_prefix ),
    'group'        => $group_text_subheadline,
    'conditions'   => $conditions_text_subheadline,
    'alt_color'    => true,
    'options'      => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  ];


  // Options
  // -------

  $options_typing_effect_time_controls = [
    'unit_mode'       => 'time',
    'available_units' => [ 's', 'ms' ],
    'fallback_value'  => '0ms',
    'ranges'          => [
      's'  => [ 'min' => 0, 'max' => 5,    'step' => 0.1 ],
      'ms' => [ 'min' => 0, 'max' => 5000, 'step' => 100 ],
    ],
  ];


  // Individual Controls - Setup
  // ---------------------------

  $control_text_content_standard = [
    'key'     => $k_pre . 'text_content',
    'type'    => 'text-editor',
    'label'   => cs_recall( 'label_content' ),
    'options' => [
      'height'                => 4,
      'disable_input_preview' => true
    ],
  ];

  $control_text_content_headline = [
    'key'        => $k_pre . 'text_content',
    'type'       => 'text-editor',
    'label'      => cs_recall( 'label_content' ),
    'conditions' => $conditions_text_typing_off,
    'options'    => [
      'height'                => 1,
      'mode'                  => 'html',
      'disable_input_preview' => true,
    ],
  ];

  $control_text_options_standard = [
    'keys' => [
      'columns' => $k_pre . 'text_columns',
    ],
    'type'    => 'checkbox-list',
    'label'   => cs_recall( 'label_nbsp' ),
    'options' => [
      'list' => [
        [ 'key' => 'columns', 'label' => cs_recall( 'label_enable_multi_column_layout' ), 'full' => true ],
      ],
    ],
  ];

  $control_text_font_size        = cs_recall( 'control_mixin_font_size',     [ 'key' => $k_pre . 'text_font_size'                                                       ] );
  $control_text_base_font_size   = cs_recall( 'control_mixin_font_size',     [ 'key' => $k_pre . 'text_base_font_size'                                                  ] );
  $control_text_tag              = cs_recall( 'control_mixin_text_tag',      [ 'key' => $k_pre . 'text_tag'                                                             ] );
  $control_text_overflow         = cs_recall( 'control_mixin_text_overflow', [ 'key' => $k_pre . 'text_overflow'                                                        ] );
  $control_text_options_headline = [
    'keys' => [
      'typing'      => $k_pre . 'text_typing',
      'subheadline' => $k_pre . 'text_subheadline',
      'graphic'     => $k_pre . 'text_graphic',
    ],
    'type'    => 'checkbox-list',
    'label'   => cs_recall( 'label_options' ),
    'options' => [
      'list' => [
        [ 'key' => 'typing',      'label' => cs_recall( 'label_typing' )      ],
        [ 'key' => 'subheadline', 'label' => cs_recall( 'label_subheadline' ) ],
        [ 'key' => 'graphic',     'label' => cs_recall( 'label_graphic' )     ],
      ],
    ],
  ];
  $control_text_bg_color = cs_recall( 'control_mixin_bg_color_int',  [ 'keys' => [ 'value' => $k_pre . 'text_bg_color', 'alt' => $k_pre . 'text_bg_color_alt' ] ] );


  // Individual Controls - Size
  // --------------------------

  $control_text_width     = cs_recall( 'control_mixin_width',     [ 'key' => $k_pre . 'text_width'     ] );
  $control_text_max_width = cs_recall( 'control_mixin_max_width', [ 'key' => $k_pre . 'text_max_width' ] );


  // Individual Controls - Subheadline
  // ---------------------------------

  $control_text_subheadline_content = [
    'key'        => $k_pre . 'text_subheadline_content',
    'type'       => 'text-editor',
    'label'      => cs_recall( 'label_content' ),
    'conditions' => $conditions_text_subheadline,
    'options'    => [
      'mode'   => 'html',
      'height' => 3,
    ],
  ];

  $control_text_subheadline_tag = cs_recall( 'control_mixin_text_tag', [ 'key' => $k_pre . 'text_subheadline_tag', 'conditions' => $conditions_text_subheadline ] );

  $control_text_subheadline_spacing = [
    'key'        => $k_pre . 'text_subheadline_spacing',
    'type'       => 'unit-slider',
    'label'      => cs_recall( 'label_spacing' ),
    'conditions' => $conditions_text_subheadline,
    'options'    => [
      'available_units' => [ 'px', 'em', 'rem' ],
      'fallback_value'  => '0.35em',
      'ranges'          => [
        'px'  => [ 'min' => 0, 'max' => 50, 'step' => 1   ],
        'em'  => [ 'min' => 0, 'max' => 3,  'step' => 0.1 ],
        'rem' => [ 'min' => 0, 'max' => 3,  'step' => 0.1 ],
      ],
    ],
  ];

  $control_text_subheadline_reverse = [
    'key'        => $k_pre . 'text_subheadline_reverse',
    'type'       => 'choose',
    'label'      => cs_recall( 'label_placement' ),
    'conditions' => $conditions_text_subheadline,
    'options'    => [
      'choices' => [
        [ 'value' => true,  'label' => cs_recall( 'label_before' ) ],
        [ 'value' => false, 'label' => cs_recall( 'label_after' )  ],
      ],
    ],
  ];


  // Individual Controls - Link
  // --------------------------

  $control_text_link = [
    'keys' => [
      'url'      => $k_pre . 'text_href',
      'new_tab'  => $k_pre . 'text_blank',
      'nofollow' => $k_pre . 'text_nofollow',
      'toggle'   => $k_pre . 'text_link'
    ],
    'type'       => 'link',
    'label'      => cs_recall( 'label_link_with_prefix' ),
    'label_vars' => [ 'prefix' => $label_prefix ],
    'options'    => cs_recall( 'options_group_toggle_off_on_bool' ),
    'group'      => $group_text_setup,
  ];


  // Control List - Setup
  // --------------------

  $control_list_text_setup = [];

  if ( $type === 'standard' ) {
    $control_list_text_setup[] = $control_text_content_standard;
    $control_list_text_setup[] = $control_text_options_standard;
  }

  if ( $type === 'headline' ) {
    $control_list_text_setup[] = $control_text_base_font_size;
    $control_list_text_setup[] = $control_text_tag;
    $control_list_text_setup[] = $control_text_content_headline;
    $control_list_text_setup[] = $control_text_overflow;
    $control_list_text_setup[] = $control_text_options_headline;
  }

  $control_list_text_setup[] = $control_text_bg_color;


  // Control List - Text Columns
  // ---------------------------

  $control_list_text_text_columns = [
    [
      'key'        => $k_pre . 'text_columns_break_inside',
      'type'       => 'choose',
      'label'      => cs_recall( 'label_content_break' ),
      'conditions' => $conditions_text_columns,
      'options'    => [
        'choices' => [
          [ 'value' => 'auto',  'label' => cs_recall( 'label_auto' )  ],
          [ 'value' => 'avoid', 'label' => cs_recall( 'label_avoid' ) ],
        ],
      ],
    ],
    [
      'key'        => $k_pre . 'text_columns_count',
      'type'       => 'unit-slider',
      'label'      => cs_recall( 'label_max_columns' ),
      'conditions' => $conditions_text_columns,
      'options'    => [
        'unit_mode'      => 'unitless',
        'fallback_value' => 2,
        'min'            => 2,
        'max'            => 5,
        'step'           => 1,
      ],
    ],
    [
      'key'        => $k_pre . 'text_columns_width',
      'type'       => 'unit-slider',
      'label'      => cs_recall( 'label_min_width' ),
      'conditions' => $conditions_text_columns,
      'options'    => [
        'available_units' => [ 'px', 'em', 'rem' ],
        'valid_keywords'  => [ 'calc' ],
        'fallback_value'  => '250px',
        'ranges'          => [
          'px'  => [ 'min' => 200, 'max' => 500, 'step' => 10  ],
          'em'  => [ 'min' => 12,  'max' => 32,  'step' => 0.5 ],
          'rem' => [ 'min' => 12,  'max' => 32,  'step' => 0.5 ],
        ],
      ],
    ],
    [
      'key'        => $k_pre . 'text_columns_gap',
      'type'       => 'unit-slider',
      'label'      => cs_recall( 'label_gap_width' ),
      'conditions' => $conditions_text_columns,
      'options'    => [
        'available_units' => [ 'px', 'em', 'rem' ],
        'valid_keywords'  => [ 'calc' ],
        'fallback_value'  => '30px',
        'ranges'          => [
          'px'  => [ 'min' => 20, 'max' => 100, 'step' => 1    ],
          'em'  => [ 'min' => 1,  'max' => 7,   'step' => 0.25 ],
          'rem' => [ 'min' => 1,  'max' => 7,   'step' => 0.25 ],
        ],
      ],
    ],
    [
      'key'        => $k_pre . 'text_columns_rule_style',
      'type'       => 'select',
      'label'      => cs_recall( 'label_rule_style' ),
      'conditions' => $conditions_text_columns,
      'options'    => cs_recall( 'options_choices_border_styles' ),
    ],
    [
      'key'        => $k_pre . 'text_columns_rule_width',
      'type'       => 'unit-slider',
      'label'      => cs_recall( 'label_rule_width' ),
      'conditions' => $conditions_text_columns,
      'options'    => [
        'available_units' => [ 'px', 'em', 'rem' ],
        'valid_keywords'  => [ 'calc' ],
        'fallback_value'  => '0px',
        'ranges'          => [
          'px'  => [ 'min' => 0, 'max' => 10, 'step' => 1    ],
          'em'  => [ 'min' => 0, 'max' => 1,  'step' => 0.05 ],
          'rem' => [ 'min' => 0, 'max' => 1,  'step' => 0.05 ],
        ],
      ],
    ],
    [
      'keys' => [
        'value' => $k_pre . 'text_columns_rule_color',
        'alt'   => $k_pre . 'text_columns_rule_color_alt',
      ],
      'type'       => 'color',
      'label'      => cs_recall( 'label_rule_color' ),
      'options'    => cs_recall( 'options_swatch_base_interaction_labels' ),
      'conditions' => $conditions_text_columns,
    ],
  ];


  // Control List - Typing Setup
  // ---------------------------

  $control_list_text_typing_setup = [
    [
      'key'   => $k_pre . 'text_typing_prefix',
      'type'  => 'text',
      'label' => cs_recall( 'label_prefix' ),
    ],
    [
      'key'     => $k_pre . 'text_typing_content',
      'type'    => 'textarea',
      'label'   => cs_recall( 'label_typed_text_1_per_line' ),
      'options' => [
        'height' => 2,
        'mode'   => 'html',
      ],
    ],
    [
      'key'   => $k_pre . 'text_typing_suffix',
      'type'  => 'text',
      'label' => cs_recall( 'label_suffix' ),
    ],
    [
      'keys' => [
        'value' => $k_pre . 'text_typing_color',
        'alt'   => $k_pre . 'text_typing_color_alt',
      ],
      'type'    => 'color',
      'label'   => cs_recall( 'label_text' ),
      'options' => cs_recall( 'options_swatch_base_interaction_labels' ),
    ],
    [
      'key'     => $k_pre . 'text_typing_delay',
      'type'    => 'unit-slider',
      'label'   => cs_recall( 'label_fwd_delay' ),
      'options' => $options_typing_effect_time_controls,
    ],
    [
      'key'     => $k_pre . 'text_typing_speed',
      'type'    => 'unit-slider',
      'label'   => cs_recall( 'label_fwd_speed' ),
      'options' => $options_typing_effect_time_controls,
    ],
    [
      'key'     => $k_pre . 'text_typing_back_delay',
      'type'    => 'unit-slider',
      'label'   => cs_recall( 'label_back_delay' ),
      'options' => $options_typing_effect_time_controls,
    ],
    [
      'key'     => $k_pre . 'text_typing_back_speed',
      'type'    => 'unit-slider',
      'label'   => cs_recall( 'label_back_speed' ),
      'options' => $options_typing_effect_time_controls,
    ],
    [
      'keys' => [
        'text_typing_loop'   => $k_pre . 'text_typing_loop',
        'text_typing_cursor' => $k_pre . 'text_typing_cursor',
      ],
      'type'    => 'checkbox-list',
      'label'   => cs_recall( 'label_options' ),
      'options' => [
        'list' => [
          [ 'key' => 'text_typing_loop',   'label' => cs_recall( 'label_loop' )   ],
          [ 'key' => 'text_typing_cursor', 'label' => cs_recall( 'label_cursor' ) ],
        ],
      ],
    ],
    [
      'key'        => $k_pre . 'text_typing_cursor_content',
      'type'       => 'text',
      'label'      => cs_recall( 'label_symbol' ),
      'conditions' => $conditions_text_typing_cursor_enabled,
    ],
    [
      'keys' => [
        'value' => $k_pre . 'text_typing_cursor_color',
        'alt'   => $k_pre . 'text_typing_cursor_color_alt',
      ],
      'type'       => 'color',
      'label'      => cs_recall( 'label_color' ),
      'conditions' => $conditions_text_typing_cursor_enabled,
      'options'    => cs_recall( 'options_swatch_base_interaction_labels' ),
    ],
  ];


  // Compose Controls
  // ----------------

  $controls = [];

  $controls[] = [
    'type'       => 'group',
    'label_vars' => [ 'prefix' => $label_prefix ],
    'group'      => $group_text_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_text_setup,
    'options'    => [
      'vertical_label'   => '',
      'horizontal_label' => cs_recall( 'label_setup_with_prefix' ),
    ],
  ];

  if ( $type === 'standard' ) {
    $controls[] = [
      'type'       => 'group',
      'label_vars' => [ 'prefix' => $label_prefix ],
      'group'      => $group_text_columns,
      'controls'   => $control_list_text_text_columns,
      'options'    => [
        'vertical_label'   => '',
        'horizontal_label' => cs_recall( 'label_columns_with_prefix' ),
      ],
    ];
  }

  if ( $type === 'headline' ) {
    $controls[] = [
      'type'       => 'group',
      'group'      => $group_text_typing,
      'controls'   => $control_list_text_typing_setup,
      'conditions' => $conditions_text_typing_on,
      'options'    => [
        'vertical_label'   => '',
        'horizontal_label' => cs_recall( 'label_typing' ),
      ],
    ];
    $controls[] = $control_text_link;
  }

  $controls[] = [
    'type'       => 'group',
    'label_vars' => [ 'prefix' => $label_prefix ],
    'group'      => $group_text_size,
    'conditions' => $conditions,
    'controls'   => [
      $control_text_width,
      $control_text_max_width,
    ],
    'options' => [
      'vertical_label'   => '',
      'horizontal_label' => cs_recall( 'label_size_with_prefix' ),
    ],
  ];

  if ( $type === 'headline' ) {
    $controls[] = cs_control( 'flexbox', $k_pre . 'text', $settings_text_flexbox );
  }


  $controls[] = cs_control( 'margin', $k_pre . 'text', $settings_text_design );
  $controls[] = cs_control( 'padding', $k_pre . 'text', $settings_text_design );
  $controls[] = cs_control( 'border', $k_pre . 'text', $settings_text_design );
  $controls[] = cs_control( 'border-radius', $k_pre . 'text', $settings_text_design );
  $controls[] = cs_control( 'box-shadow', $k_pre . 'text', $settings_text_design );

  if ( $type === 'headline' ) {
    $controls[] = cs_control( 'margin', $k_pre . 'text_content', $settings_text_content_margin );
  }

  $controls[] = cs_control( 'text-format', $k_pre . 'text', $settings_text_text );
  $controls[] = cs_control( 'text-shadow', $k_pre . 'text', $settings_text_text );

  if ( $type === 'headline' ) {
    $controls[] = [
      'type'       => 'group',
      'label_vars' => [ 'prefix' => $label_prefix ],
      'group'      => $group_text_subheadline,
      'conditions' => $conditions_text_subheadline,
      'options'    => [
        'vertical_label'   => '',
        'horizontal_label' => cs_recall( 'label_subheadline_with_prefix' ),
      ],
      'controls' => [
        $control_text_subheadline_content,
        $control_text_subheadline_tag,
        $control_text_subheadline_spacing,
        $control_text_subheadline_reverse,
      ],
    ];
    $controls[] = cs_control( 'text-format', $k_pre . 'text_subheadline', $settings_text_subheadline_text );
    $controls[] = cs_control( 'text-shadow', $k_pre . 'text_subheadline', $settings_text_subheadline_text );
  }

  $text_controls = [
    'controls'    => $controls,
    'control_nav' => [
      $group                  => $group_title,
      $group_text_setup       => cs_recall( 'label_setup' ),
      $group_text_typing      => cs_recall( 'label_typing' ),
      $group_text_columns     => cs_recall( 'label_columns' ),
      $group_text_size        => cs_recall( 'label_size' ),
      $group_text_design      => cs_recall( 'label_design' ),
      $group_text_text        => cs_recall( 'label_text' ),
      $group_text_subheadline => cs_recall( 'label_subheadline' ),
    ]
  ];

  if ( $type === 'headline' ) {

    return cs_compose_controls(
      $text_controls,
      cs_partial_controls( 'graphic', [
        'k_pre'               => $k_pre . 'text',
        'group'               => $group_text_graphic,
        'conditions'          => $conditions,
        'has_alt'             => true,
        'has_interactions'    => true,
        'has_sourced_content' => false,
        'has_toggle'          => false,
      ] ),
      [
        'control_nav' => [
          $group_text_graphic => cs_recall( 'label_graphic' )
        ]
      ]
    );
  }

  return $text_controls;
}

cs_register_control_partial( 'text', 'x_control_partial_text' );
