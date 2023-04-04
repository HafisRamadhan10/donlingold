<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/PAGINATION.PHP
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

function x_control_partial_pagination( $settings ) {

  // Setup
  // -----
  // 01. Types available include...
  //     - 'comment'  : for paginating comments, can be numbered
  //     - 'post'     : for paginating posts on indexes, can be numbered
  //     - 'product'  : for paginating products on indexes, can be numbered
  //     - 'post-nav' : for navigating amongst posts while on single posts

  $type = ( isset( $settings['type'] ) ) ? $settings['type'] : 'post'; // 01


  // Groups
  // ------

  $group_pagination                 = 'pagination';
  $group_pagination_setup           = $group_pagination . ':setup';
  $group_pagination_size            = $group_pagination . ':size';
  $group_pagination_design          = $group_pagination . ':design';

  $group_pagination_items           = 'pagination_items';
  $group_pagination_items_setup     = $group_pagination_items . ':setup';
  $group_pagination_items_size      = $group_pagination_items . ':size';
  $group_pagination_items_design    = $group_pagination_items . ':design';
  $group_pagination_items_current   = $group_pagination_items . ':current';
  $group_pagination_items_dots      = $group_pagination_items . ':dots';
  $group_pagination_items_prev_next = $group_pagination_items . ':prevnext';


  // Conditions
  // ----------

  $condition_pagination_is_numbered              = [ 'key' => 'pagination_numbered_hide', 'op' => 'IN', 'value' => [ 'none', 'xs', 'sm', 'md', 'lg' ] ];
  $condition_pagination_items_type_text          = [ 'pagination_items_prev_next_type' => 'text' ];
  $condition_pagination_items_type_icon          = [ 'pagination_items_prev_next_type' => 'icon' ];
  $conditions_pagination_has_dots_overwrite      = [ $condition_pagination_is_numbered, [ 'pagination_dots' => true ] ];
  $conditions_pagination_has_prev_next_overwrite = [ $condition_pagination_is_numbered, [ 'pagination_prev_next' => true ] ];


  // Options
  // -------

  $options_pagination_end_and_mid_size = [
    'unit_mode'      => 'unitless',
    'fallback_value' => 1,
    'min'            => 0,
    'max'            => 5,
    'step'           => 1,
  ];

  $options_pagination_flex_justify = [
    'choices' => [
      [ 'value' => 'flex-start',    'label' => cs_recall( 'label_start' )         ],
      [ 'value' => 'center',        'label' => cs_recall( 'label_center' )        ],
      [ 'value' => 'flex-end',      'label' => cs_recall( 'label_end' )           ],
      [ 'value' => 'space-between', 'label' => cs_recall( 'label_space_between' ) ],
      [ 'value' => 'space-around',  'label' => cs_recall( 'label_space_around' )  ],
      [ 'value' => 'space-evenly',  'label' => cs_recall( 'label_space_evenly' )  ],
    ],
  ];

  $options_pagination_items_prev_next_type = [
    'choices' => [
      [ 'value' => 'icon', 'label' => cs_recall( 'label_icon' ) ],
      [ 'value' => 'text', 'label' => cs_recall( 'label_text' ) ],
    ],
  ];

  $options_pagination_items_gap = [
    'available_units' => [ 'px', 'em', 'rem' ],
    'valid_keywords'  => [ 'calc' ],
    'fallback_value'  => '0px',
    'ranges'          => [
      'px'  => [ 'min' => 0, 'max' => 10, 'step' => 1   ],
      'em'  => [ 'min' => 0, 'max' => 1,  'step' => 0.1 ],
      'rem' => [ 'min' => 0, 'max' => 1,  'step' => 0.1 ],
    ],
  ];


  // Settings
  // --------

  $settings_pagination_design = [
    'group' => $group_pagination_design,
  ];

  $settings_pagination_items_text = [
    'group'              => $group_pagination_items,
    'label_prefix'       => cs_recall( 'label_items' ),
    'no_letter_spacing'  => true,
    'no_line_height'     => true,
    'no_text_align'      => true,
    'no_text_decoration' => true,
    'no_text_transform'  => true,
    'no_text_color'      => true,
    'alt_color'          => true,
    'options'            => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  ];

  $settings_pagination_items_design = [
    'group'        => $group_pagination_items_design,
    'label_prefix' => cs_recall( 'label_items' ),
  ];

  $settings_pagination_items_design_color = [
    'group'        => $group_pagination_items_design,
    'label_prefix' => cs_recall( 'label_items' ),
    'alt_color'    => true,
    'options'      => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  ];


  // Individual Controls (Base)
  // --------------------------

  $control_pagination_base_font_size = cs_recall( 'control_mixin_font_size', [ 'key' => 'pagination_base_font_size' ] );

  $control_pagination_numbered_hide = [
    'key'     => 'pagination_numbered_hide',
    'type'    => 'choose-breakpoint',
    'description' => __( 'Numbers will be hidden on the selected screen size and smaller', 'cornerstone' ),
    'label'   => cs_recall( 'label_breakpoint_to_hide_numbers' )
  ];

  $control_pagination_numbered_end_size = [
    'key'     => 'pagination_numbered_end_size',
    'type'    => 'unit',
    'label'   => cs_recall( 'label_end_number_count' ),
    'options' => $options_pagination_end_and_mid_size,
  ];

  $control_pagination_numbered_mid_size = [
    'key'     => 'pagination_numbered_mid_size',
    'type'    => 'unit',
    'label'   => cs_recall( 'label_mid_number_count' ),
    'options' => $options_pagination_end_and_mid_size,
  ];

  $control_pagination_numbered_end_and_mid_size = [
    'type'      => 'group',
    'label'     => cs_recall( 'label_end_and_mid_number_count' ),
    'condition' => $condition_pagination_is_numbered,
    'controls'  => [
      $control_pagination_numbered_end_size,
      $control_pagination_numbered_mid_size,
    ],
  ];

  $control_pagination_flex_justify = [
    'key'     => 'pagination_flex_justify',
    'type'    => 'select',
    'label'   => cs_recall( 'label_justify' ),
    'options' => $options_pagination_flex_justify,
  ];

  $control_pagination_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'pagination_bg_color' ] ] );


  // Individual Controls (Size)
  // --------------------------

  $control_pagination_width     = cs_recall( 'control_mixin_width',     [ 'key' => 'pagination_width'     ] );
  $control_pagination_max_width = cs_recall( 'control_mixin_max_width', [ 'key' => 'pagination_max_width' ] );


  // Individual Controls (Items)
  // ---------------------------

  $control_pagination_items_prev_next_type = [
    'key'     => 'pagination_items_prev_next_type',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_prev_next_type' ),
    'options' => $options_pagination_items_prev_next_type,
  ];

  $control_pagination_items_prev_icon = [
    'key'       => 'pagination_items_prev_icon',
    'type'      => 'icon',
    'label'     => cs_recall( 'label_previous' ),
    'condition' => $condition_pagination_items_type_icon,
  ];

  $control_pagination_items_next_icon = [
    'key'       => 'pagination_items_next_icon',
    'type'      => 'icon',
    'label'     => cs_recall( 'label_next' ),
    'condition' => $condition_pagination_items_type_icon,
  ];

  $control_pagination_items_prev_next_icon = [
    'type'      => 'group',
    'label'     => cs_recall( 'label_prev_next_icons' ),
    'condition' => $condition_pagination_items_type_icon,
    'controls'  => [
      $control_pagination_items_prev_icon,
      $control_pagination_items_next_icon,
    ],
  ];

  $control_pagination_items_prev_text = [
    'key'       => 'pagination_items_prev_text',
    'type'      => 'text',
    'label'     => cs_recall( 'label_previous' ),
    'condition' => $condition_pagination_items_type_text,
  ];

  $control_pagination_items_next_text = [
    'key'       => 'pagination_items_next_text',
    'type'      => 'text',
    'label'     => cs_recall( 'label_next' ),
    'condition' => $condition_pagination_items_type_text,
  ];

  $control_pagination_items_prev_next_text = [
    'type'      => 'group',
    'label'     => cs_recall( 'label_prev_next_text' ),
    'condition' => $condition_pagination_items_type_text,
    'controls'  => [
      $control_pagination_items_prev_text,
      $control_pagination_items_next_text,
    ],
  ];

  $control_pagination_items_gap = cs_recall( 'control_mixin_gap', [ 'key' => 'pagination_items_gap' ] );

  $control_pagination_items_grow = [
    'key'     => 'pagination_items_grow',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_fill_space' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  ];

  $control_pagination_items_colors    = cs_recall( 'control_mixin_color_int',    [ 'keys' => [ 'value' => 'pagination_items_text_color', 'alt' => 'pagination_items_text_color_alt' ] ] );
  $control_pagination_items_bg_colors = cs_recall( 'control_mixin_bg_color_int', [ 'keys' => [ 'value' => 'pagination_items_bg_color', 'alt' => 'pagination_items_bg_color_alt' ]     ] );

  $control_pagination_color_custom_colors = [
    'keys' => [
      'dots'      => 'pagination_dots',
      'prev_next' => 'pagination_prev_next',
    ],
    'type'      => 'checkbox-list',
    'label'     => cs_recall( 'label_custom_colors' ),
    'condition' => $condition_pagination_is_numbered,
    'options'   => [
      'list' => [
        [ 'key' => 'dots',      'label' => cs_recall( 'label_dots' )      ],
        [ 'key' => 'prev_next', 'label' => cs_recall( 'label_prev_next' ) ],
      ],
    ],
  ];


  // Individual Controls (Items Size)
  // --------------------------------

  $control_pagination_items_min_width  = cs_recall( 'control_mixin_min_width',  [ 'key' => 'pagination_items_min_width'  ] );
  $control_pagination_items_min_height = cs_recall( 'control_mixin_min_height', [ 'key' => 'pagination_items_min_height' ] );


  // Individual Controls (Current)
  // -----------------------------

  $control_pagination_current_text_color       = cs_recall( 'control_mixin_color_solo',    [ 'keys' => [ 'value' => 'pagination_current_text_color' ], 'label' => cs_recall( 'label_text' )             ] );
  $control_pagination_current_border_color     = cs_recall( 'control_mixin_color_solo',    [ 'keys' => [ 'value' => 'pagination_current_border_color' ], 'label' => cs_recall( 'label_border' )         ] );
  $control_pagination_current_box_shadow_color = cs_recall( 'control_mixin_color_solo',    [ 'keys' => [ 'value' => 'pagination_current_box_shadow_color' ], 'label' => cs_recall( 'label_box_shadow' ) ] );
  $control_pagination_current_bg_color         = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'pagination_current_bg_color' ]                                                     ] );


  // Individual Controls (Dots)
  // --------------------------

  $control_pagination_dots_text_color       = cs_recall( 'control_mixin_color_solo',    [ 'keys' => [ 'value' => 'pagination_dots_text_color' ], 'label' => cs_recall( 'label_text' )             ] );
  $control_pagination_dots_border_color     = cs_recall( 'control_mixin_color_solo',    [ 'keys' => [ 'value' => 'pagination_dots_border_color' ], 'label' => cs_recall( 'label_border' )         ] );
  $control_pagination_dots_box_shadow_color = cs_recall( 'control_mixin_color_solo',    [ 'keys' => [ 'value' => 'pagination_dots_box_shadow_color' ], 'label' => cs_recall( 'label_box_shadow' ) ] );
  $control_pagination_dots_bg_color         = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'pagination_dots_bg_color' ]                                                     ] );


  // Individual Controls (Prev / Next)
  // ---------------------------------

  $control_pagination_prev_next_text_color       = cs_recall( 'control_mixin_color_int',    [ 'keys' => [ 'value' => 'pagination_prev_next_text_color', 'alt' => 'pagination_prev_next_text_color_alt' ], 'label' => cs_recall( 'label_text' )                   ] );
  $control_pagination_prev_next_border_color     = cs_recall( 'control_mixin_color_int',    [ 'keys' => [ 'value' => 'pagination_prev_next_border_color', 'alt' => 'pagination_prev_next_border_color_alt' ], 'label' => cs_recall( 'label_border' )             ] );
  $control_pagination_prev_next_box_shadow_color = cs_recall( 'control_mixin_color_int',    [ 'keys' => [ 'value' => 'pagination_prev_next_box_shadow_color', 'alt' => 'pagination_prev_next_box_shadow_color_alt' ], 'label' => cs_recall( 'label_box_shadow' ) ] );
  $control_pagination_prev_next_bg_color         = cs_recall( 'control_mixin_bg_color_int', [ 'keys' => [ 'value' => 'pagination_prev_next_bg_color', 'alt' => 'pagination_prev_next_bg_color_alt' ]                                                             ] );


  // Compose Controls
  // ----------------

  $controls_pagination_setup = [
    $control_pagination_base_font_size
  ];

  if ( $type !== 'post-nav' ) {
    $controls_pagination_setup[] = $control_pagination_numbered_hide;
    $controls_pagination_setup[] = $control_pagination_numbered_end_and_mid_size;
  }

  $controls_pagination_setup[] = $control_pagination_flex_justify;
  $controls_pagination_setup[] = $control_pagination_bg_color;

  return [

    'controls' => [
      [
        'type'     => 'group',
        'group'    => $group_pagination_setup,
        'controls' => $controls_pagination_setup,
      ],
      [
        'type'     => 'group',
        'group'    => $group_pagination_size,
        'controls' => [
          $control_pagination_width,
          $control_pagination_max_width,
        ],
      ],
      cs_control( 'margin',        'pagination', $settings_pagination_design ),
      cs_control( 'padding',       'pagination', $settings_pagination_design ),
      cs_control( 'border',        'pagination', $settings_pagination_design ),
      cs_control( 'border-radius', 'pagination', $settings_pagination_design ),
      cs_control( 'box-shadow',    'pagination', $settings_pagination_design ),
      [
        'type'     => 'group',
        'group'    => $group_pagination_items_setup,
        'controls' => [
          $control_pagination_items_prev_next_type,
          $control_pagination_items_prev_next_icon,
          $control_pagination_items_prev_next_text,
          $control_pagination_items_gap,
          $control_pagination_items_grow,
          $control_pagination_items_colors,
          $control_pagination_items_bg_colors,
          $control_pagination_color_custom_colors,
        ],
      ],
      [
        'type'     => 'group',
        'group'    => $group_pagination_items_size,
        'controls' => [
          $control_pagination_items_min_width,
          $control_pagination_items_min_height,
        ],
      ],
      cs_control( 'padding',       'pagination_items', $settings_pagination_items_design       ),
      cs_control( 'border',        'pagination_items', $settings_pagination_items_design_color ),
      cs_control( 'border-radius', 'pagination_items', $settings_pagination_items_design       ),
      cs_control( 'box-shadow',    'pagination_items', $settings_pagination_items_design_color ),
      cs_control( 'text-format',   'pagination_items', $settings_pagination_items_text         ),
      [
        'type'      => 'group',
        'group'     => $group_pagination_items_current,
        'condition' => $condition_pagination_is_numbered,
        'controls'  => [
          $control_pagination_current_text_color,
          $control_pagination_current_border_color,
          $control_pagination_current_box_shadow_color,
          $control_pagination_current_bg_color,
        ],
      ],
      [
        'type'       => 'group',
        'group'      => $group_pagination_items_dots,
        'conditions' => $conditions_pagination_has_dots_overwrite,
        'controls'   => [
          $control_pagination_dots_text_color,
          $control_pagination_dots_border_color,
          $control_pagination_dots_box_shadow_color,
          $control_pagination_dots_bg_color,
        ],
      ],
      [
        'type'       => 'group',
        'group'      => $group_pagination_items_prev_next,
        'conditions' => $conditions_pagination_has_prev_next_overwrite,
        'controls'   => [
          $control_pagination_prev_next_text_color,
          $control_pagination_prev_next_border_color,
          $control_pagination_prev_next_box_shadow_color,
          $control_pagination_prev_next_bg_color,
        ],
      ],
    ],
    'control_nav' => [
      $group_pagination                 => cs_recall( 'label_pagination' ),
      $group_pagination_setup           => cs_recall( 'label_setup' ),
      $group_pagination_size            => cs_recall( 'label_size' ),
      $group_pagination_design          => cs_recall( 'label_design' ),

      $group_pagination_items           => cs_recall( 'label_items' ),
      $group_pagination_items_setup     => cs_recall( 'label_setup' ),
      $group_pagination_items_size      => cs_recall( 'label_size' ),
      $group_pagination_items_design    => cs_recall( 'label_design' ),
      $group_pagination_items_current   => cs_recall( 'label_current' ),
      $group_pagination_items_dots      => cs_recall( 'label_dots' ),
      $group_pagination_items_prev_next => cs_recall( 'label_prev_next' ),
    ],

  ];

}

cs_register_control_partial( 'pagination', 'x_control_partial_pagination' );
