<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TABS.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Values
//   02. Style
//   03. Render
//   04. Define Element
//   05. Builder Setup
//   06. Register Element
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  [
    'tabs_base_font_size'                => cs_value( '1em' ),
    'tabs_width'                         => cs_value( 'auto' ),
    'tabs_max_width'                     => cs_value( '100%' ),
    'tabs_bg_color'                      => cs_value( 'transparent', 'style:color' ),
    'tabs_margin'                        => cs_value( '!0em' ),
    'tabs_padding'                       => cs_value( '!0em' ),
    'tabs_border_width'                  => cs_value( '!0px' ),
    'tabs_border_style'                  => cs_value( 'solid' ),
    'tabs_border_color'                  => cs_value( 'transparent', 'style:color' ),
    'tabs_border_radius'                 => cs_value( '!0px' ),
    'tabs_box_shadow_dimensions'         => cs_value( '!0em 0em 0em 0em' ),
    'tabs_box_shadow_color'              => cs_value( 'transparent', 'style:color' ),

    'tabs_tablist_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'tabs_tablist_margin'                => cs_value( '0px 0px -1px 0px' ),
    'tabs_tablist_padding'               => cs_value( '!0em' ),
    'tabs_tablist_border_width'          => cs_value( '!0px' ),
    'tabs_tablist_border_style'          => cs_value( 'solid' ),
    'tabs_tablist_border_color'          => cs_value( 'transparent', 'style:color' ),
    'tabs_tablist_border_radius'         => cs_value( '!0px' ),
    'tabs_tablist_box_shadow_dimensions' => cs_value( '!0em 0em 0em 0em' ),
    'tabs_tablist_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),

    'tabs_tabs_fill_space'               => cs_value( false ),
    'tabs_tabs_justify_content'          => cs_value( 'flex-start' ),
    'tabs_tabs_min_width'                => cs_value( '0px' ),
    'tabs_tabs_max_width'                => cs_value( 'none' ),
    'tabs_tabs_bg_color'                 => cs_value( 'transparent', 'style:color' ),
    'tabs_tabs_bg_color_alt'             => cs_value( 'transparent', 'style:color' ),
    'tabs_tabs_margin'                   => cs_value( '!0px' ),
    'tabs_tabs_padding'                  => cs_value( '0.75rem 1.5rem 0.75rem 1.5rem' ),
    'tabs_tabs_border_width'             => cs_value( '0px 0px 1px 0px' ),
    'tabs_tabs_border_style'             => cs_value( 'solid solid solid solid' ),
    'tabs_tabs_border_color'             => cs_value( 'transparent transparent transparent transparent', 'style:color' ),
    'tabs_tabs_border_color_alt'         => cs_value( 'transparent transparent rgba(0, 0, 0, 1) transparent', 'style:color' ),
    'tabs_tabs_border_radius'            => cs_value( '!0px' ),
    'tabs_tabs_box_shadow_dimensions'    => cs_value( '!0em 0em 0em 0em' ),
    'tabs_tabs_box_shadow_color'         => cs_value( 'transparent', 'style:color' ),
    'tabs_tabs_box_shadow_color_alt'     => cs_value( 'transparent', 'style:color' ),
    'tabs_tabs_font_family'              => cs_value( 'inherit', 'style:font-family' ),
    'tabs_tabs_font_weight'              => cs_value( 'inherit:400', 'style:font-weight' ),
    'tabs_tabs_font_size'                => cs_value( '0.75em' ),
    'tabs_tabs_letter_spacing'           => cs_value( '0.15em' ),
    'tabs_tabs_line_height'              => cs_value( '1' ),
    'tabs_tabs_font_style'               => cs_value( 'normal' ),
    'tabs_tabs_text_align'               => cs_value( 'none' ),
    'tabs_tabs_text_decoration'          => cs_value( 'none' ),
    'tabs_tabs_text_transform'           => cs_value( 'uppercase' ),
    'tabs_tabs_text_color'               => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'tabs_tabs_text_color_alt'           => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'tabs_tabs_text_shadow_dimensions'   => cs_value( '!0px 0px 0px' ),
    'tabs_tabs_text_shadow_color'        => cs_value( 'transparent', 'style:color' ),
    'tabs_tabs_text_shadow_color_alt'    => cs_value( 'transparent', 'style:color' ),

    'tabs_panels_equal_height'           => cs_value( false, 'markup' ),
    'tabs_panels_bg_color'               => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'tabs_panels_flex_justify'           => cs_value( 'flex-start' ),
    'tabs_panels_flex_align'             => cs_value( 'stretch' ),
    'tabs_panels_margin'                 => cs_value( '!0em' ),
    'tabs_panels_padding'                => cs_value( '1.5rem' ),
    'tabs_panels_border_width'           => cs_value( '1px' ),
    'tabs_panels_border_style'           => cs_value( 'solid' ),
    'tabs_panels_border_color'           => cs_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
    'tabs_panels_border_radius'          => cs_value( '!0px' ),
    'tabs_panels_box_shadow_dimensions'  => cs_value( '0em 0.25em 2em 0em' ),
    'tabs_panels_box_shadow_color'       => cs_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
    'tabs_panels_font_family'            => cs_value( 'inherit', 'style:font-family' ),
    'tabs_panels_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
    'tabs_panels_font_size'              => cs_value( '1em' ),
    'tabs_panels_letter_spacing'         => cs_value( '0em' ),
    'tabs_panels_line_height'            => cs_value( '1.4' ),
    'tabs_panels_font_style'             => cs_value( 'normal' ),
    'tabs_panels_text_align'             => cs_value( 'none' ),
    'tabs_panels_text_decoration'        => cs_value( 'none' ),
    'tabs_panels_text_transform'         => cs_value( 'none' ),
    'tabs_panels_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'tabs_panels_text_shadow_dimensions' => cs_value( '!0px 0px 0px' ),
    'tabs_panels_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  ],
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_tabs() {
  return [
    'require' => [ 'elements-legacy' ],
    'modules' => [ 'tabs', 'effects' ]
  ];
}



// Render
// =============================================================================

function x_element_render_tabs( $data ) {
  $tabs = [];

  foreach ( $data['_modules'] as $key => $element ) {
    $definition = cs_get_element( $element['_type'] );
    if ( ! $definition->should_hide( $element ) ) {
      $tabs[] = $element;
    }
  }

  $set_initial = ! apply_filters( 'cs_is_preview', false );


  // Atts: Tabs
  // ----------

  $atts_tabs = [
    'class' => array_merge( ['x-tabs'], $data['classes'] )
  ];

  if ( isset( $data['id'] ) && ! empty( $data['id'] ) ) {
    $atts_tabs['id'] = $data['id'];
  }

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts_tabs['style'] = $data['style'];
  }

  $atts_tabs = cs_apply_effect( $atts_tabs, $data );
  $tabs_js_atts = [];

  if ($data['tabs_panels_equal_height']) {
    $tabs_js_atts['equalPanelHeight'] = $data['tabs_panels_equal_height'];
  }

  $atts_tabs = array_merge( $atts_tabs, cs_element_js_atts( 'tabs', $tabs_js_atts ) );



  $tab_buttons = [];
  $tab_panels = [];

  foreach ( $tabs as $index => $tab ) {


    // Tab Setup
    // ---------

    $tab_id = isset($tab['id']) && !empty($tab['id']) ? $tab['id'] : $tab['unique_id'];
    $first_open = ( $index === 0 && $set_initial );


    // Button Output
    // -------------

    $button_atts = [
      'id'                  => 'tab-' . $tab_id,
      'class'               => [ $tab['style_id'] ],
      'role'                => 'tab',
      'aria-selected'       => $first_open ? 'true' : 'false',
      'aria-controls'       => 'panel-' . $tab_id,
      'data-x-toggle'       => 'tab',
      'data-x-toggleable'   => 'tab-item-' . $tab_id,
      'data-x-toggle-group' => 'tab-group-' . $data['unique_id'],
    ];

    if ( $first_open ) {
      $button_atts['class'][] = 'x-active';
    }

    if ( ! empty( $tab['toggle_hash'] ) ) {
      $button_atts['data-x-toggle-hash'] = $tab['toggle_hash'];
    }

    if (isset($tab['class'])) {
      $button_atts['class'][] = $tab['class'];
    }

    $tab_buttons[] = cs_tag('li', ['role' => 'presentation'], [
      cs_tag('button', $button_atts, $tab['tab_label_custom_atts'], cs_tag('span', $tab['tab_label_content']) )
    ]);

    // Panel Output
    // ------------

    $panel_atts = [
      'id'                => 'panel-' . $tab_id,
      'class'             => [ 'x-tabs-panel', $tab['style_id'] ],
      'role'              => 'tabpanel',
      'aria-labelledby'   => 'tab-' . $tab_id,
      'aria-hidden'       => $first_open ? 'false' : 'true',
      'data-x-toggleable' => 'tab-item-' . $tab_id
    ];

    if ( $first_open ) {
      $panel_atts['class'][] = 'x-active';
    }

    if (isset($tab['class'])) {
      $panel_atts['class'][] = $tab['class'];
    }

    $tab_panels[] = cs_tag('div', $panel_atts, $tab['tab_content_custom_atts'], $tab['tab_content']);

  }

  return cs_tag('div', $atts_tabs, $data['custom_atts'], [
    cs_tag( 'div', [ 'class' => 'x-tabs-list' ], cs_tag('ul', [ 'role' => 'tablist' ], $tab_buttons ) ),
    cs_tag( 'div', [ 'class' => 'x-tabs-panels'], $tab_panels )
  ]);

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_tabs() {

  $settings_tabs_tabs_design = [
    'group'     => 'tabs_tabs:design',
    'alt_color' => true,
    'options'   => cs_recall( 'options_color_base_interaction_labels' ),
  ];

  $settings_tabs_tabs_text = [
    'group'     => 'tabs_tabs:text',
    'alt_color' => true,
    'options'   => cs_recall( 'options_color_base_interaction_labels' ),
  ];


  // Individual Controls - Children
  // ------------------------------

  $control_tabs_children = [
    'type'  => 'sortable',
    'group' => 'tabs:children'
  ];


  // Individual Controls - Setup
  // ---------------------------

  $control_tabs_base_font_size = cs_recall( 'control_mixin_font_size',     [ 'key' => 'tabs_base_font_size'           ] );
  $control_tabs_width          = cs_recall( 'control_mixin_width',         [ 'key' => 'tabs_width'                    ] );
  $control_tabs_max_width      = cs_recall( 'control_mixin_max_width',     [ 'key' => 'tabs_max_width'                ] );
  $control_tabs_bg_color       = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'tabs_bg_color' ] ] );


  // Individual Controls - Setup, Tablist
  // ------------------------------------

  $control_tabs_tablist_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'tabs_tablist_bg_color' ] ] );


  // Individual Controls - Setup, Tabs
  // ---------------------------------

  $control_tabs_tabs_fill_space = [
    'key'     => 'tabs_tabs_fill_space',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_fill_space' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  ];

  $control_tabs_tabs_justify_content = [
    'key'       => 'tabs_tabs_justify_content',
    'type'      => 'select',
    'label'     => cs_recall( 'label_align_horizontal' ),
    'condition' => [ 'tabs_tabs_fill_space' => false ],
    'options'   => [
      'choices' => [
        [ 'value' => 'flex-start',    'label' => cs_recall( 'label_start' )         ],
        [ 'value' => 'center',        'label' => cs_recall( 'label_center' )        ],
        [ 'value' => 'flex-end',      'label' => cs_recall( 'label_end' )           ],
        [ 'value' => 'space-between', 'label' => cs_recall( 'label_space_between' ) ],
        [ 'value' => 'space-around',  'label' => cs_recall( 'label_space_around' )  ],
        [ 'value' => 'space-evenly',  'label' => cs_recall( 'label_space_evenly' )  ],
      ],
    ],
  ];

  $control_tabs_tabs_min_width = cs_recall( 'control_mixin_min_width',    [ 'key' => 'tabs_tabs_min_width'                                                   ] );
  $control_tabs_tabs_max_width = cs_recall( 'control_mixin_max_width',    [ 'key' => 'tabs_tabs_max_width'                                                   ] );
  $control_tabs_tabs_bg_colors = cs_recall( 'control_mixin_bg_color_int', [ 'keys' => [ 'value' => 'tabs_tabs_bg_color', 'alt' => 'tabs_tabs_bg_color_alt' ] ] );


  // Individual Controls - Setup, Panels
  // -----------------------------------

  $control_tabs_panels_equal_height = [
    'key'     => 'tabs_panels_equal_height',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_equal_height' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  ];

  $control_tabs_panels_flex_justify = [
    'key'       => 'tabs_panels_flex_justify',
    'type'      => 'select',
    'label'     => cs_recall( 'label_align_vertical' ),
    'condition' => [ 'tabs_panels_equal_height' => true ],
    'options'   => [
      'choices' => [
        [ 'value' => 'flex-start',    'label' => cs_recall( 'label_start' )         ],
        [ 'value' => 'center',        'label' => cs_recall( 'label_center' )        ],
        [ 'value' => 'flex-end',      'label' => cs_recall( 'label_end' )           ],
        [ 'value' => 'space-between', 'label' => cs_recall( 'label_space_between' ) ],
        [ 'value' => 'space-around',  'label' => cs_recall( 'label_space_around' )  ],
        [ 'value' => 'space-evenly',  'label' => cs_recall( 'label_space_evenly' )  ],
      ],
    ],
  ];

  $control_tabs_panels_flex_align = [
    'key'       => 'tabs_panels_flex_align',
    'type'      => 'select',
    'label'     => cs_recall( 'label_align_horizontal' ),
    'condition' => [ 'tabs_panels_equal_height' => true ],
    'options'   => [
      'choices' => [
        [ 'value' => 'flex-start', 'label' => cs_recall( 'label_start' )   ],
        [ 'value' => 'center',     'label' => cs_recall( 'label_center' )  ],
        [ 'value' => 'flex-end',   'label' => cs_recall( 'label_end' )     ],
        [ 'value' => 'stretch',    'label' => cs_recall( 'label_stretch' ) ],
      ],
    ],
  ];

  $control_tabs_panels_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'tabs_panels_bg_color' ] ] );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    [
      'controls' => [
        $control_tabs_children,
        [
          'type'     => 'group',
          'group'    => 'tabs:setup',
          'controls' => [
            $control_tabs_base_font_size,
            $control_tabs_bg_color,
          ],
        ],
        [
          'type'     => 'group',
          'group'    => 'tabs:size',
          'controls' => [
            $control_tabs_width,
            $control_tabs_max_width,
          ],
        ],

        cs_control( 'margin',        'tabs', [ 'group' => 'tabs:design' ] ),
        cs_control( 'padding',       'tabs', [ 'group' => 'tabs:design' ] ),
        cs_control( 'border',        'tabs', [ 'group' => 'tabs:design' ] ),
        cs_control( 'border-radius', 'tabs', [ 'group' => 'tabs:design' ] ),
        cs_control( 'box-shadow',    'tabs', [ 'group' => 'tabs:design' ] ),

        [
          'type'     => 'group',
          'group'    => 'tabs_tablist:setup',
          'controls' => [
            $control_tabs_tablist_bg_color,
          ],
        ],

        cs_control( 'margin',        'tabs_tablist', [ 'group' => 'tabs_tablist:design' ] ),
        cs_control( 'padding',       'tabs_tablist', [ 'group' => 'tabs_tablist:design' ] ),
        cs_control( 'border',        'tabs_tablist', [ 'group' => 'tabs_tablist:design' ] ),
        cs_control( 'border-radius', 'tabs_tablist', [ 'group' => 'tabs_tablist:design' ] ),
        cs_control( 'box-shadow',    'tabs_tablist', [ 'group' => 'tabs_tablist:design' ] ),

        [
          'type'     => 'group',
          'group'    => 'tabs_tabs:setup',
          'controls' => [
            $control_tabs_tabs_fill_space,
            $control_tabs_tabs_justify_content,
            $control_tabs_tabs_bg_colors,
          ],
        ],
        [
          'type'     => 'group',
          'group'    => 'tabs_tabs:size',
          'controls' => [
            $control_tabs_tabs_min_width,
            $control_tabs_tabs_max_width,
          ],
        ],

        cs_control( 'margin',        'tabs_tabs', $settings_tabs_tabs_design ),
        cs_control( 'padding',       'tabs_tabs', $settings_tabs_tabs_design ),
        cs_control( 'border',        'tabs_tabs', $settings_tabs_tabs_design ),
        cs_control( 'border-radius', 'tabs_tabs', $settings_tabs_tabs_design ),
        cs_control( 'box-shadow',    'tabs_tabs', $settings_tabs_tabs_design ),

        cs_control( 'text-format', 'tabs_tabs', $settings_tabs_tabs_text ),
        cs_control( 'text-shadow', 'tabs_tabs', $settings_tabs_tabs_text ),

        [
          'type'     => 'group',
          'group'    => 'tabs_panels:setup',
          'controls' => [
            $control_tabs_panels_equal_height,
            $control_tabs_panels_flex_justify,
            $control_tabs_panels_flex_align,
            $control_tabs_panels_bg_color
          ],
        ],

        cs_control( 'margin',        'tabs_panels', [ 'group' => 'tabs_panels:design' ] ),
        cs_control( 'padding',       'tabs_panels', [ 'group' => 'tabs_panels:design' ] ),
        cs_control( 'border',        'tabs_panels', [ 'group' => 'tabs_panels:design' ] ),
        cs_control( 'border-radius', 'tabs_panels', [ 'group' => 'tabs_panels:design' ] ),
        cs_control( 'box-shadow',    'tabs_panels', [ 'group' => 'tabs_panels:design' ] ),

        cs_control( 'text-format', 'tabs_panels', [ 'group' => 'tabs_panels:text' ] ),
        cs_control( 'text-shadow', 'tabs_panels', [ 'group' => 'tabs_panels:text' ] )

      ],
      'control_nav' => [
        'tabs'                => cs_recall( 'label_tabs' ),
        'tabs:children'       => cs_recall( 'label_children' ),
        'tabs:setup'          => cs_recall( 'label_setup' ),
        'tabs:size'           => cs_recall( 'label_size' ),
        'tabs:design'         => cs_recall( 'label_design' ),

        'tabs_tablist'        => cs_recall( 'label_tab_list' ),
        'tabs_tablist:setup'  => cs_recall( 'label_setup' ),
        'tabs_tablist:design' => cs_recall( 'label_design' ),

        'tabs_tabs'           => cs_recall( 'label_individual_tabs' ),
        'tabs_tabs:setup'     => cs_recall( 'label_setup' ),
        'tabs_tabs:size'      => cs_recall( 'label_size' ),
        'tabs_tabs:design'    => cs_recall( 'label_design' ),
        'tabs_tabs:text'      => cs_recall( 'label_text' ),

        'tabs_panels'         => cs_recall( 'label_panels' ),
        'tabs_panels:setup'   => cs_recall( 'label_setup' ),
        'tabs_panels:design'  => cs_recall( 'label_design' ),
        'tabs_panels:text'    => cs_recall( 'label_text' ),
      ],
    ],
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true ] )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'tabs', [
  'title'      => __( 'Tabs', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_tabs',
  'tss'        => 'x_element_tss_tabs',
  'render'     => 'x_element_render_tabs',
  'icon'       => 'native',
  'options'    => [
    'add_new_element'  => [ '_type' => 'tab' ],
    'valid_children'   => [ 'tab' ],
    'render_children'  => true,
    'default_children' => [
      [ '_type' => 'tab', 'tab_label_content' => __( 'Tab 1', 'cornerstone' ) ],
      [ '_type' => 'tab', 'tab_label_content' => __( 'Tab 2', 'cornerstone' ), 'tab_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pretium, nisi ut volutpat mollis, leo risus interdum arcu, eget facilisis quam felis id mauris. Ut convallis, lacus nec ornare volutpat, velit turpis scelerisque purus.', '__x__' ) ],
    ],
  ]
] );
