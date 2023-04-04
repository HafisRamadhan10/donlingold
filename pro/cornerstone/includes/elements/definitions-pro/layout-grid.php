<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/LAYOUT-GRID.PHP
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
  array(
    'layout_grid_template_columns'      => cs_value( '1fr', 'style' ),
    'layout_grid_template_rows'         => cs_value( 'auto', 'style' ),

    'layout_grid_gap_column'            => cs_value( '20px', 'style' ),
    'layout_grid_gap_row'               => cs_value( '20px', 'style' ),
    'layout_grid_justify_content'       => cs_value( 'center', 'style' ),
    'layout_grid_align_content'         => cs_value( 'start', 'style' ),
    'layout_grid_justify_items'         => cs_value( 'stretch', 'style' ),
    'layout_grid_align_items'           => cs_value( 'stretch', 'style' ),

    'layout_grid_base_font_size'        => cs_value( '1em', 'style' ),
    'layout_grid_tag'                   => cs_value( 'div', 'markup' ),
    'layout_grid_global_container'      => cs_value( false, 'markup' ),
    'layout_grid_width'                 => cs_value( 'auto', 'style' ),
    'layout_grid_max_width'             => cs_value( 'none', 'style' ),
    'layout_grid_text_align'            => cs_value( 'none', 'style' ),
    'layout_grid_overflow'              => cs_value( 'visible', 'style' ),
    'layout_grid_z_index'               => cs_value( 'auto', 'style' ),
    'layout_grid_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'layout_grid_bg_color_alt'          => cs_value( '', 'style:color' ),
    'layout_grid_bg_advanced'           => cs_value( false, 'markup' ),

    'layout_grid_href'                  => cs_value( '', 'markup', true ),
    'layout_grid_blank'                 => cs_value( false, 'markup', true ),
    'layout_grid_nofollow'              => cs_value( false, 'markup', true ),

    'layout_grid_margin'                => cs_value( '!0px auto 0px auto', 'style' ),
    'layout_grid_padding'               => cs_value( '!0px 0px 0px 0px', 'style' ),
    'layout_grid_border_width'          => cs_value( '!0px', 'style' ),
    'layout_grid_border_style'          => cs_value( 'solid', 'style' ),
    'layout_grid_border_color'          => cs_value( 'transparent', 'style:color' ),
    'layout_grid_border_color_alt'      => cs_value( '', 'style:color' ),
    'layout_grid_border_radius'         => cs_value( '!0px', 'style' ),
    'layout_grid_box_shadow_dimensions' => cs_value( '!0px 0px 0px 0px', 'style' ),
    'layout_grid_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
    'layout_grid_box_shadow_color_alt'  => cs_value( '', 'style:color' ),
  ),
  cs_values( 'particle', 'layout_grid_primary' ),
  cs_values( 'particle', 'layout_grid_secondary' ),
  'omega',
  'omega:custom-atts',
  'omega:looper-provider',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_tss_layout_grid() {

  return [
    'modules' => [
      'layout-grid',
      'effects',
      ['particle', [
        'name'  => 'particle-primary',
        'args' => [
          'selector' => '.is-primary',
          'isDirectChild' => true
        ],
        'remap' => [
          'layout_grid_primary_particle' => 'particle',
          'effects_duration' => 'duration',
          'effects_timing_function' => 'timing_function'
        ]
      ]],
      ['particle', [
        'name'  => 'particle-secondary',
        'args' => [
          'selector' => '.is-secondary',
          'isDirectChild' => true
        ],
        'remap' => [
          'layout_grid_secondary_particle' => 'particle',
          'effects_duration' => 'duration',
          'effects_timing_function' => 'timing_function'
        ]
      ]]
    ]
  ];
}


// Render
// =============================================================================

