<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/CART.PHP
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

function x_control_partial_cart( $settings ) {

  // Setup
  // -----

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'cart';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : cs_recall( 'label_cart' );
  $conditions  = ( isset( $settings['conditions'] )  ) ? $settings['conditions']  : [];
  $is_nested   = ( isset( $settings['is_nested'] )   ) ? $settings['is_nested']   : true;


  // Groups
  // ------

  $group_cart                   = $group;
  $group_cart_setup             = $group . ':setup';
  $group_cart_size              = $group . ':size';
  $group_cart_design            = $group . ':design';

  $group_cart_items             = $group . '_items';
  $group_cart_items_setup       = $group_cart_items . ':setup';
  $group_cart_items_design      = $group_cart_items . ':design';

  $group_cart_thumbnails        = $group . '_thumbnails';
  $group_cart_thumbnails_size   = $group_cart_thumbnails . ':setup';
  $group_cart_thumbnails_design = $group_cart_thumbnails . ':design';

  $group_cart_links             = $group . '_links';
  $group_cart_links_text        = $group_cart_links . ':text';

  $group_cart_quantity          = $group . '_quantity';
  $group_cart_quantity_text     = $group_cart_quantity . ':text';

  $group_cart_total             = $group . '_total';
  $group_cart_total_setup       = $group_cart_total . ':setup';
  $group_cart_total_design      = $group_cart_total . ':design';
  $group_cart_total_text        = $group_cart_total . ':text';

  $group_cart_buttons           = $group . '_buttons';
  $group_cart_buttons_setup     = $group_cart_buttons . ':setup';
  $group_cart_buttons_design    = $group_cart_buttons . ':design';


  // Options
  // -------

  $options_cart_items_display_remove = [
    'choices' => [
      [ 'value' => false, 'label' => cs_recall( 'label_hide' ) ],
      [ 'value' => true,  'label' => cs_recall( 'label_show' ) ],
    ],
  ];

  $options_cart_items_content_spacing = [
    'available_units' => [ 'px', 'em', 'rem' ],
    'fallback_value'  => '15px',
    'ranges'          => [
      'px'  => [ 'min' => '10', 'max' => '25', 'step' => '1'    ],
      'em'  => [ 'min' => '1',  'max' => '2',  'step' => '0.01' ],
      'rem' => [ 'min' => '1',  'max' => '2',  'step' => '0.01' ],
    ],
  ];

  $options_cart_buttons_justify_content = [
    'choices' => [
      [ 'value' => 'flex-start',    'label' => cs_recall( 'label_start' )   ],
      [ 'value' => 'center',        'label' => cs_recall( 'label_center' )  ],
      [ 'value' => 'flex-end',      'label' => cs_recall( 'label_end' )     ],
      [ 'value' => 'space-around',  'label' => cs_recall( 'label_spread' )  ],
      [ 'value' => 'space-between', 'label' => cs_recall( 'label_justify' ) ],
    ],
  ];


  // Settings
  // --------

  $settings_cart_design = [
    'group'      => $group_cart_design,
    'conditions' => $conditions,
  ];

  $settings_cart_title = [
    'label_prefix' => cs_recall( 'label_title' ),
    'group'        => $group_cart_setup,
    'conditions'   => array_merge( $conditions, [ [ 'key' => 'cart_title', 'op' => 'NOT IN', 'value' => [ '' ] ] ] ),
  ];

  $settings_cart_items_design = [
    'group'        => $group_cart_items_design,
    'conditions'   => $conditions,
  ];

  $settings_cart_items_design_with_color = [
    'group'        => $group_cart_items_design,
    'conditions'   => $conditions,
    'alt_color'    => true,
    'options'      => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  ];

  $settings_cart_thumbs = [
    'group'      => $group_cart_thumbnails_design,
    'conditions' => $conditions,
  ];

  $settings_cart_links = [
    'group'      => $group_cart_links_text,
    'conditions' => $conditions,
  ];

  $settings_cart_links_with_color = [
    'group'      => $group_cart_links_text,
    'conditions' => $conditions,
    'alt_color'  => true,
    'options'    => cs_recall( 'options_color_swatch_base_interaction_labels' ),
  ];

  $settings_cart_quantity = [
    'group'      => $group_cart_quantity_text,
    'conditions' => $conditions,
  ];

  $settings_cart_total_design = [
    'group'      => $group_cart_total_design,
    'conditions' => $conditions,
  ];

  $settings_cart_total_text = [
    'group'      => $group_cart_total_text,
    'conditions' => $conditions,
  ];

  $settings_cart_buttons_design = [
    'group'      => $group_cart_buttons_design,
    'conditions' => $conditions,
  ];


  // Individual Controls
  // -------------------

  $control_cart_width     = cs_recall( 'control_mixin_width',     [ 'key' => 'cart_width'     ] );
  $control_cart_max_width = cs_recall( 'control_mixin_max_width', [ 'key' => 'cart_max_width' ] );

  $control_cart_title = [
    'key'   => 'cart_title',
    'type'  => 'text',
    'label' => cs_recall( 'label_title' ),
  ];

  $control_cart_order_items   = cs_recall( 'control_mixin_1_2_3_placement', [ 'key' => 'cart_order_items', 'label' => cs_recall( 'label_items_placement' )     ] );
  $control_cart_order_total   = cs_recall( 'control_mixin_1_2_3_placement', [ 'key' => 'cart_order_total', 'label' => cs_recall( 'label_total_placement' )     ] );
  $control_cart_order_buttons = cs_recall( 'control_mixin_1_2_3_placement', [ 'key' => 'cart_order_buttons', 'label' => cs_recall( 'label_buttons_placement' ) ] );
  $control_cart_bg_color      = cs_recall( 'control_mixin_bg_color_solo',   [ 'keys' => [ 'value' => 'cart_bg' ]                                               ] );

  $control_cart_items_display_remove = [
    'key'     => 'cart_items_display_remove',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_remove_button' ),
    'options' => $options_cart_items_display_remove,
  ];

  $control_cart_items_content_spacing = [
    'key'     => 'cart_items_content_spacing',
    'type'    => 'slider',
    'label'   => cs_recall( 'label_content_spacing' ),
    'options' => $options_cart_items_content_spacing,
  ];

  $control_cart_items_bg_colors = cs_recall( 'control_mixin_bg_color_int', [ 'keys' => [ 'value' => 'cart_items_bg', 'alt' => 'cart_items_bg_alt' ] ] );
  $control_cart_thumbs_width    = cs_recall( 'control_mixin_width', [ 'key' => 'cart_thumbs_width'                                                  ] );
  $control_cart_total_bg        = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'cart_total_bg' ]                              ] );

  $control_cart_buttons_justify_content = [
    'key'     => 'cart_buttons_justify_content',
    'type'    => 'select',
    'label'   => cs_recall( 'label_align_horizontal' ),
    'options' => $options_cart_buttons_justify_content,
  ];

  $control_cart_buttons_bg = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'cart_buttons_bg' ] ] );


  // Control Lists
  // -------------

  $control_list_cart_setup = [];
  $control_group_cart_size = [];

  if ( $is_nested ) {
    $control_list_cart_setup[] = $control_cart_title;
  }

  $control_list_cart_setup[] = $control_cart_order_items;
  $control_list_cart_setup[] = $control_cart_order_total;
  $control_list_cart_setup[] = $control_cart_order_buttons;

  if ( ! $is_nested ) {
    $control_list_cart_setup[] = $control_cart_bg_color;
  }



  // Compose Controls
  // ----------------

  $controls = [
    [
      'type'       => 'group',
      'group'      => $group_cart_setup,
      'conditions' => $conditions,
      'controls'   => $control_list_cart_setup,
    ]
  ];

  if ( ! $is_nested ) {
    $controls[] = [
      'type'       => 'group',
      'group'      => $group_cart_size,
      'conditions' => $conditions,
      'controls'   => [
        $control_cart_width,
        $control_cart_max_width,
      ]
    ];
  }

  if ( $is_nested ) {
    $controls[] = cs_control( 'margin',      'cart_title', $settings_cart_title );
    $controls[] = cs_control( 'text-format', 'cart_title', $settings_cart_title );
    $controls[] = cs_control( 'text-shadow', 'cart_title', $settings_cart_title );
  } else {
    $controls[] = cs_control( 'margin',        'cart', $settings_cart_design );
    $controls[] = cs_control( 'padding',       'cart', $settings_cart_design );
    $controls[] = cs_control( 'border',        'cart', $settings_cart_design );
    $controls[] = cs_control( 'border-radius', 'cart', $settings_cart_design );
    $controls[] = cs_control( 'box-shadow',    'cart', $settings_cart_design );
  }

  $controls = array_merge( $controls, [

    // Items
    // -----

    [
      'type'       => 'group',
      'group'      => $group_cart_items_setup,
      'conditions' => $conditions,
      'controls'   => [
        $control_cart_items_display_remove,
        $control_cart_items_content_spacing,
        $control_cart_items_bg_colors,
      ],
    ],
    cs_control( 'margin',        'cart_items', $settings_cart_items_design            ),
    cs_control( 'padding',       'cart_items', $settings_cart_items_design            ),
    cs_control( 'border',        'cart_items', $settings_cart_items_design_with_color ),
    cs_control( 'border-radius', 'cart_items', $settings_cart_items_design            ),
    cs_control( 'box-shadow',    'cart_items', $settings_cart_items_design_with_color ),
    [
      'type'       => 'group',
      'group'      => $group_cart_thumbnails_size,
      'conditions' => $conditions,
      'controls'   => [
        $control_cart_thumbs_width,
      ],
    ],
    cs_control( 'border-radius', 'cart_thumbs', $settings_cart_thumbs ),
    cs_control( 'box-shadow',    'cart_thumbs', $settings_cart_thumbs ),

    cs_control( 'text-format', 'cart_links', $settings_cart_links ),
    cs_control( 'text-shadow', 'cart_links', $settings_cart_links_with_color ),

    cs_control( 'text-format', 'cart_quantity', $settings_cart_quantity ),
    cs_control( 'text-shadow', 'cart_quantity', $settings_cart_quantity ),


    // Total
    // -----

    [
      'type'       => 'group',
      'group'      => $group_cart_total_setup,
      'conditions' => $conditions,
      'controls'   => [
        $control_cart_total_bg,
      ],
    ],
    cs_control( 'margin',        'cart_total', $settings_cart_total_design ),
    cs_control( 'padding',       'cart_total', $settings_cart_total_design ),
    cs_control( 'border',        'cart_total', $settings_cart_total_design ),
    cs_control( 'border-radius', 'cart_total', $settings_cart_total_design ),
    cs_control( 'box-shadow',    'cart_total', $settings_cart_total_design ),

    cs_control( 'text-format', 'cart_total', $settings_cart_total_text ),
    cs_control( 'text-shadow', 'cart_total', $settings_cart_total_text ),


    // Buttons
    // -------

    [
      'type'       => 'group',
      'group'      => $group_cart_buttons_setup,
      'conditions' => $conditions,
      'controls'   => [
        $control_cart_buttons_justify_content,
        $control_cart_buttons_bg,
      ],
    ],
    cs_control( 'margin',        'cart_buttons', $settings_cart_buttons_design ),
    cs_control( 'padding',       'cart_buttons', $settings_cart_buttons_design ),
    cs_control( 'border',        'cart_buttons', $settings_cart_buttons_design ),
    cs_control( 'border-radius', 'cart_buttons', $settings_cart_buttons_design ),
    cs_control( 'box-shadow',    'cart_buttons', $settings_cart_buttons_design )

  ]);

  if ( $is_nested ) {
    $controls[] = [
      'key'        => 'cart_custom_atts',
      'type'       => 'attributes',
      'group'      => 'omega:setup',
      'label'      => cs_recall( 'label_custom_attributes_with_prefix' ),
      'label_vars' => [ 'prefix' => cs_recall( 'label_cart' ) ]
    ];
  }


  // Render Controls
  // ---------------

  return [
    'controls'    => $controls,
    'control_nav' => [
      $group_cart                   => cs_recall( 'label_cart' ),
      $group_cart_setup             => cs_recall( 'label_setup' ),
      $group_cart_size              => cs_recall( 'label_size' ),
      $group_cart_design            => cs_recall( 'label_design' ),

      $group_cart_items             => cs_recall( 'label_items' ),
      $group_cart_items_setup       => cs_recall( 'label_setup' ),
      $group_cart_items_design      => cs_recall( 'label_design' ),

      $group_cart_thumbnails        => cs_recall( 'label_thumbnail' ),
      $group_cart_thumbnails_size   => cs_recall( 'label_size' ),
      $group_cart_thumbnails_design => cs_recall( 'label_design' ),

      $group_cart_links             => cs_recall( 'label_links' ),
      $group_cart_links_text        => cs_recall( 'label_text' ),

      $group_cart_quantity          => cs_recall( 'label_quantity' ),
      $group_cart_quantity_text     => cs_recall( 'label_text' ),

      $group_cart_total             => cs_recall( 'label_total' ),
      $group_cart_total_setup       => cs_recall( 'label_setup' ),
      $group_cart_total_design      => cs_recall( 'label_design' ),
      $group_cart_total_text        => cs_recall( 'label_text' ),

      $group_cart_buttons           => cs_recall( 'label_buttons_container' ),
      $group_cart_buttons_setup     => cs_recall( 'label_setup' ),
      $group_cart_buttons_design    => cs_recall( 'label_design' ),
    ]
  ];
}

cs_register_control_partial( 'cart', 'x_control_partial_cart' );
