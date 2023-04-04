<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/ANCHOR.PHP
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

function x_control_partial_anchor( $settings ) {

  // Setup
  // -----
  // 01. Available types:
  //     -- 'button'
  //     -- 'menu-item'
  //     -- 'toggle'

  $label_prefix             = ( isset( $settings['label_prefix'] )             ) ? $settings['label_prefix']             : '';
  $k_pre                    = ( isset( $settings['k_pre'] )                    ) ? $settings['k_pre'] . '_'              : '';
  $group                    = ( isset( $settings['group'] )                    ) ? $settings['group']                    : 'anchor';
  $group_title              = ( isset( $settings['group_title'] )              ) ? $settings['group_title']              : cs_recall( 'label_menu_item' );
  $conditions               = ( isset( $settings['conditions'] )               ) ? $settings['conditions']               : [];
  $type                     = ( isset( $settings['type'] )                     ) ? $settings['type']                     : 'menu-item'; // 01
  $has_template             = ( isset( $settings['has_template'] )             ) ? $settings['has_template']             : true;
  $has_link_control         = ( isset( $settings['has_link_control'] )         ) ? $settings['has_link_control']         : false;
  $has_share_control        = ( isset( $settings['has_share_control'] )        ) ? $settings['has_share_control']        : false;
  $has_interactive_content  = ( isset( $settings['has_interactive_content'] )  ) ? $settings['has_interactive_content']  : false;
  $add_custom_atts          = ( isset( $settings['add_custom_atts'] )          ) ? $settings['add_custom_atts']          : false;
  $label_prefix_custom_atts = ( isset( $settings['label_prefix_custom_atts'] ) ) ? $settings['label_prefix_custom_atts'] : cs_recall( 'label_toggle' );


  // Groups
  // ------

  $group_anchor_setup               = $group . ':setup';
  $group_anchor_size                = $group . ':size';
  $group_anchor_design              = $group . ':design';
  $group_anchor_text                = $group . ':text';
  $group_anchor_primary             = $group . ':primary';
  $group_anchor_secondary           = $group . ':secondary';
  $group_anchor_graphic             = $group . ':graphic';
  $group_anchor_interactive_content = $group . ':interactive_content';
  $group_anchor_sub_indicator       = $group . ':sub_indicator';
  $group_anchor_particles           = $group . ':particles';


  // Conditions
  // ----------

  $conditions_anchor_text                                = array_merge( $conditions, [ [ $k_pre . 'anchor_text' => true ] ] );
  $conditions_anchor_sub_indicator                       = array_merge( $conditions, [ [ $k_pre . 'anchor_sub_indicator' => true ] ] );
  $conditions_anchor_interactive_content                 = array_merge( $conditions, [ [ $k_pre . 'anchor_interactive_content' => true ] ] );
  $conditions_anchor_interactive_content_icons           = array_merge( $conditions, [ [ $k_pre . 'anchor_interactive_content' => true ], [ $k_pre . 'anchor_graphic' => true ], [ $k_pre . 'anchor_graphic_type' => 'icon' ] ] );
  $conditions_anchor_interactive_content_secondary_icon  = array_merge( $conditions, [ [ $k_pre . 'anchor_interactive_content' => true ], [ $k_pre . 'anchor_graphic' => true ], [ $k_pre . 'anchor_graphic_type' => 'icon' ], [ $k_pre . 'anchor_graphic_icon_alt_enable' => true ] ] );
  $conditions_anchor_interactive_content_images          = array_merge( $conditions, [ [ $k_pre . 'anchor_interactive_content' => true ], [ $k_pre . 'anchor_graphic' => true ], [ $k_pre . 'anchor_graphic_type' => 'image' ] ] );
  $conditions_anchor_interactive_content_secondary_image = array_merge( $conditions, [ [ $k_pre . 'anchor_interactive_content' => true ], [ $k_pre . 'anchor_graphic' => true ], [ $k_pre . 'anchor_graphic_type' => 'image' ], [ $k_pre . 'anchor_graphic_image_alt_enable' => true ] ] );

  if ( $has_interactive_content ) {
    $conditions_anchor_primary_text    = array_merge( $conditions, [ [ $k_pre . 'anchor_text' => true ], [ 'key' => $k_pre . 'anchor_text_primary_content', 'op' => 'NOT IN', 'value' => [ '' ] ], [ 'key' => $k_pre . 'anchor_interactive_content_text_primary_content', 'op' => 'NOT IN', 'value' => [ '' ], 'or' => true ] ] );
    $conditions_anchor_secondary_text  = array_merge( $conditions, [ [ $k_pre . 'anchor_text' => true ], [ 'key' => $k_pre . 'anchor_text_secondary_content', 'op' => 'NOT IN', 'value' => [ '' ] ], [ 'key' => $k_pre . 'anchor_interactive_content_text_secondary_content', 'op' => 'NOT IN', 'value' => [ '' ], 'or' => true ] ] );
  } else {
    $conditions_anchor_primary_text    = array_merge( $conditions, [ [ $k_pre . 'anchor_text' => true ], [ 'key' => $k_pre . 'anchor_text_primary_content', 'op' => 'NOT IN', 'value' => [ '' ] ] ] );
    $conditions_anchor_secondary_text  = array_merge( $conditions, [ [ $k_pre . 'anchor_text' => true ], [ 'key' => $k_pre . 'anchor_text_secondary_content', 'op' => 'NOT IN', 'value' => [ '' ] ] ] );
  }


  // Options
  // -------

  $options_anchor_text_content = [
    'placeholder' => cs_recall( 'label_no_output_if_empty' )
  ];

  $options_anchor_text_spacing = [
    'available_units' => [ 'px', 'em', 'rem' ],
    'fallback_value'  => '5px',
  ];

  $options_anchor_interactions = [
    'choices' => [
      [ 'value' => 'none',                  'label' => cs_recall( 'label_none' )         ],
      [ 'value' => 'x-anchor-slide-top',    'label' => cs_recall( 'label_slide_top' )    ],
      [ 'value' => 'x-anchor-slide-left',   'label' => cs_recall( 'label_slide_left' )   ],
      [ 'value' => 'x-anchor-slide-right',  'label' => cs_recall( 'label_slide_right' )  ],
      [ 'value' => 'x-anchor-slide-bottom', 'label' => cs_recall( 'label_slide_bottom' ) ],
      [ 'value' => 'x-anchor-scale-up',     'label' => cs_recall( 'label_scale_up' )     ],
      [ 'value' => 'x-anchor-scale-down',   'label' => cs_recall( 'label_scale_down' )   ],
      [ 'value' => 'x-anchor-flip-x',       'label' => cs_recall( 'label_flip_x' )       ],
      [ 'value' => 'x-anchor-flip-y',       'label' => cs_recall( 'label_flip_y' )       ],
    ],
  ];

  $options_anchor_interactive_content_interactions = [
    'choices' => [
      [ 'value' => 'x-anchor-content-out-slide-top-in-scale-up',    'label' => cs_recall( 'label_slide_top_scale_up' )    ],
      [ 'value' => 'x-anchor-content-out-slide-left-in-scale-up',   'label' => cs_recall( 'label_slide_left_scale_up' )   ],
      [ 'value' => 'x-anchor-content-out-slide-right-in-scale-up',  'label' => cs_recall( 'label_slide_right_scale_up' )  ],
      [ 'value' => 'x-anchor-content-out-slide-bottom-in-scale-up', 'label' => cs_recall( 'label_slide_bottom_scale_up' ) ],
    ],
  ];

  $options_anchor_sub_indicator_font_size = [
    'available_units' => [ 'px', 'em', 'rem' ],
    'fallback_value'  => '1em',
  ];

  $options_anchor_sub_indicator_width_and_height = [
    'available_units' => [ 'px', 'em', 'rem' ],
    'fallback_value'  => '1em',
    'valid_keywords'  => [ 'auto' ],
  ];


  // Settings
  // --------

  $settings_anchor_design = [
    'label_prefix' => $label_prefix,
    'group'        => $group_anchor_design,
    'conditions'   => $conditions,
    'alt_color'    => true,
    'options'      => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  ];

  $settings_anchor_primary_text = [
    'label_prefix' => sprintf( cs_recall( 'label_primary_with_sprintf_prefix' ), $label_prefix ),
    'group'        => $group_anchor_primary,
    'conditions'   => $conditions_anchor_primary_text,
    'alt_color'    => true,
    'options'      => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  ];

  $settings_anchor_secondary_text = [
    'label_prefix' => sprintf( cs_recall( 'label_secondary_with_sprintf_prefix' ), $label_prefix ),
    'group'        => $group_anchor_secondary,
    'conditions'   => $conditions_anchor_secondary_text,
    'alt_color'    => true,
    'options'      => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  ];


  // Anchor Options Keys
  // -------------------
  // 01.

  $keys_anchor_options = [
    'text'    => $k_pre . 'anchor_text',
    'graphic' => $k_pre . 'anchor_graphic',
  ];

  if ( $has_interactive_content ) {
    $keys_anchor_options['interactive_content'] = $k_pre . 'anchor_interactive_content';
  }

  if ( $type === 'menu-item' ) {
    $keys_anchor_options['sub_indicator'] = $k_pre . 'anchor_sub_indicator';
  }


  // Anchor Options Keys List
  // ------------------------

  $list_anchor_options = [
    [ 'key' => 'text',    'label' => cs_recall( 'label_text' )    ],
    [ 'key' => 'graphic', 'label' => cs_recall( 'label_graphic' ) ],
  ];

  if ( $has_interactive_content ) {
    $list_anchor_options[] = [ 'key' => 'interactive_content', 'label' => cs_recall( 'label_int_content' ) ];
  }

  if ( $type === 'menu-item' ) {
    $list_anchor_options[] = [ 'key' => 'sub_indicator', 'label' => cs_recall( 'label_sub_indicator' ) ];
  }


  // Individual Controls - Setup
  // ---------------------------

  $control_anchor_base_font_size = cs_recall( 'control_mixin_font_size',    [ 'key' => $k_pre . 'anchor_base_font_size'                                                              ] );
  $control_anchor_options        = [
    'keys'    => $keys_anchor_options,
    'type'    => 'checkbox-list',
    'label'   => cs_recall( 'label_options' ),
    'options' => [
      'list' => $list_anchor_options
    ],
  ];
  $control_anchor_bg_colors      = cs_recall( 'control_mixin_bg_color_int', [ 'keys' => [ 'value' => $k_pre . 'anchor_bg_color', 'alt' => $k_pre . 'anchor_bg_color_alt' ]           ] );
  $control_anchor_transition     = cs_recall( 'control_mixin_transition',   [ 'keys' => [ 'duration' => $k_pre . 'anchor_duration', 'timing'  => $k_pre . 'anchor_timing_function' ] ] );


  // Individual Controls - Link
  // --------------------------

  $control_anchor_link = [
    'keys' => [
      'url'      => $k_pre . 'anchor_href',
      'has_info' => $k_pre . 'anchor_info',
      'new_tab'  => $k_pre . 'anchor_blank',
      'nofollow' => $k_pre . 'anchor_nofollow'
    ],
    'type'       => 'link',
    'label'      => cs_recall( 'label_link_with_prefix' ),
    'label_vars' => [ 'prefix' => $label_prefix ],
    'group'      => $group_anchor_setup,
    'conditions' => $conditions,
  ];


  // Individual Controls - Share
  // ---------------------------

  $control_anchor_share = [
    'keys' => [
      'url'           => $k_pre . 'anchor_href',
      'share_enabled' => $k_pre . 'anchor_share_enabled',
      'share_type'    => $k_pre . 'anchor_share_type',
      'share_title'   => $k_pre . 'anchor_share_title',
      'has_info'      => $k_pre . 'anchor_info',
      'new_tab'       => $k_pre . 'anchor_blank',
      'nofollow'      => $k_pre . 'anchor_nofollow'
    ],
    'type'       => 'share',
    'label'      => cs_recall( 'label_behavior_with_prefix' ),
    'label_vars' => [ 'prefix' => $label_prefix ],
    'group'      => $group_anchor_setup,
    'conditions' => $conditions,
  ];


  // Individual Controls - Size
  // --------------------------

  $control_anchor_width      = cs_recall( 'control_mixin_width',      [ 'key' => $k_pre . 'anchor_width'      ] );
  $control_anchor_min_width  = cs_recall( 'control_mixin_min_width',  [ 'key' => $k_pre . 'anchor_min_width'  ] );
  $control_anchor_max_width  = cs_recall( 'control_mixin_max_width',  [ 'key' => $k_pre . 'anchor_max_width'  ] );
  $control_anchor_height     = cs_recall( 'control_mixin_height',     [ 'key' => $k_pre . 'anchor_height'     ] );
  $control_anchor_min_height = cs_recall( 'control_mixin_min_height', [ 'key' => $k_pre . 'anchor_min_height' ] );
  $control_anchor_max_height = cs_recall( 'control_mixin_max_height', [ 'key' => $k_pre . 'anchor_max_height' ] );


  // Controls - Text
  // ---------------

  $control_anchor_text_content_local_primary = [
    'key'        => $k_pre . 'anchor_text_primary_content',
    'type'       => 'text',
    'label'      => cs_recall( 'label_primary' ),
    'conditions' => $conditions_anchor_text,
    'options'    => $options_anchor_text_content,
  ];

  $control_anchor_text_content_local_secondary = [
    'key'        => $k_pre . 'anchor_text_secondary_content',
    'type'       => 'text',
    'label'      => cs_recall( 'label_secondary' ),
    'conditions' => $conditions_anchor_text,
    'options'    => $options_anchor_text_content,
  ];

  $control_anchor_text_content_sourced_primary = [
    'key'        => $k_pre . 'anchor_text_primary_content',
    'type'       => 'choose',
    'label'      => cs_recall( 'label_primary' ),
    'conditions' => $conditions_anchor_text,
    'options'    => cs_recall( 'options_choices_off_on_string' ),
  ];

  $control_anchor_text_content_sourced_secondary = [
    'key'        => $k_pre . 'anchor_text_secondary_content',
    'type'       => 'choose',
    'label'      => cs_recall( 'label_secondary' ),
    'conditions' => $conditions_anchor_text,
    'options'    => cs_recall( 'options_choices_off_on_string' ),
  ];

  $control_anchor_text_spacing = [
    'key'        => $k_pre . 'anchor_text_spacing',
    'type'       => 'unit-slider',
    'label'      => cs_recall( 'label_spacing' ),
    'conditions' => $conditions_anchor_secondary_text,
    'options'    => $options_anchor_text_spacing,
  ];

  $control_anchor_text_order = [
    'key'        => $k_pre . 'anchor_text_reverse',
    'type'       => 'choose',
    'label'      => cs_recall( 'label_placement' ),
    'conditions' => $conditions_anchor_secondary_text,
    'options'    => cs_recall( 'options_choices_before_after' ),
  ];

  $control_anchor_text_interaction = [
    'key'     => $k_pre . 'anchor_text_interaction',
    'type'    => 'select',
    'label'   => cs_recall( 'label_interaction' ),
    'options' => $options_anchor_interactions,
  ];

  $control_anchor_text_overflow = cs_recall( 'control_mixin_text_overflow', [ 'key' => $k_pre . 'anchor_text_overflow' ] );


  // Controls - Interactive Content
  // ------------------------------

  $control_anchor_interactive_content_text_primary_content = [
    'key'        => $k_pre . 'anchor_interactive_content_text_primary_content',
    'type'       => 'text',
    'label'      => cs_recall( 'label_primary' ),
    'conditions' => $conditions_anchor_interactive_content,
    'options'    => $options_anchor_text_content,
  ];

  $control_anchor_interactive_content_text_secondary_content = [
    'key'        => $k_pre . 'anchor_interactive_content_text_secondary_content',
    'type'       => 'text',
    'label'      => cs_recall( 'label_secondary' ),
    'conditions' => $conditions_anchor_interactive_content,
    'options'    => $options_anchor_text_content,
  ];

  $control_anchor_interactive_content_interaction = [
    'key'        => $k_pre . 'anchor_interactive_content_interaction',
    'type'       => 'select',
    'label'      => cs_recall( 'label_interaction' ),
    'conditions' => $conditions_anchor_interactive_content,
    'options'    => $options_anchor_interactive_content_interactions,
  ];


  // Controls - Interactive Content (Graphic Icon)
  // ---------------------------------------------

  $control_anchor_interactive_content_graphic_icon = [
    'key'        => $k_pre . 'anchor_interactive_content_graphic_icon',
    'type'       => 'icon',
    'group'      => $group,
    'label'      => cs_recall( 'label_icon' ),
    'conditions' => $conditions_anchor_interactive_content_icons,
    'options'    => [ 'label' => cs_recall( 'label_select' ) ],
  ];

  $control_anchor_interactive_content_graphic_icon_alt = [
    'key'        => $k_pre . 'anchor_interactive_content_graphic_icon_alt',
    'type'       => 'icon',
    'group'      => $group,
    'label'      => cs_recall( 'label_nbsp' ),
    'conditions' => $conditions_anchor_interactive_content_secondary_icon,
    'options'    => [ 'label' => cs_recall( 'label_select' ) ],
  ];


  // Controls - Interactive Content (Graphic Image)
  // ----------------------------------------------

  $control_anchor_interactive_content_graphic_image = [
    'key'     => $k_pre . 'anchor_interactive_content_graphic_image_src',
    'type'    => 'image-source',
    'label'   => cs_recall( 'label_source' ),
    'options' => [
      'height' => 4,
    ],
  ];

  $control_anchor_interactive_content_graphic_image_alt_text = [
    'key'     => $k_pre . 'anchor_interactive_content_graphic_image_alt',
    'type'    => 'text',
    'label'   => cs_recall( 'label_alt_text' ),
    'options' => [
      'placeholder' => cs_recall( 'label_describe_your_image' ),
    ],
  ];

  $control_anchor_interactive_content_graphic_image_alt = [
    'key'     => $k_pre . 'anchor_interactive_content_graphic_image_src_alt',
    'type'    => 'image-source',
    'label'   => cs_recall( 'label_source' ),
    'options' => [
      'height' => 4,
    ],
  ];

  $control_anchor_interactive_content_graphic_image_alt_text_alt = [
    'key'     => $k_pre . 'anchor_interactive_content_graphic_image_alt_alt',
    'type'    => 'text',
    'label'   => cs_recall( 'label_alt_text' ),
    'options' => [
      'placeholder' => cs_recall( 'label_describe_your_image' ),
    ],
  ];


  // Controls - Sub Indicator
  // ------------------------

  $control_anchor_sub_indicator_font_size = [
    'key'        => $k_pre . 'anchor_sub_indicator_font_size',
    'type'       => 'unit-slider',
    'label'      => cs_recall( 'label_size' ),
    'conditions' => $conditions_anchor_sub_indicator,
    'options'    => $options_anchor_sub_indicator_font_size,
  ];

  $control_anchor_sub_indicator_width = [
    'key'     => $k_pre . 'anchor_sub_indicator_width',
    'type'    => 'unit-slider',
    'label'   => cs_recall( 'label_width' ),
    'options' => $options_anchor_sub_indicator_width_and_height,
  ];

  $control_anchor_sub_indicator_height = [
    'key'     => $k_pre . 'anchor_sub_indicator_height',
    'type'    => 'unit-slider',
    'label'   => cs_recall( 'label_height' ),
    'options' => $options_anchor_sub_indicator_width_and_height,
  ];

  $control_anchor_sub_indicator_icon = [
    'key'        => $k_pre . 'anchor_sub_indicator_icon',
    'type'       => 'icon',
    'label'      => cs_recall( 'label_icon' ),
    'conditions' => $conditions_anchor_sub_indicator,
  ];

  $control_anchor_sub_indicator_colors = [
    'keys' => [
      'value' => $k_pre . 'anchor_sub_indicator_color',
      'alt'   => $k_pre . 'anchor_sub_indicator_color_alt',
    ],
    'type'       => 'color',
    'label'      => cs_recall( 'label_color' ),
    'conditions' => $conditions_anchor_sub_indicator,
    'options'    => cs_recall( 'options_swatch_base_interaction_labels' ),
  ];


  // Control List - Setup
  // --------------------

  $control_list_anchor_setup = [
    $control_anchor_base_font_size,
    $control_anchor_options,
    $control_anchor_bg_colors,
  ];

  if ( $type === 'menu-item' ) {
    $control_list_anchor_setup[] = $control_anchor_transition;
  }


  // Control List - Text Setup
  // -------------------------

  $control_list_anchor_text_setup = [];

  if ( $type !== 'menu-item' ) {
    $control_list_anchor_text_setup[] = $control_anchor_text_content_local_primary;
    $control_list_anchor_text_setup[] = $control_anchor_text_content_local_secondary;
  } else if ( $type === 'menu-item' ) {
    $control_list_anchor_text_setup[] = $control_anchor_text_content_sourced_primary;
    $control_list_anchor_text_setup[] = $control_anchor_text_content_sourced_secondary;
  }

  $control_list_anchor_text_setup[] = $control_anchor_text_spacing;
  $control_list_anchor_text_setup[] = $control_anchor_text_order;
  $control_list_anchor_text_setup[] = $control_anchor_text_interaction;
  $control_list_anchor_text_setup[] = $control_anchor_text_overflow;


  // Control Groups
  // --------------

  $control_group_anchor_setup = [
    [
      'type'       => 'group',
      'label_vars' => [ 'prefix' => $label_prefix ],
      'group'      => $group_anchor_setup,
      'conditions' => $conditions,
      'controls'   => $control_list_anchor_setup,
      'options'    => [
        'vertical_label'   => '',
        'horizontal_label' => cs_recall( 'label_setup_with_prefix' ),
      ],
    ],
  ];

  $control_group_anchor_size = [
    'type'       => 'group',
    'label_vars' => [ 'prefix' => $label_prefix ],
    'group'      => $group_anchor_size,
    'conditions' => $conditions,
    'controls'   => [
      $control_anchor_width,
      $control_anchor_min_width,
      $control_anchor_max_width,
      $control_anchor_height,
      $control_anchor_min_height,
      $control_anchor_max_height,
    ],
    'options' => [
      'vertical_label'   => '',
      'horizontal_label' => cs_recall( 'label_size_with_prefix' ),
    ],
  ];

  $control_group_anchor_text_setup = [
    [
      'type'       => 'group',
      'label_vars' => [ 'prefix' => $label_prefix ],
      'group'      => $group_anchor_text,
      'controls'   => $control_list_anchor_text_setup,
      'conditions' => $conditions_anchor_text,
      'options'    => [
        'vertical_label'   => '',
        'horizontal_label' => cs_recall( 'label_text_setup_with_prefix' ),
      ],
    ],
  ];

  $control_group_anchor_interactive_content_setup = [
    [
      'type'       => 'group',
      'label_vars' => [ 'prefix' => $label_prefix ],
      'group'      => $group_anchor_interactive_content,
      'conditions' => $conditions_anchor_interactive_content,
      'controls'   => [
        $control_anchor_interactive_content_text_primary_content,
        $control_anchor_interactive_content_text_secondary_content,
        $control_anchor_interactive_content_graphic_icon,
        $control_anchor_interactive_content_graphic_icon_alt,
        $control_anchor_interactive_content_interaction,
      ],
      'options' => [
        'vertical_label'   => '',
        'horizontal_label' => cs_recall( 'label_interactive_content_with_prefix' ),
      ],
    ],
    [
      'type'       => 'group',
      'label'      => cs_recall( 'label_interactive_primary_graphic_image_with_prefix' ),
      'label_vars' => [ 'prefix' => $label_prefix ],
      'group'      => $group_anchor_interactive_content,
      'conditions' => $conditions_anchor_interactive_content_images,
      'controls'   => [
        $control_anchor_interactive_content_graphic_image,
        $control_anchor_interactive_content_graphic_image_alt_text,
      ],
    ],
    [
      'type'       => 'group',
      'label'      => cs_recall( 'label_interactive_secondary_graphic_image_with_prefix' ),
      'label_vars' => [ 'prefix' => $label_prefix ],
      'group'      => $group_anchor_interactive_content,
      'conditions' => $conditions_anchor_interactive_content_secondary_image,
      'controls'   => [
        $control_anchor_interactive_content_graphic_image_alt,
        $control_anchor_interactive_content_graphic_image_alt_text_alt,
      ],
    ],
  ];

  $control_group_anchor_sub_indicator_setup = [
    'type'       => 'group',
    'label_vars' => [ 'prefix' => $label_prefix ],
    'group'      => $group_anchor_sub_indicator,
    'conditions' => $conditions_anchor_sub_indicator,
    'controls'   => [
      $control_anchor_sub_indicator_font_size,
      $control_anchor_sub_indicator_width,
      $control_anchor_sub_indicator_height,
      $control_anchor_sub_indicator_icon,
      $control_anchor_sub_indicator_colors,
    ],
    'options' => [
      'vertical_label'   => '',
      'horizontal_label' => cs_recall( 'label_sub_indicator_with_prefix' ),
    ],
  ];

  // Control Groups
  // --------------

  $control_nav = [
    $group                            => $group_title,
    $group_anchor_setup               => cs_recall( 'label_setup' ),
    $group_anchor_size                => cs_recall( 'label_size' ),
    $group_anchor_design              => cs_recall( 'label_design' ),
    $group_anchor_text                => cs_recall( 'label_text' ),
    $group_anchor_primary             => cs_recall( 'label_primary' ),
    $group_anchor_secondary           => cs_recall( 'label_secondary' ),
    $group_anchor_graphic             => cs_recall( 'label_graphic' ),
    $group_anchor_interactive_content => cs_recall( 'label_interactive_content' ),
    $group_anchor_sub_indicator       => cs_recall( 'label_sub_indicator' ),
    $group_anchor_particles           => cs_recall( 'label_particles' ),
  ];

  if ( ! $has_template ) {
    unset( $control_nav[$group_anchor_setup] );
    unset( $control_nav[$group_anchor_graphic] );
  }

  if ( ! $has_interactive_content ) {
    unset( $control_nav[$group_anchor_interactive_content] );
  }

  if ( $type !== 'menu-item' ) {
    unset( $control_nav[$group_anchor_sub_indicator] );
  }


  // Compose Controls
  // ----------------

  $before_graphic_adv = $control_group_anchor_setup;

  if ( $has_link_control ) {
    $before_graphic_adv[] = $control_anchor_link;
  }

  if ( $has_share_control ) {
    $before_graphic_adv[] = $control_anchor_share;
  }

  $before_graphic_adv[] = $control_group_anchor_size;


  // Design
  // ------

  if ( $has_template ) {
    $before_graphic_adv[] = cs_control( 'flexbox', $k_pre . 'anchor', [
      'group'      => $group_anchor_design,
      'conditions' => $conditions
    ] );
  }

  $before_graphic_adv = array_merge(
    $before_graphic_adv,
    [
      cs_control( 'margin', $k_pre . 'anchor', [
        'label_prefix' => $label_prefix,
        'group'        => $group_anchor_design,
        'conditions'   => $conditions,
      ] ),
      cs_control( 'padding',       $k_pre . 'anchor', $settings_anchor_design ),
      cs_control( 'border',        $k_pre . 'anchor', $settings_anchor_design ),
      cs_control( 'border-radius', $k_pre . 'anchor', $settings_anchor_design ),
      cs_control( 'box-shadow',    $k_pre . 'anchor', $settings_anchor_design )
    ]
  );


  // Text
  // ----

  if ( $has_template ) {
    $before_graphic_adv = array_merge(
      $before_graphic_adv,
      $control_group_anchor_text_setup
    );
  }

  $before_graphic_adv = array_merge(
    $before_graphic_adv,
    [
      cs_control( 'margin', $k_pre . 'anchor_text', [
        'label_prefix' => sprintf( cs_recall( 'label_text_with_sprintf_prefix' ), $label_prefix ),
        'group'        => $group_anchor_text,
        'conditions'   => $conditions_anchor_text,
      ] ),
      cs_control( 'text-format', $k_pre . 'anchor_primary', $settings_anchor_primary_text ),
      cs_control( 'text-shadow', $k_pre . 'anchor_primary', $settings_anchor_primary_text ),
    ]
  );

  if ( $has_template ) {
    $before_graphic_adv = array_merge(
      $before_graphic_adv,
      [
        cs_control( 'text-format', $k_pre . 'anchor_secondary', $settings_anchor_secondary_text ),
        cs_control( 'text-shadow', $k_pre . 'anchor_secondary', $settings_anchor_secondary_text )
      ]
    );
  }

  $before_graphic = [
    'controls'    => $before_graphic_adv,
    'control_nav' => $control_nav
  ];

  $compose_from = [ $before_graphic ];

  if ( $has_template ) {

    $settings_anchor_graphic = [
      'k_pre'               => $k_pre . 'anchor',
      'group'               => $group_anchor_graphic,
      'conditions'          => $conditions,
      'has_alt'             => true,
      'has_interactions'    => true,
      'has_sourced_content' => false,
      'has_toggle'          => false,
      'adv'                 => true,
    ];

    if ( $type === 'menu-item' ) {
      $settings_anchor_graphic['has_sourced_content'] = true;
    }

    if ( $type === 'toggle' ) {
      $settings_anchor_graphic['has_toggle'] = true;
    }

    $compose_from[] = cs_partial_controls( 'graphic', $settings_anchor_graphic );
  }

  $after_graphic_adv = [];

  if ( $has_interactive_content ) {
    $after_graphic_adv = array_merge(
      $after_graphic_adv,
      $control_group_anchor_interactive_content_setup
    );
  }


  // Sub Indicator
  // -------------

  if ( $has_template && $type === 'menu-item' ) {
    $after_graphic_adv[] = $control_group_anchor_sub_indicator_setup;

    $after_graphic_adv[] = cs_control( 'margin', $k_pre . 'anchor_sub_indicator', [
      'label_prefix' => sprintf( cs_recall( 'label_sub_indicator_with_sprintf_prefix' ), $label_prefix ),
      'group'        => $group_anchor_sub_indicator,
      'conditions'   => $conditions_anchor_sub_indicator,
    ] );

    $after_graphic_adv[] = cs_control( 'text-shadow', $k_pre . 'anchor_sub_indicator', [
      'label_prefix' => sprintf( cs_recall( 'label_sub_indicator_with_sprintf_prefix' ), $label_prefix ),
      'group'        => $group_anchor_sub_indicator,
      'conditions'   => $conditions_anchor_sub_indicator,
      'alt_color'    => true,
      'options'      => cs_recall( 'options_color_swatch_base_interaction_labels' ),
    ] );
  }

  if ( count( $after_graphic_adv ) > 0 ) {
    $compose_from[] = [
      'controls' => $after_graphic_adv
    ];
  }

  if ( $has_template ) {

    $compose_from[] = cs_partial_controls( 'particle', [
      'label_prefix' => cs_recall( 'label_primary' ),
      'k_pre'        => $k_pre . 'anchor_primary',
      'group'        => $group_anchor_particles,
      'conditions'   => $conditions,
    ] );

    $compose_from[] = cs_partial_controls( 'particle', [
      'label_prefix' => cs_recall( 'label_secondary' ),
      'k_pre'        => $k_pre . 'anchor_secondary',
      'group'        => $group_anchor_particles,
      'conditions'   => $conditions,
    ] );

  }


  if ( $add_custom_atts ) {
    $compose_from[] = [
      'controls' => [
        [
          'key'        => $k_pre . 'anchor_custom_atts',
          'type'       => 'attributes',
          'conditions' => $conditions,
          'group'      => 'omega:setup',
          'label'      => cs_recall( 'label_custom_attributes_with_prefix' ),
          'label_vars' => [ 'prefix' => $label_prefix_custom_atts ]
        ]
      ]
    ];
  }


  return call_user_func_array( 'cs_compose_controls', $compose_from );
}

cs_register_control_partial( 'anchor', 'x_control_partial_anchor' );