function x_element_render_layout_grid( $data ) {


  // Prepare Attr Values
  // -------------------

  $classes = ['x-grid'];

  if ( $data['layout_grid_global_container'] == true ) {
    $classes[] = 'x-container max width';
  }

  // Particles
  // ---------

  $particles = cs_make_particles( $data, 'layout_grid' );

  if ( ! empty( $particles ) ) {
    $classes[] = 'has-particle';
  }

  // Atts
  // ----

  $atts = [
    'class' => array_merge( $classes, $data['classes'] )
  ];

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }

  if ( isset( $data['id'] ) && ! empty( $data['id'] ) ) {
    $atts['id'] = $data['id'];
  }

  if ( $data['layout_grid_tag'] === 'a' ) {
    $atts = cs_apply_link( $atts, $data, 'layout_grid' );
  }

  $atts = cs_apply_effect( $atts, $data );


  // Output
  // ------

  return cs_tag( $data['layout_grid_tag'], $atts, $data['custom_atts'], [
    $data['layout_grid_bg_advanced'] ? cs_make_bg( $data ) : '',
    cs_render_child_elements( $data, 'x_layout_grid' ),
    $particles
  ]);

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_layout_grid() {

  // Helpers
  // -------

  $base_group                               = 'layout_grid';
  $group_layout_grid_children               = $base_group . ':children';
  $group_layout_grid_setup                  = $base_group . ':setup';
  $group_layout_grid_link                   = $base_group . ':link';
  $group_layout_grid_background_layers      = $base_group . ':background-layers';
  $group_layout_grid_layout                 = $base_group . ':layout';
  $group_layout_grid_size                   = $base_group . ':size';
  $group_layout_grid_design                 = $base_group . ':design';
  $group_layout_grid_particles              = $base_group . ':particles';

  $condition_layout_grid_is_anchor          = array( 'layout_grid_tag' => 'a' );
  $condition_layout_grid_is_not_anchor      = array( 'key' => 'layout_grid_tag', 'op' => '!=', 'value' => 'a' );
  $condition_layout_grid_container_enabled  = array( 'layout_grid_global_container' => true );
  $condition_layout_grid_container_disabled = array( 'layout_grid_global_container' => false );


  // Settings
  // --------

  $settings_layout_grid_design_no_color = array(
    'group' => $group_layout_grid_design,
  );

  $settings_layout_grid_design_margin = array(
    'group' => $group_layout_grid_design,
    'options' => array(
      'left'  => array( 'disabled' => true, 'fallback_value' => 'auto' ),
      'right' => array( 'disabled' => true, 'fallback_value' => 'auto' ),
    ),
  );

  $settings_layout_grid_design_with_color = array(
    'group'     => $group_layout_grid_design,
    'alt_color' => true,
    'options'   => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  );


  // Individual Controls - Children
  // ------------------------------

  $control_layout_grid_children = array(
    'type'  => 'sortable',
    'group' => $group_layout_grid_children,
  );


  // Individual Controls - Setup
  // ---------------------------

  $control_layout_grid_base_font_size = cs_recall( 'control_mixin_font_size',        [ 'key' => 'layout_grid_base_font_size'                                                                                         ] );
  $control_layout_grid_tag            = cs_recall( 'control_mixin_layout_tag',       [ 'key' => 'layout_grid_tag'                                                                                                    ] );
  $control_layout_grid_text_align     = cs_recall( 'control_mixin_text_align',       [ 'key' => 'layout_grid_text_align'                                                                                             ] );
  $control_layout_grid_overflow       = cs_recall( 'control_mixin_overflow',         [ 'key' => 'layout_grid_overflow'                                                                                               ] );
  $control_layout_grid_z_index        = cs_recall( 'control_mixin_z_index',          [ 'key' => 'layout_grid_z_index'                                                                                                ] );
  $control_layout_grid_background     = cs_recall( 'control_mixin_bg_color_int_adv', [ 'keys' => [ 'value' => 'layout_grid_bg_color', 'alt' => 'layout_grid_bg_color_alt', 'checkbox' => 'layout_grid_bg_advanced' ] ] );


  // Individual Controls - Link
  // --------------------------

  $control_layout_grid_link = [
    'keys' => [
      'url'      => 'layout_grid_href',
      'new_tab'  => 'layout_grid_blank',
      'nofollow' => 'layout_grid_nofollow',
    ],
    'type'      => 'link',
    'group'     => $group_layout_grid_link,
    'condition' => $condition_layout_grid_is_anchor,
  ];


  // Individual Controls - Layout
  // ----------------------------

  $control_layout_grid_template_preview = array(
    'keys'    => [
      'rows'    => 'layout_grid_template_rows',
      'columns' => 'layout_grid_template_columns',
    ],
    'type'    => 'layout-grid-preview',
    'options' => array( 'height' => 4 ),
  );

  $control_layout_grid_template_columns = array(
    'key'   => 'layout_grid_template_columns',
    'type'  => 'layout-grid-template',
    'label' => cs_recall( 'label_columns' ),
    'options' => [
      'empty' => [
        'title'   => cs_recall( 'label_get_started' ),
        'message' => __( 'Click + to begin creating a Column Template.', '__x__' ),
      ]
    ]
  );

  $control_layout_grid_template_rows = array(
    'key'   => 'layout_grid_template_rows',
    'type'  => 'layout-grid-template',
    'label' => cs_recall( 'label_rows' ),
    'options' => [
      'empty' => [
        'title'   => cs_recall( 'label_get_started' ),
        'message' => __( 'Click + to begin creating a Row Template.', '__x__' ),
      ]
    ]
  );

  $control_layout_grid_gap_column      = cs_recall( 'control_mixin_gap',             [ 'key' => 'layout_grid_gap_column', 'label' => cs_recall( 'label_gap_width' )      ] ); // width
  $control_layout_grid_gap_row         = cs_recall( 'control_mixin_gap',             [ 'key' => 'layout_grid_gap_row', 'label' => cs_recall( 'label_gap_height' )        ] ); // height
  $control_layout_grid_justify_content = cs_recall( 'control_mixin_justify_content', [ 'key' => 'layout_grid_justify_content', 'label' => cs_recall( 'label_content_x' ) ] ); // X Content
  $control_layout_grid_align_content   = cs_recall( 'control_mixin_align_content',   [ 'key' => 'layout_grid_align_content', 'label' => cs_recall( 'label_content_y' )   ] ); // Y Content
  $control_layout_grid_justify_items   = cs_recall( 'control_mixin_justify_items',   [ 'key' => 'layout_grid_justify_items', 'label' => cs_recall( 'label_items_x' )     ] ); // X Items
  $control_layout_grid_align_items     = cs_recall( 'control_mixin_align_items',     [ 'key' => 'layout_grid_align_items', 'label' => cs_recall( 'label_items_y' )       ] ); // Y Items


  // Individual Controls - Size
  // --------------------------

  $control_layout_grid_global_container             = cs_recall( 'control_mixin_global_container',                [ 'key' => 'layout_grid_global_container'                                                          ] );
  $control_layout_grid_global_container_placeholder = cs_recall( 'control_mixin_global_container_placeholder_x2', [ 'key' => 'layout_grid_global_container', 'condition' => $condition_layout_grid_container_enabled ] );
  $control_layout_grid_width                        = cs_recall( 'control_mixin_width',                           [ 'key' => 'layout_grid_width', 'condition' => $condition_layout_grid_container_disabled           ] );
  $control_layout_grid_max_width                    = cs_recall( 'control_mixin_max_width',                       [ 'key' => 'layout_grid_max_width', 'condition' => $condition_layout_grid_container_disabled       ] );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    [
      'controls' => [
        $control_layout_grid_children,
        [
          'type'     => 'group',
          'group'    => $group_layout_grid_setup,
          'controls' => [
            $control_layout_grid_base_font_size,
            $control_layout_grid_tag,
            $control_layout_grid_text_align,
            $control_layout_grid_overflow,
            $control_layout_grid_z_index,
            $control_layout_grid_background,
          ],
        ],
        [
          'type'     => 'group',
          'group'    => $group_layout_grid_layout,
          'controls' => [
            $control_layout_grid_template_preview,
            $control_layout_grid_template_columns,
            $control_layout_grid_template_rows,
            $control_layout_grid_gap_column,
            $control_layout_grid_gap_row,
            $control_layout_grid_justify_content,
            $control_layout_grid_align_content,
            $control_layout_grid_justify_items,
            $control_layout_grid_align_items,
          ],
        ],
        $control_layout_grid_link,
        [
          'keys'     => [ 'checkbox' => 'layout_grid_global_container' ],
          'type'     => 'group',
          'group'    => $group_layout_grid_size,
          'options'  => [
            'vertical_label'   => cs_recall( 'label_nbsp' ),
            'horizontal_label' => cs_recall( 'label_size' ),
            'checkbox'         => cs_recall( 'options_group_checkbox_off_on_bool', [ 'label' => cs_recall( 'label_global_container' ) ] )
          ],
          'controls' => [
            $control_layout_grid_global_container_placeholder,
            $control_layout_grid_width,
            $control_layout_grid_max_width,
          ],
        ],
      ],
      'control_nav' => [
        $base_group                          => cs_recall( 'label_grid' ),
        $group_layout_grid_children          => cs_recall( 'label_children' ),
        $group_layout_grid_setup             => cs_recall( 'label_setup' ),
        $group_layout_grid_layout            => cs_recall( 'label_layout' ),
        $group_layout_grid_background_layers => cs_recall( 'label_background_layers' ),
        $group_layout_grid_link              => cs_recall( 'label_link' ),
        $group_layout_grid_size              => cs_recall( 'label_size' ),
        $group_layout_grid_design            => cs_recall( 'label_design' ),
        $group_layout_grid_particles         => cs_recall( 'label_particles' ),
      ],
    ],
    cs_partial_controls( 'bg', [
      'group'     => $group_layout_grid_background_layers,
      'condition' => array( 'layout_grid_bg_advanced' => true ),
    ] ),
    [
      'controls' => [
        cs_control( 'margin', 'layout_grid', $settings_layout_grid_design_margin ),
        cs_control( 'padding', 'layout_grid', $settings_layout_grid_design_no_color ),
        cs_control( 'border', 'layout_grid', $settings_layout_grid_design_with_color ),
        cs_control( 'border-radius', 'layout_grid', $settings_layout_grid_design_no_color ),
        cs_control( 'box-shadow', 'layout_grid', $settings_layout_grid_design_with_color )
      ]
    ],
    cs_partial_controls( 'particle', [
      'label_prefix' => cs_recall( 'label_primary' ),
      'k_pre'        => 'layout_grid_primary',
      'group'        => $group_layout_grid_particles,
    ] ),
    cs_partial_controls( 'particle', [
      'label_prefix' => cs_recall( 'label_secondary' ),
      'k_pre'        => 'layout_grid_secondary',
      'group'        => $group_layout_grid_particles,
    ] ),
    cs_partial_controls( 'effects', [ 'has_provider' => true ] ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true, 'add_looper_provider' => true, 'add_looper_consumer' => true ] )
  );

}



