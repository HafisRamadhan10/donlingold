<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/SLIDE-PAGINATION.PHP
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
    'slide_pagination_base_font_size'               => cs_value( '1em', 'style' ),
    'slide_pagination_direction'                    => cs_value( 'row', 'style' ),
    'slide_pagination_wrap'                         => cs_value( false, 'style' ),
    'slide_pagination_justify'                      => cs_value( 'center', 'style' ),

    'slide_pagination_content_length_main'          => cs_value( 'auto', 'style' ),
    'slide_pagination_content_max_length_main'      => cs_value( 'none', 'style' ),

    'slide_pagination_margin'                       => cs_value( '!0px 0px 0px 0px', 'style' ),

    'slide_pagination_item_gap'                     => cs_value( '4px', 'style' ),
    'slide_pagination_item_length_main'             => cs_value( '12px', 'style' ),
    'slide_pagination_item_length_cross'            => cs_value( '12px', 'style' ),
    'slide_pagination_item_radius'                  => cs_value( '100px', 'style' ),
    'slide_pagination_item_transform'               => cs_value( 'off', 'style' ),
    'slide_pagination_item_grow_out_multiplier'     => cs_value( 3, 'style' ),
    'slide_pagination_item_scale_up_starting_scale' => cs_value( 0.5, 'style' ),
    'slide_pagination_item_bg_color'                => cs_value( 'rgba(0, 0, 0, 0.16)', 'style:color' ),
    'slide_pagination_item_bg_color_alt'            => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  ],
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_slide_pagination() {
  return [
    'modules' => [
      'slide-pagination',
      'effects'
    ]
  ];
}



// Render
// =============================================================================

