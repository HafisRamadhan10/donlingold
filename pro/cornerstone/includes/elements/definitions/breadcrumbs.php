<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/BREADCRUMBS.PHP
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
    'breadcrumbs_home_label_type'                  => cs_value( 'text', 'markup' ),
    'breadcrumbs_home_label_text'                  => cs_value( __( 'Home', 'cornerstone' ), 'markup', true ),
    'breadcrumbs_home_label_icon'                  => cs_value( 'home', 'markup', true ),
    'breadcrumbs_width'                            => cs_value( 'auto' ),
    'breadcrumbs_max_width'                        => cs_value( 'none' ),
    'breadcrumbs_flex_justify'                     => cs_value( 'flex-start' ),
    'breadcrumbs_reverse'                          => cs_value( false ),
    'breadcrumbs_bg_color'                         => cs_value( 'transparent', 'style:color' ),

    'breadcrumbs_font_family'                      => cs_value( 'inherit', 'style:font-family' ),
    'breadcrumbs_font_weight'                      => cs_value( 'inherit:400', 'style:font-weight' ),
    'breadcrumbs_font_size'                        => cs_value( '1em' ),
    'breadcrumbs_line_height'                      => cs_value( '1.4' ),

    'breadcrumbs_margin'                           => cs_value( '!0em' ),
    'breadcrumbs_padding'                          => cs_value( '!0em' ),
    'breadcrumbs_border_width'                     => cs_value( '!0px' ),
    'breadcrumbs_border_style'                     => cs_value( 'solid' ),
    'breadcrumbs_border_color'                     => cs_value( 'transparent', 'style:color' ),
    'breadcrumbs_border_radius'                    => cs_value( '!0px' ),
    'breadcrumbs_box_shadow_dimensions'            => cs_value( '!0em 0em 0em 0em' ),
    'breadcrumbs_box_shadow_color'                 => cs_value( 'transparent', 'style:color' ),

    'breadcrumbs_delimiter'                        => cs_value( true, 'markup' ),
    'breadcrumbs_delimiter_type'                   => cs_value( 'text', 'markup' ),
    'breadcrumbs_delimiter_ltr_text'               => cs_value( '&rarr;', 'markup' ),
    'breadcrumbs_delimiter_rtl_text'               => cs_value( '&larr;', 'markup' ),
    'breadcrumbs_delimiter_ltr_icon'               => cs_value( 'o-angle-right', 'markup' ),
    'breadcrumbs_delimiter_rtl_icon'               => cs_value( 'o-angle-left', 'markup' ),
    'breadcrumbs_delimiter_spacing'                => cs_value( '8px' ),
    'breadcrumbs_delimiter_color'                  => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'breadcrumbs_delimiter_text_shadow_dimensions' => cs_value( '!0px 0px 0px' ),
    'breadcrumbs_delimiter_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),

    'breadcrumbs_links_base_font_size'             => cs_value( '1em' ),
    'breadcrumbs_links_min_width'                  => cs_value( '0em' ),
    'breadcrumbs_links_max_width'                  => cs_value( 'none' ),
    'breadcrumbs_links_color'                      => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'breadcrumbs_links_color_alt'                  => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'breadcrumbs_links_bg_color'                   => cs_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_bg_color_alt'               => cs_value( 'transparent', 'style:color' ),

    'breadcrumbs_links_font_style'                 => cs_value( 'normal' ),
    'breadcrumbs_links_text_align'                 => cs_value( 'none' ),
    'breadcrumbs_links_text_transform'             => cs_value( 'none' ),
    'breadcrumbs_links_letter_spacing'             => cs_value( '0em' ),
    'breadcrumbs_links_line_height'                => cs_value( '1.3' ),
    'breadcrumbs_links_text_shadow_dimensions'     => cs_value( '!0px 0px 0px' ),
    'breadcrumbs_links_text_shadow_color'          => cs_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_text_shadow_color_alt'      => cs_value( 'transparent', 'style:color' ),

    'breadcrumbs_links_margin'                     => cs_value( '!0px' ),
    'breadcrumbs_links_padding'                    => cs_value( '!0em 0em 0em 0em' ),
    'breadcrumbs_links_border_width'               => cs_value( '!0px' ),
    'breadcrumbs_links_border_style'               => cs_value( 'solid' ),
    'breadcrumbs_links_border_color'               => cs_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_border_color_alt'           => cs_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_border_radius'              => cs_value( '!0px' ),
    'breadcrumbs_links_box_shadow_dimensions'      => cs_value( '!0em 0em 0em 0em' ),
    'breadcrumbs_links_box_shadow_color'           => cs_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_box_shadow_color_alt'       => cs_value( 'transparent', 'style:color' ),
  ],
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_breadcrumbs() {
  return [
    'require' => [ 'elements-wp' ],
    'modules' => [ 'breadcrumbs']
  ];
}


