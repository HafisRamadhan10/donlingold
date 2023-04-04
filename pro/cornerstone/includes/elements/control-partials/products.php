<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/PRODUCTS.PHP
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

function x_control_partial_products( $settings ) {

  // Setup
  // -----
  // 01. Types available include...
  //     - 'cross-sells'
  //     - 'upsells'
  //     - 'related'

  $type = ( isset( $settings['type'] ) ) ? $settings['type'] : 'related'; // 01


  // Groups
  // ------

  $group        = 'products';
  $group_setup  = $group . ':setup';
  $group_design = $group . ':design';


  // Conditions
  // ----------

  $condition_products_is_numbered      = [ 'key' => 'products_numbered_hide', 'op' => 'IN', 'value' => [ 'none', 'xs', 'sm', 'md', 'lg' ] ];
  $condition_products_items_type_text  = [ 'products_items_prev_next_type' => 'text' ];
  $condition_products_items_type_icon  = [ 'products_items_prev_next_type' => 'icon' ];


  // Options
  // -------

  $options_products_count_choose = [
    'choices' => [
      [ 'value' => 1, 'label' => '1' ],
      [ 'value' => 2, 'label' => '2' ],
      [ 'value' => 3, 'label' => '3' ],
      [ 'value' => 4, 'label' => '4' ],
    ],
  ];

  $options_products_count_slider = [
    'unit_mode'      => 'unitless',
    'fallback_value' => 4,
    'min'            => 1,
    'max'            => 12,
    'step'           => 1,
  ];

  $options_products_columns = [
    'choices' => [
      [ 'value' => 1, 'label' => '1' ],
      [ 'value' => 2, 'label' => '2' ],
      [ 'value' => 3, 'label' => '3' ],
      [ 'value' => 4, 'label' => '4' ],
    ],
  ];

  $options_products_orderby = [
    'choices' => [
      [ 'value' => 'rand',       'label' => cs_recall( 'label_random' )     ],
      [ 'value' => 'title',      'label' => cs_recall( 'label_title' )      ],
      [ 'value' => 'ID',         'label' => cs_recall( 'label_id' )         ],
      [ 'value' => 'date',       'label' => cs_recall( 'label_date' )       ],
      [ 'value' => 'modified',   'label' => cs_recall( 'label_modified' )   ],
      [ 'value' => 'menu_order', 'label' => cs_recall( 'label_menu_order' ) ],
      [ 'value' => 'price',      'label' => cs_recall( 'label_price' )      ],
    ],
  ];

  $options_products_order = [
    'choices' => [
      [ 'value' => 'desc', 'label' => cs_recall( 'label_desc' ) ],
      [ 'value' => 'asc',  'label' => cs_recall( 'label_asc' )  ],
    ],
  ];


  // Settings
  // --------

  $settings_products_design = [
    'group' => $group_design,
  ];


  // Individual Controls - Base
  // --------------------------

  $control_products_count_choose = [
    'key'     => 'products_count',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_count' ),
    'options' => $options_products_count_choose,
  ];

  $control_products_count_slider = [
    'key'     => 'products_count',
    'type'    => 'unit-slider',
    'label'   => cs_recall( 'label_count' ),
    'options' => $options_products_count_slider,
  ];

  $control_products_columns = [
    'key'     => 'products_columns',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_columns' ),
    'options' => $options_products_columns,
  ];

  $control_products_orderby = [
    'key'     => 'products_orderby',
    'type'    => 'select',
    'label'   => cs_recall( 'label_orderby' ),
    'options' => $options_products_orderby,
  ];

  $control_products_order = [
    'key'     => 'products_order',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_order' ),
    'options' => $options_products_order,
  ];


  // Compose Controls
  // ----------------

  $controls_products_setup = [
    $control_products_count_slider,
    $control_products_columns,
    $control_products_orderby,
    $control_products_order,
  ];

  return [

    'controls' => [
      [
        'type'     => 'group',
        'group'    => $group_setup,
        'controls' => $controls_products_setup,
      ],
      cs_control( 'margin', 'products', $settings_products_design ),
    ],
    'control_nav' => [
      $group        => cs_recall( 'label_products' ),
      $group_setup  => cs_recall( 'label_setup' ),
      $group_design => cs_recall( 'label_design' ),
    ],
  ];

}

cs_register_control_partial( 'products', 'x_control_partial_products' );