function x_element_render_slide_pagination( $data ) {

  $atts = [
    'class'                   => array_merge( [ 'x-slide-pagination', 'is-' . $data['slide_pagination_direction'] ], $data['classes'] ),
    'data-x-slide-pagination' => ''
  ];

  if ( isset( $data['id'] ) && ! empty( $data['id'] ) ) {
    $atts['id'] = $data['id'];
  }

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }

  $atts = cs_apply_effect( $atts, $data );

  return cs_tag( 'ul', $atts, $data['custom_atts'], '' );

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_slide_pagination() {

  // Helpers
  // -------

  $group_slide_pagination_base       = 'slide_pagination';
  $group_slide_pagination_setup      = $group_slide_pagination_base . ':setup';
  $group_slide_pagination_size       = $group_slide_pagination_base . ':size';
  $group_slide_pagination_design     = $group_slide_pagination_base . ':design';
  $group_slide_pagination_indicators = $group_slide_pagination_base . ':indicators';


  // Conditions
  // ----------

  $condition_slide_pagination_is_row                = [ 'slide_pagination_direction' => 'row' ];
  $condition_slide_pagination_is_column             = [ 'slide_pagination_direction' => 'column' ];
  $condition_slide_pagination_transform_is_grow_out = [ 'slide_pagination_item_transform' => 'grow-out' ];
  $condition_slide_pagination_transform_is_scale_up = [ 'slide_pagination_item_transform' => 'scale-up' ];


  // Settings
  // --------

  $settings_slide_pagination_design = [
    'group' => $group_slide_pagination_design
  ];


  // Individual Controls - Setup
  // ---------------------------

  $control_slide_pagination_base_font_size = cs_recall( 'control_mixin_font_size',    [ 'key' => 'slide_pagination_base_font_size' ] );
  $control_slide_pagination_direction      = cs_recall( 'control_mixin_direction_rc', [ 'key' => 'slide_pagination_direction'      ] );
  $control_slide_pagination_wrap           = [
    'key'     => 'slide_pagination_wrap',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_wrap' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  ];
  $control_slide_pagination_justify_row    = cs_recall( 'control_mixin_justify_content', [ 'key' => 'slide_pagination_justify', 'label' => cs_recall( 'label_horizontal' ), 'condition' => $condition_slide_pagination_is_row, 'options' => array_merge( cs_recall( 'options_justify_content_flex' ), [ 'icon_direction' => 'x' ] )  ] );
  $control_slide_pagination_justify_column = cs_recall( 'control_mixin_justify_content', [ 'key' => 'slide_pagination_justify', 'label' => cs_recall( 'label_vertical' ), 'condition' => $condition_slide_pagination_is_column, 'options' => array_merge( cs_recall( 'options_justify_content_flex' ), [ 'icon_direction' => 'y' ] ) ] );


  // Individual Controls - Size
  // --------------------------

  $control_slide_pagination_content_length_main_as_width      = cs_recall( 'control_mixin_width',      [ 'key' => 'slide_pagination_content_length_main', 'label' => cs_recall( 'label_width' ), 'condition' => $condition_slide_pagination_is_row             ] );
  $control_slide_pagination_content_max_length_main_as_width  = cs_recall( 'control_mixin_max_width',  [ 'key' => 'slide_pagination_content_max_length_main', 'label' => cs_recall( 'label_max_width' ), 'condition' => $condition_slide_pagination_is_row     ] );
  $control_slide_pagination_content_length_main_as_height     = cs_recall( 'control_mixin_height',     [ 'key' => 'slide_pagination_content_length_main', 'label' => cs_recall( 'label_height' ), 'condition' => $condition_slide_pagination_is_column         ] );
  $control_slide_pagination_content_max_length_main_as_height = cs_recall( 'control_mixin_max_height', [ 'key' => 'slide_pagination_content_max_length_main', 'label' => cs_recall( 'label_max_height' ), 'condition' => $condition_slide_pagination_is_column ] );


  // Individual Controls - Items
  // ---------------------------

  $control_slide_pagination_item_gap                    = cs_recall( 'control_mixin_gap',    [ 'key' => 'slide_pagination_item_gap'                                                                ] );
  $control_slide_pagination_item_length_main_as_width   = cs_recall( 'control_mixin_width',  [ 'key' => 'slide_pagination_item_length_main', 'condition' => $condition_slide_pagination_is_row     ] );
  $control_slide_pagination_item_length_cross_as_height = cs_recall( 'control_mixin_height', [ 'key' => 'slide_pagination_item_length_cross', 'condition' => $condition_slide_pagination_is_row    ] );
  $control_slide_pagination_item_length_cross_as_width  = cs_recall( 'control_mixin_width',  [ 'key' => 'slide_pagination_item_length_cross', 'condition' => $condition_slide_pagination_is_column ] );
  $control_slide_pagination_item_length_main_as_height  = cs_recall( 'control_mixin_height', [ 'key' => 'slide_pagination_item_length_main', 'condition' => $condition_slide_pagination_is_column  ] );
  $control_slide_pagination_item_radius                 = cs_recall( 'control_mixin_width',  [ 'key' => 'slide_pagination_item_radius', 'label' => cs_recall( 'label_radius' )                     ] );

  $control_slide_pagination_item_transform = array(
    'key'     => 'slide_pagination_item_transform',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_transform' ),
    'options' => [
      'off_value' => 'off',
      'choices'   => [
        [ 'value' => 'grow-out', 'label' => cs_recall( 'label_grow_out' ) ],
        [ 'value' => 'scale-up', 'label' => cs_recall( 'label_scale_up' ) ],
      ],
    ],
  );

  $control_slide_pagination_item_grow_out_multiplier = array(
    'key'       => 'slide_pagination_item_grow_out_multiplier',
    'type'      => 'unit-slider',
    'label'     => cs_recall( 'label_multiplier' ),
    'condition' => $condition_slide_pagination_transform_is_grow_out,
    'options'   => [
      'unit_mode'      => 'unitless',
      'fallback_value' => 3,
      'min'            => 2,
      'max'            => 5,
      'step'           => 0.25,
    ]
  );

  $control_slide_pagination_item_scale_up_starting_scale = array(
    'key'       => 'slide_pagination_item_scale_up_starting_scale',
    'type'      => 'unit-slider',
    'label'     => cs_recall( 'label_starts_at' ),
    'condition' => $condition_slide_pagination_transform_is_scale_up,
    'options'   => [
      'unit_mode'      => 'unitless',
      'fallback_value' => 0.5,
      'min'            => 0,
      'max'            => 1,
      'step'           => 0.05,
    ]
  );

  $control_slide_paginatino_item_background = cs_recall( 'control_mixin_bg_color_int', [ 'keys' => [ 'value' => 'slide_pagination_item_bg_color', 'alt' => 'slide_pagination_item_bg_color_alt' ] ] );


  // Output
  // ------

  return cs_compose_controls(
    [
      'controls' => array(
        [
          'type'     => 'group',
          'group'    => $group_slide_pagination_setup,
          'controls' => [
            $control_slide_pagination_base_font_size,
            $control_slide_pagination_direction,
            $control_slide_pagination_wrap,
            $control_slide_pagination_justify_row,
            $control_slide_pagination_justify_column,
          ],
        ],
        [
          'type'     => 'group',
          'group'    => $group_slide_pagination_size,
          'controls' => [
            $control_slide_pagination_content_length_main_as_width,
            $control_slide_pagination_content_max_length_main_as_width,
            $control_slide_pagination_content_length_main_as_height,
            $control_slide_pagination_content_max_length_main_as_height,
          ],
        ],
        cs_control( 'margin', 'slide_pagination', $settings_slide_pagination_design ),
        [
          'type'     => 'group',
          'group'    => $group_slide_pagination_indicators,
          'controls' => [
            $control_slide_pagination_item_gap,
            $control_slide_pagination_item_length_main_as_width,
            $control_slide_pagination_item_length_cross_as_height,
            $control_slide_pagination_item_length_cross_as_width,
            $control_slide_pagination_item_length_main_as_height,
            $control_slide_pagination_item_radius,
            $control_slide_pagination_item_transform,
            $control_slide_pagination_item_grow_out_multiplier,
            $control_slide_pagination_item_scale_up_starting_scale,
            $control_slide_paginatino_item_background,
          ],
        ],
      ),
      'control_nav' => [
        $group_slide_pagination_base       => cs_recall( 'label_slide_pagination' ),
        $group_slide_pagination_setup      => cs_recall( 'label_setup' ),
        $group_slide_pagination_size       => cs_recall( 'label_size' ),
        $group_slide_pagination_design     => cs_recall( 'label_design' ),
        $group_slide_pagination_indicators => cs_recall( 'label_indicators' ),
      ]
    ],
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true ] )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'slide-pagination', [
  'title'      => __( 'Slide Pagination', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_slide_pagination',
  'tss'        => 'x_element_tss_slide_pagination',
  'render'     => 'x_element_render_slide_pagination',
  'icon'       => 'native',
  'options'    => [
    'empty_placeholder' => false
  ]
] );