// Grid Presets
// =============================================================================

function x_layout_grid_presets() {

  // Template Management
  // 1. Inspect a Grid element
  // 2. Dev Toolkit > Tools > Elements > Prefab Values
  // 3. Paste resulting PHP to template property below

  return [
    'option-01' => [
      'title' => __( '2 Columns', 'cornerstone' ),
      'previewCellCount' =>  4,
      'values' => [
        '_type'                             => 'layout-grid',
        '_bp_base'                          => '4_4',
        '_bp_data4_4'                       => [
          'layout_grid_template_columns' => [
            null,
            '1fr',
            null,
            null,
            null
          ]
        ],
        '_m'                                => [
          'e' => 1
        ],
        'layout_grid_global_container'      => true,
        'layout_grid_template_columns'      => '1fr 1fr',
        '_modules'                          => [
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ]
        ]
      ]
    ],
    'option-02' => [
      'title' => __( '3 Columns', 'cornerstone' ),
      'previewCellCount' =>  6,
      'values' => [
        '_type'                             => 'layout-grid',
        '_bp_base'                          => '4_4',
        '_bp_data4_4'                       => [
          'layout_grid_template_columns' => [
            null,
            '1fr',
            '1fr 1fr',
            null,
            null
          ]
        ],
        '_m'                                => [
          'e' => 1
        ],
        'layout_grid_global_container'      => true,
        'layout_grid_template_columns'      => '1fr 1fr 1fr',
        '_modules'                          => [
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ]
        ]
      ]
    ],
    'option-03' => [
      'title' => __( '4 Columns', 'cornerstone' ),
      'previewCellCount' =>  8,
      'values' => [
        '_type'                             => 'layout-grid',
        '_bp_base'                          => '4_4',
        '_bp_data4_4'                       => [
          'layout_grid_template_columns' => [
            '1fr',
            null,
            '1fr 1fr',
            null,
            null
          ]
        ],
        '_m'                                => [
          'e' => 1
        ],
        'layout_grid_global_container'      => true,
        'layout_grid_template_columns'      => '1fr 1fr 1fr 1fr',
        '_modules'                          => [
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ]
        ]
      ]
    ],
    'option-04' => [
      'title' => __( 'Domino (2fr 1fr)', 'cornerstone' ),
      'previewCellCount' =>  3,
      'values' => [
        '_type'                             => 'layout-grid',
        '_bp_base'                          => '4_4',
        '_bp_data4_4'                       => [
          'layout_grid_template_columns' => [
            null,
            '1fr',
            '1fr 1fr',
            null,
            null
          ]
        ],
        '_m'                                => [
          'e' => 1
        ],
        'layout_grid_global_container'      => true,
        'layout_grid_template_columns'      => '2fr 1fr',
        '_modules'                          => [
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                '',
                null,
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                '',
                '3',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '2',
            'layout_cell_column_start'          => '1',
            'layout_cell_row_end'               => '3',
            'layout_cell_row_start'             => '1'
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ]
        ]
      ]
    ],
    'option-05' => [
      'title' => __( 'Domino (1fr 2fr)', 'cornerstone' ),
      'previewCellCount' =>  3,
      'values' => [
        '_type'                             => 'layout-grid',
        '_bp_base'                          => '4_4',
        '_bp_data4_4'                       => [
          'layout_grid_template_columns' => [
            null,
            '1fr',
            '1fr 1fr',
            null,
            null
          ]
        ],
        '_m'                                => [
          'e' => 1
        ],
        'layout_grid_global_container'      => true,
        'layout_grid_template_columns'      => '1fr 2fr',
        '_modules'                          => [
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                '',
                '1',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                '',
                null,
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '3',
            'layout_cell_column_start'          => '2',
            'layout_cell_row_end'               => '3',
            'layout_cell_row_start'             => '1',
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ]
        ]
      ]
    ],
    'option-06' => [
      'title' => __( 'Domino (2fr 1fr 1fr)', 'cornerstone' ),
      'previewCellCount' =>  5,
      'values' => [
        '_type'                             => 'layout-grid',
        '_bp_base'                          => '4_4',
        '_bp_data4_4'                       => [
          'layout_grid_template_columns' => [
            null,
            '1fr',
            '1fr 1fr',
            null,
            null
          ]
        ],
        '_m'                                => [
          'e' => 1
        ],
        'layout_grid_global_container'      => true,
        'layout_grid_template_columns'      => '2fr 1fr 1fr',
        '_modules'                          => [
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                '',
                null,
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                '',
                '3',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '2',
            'layout_cell_column_start'          => '1',
            'layout_cell_row_end'               => '3',
            'layout_cell_row_start'             => '1',
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ]
        ]
      ]
    ],
    'option-07' => [
      'title' => __( 'Domino (1fr 1fr 2fr)', 'cornerstone' ),
      'previewCellCount' =>  5,
      'values' => [
        '_type'                             => 'layout-grid',
        '_bp_base'                          => '4_4',
        '_bp_data4_4'                       => [
          'layout_grid_template_columns' => [
            null,
            '1fr',
            '1fr 1fr',
            null,
            null
          ]
        ],
        '_m'                                => [
          'e' => 1
        ],
        'layout_grid_global_container'      => true,
        'layout_grid_template_columns'      => '1fr 1fr 2fr',
        '_modules'                          => [
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                '',
                '1',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                '',
                '3',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '4',
            'layout_cell_column_start'          => '3',
            'layout_cell_row_end'               => '3',
            'layout_cell_row_start'             => '1',
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ]
        ]
      ]
    ],
    'option-08' => [
      'title' => __( 'Cell Overlap (Standard)', 'cornerstone' ),
      'previewCellCount' =>  2,
      'values' => [
        '_type'                             => 'layout-grid',
        '_bp_base'                          => '4_4',
        '_bp_data4_4'                       => [
          'layout_grid_template_columns' => [
            '1rem 1fr 1rem',
            '2rem 1fr 2rem',
            null,
            null,
            null
          ],
          'layout_grid_template_rows'    => [
            null,
            'auto 2rem auto',
            null,
            null,
            null
          ]
        ],
        '_m'                                => [
          'e' => 1
        ],
        'layout_grid_global_container'      => true,
        'layout_grid_template_columns'      => '1fr 4rem 1fr',
        'layout_grid_template_rows'         => '4rem 1fr 4rem',
        '_modules'                          => [
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_row_end' => [
                null,
                '3',
                null,
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_bg_color'              => 'rgba(0, 0, 0, 0.1)',
            'layout_cell_column_end'            => '3',
            'layout_cell_column_start'          => '1',
            'layout_cell_row_end'               => '4',
            'layout_cell_row_start'             => '1',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_row_end' => [
                null,
                '4',
                null,
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_bg_color'              => 'rgba(0, 0, 0, 0.1)',
            'layout_cell_column_end'            => '4',
            'layout_cell_column_start'          => '2',
            'layout_cell_row_end'               => '3',
            'layout_cell_row_start'             => '2',
          ]
        ]
      ]
    ],
    'option-09' => [
      'title' => __( 'Cell Overlap (Reversed)', 'cornerstone' ),
      'previewCellCount' =>  2,
      'values' => [
        '_type'                             => 'layout-grid',
        '_bp_base'                          => '4_4',
        '_bp_data4_4'                       => [
          'layout_grid_template_columns' => [
            '1rem 1fr 1rem',
            '2rem 1fr 2rem',
            null,
            null,
            null
          ],
          'layout_grid_template_rows'    => [
            null,
            'auto 2rem auto',
            null,
            null,
            null
          ]
        ],
        '_m'                                => [
          'e' => 1
        ],
        'layout_grid_global_container'      => true,
        'layout_grid_template_columns'      => '1fr 4rem 1fr',
        'layout_grid_template_rows'         => '4rem 1fr 4rem',
        '_modules'                          => [
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_row_end' => [
                null,
                '3',
                null,
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_bg_color'              => 'rgba(0, 0, 0, 0.1)',
            'layout_cell_column_end'            => '4',
            'layout_cell_column_start'          => '2',
            'layout_cell_row_end'               => '4',
            'layout_cell_row_start'             => '1',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_row_end' => [
                null,
                '4',
                null,
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_bg_color'              => 'rgba(0, 0, 0, 0.1)',
            'layout_cell_column_end'            => '3',
            'layout_cell_column_start'          => '1',
            'layout_cell_row_end'               => '3',
            'layout_cell_row_start'             => '2'
          ]
        ]
      ]
    ],
    'option-10' => [
      'title' => __( 'Minmax (Fill Space)', 'cornerstone' ),
      'previewCellCount' =>  6,
      'values' => [
        '_type'                             => 'layout-grid',
        '_bp_base'                          => '4_4',
        '_m'                                => [
          'e' => 1
        ],
        'layout_grid_global_container'      => true,
        'layout_grid_template_columns'      => 'repeat(auto-fit, minmax(16rem, 1fr))',
        '_modules'                          => [
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ]
        ]
      ]
    ],
    'option-11' => [
      'title' => __( 'Minmax (Max Width)', 'cornerstone' ),
      'previewCellCount' =>  6,
      'values' => [
        '_type'                             => 'layout-grid',
        '_bp_base'                          => '4_4',
        '_m'                                => [
          'e' => 1
        ],
        'layout_grid_global_container'      => true,
        'layout_grid_justify_content'       => 'space-evenly',
        'layout_grid_template_columns'      => 'repeat(auto-fit, minmax(16rem, 16rem))',
        '_modules'                          => [
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ],
          [
            '_type'    => 'layout-cell',
            '_bp_base' => '4_4',
            '_m'       => [ 'e' => 1 ]
          ]
        ]
      ]
    ],
    'option-12' => [
      'title' => __( 'Offset Masonry', 'cornerstone' ),
      'previewCellCount' =>  9,
      'values' => [
        '_type'                             => 'layout-grid',
        '_bp_base'                          => '4_4',
        '_bp_data4_4'                       => [
          'layout_grid_template_columns' => [
            '1rem 1fr 1rem',
            '5rem 1fr 5rem',
            '1fr 1fr',
            null,
            null
          ]
        ],
        '_m'                                => [
          'e' => 1
        ],
        'layout_grid_global_container'      => true,
        'layout_grid_template_columns'      => '1fr 1fr 1fr',
        '_modules'                          => [
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                '1',
                null,
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                'span 2',
                null,
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                '',
                '2',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                '',
                'span 2',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_row_end'               => 'span 3',
            'layout_cell_row_start'             => '3',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                'span 2',
                null,
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                '4',
                null,
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                '',
                '1',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                '',
                'span 2',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_row_end'               => 'span 3',
            'layout_cell_row_start'             => '2',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                '1',
                null,
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                'span 2',
                null,
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                '',
                'auto',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                '',
                'span 2',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_row_end'               => 'span 3',
            'layout_cell_row_start'             => '1',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                'span 2',
                null,
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                '4',
                null,
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                '',
                null,
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                '',
                'span 2',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_row_end'               => 'span 3',
            'layout_cell_row_start'             => 'auto',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                '1',
                null,
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                'span 2',
                null,
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                '',
                null,
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                '',
                'span 2',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_row_end'               => 'span 3',
            'layout_cell_row_start'             => 'auto',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                'span 2',
                null,
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                '4',
                null,
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                '',
                null,
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                '',
                'span 2',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_row_end'               => 'span 3',
            'layout_cell_row_start'             => 'auto',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                '1',
                null,
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                'span 2',
                null,
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                '',
                null,
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                '',
                'span 2',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_row_end'               => 'span 3',
            'layout_cell_row_start'             => 'auto',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                'span 2',
                null,
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                '4',
                null,
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                '',
                null,
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                '',
                'span 2',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_row_end'               => 'span 3',
            'layout_cell_row_start'             => 'auto',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                '1',
                null,
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                'span 2',
                null,
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                '',
                null,
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                '',
                'span 2',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_row_end'               => 'span 3',
            'layout_cell_row_start'             => 'auto',
          ]
        ]
      ]
    ],
    'option-13' => [
      'title' => __( 'Pyramid', 'cornerstone' ),
      'previewCellCount' =>  6,
      'values' => [
        '_type'                             => 'layout-grid',
        '_bp_base'                          => '4_4',
        '_bp_data4_4'                       => [
          'layout_grid_template_columns' => [
            null,
            '1fr',
            '1fr 1fr',
            null,
            null
          ]
        ],
        '_m'                                => [
          'e' => 1
        ],
        'layout_grid_global_container'      => true,
        'layout_grid_template_columns'      => 'repeat(6, 1fr)',
        '_modules'                          => [
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '5',
            'layout_cell_column_start'          => '3',
            'layout_cell_row_end'               => '2',
            'layout_cell_row_start'             => '1',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '4',
            'layout_cell_column_start'          => '2',
            'layout_cell_row_end'               => '3',
            'layout_cell_row_start'             => '2',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '6',
            'layout_cell_column_start'          => '4',
            'layout_cell_row_end'               => '3',
            'layout_cell_row_start'             => '2',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '3',
            'layout_cell_column_start'          => '1',
            'layout_cell_row_end'               => '4',
            'layout_cell_row_start'             => '3',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '5',
            'layout_cell_column_start'          => '3',
            'layout_cell_row_end'               => '4',
            'layout_cell_row_start'             => '3',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '7',
            'layout_cell_column_start'          => '5',
            'layout_cell_row_end'               => '4',
            'layout_cell_row_start'             => '3',
          ]
        ]
      ]
    ],
    'option-14' => [
      'title' => __( 'Board Game', 'cornerstone' ),
      'previewCellCount' =>  13,
      'values' => [
        '_type'                             => 'layout-grid',
        '_bp_base'                          => '4_4',
        '_bp_data4_4'                       => [
          'layout_grid_template_columns' => [
            '1fr',
            null,
            '1fr 1fr',
            null,
            null
          ]
        ],
        '_m'                                => [
          'e' => 1
        ],
        'layout_grid_global_container'      => true,
        'layout_grid_template_columns'      => '1fr 1fr 1fr 1fr',
        '_modules'                          => [
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                '',
                null,
                '1',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                '',
                null,
                '-1',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '4',
            'layout_cell_column_start'          => '2',
            'layout_cell_row_end'               => '4',
            'layout_cell_row_start'             => '2',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '2',
            'layout_cell_column_start'          => '1',
            'layout_cell_row_end'               => '2',
            'layout_cell_row_start'             => '1',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '3',
            'layout_cell_column_start'          => '2',
            'layout_cell_row_end'               => '2',
            'layout_cell_row_start'             => '1',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '4',
            'layout_cell_column_start'          => '3',
            'layout_cell_row_end'               => '2',
            'layout_cell_row_start'             => '1',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '5',
            'layout_cell_column_start'          => '4',
            'layout_cell_row_end'               => '2',
            'layout_cell_row_start'             => '1',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '5',
            'layout_cell_column_start'          => '4',
            'layout_cell_row_end'               => '3',
            'layout_cell_row_start'             => '2',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_label'                            => 'Cell 7',
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '5',
            'layout_cell_column_start'          => '4',
            'layout_cell_row_end'               => '4',
            'layout_cell_row_start'             => '3',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '5',
            'layout_cell_column_start'          => '4',
            'layout_cell_row_end'               => '5',
            'layout_cell_row_start'             => '4',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '4',
            'layout_cell_column_start'          => '3',
            'layout_cell_row_end'               => '5',
            'layout_cell_row_start'             => '4',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '3',
            'layout_cell_column_start'          => '2',
            'layout_cell_row_end'               => '5',
            'layout_cell_row_start'             => '4',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '2',
            'layout_cell_column_start'          => '1',
            'layout_cell_row_end'               => '5',
            'layout_cell_row_start'             => '4',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '2',
            'layout_cell_column_start'          => '1',
            'layout_cell_row_end'               => '4',
            'layout_cell_row_start'             => '3',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '2',
            'layout_cell_column_start'          => '1',
            'layout_cell_row_end'               => '3',
            'layout_cell_row_start'             => '2',
          ]
        ]
      ]
    ],
    'option-15' => [
      'title' => __( 'Mosaic', 'cornerstone' ),
      'previewCellCount' =>  9,
      'values' => [
        '_type'                             => 'layout-grid',
        '_bp_base'                          => '4_4',
        '_bp_data4_4'                       => [
          'layout_grid_template_columns' => [
            'repeat(4, 1fr)',
            null,
            'repeat(6, 1fr)',
            null,
            null
          ],
          'layout_grid_template_rows'    => [
            'repeat(6, minmax(min-content, calc(100vw / 4)))',
            'repeat(6, minmax(min-content, calc(100vw / 6)))',
            'repeat(5, minmax(min-content, calc(100vw / 6)))',
            null,
            null
          ]
        ],
        '_m'                                => [
          'e' => 1
        ],
        'layout_grid_gap_column'            => '0rem',
        'layout_grid_gap_row'               => '0rem',
        'layout_grid_global_container'      => true,
        'layout_grid_template_columns'      => 'repeat(8, 1fr)',
        'layout_grid_template_rows'         => 'repeat(4, calc(100vw / 8))',
        '_modules'                          => [
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                '1',
                '3',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                '5',
                '6',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '2',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_column_end'            => '8',
            'layout_cell_column_start'          => '5',
            'layout_cell_row_end'               => '3',
            'layout_cell_row_start'             => '1',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_end' => [
                '2',
                '3',
                null,
                null,
                null
              ],
              'layout_cell_row_start'  => [
                null,
                '3',
                '2',
                null,
                null
              ],
              'layout_cell_row_end'    => [
                null,
                '4',
                '3',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_bg_color'              => 'rgba(0, 0, 0, 0.8)',
            'layout_cell_column_end'            => '2',
            'layout_cell_column_start'          => '1',
            'layout_cell_row_end'               => '2',
            'layout_cell_row_start'             => '1',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                null,
                '4',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                '5',
                '6',
                '5',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                '6',
                '4',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                '7',
                '5',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_bg_color'              => 'rgba(0, 0, 0, 0.8)',
            'layout_cell_column_end'            => '9',
            'layout_cell_column_start'          => '8',
            'layout_cell_row_end'               => '4',
            'layout_cell_row_start'             => '3',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                '3',
                '4',
                null,
                null,
                null
              ],
              'layout_cell_column_end'   => [
                '5',
                null,
                null,
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '2',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '4',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_bg_color'              => 'rgba(0, 0, 0, 0.5)',
            'layout_cell_column_end'            => '7',
            'layout_cell_column_start'          => '5',
            'layout_cell_row_end'               => '5',
            'layout_cell_row_start'             => '3',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                null,
                '1',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                '3',
                '4',
                '3',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                '4',
                '3',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                '6',
                '5',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_bg_color'              => 'rgba(0, 0, 0, 0.5)',
            'layout_cell_column_end'            => '4',
            'layout_cell_column_start'          => '2',
            'layout_cell_row_end'               => '4',
            'layout_cell_row_start'             => '2',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                '2',
                '3',
                '2',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                '3',
                '4',
                '3',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_bg_color'              => 'rgba(0, 0, 0, 0.15)',
            'layout_cell_column_end'            => '2',
            'layout_cell_column_start'          => '1',
            'layout_cell_row_end'               => '3',
            'layout_cell_row_start'             => '2',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                '4',
                '5',
                '3',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                '5',
                '6',
                '4',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                '4',
                '3',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                '5',
                '4',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_bg_color'              => 'rgba(0, 0, 0, 0.15)',
            'layout_cell_column_end'            => '3',
            'layout_cell_column_start'          => '2',
            'layout_cell_row_end'               => '5',
            'layout_cell_row_start'             => '4',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                '3',
                '6',
                '3',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                '4',
                '7',
                '4',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                null,
                '5',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                null,
                '6',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_bg_color'              => 'rgba(0, 0, 0, 0.15)',
            'layout_cell_column_end'            => '5',
            'layout_cell_column_start'          => '4',
            'layout_cell_row_end'               => '5',
            'layout_cell_row_start'             => '4',
          ],
          [
            '_type'                             => 'layout-cell',
            '_bp_base'                          => '4_4',
            '_bp_data4_4'                       => [
              'layout_cell_column_start' => [
                null,
                '1',
                '6',
                null,
                null
              ],
              'layout_cell_column_end'   => [
                null,
                '2',
                '7',
                null,
                null
              ],
              'layout_cell_row_start'    => [
                null,
                '6',
                '4',
                null,
                null
              ],
              'layout_cell_row_end'      => [
                null,
                '7',
                '5',
                null,
                null
              ]
            ],
            '_m'                                => [
              'e' => 1
            ],
            'layout_cell_bg_color'              => 'rgba(0, 0, 0, 0.15)',
            'layout_cell_column_end'            => '8',
            'layout_cell_column_start'          => '7',
            'layout_cell_row_end'               => '4',
            'layout_cell_row_start'             => '3',
          ]
        ]
      ]
    ],
  ];

}