// Render
// =============================================================================

function x_element_render_breadcrumbs( $data ) {

  extract( $data );

  // Prepare Attr Values
  // -------------------

  $breadcrumbs_atts = [
    'class' => array_merge( ['x-crumbs'], $classes ),
    'role'  => 'navigation',
  ];

  if ( isset( $id ) && ! empty( $id ) ) {
    $breadcrumbs_atts['id'] = $id;
  }

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }

  $breadcrumbs_atts = cs_apply_effect( $breadcrumbs_atts, $data );

  $breadcrumbs_list_atts = array(
    'class'      => 'x-crumbs-list',
    'itemscope'  => '',
    'itemtype'   => 'http://schema.org/BreadcrumbList',
    'aria-label' => __( 'Breadcrumb Navigation', 'cornerstone' )
  );


  // Prepare $args_items
  // -------------------

  $delimiter_ltr = ( $breadcrumbs_delimiter === true ) ? ${"breadcrumbs_delimiter_ltr_" . $breadcrumbs_delimiter_type} : '';
  $delimiter_rtl = ( $breadcrumbs_delimiter === true ) ? ${"breadcrumbs_delimiter_rtl_" . $breadcrumbs_delimiter_type} : '';

  if ( $breadcrumbs_delimiter === true && $breadcrumbs_delimiter_type === 'icon' ) {
    $delimiter_ltr = cs_get_partial_view( 'icon', [ 'icon' => $delimiter_ltr ] );
    $delimiter_rtl = cs_get_partial_view( 'icon', [ 'icon' => $delimiter_rtl ] );
  }

  $args_items = array(
    'delimiter_ltr' => $delimiter_ltr,
    'delimiter_rtl' => $delimiter_rtl,
  );


  // Prepare $args_data
  // ------------------

  $home_label = $breadcrumbs_home_label_text;

  if ( $breadcrumbs_home_label_type === 'icon' ) {
    $home_label = cs_get_partial_view( 'icon', [ 'icon' => $breadcrumbs_home_label_icon ] )  . '<span class="visually-hidden">' . $breadcrumbs_home_label_text . '</span>';
  }

  $args_data = array(
    'home_label' => $home_label,
  );


  // Output
  // ------

  $content = '';

  if ( function_exists('x_breadcrumbs_items') ) {
    $content = x_breadcrumbs_items( x_breadcrumbs_data( $args_data ), $args_items );
  }

  return cs_tag( 'nav', $breadcrumbs_atts, $custom_atts, [
    cs_tag( 'ol', $breadcrumbs_list_atts, $content )
  ]);

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_breadcrumbs() {

  // Groups
  // ------

  $group           = 'breadcrumbs';
  $group_setup     = $group . ':setup';
  $group_size      = $group . ':size';
  $group_design    = $group . ':design';
  $group_delimiter = $group . ':delimiter';
  $group_links     = $group . ':links';


  // Conditions
  // ----------

  $condition_breadcrumbs_home_label_text     = [ 'breadcrumbs_home_label_type' => 'text' ];
  $condition_breadcrumbs_home_label_icon     = [ 'breadcrumbs_home_label_type' => 'icon' ];
  $condition_breadcrumbs_delimiter           = [ 'breadcrumbs_delimiter' => true ];
  $condition_breadcrumbs_delimiter_type_text = [ 'breadcrumbs_delimiter_type' => 'text' ];
  $condition_breadcrumbs_delimiter_type_icon = [ 'breadcrumbs_delimiter_type' => 'icon' ];

  $conditions_breadcrumbs_delimiter_text     = [ $condition_breadcrumbs_delimiter, $condition_breadcrumbs_delimiter_type_text ];
  $conditions_breadcrumbs_delimiter_icon     = [ $condition_breadcrumbs_delimiter, $condition_breadcrumbs_delimiter_type_icon ];


  // Options
  // -------

  $options_breadcrumbs_home_label_type = [
    'choices' => [
      [ 'value' => 'text', 'label' => cs_recall( 'label_text' ) ],
      [ 'value' => 'icon', 'label' => cs_recall( 'label_icon' ) ],
    ],
  ];

  $options_breadcrumbs_flex_justify = [
    'choices' => [
      [ 'value' => 'flex-start', 'label' => cs_recall( 'label_start' )  ],
      [ 'value' => 'center',     'label' => cs_recall( 'label_center' ) ],
    ],
  ];

  $options_breadcrumbs_flex_direction = [
    'choices' => [
      [ 'value' => false, 'label' => cs_recall( 'label_inherit' ) ],
      [ 'value' => true,  'label' => cs_recall( 'label_reverse' ) ],
    ],
  ];

  $options_breadcrumbs_delimiter_type = [
    'choices' => [
      [ 'value' => 'text', 'label' => cs_recall( 'label_text' ) ],
      [ 'value' => 'icon', 'label' => cs_recall( 'label_icon' ) ],
    ],
  ];


  // Settings
  // --------

  $settings_breadcrumbs_design = [
    'group' => $group_design,
  ];

  $settings_breadcrumbs_links = [
    'group'        => $group_links,
    'label_prefix' => cs_recall( 'label_links' ),
  ];

  $settings_breadcrumbs_links_color = [
    'group'        => $group_links,
    'alt_color'    => true,
    'label_prefix' => cs_recall( 'label_links' ),
    'options'      => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  ];


  // Individual Controls (Setup)
  // ---------------------------

  $control_breadcrumbs_home_label_type = [
    'key'     => 'breadcrumbs_home_label_type',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_home_link' ),
    'options' => $options_breadcrumbs_home_label_type,
  ];

  $control_breadcrumbs_home_label_text = [
    'key'   => 'breadcrumbs_home_label_text',
    'type'  => 'text',
    'label' => cs_recall( 'label_home_label' ),
  ];

  $control_breadcrumbs_home_label_icon = [
    'key'   => 'breadcrumbs_home_label_icon',
    'type'  => 'icon',
    'label' => cs_recall( 'label_home_label' ),
  ];

  $control_breadcrumbs_home_label_text_and_icon = [
    'type'      => 'group',
    'label'     => cs_recall( 'label_home_label' ),
    'condition' => $condition_breadcrumbs_home_label_icon,
    'controls'  => [
      $control_breadcrumbs_home_label_text,
      $control_breadcrumbs_home_label_icon,
    ],
  ];

  $control_breadcrumbs_flex_justify = [
    'key'     => 'breadcrumbs_flex_justify',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_align_horizontal' ),
    'options' => $options_breadcrumbs_flex_justify,
  ];

  $control_breadcrumbs_reverse = [
    'key'     => 'breadcrumbs_reverse',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_direction' ),
    'options' => $options_breadcrumbs_flex_direction,
  ];

  $control_breadcrumbs_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'breadcrumbs_bg_color' ] ] );


  // Individual Controls (Size)
  // --------------------------

  $control_breadcrumbs_width     = cs_recall( 'control_mixin_width',     [ 'key' => 'breadcrumbs_width'     ] );
  $control_breadcrumbs_max_width = cs_recall( 'control_mixin_max_width', [ 'key' => 'breadcrumbs_max_width' ] );


  // Individual Controls (Delimiter)
  // -------------------------------

  $control_breadcrumbs_delimiter_type = [
    'key'       => 'breadcrumbs_delimiter_type',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_type' ),
    'condition' => $condition_breadcrumbs_delimiter,
    'options'   => $options_breadcrumbs_delimiter_type,
  ];

  $control_breadcrumbs_delimiter_columns = [
    'type'     => 'group',
    'label'    => cs_recall( 'label_nbsp' ),
    'controls' => [
      [ 'type' => 'label', 'label' => cs_recall( 'label_ltr' ), 'options' => [ 'columns' => 1 ] ],
      [ 'type' => 'label', 'label' => cs_recall( 'label_rtl' ), 'options' => [ 'columns' => 1 ] ],
    ],
  ];

  $control_breadcrumbs_delimiter_ltr_text = [
    'key'        => 'breadcrumbs_delimiter_ltr_text',
    'type'       => 'text',
    'label'      => cs_recall( 'label_ltr_delimiter' ),
    'conditions' => $conditions_breadcrumbs_delimiter_text,
  ];

  $control_breadcrumbs_delimiter_rtl_text = [
    'key'        => 'breadcrumbs_delimiter_rtl_text',
    'type'       => 'text',
    'label'      => cs_recall( 'label_rtl_delimiter' ),
    'conditions' => $conditions_breadcrumbs_delimiter_text,
  ];

  $control_breadcrumbs_delimiter_ltr_and_rtl_text = [
    'type'       => 'group',
    'label'      => cs_recall( 'label_delimiter' ),
    'options'    => [ 'grouped' => true ],
    'conditions' => $conditions_breadcrumbs_delimiter_text,
    'controls'   => [
      $control_breadcrumbs_delimiter_ltr_text,
      $control_breadcrumbs_delimiter_rtl_text,
    ],
  ];

  $control_breadcrumbs_delimiter_ltr_icon = [
    'key'        => 'breadcrumbs_delimiter_ltr_icon',
    'type'       => 'icon',
    'label'      => cs_recall( 'label_ltr_delimiter' ),
    'conditions' => $conditions_breadcrumbs_delimiter_icon,
  ];

  $control_breadcrumbs_delimiter_rtl_icon = [
    'key'        => 'breadcrumbs_delimiter_rtl_icon',
    'type'       => 'icon',
    'label'      => cs_recall( 'label_rtl_delimiter' ),
    'conditions' => $conditions_breadcrumbs_delimiter_icon,
  ];

  $control_breadcrumbs_delimiter_ltr_and_rtl_icon = [
    'type'       => 'group',
    'label'      => cs_recall( 'label_delimiter' ),
    'options'    => [ 'grouped' => true ],
    'conditions' => $conditions_breadcrumbs_delimiter_icon,
    'controls'   => [
      $control_breadcrumbs_delimiter_ltr_icon,
      $control_breadcrumbs_delimiter_rtl_icon,
    ],
  ];

  $control_breadcrumbs_delimiter_spacing = cs_recall( 'control_mixin_gap',        [ 'key' => 'breadcrumbs_delimiter_spacing', 'label' => cs_recall( 'label_gap_width' ), 'condition' => $condition_breadcrumbs_delimiter ] );
  $control_breadcrumbs_delimiter_color   = cs_recall( 'control_mixin_color_solo', [ 'keys' => [ 'value' => 'breadcrumbs_delimiter_color' ], 'condition' => $condition_breadcrumbs_delimiter                              ] );


  // Individual Controls (Links)
  // ---------------------------

  $control_breadcrumbs_links_base_font_size = cs_recall( 'control_mixin_font_size',      [ 'key' => 'breadcrumbs_links_base_font_size', 'label' => cs_recall( 'label_size' )                ] );
  $control_breadcrumbs_links_letter_spacing = cs_recall( 'control_mixin_letter_spacing', [ 'key' => 'breadcrumbs_links_letter_spacing'                                                      ] );
  $control_breadcrumbs_links_line_height    = cs_recall( 'control_mixin_line_height',    [ 'key' => 'breadcrumbs_links_line_height'                                                         ] );
  $control_breadcrumbs_links_font_style     = cs_recall( 'control_mixin_font_style',     [ 'key' => 'breadcrumbs_links_font_style'                                                          ] );
  $control_breadcrumbs_links_text_align     = cs_recall( 'control_mixin_text_align',     [ 'key' => 'breadcrumbs_links_text_align'                                                          ] );
  $control_breadcrumbs_links_text_transform = cs_recall( 'control_mixin_text_transform', [ 'key' => 'breadcrumbs_links_text_transform'                                                      ] );
  $control_breadcrumbs_links_colors         = cs_recall( 'control_mixin_color_int',      [ 'keys' => [ 'value' => 'breadcrumbs_links_color', 'alt' => 'breadcrumbs_links_color_alt' ]       ] );
  $control_breadcrumbs_links_bg_colors      = cs_recall( 'control_mixin_bg_color_int',   [ 'keys' => [ 'value' => 'breadcrumbs_links_bg_color', 'alt' => 'breadcrumbs_links_bg_color_alt' ] ] );


  // Individual Controls (Links Size)
  // --------------------------------

  $control_breadcrumbs_links_min_width = cs_recall( 'control_mixin_min_width', [ 'key' => 'breadcrumbs_links_min_width' ] );
  $control_breadcrumbs_links_max_width = cs_recall( 'control_mixin_max_width', [ 'key' => 'breadcrumbs_links_max_width' ] );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    [
      'controls' => [
        [
          'type'     => 'group',
          'group'    => $group_setup,
          'controls' => [
            $control_breadcrumbs_home_label_type,
            array_merge( $control_breadcrumbs_home_label_text, [ 'condition' => $condition_breadcrumbs_home_label_text ] ),
            $control_breadcrumbs_home_label_text_and_icon,
            $control_breadcrumbs_flex_justify,
            $control_breadcrumbs_reverse,
            $control_breadcrumbs_bg_color,
          ],
        ],
        [
          'type'     => 'group',
          'group'    => $group_size,
          'controls' => [
            $control_breadcrumbs_width,
            $control_breadcrumbs_max_width,
          ],
        ],
        cs_control( 'text-format', 'breadcrumbs', [
          'group'              => $group_design,
          'no_letter_spacing'  => true,
          'no_font_style'      => true,
          'no_text_align'      => true,
          'no_text_decoration' => true,
          'no_text_transform'  => true,
          'no_text_color'      => true,
        ] ),
        cs_control( 'margin', 'breadcrumbs', $settings_breadcrumbs_design ),
        cs_control( 'padding', 'breadcrumbs', $settings_breadcrumbs_design ),
        cs_control( 'border', 'breadcrumbs', $settings_breadcrumbs_design ),
        cs_control( 'border-radius', 'breadcrumbs', $settings_breadcrumbs_design ),
        cs_control( 'box-shadow', 'breadcrumbs', $settings_breadcrumbs_design ),
        [
          'key'      => 'breadcrumbs_delimiter',
          'type'     => 'group',
          'group'    => $group_delimiter,
          'options'  => cs_recall( 'options_group_toggle_off_on_bool' ),
          'controls' => [
            $control_breadcrumbs_delimiter_type,
            $control_breadcrumbs_delimiter_columns,
            $control_breadcrumbs_delimiter_ltr_and_rtl_text,
            $control_breadcrumbs_delimiter_ltr_and_rtl_icon,
            $control_breadcrumbs_delimiter_spacing,
            $control_breadcrumbs_delimiter_color,
          ],
        ],
        cs_control( 'text-shadow', 'breadcrumbs_delimiter', [
          'group'        => $group_delimiter,
          'label_prefix' => cs_recall( 'label_delimiter' ),
          'condition'    => $condition_breadcrumbs_delimiter,
        ] ),
        [
          'type'     => 'group',
          'group'    => $group_links,
          'controls' => [
            $control_breadcrumbs_links_base_font_size,
            $control_breadcrumbs_links_letter_spacing,
            $control_breadcrumbs_links_line_height,
            $control_breadcrumbs_links_font_style,
            $control_breadcrumbs_links_text_align,
            $control_breadcrumbs_links_text_transform,
            $control_breadcrumbs_links_colors,
            $control_breadcrumbs_links_bg_colors,
          ],
        ],
        cs_control( 'text-shadow', 'breadcrumbs_links', $settings_breadcrumbs_links_color ),
        [
          'type'     => 'group',
          'group'    => $group_links,
          'controls' => [
            $control_breadcrumbs_links_min_width,
            $control_breadcrumbs_links_max_width,
          ],
          'options' => [
            'vertical_label'   => cs_recall( 'label_size' ),
            'horizontal_label' => cs_recall( 'label_links_size' ),
          ]
        ],
        cs_control( 'margin', 'breadcrumbs_links', $settings_breadcrumbs_links ),
        cs_control( 'padding', 'breadcrumbs_links', $settings_breadcrumbs_links ),
        cs_control( 'border', 'breadcrumbs_links', $settings_breadcrumbs_links_color ),
        cs_control( 'border-radius', 'breadcrumbs_links', $settings_breadcrumbs_links ),
        cs_control( 'box-shadow', 'breadcrumbs_links', $settings_breadcrumbs_links_color )
      ],
      'control_nav' => [
        $group           => cs_recall( 'label_breadcrumbs' ),
        $group_setup     => cs_recall( 'label_setup' ),
        $group_size      => cs_recall( 'label_size' ),
        $group_design    => cs_recall( 'label_design' ),
        $group_delimiter => cs_recall( 'label_delimiter' ),
        $group_links     => cs_recall( 'label_links' ),
      ],
    ],
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'breadcrumbs', [
  'title'      => __( 'Breadcrumbs', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_breadcrumbs',
  'tss'        => 'x_element_tss_breadcrumbs',
  'render'     => 'x_element_render_breadcrumbs',
  'icon'       => 'native',
] );