// Register Element
// =============================================================================

cs_register_element( 'layout-grid', [
  'title'      => __( 'Grid', 'cornerstone' ),
  'values'     => $values,
  'migrations' => [
    [
      'layout_grid_gap_column'            => '1rem',
      'layout_grid_gap_row'               => '1rem',
      'layout_grid_padding'               => '!0px',
      'layout_grid_box_shadow_dimensions' => '!0em 0em 0em 0em',
    ],
  ],
  'components' => [ 'bg', 'effects' ],
  'builder'  => 'x_element_builder_setup_layout_grid',
  'tss' => 'x_element_tss_layout_grid',
  'render'   => 'x_element_render_layout_grid',
  'icon'     => 'native',
  'children' => 'x_layout_grid',
  'options'  => [
    'valid_children'    => [ 'layout-cell' ],
    'index_labels'      => true,
    'is_draggable'      => false,
    // 'library'           => [ 'content', 'layout-single', 'layout-archive' ],
    'empty_placeholder' => false,
    'add_new_element'   => [ '_type' => 'layout-cell' ],
    'tag_key'  => 'layout_grid_tag',
    'contrast_keys'     => [
      'bg:layout_grid_bg_advanced',
      'layout_grid_bg_color'
    ],
    'side_effects' => [
      [
        'observe' => 'layout_grid_bg_advanced',
        'conditions' => [
          ['key' => 'layout_grid_bg_advanced', 'op' => '==', 'value' => true ],
          ['key' => 'layout_grid_z_index',     'op' => '==', 'value' => 'auto' ]
        ],
        'apply' => [
          'layout_grid_z_index' => '1'
        ]
      ]
    ]
  ]
] );
