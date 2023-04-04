<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/RATING.PHP
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

function x_control_partial_rating( $settings ) {

  // Setup
  // -----
  // 01. Available types (not used at the moment):
  //     -- 'reviewRating'
  //     -- 'aggregateRating'

  $label_prefix   = ( isset( $settings['label_prefix'] )   ) ? $settings['label_prefix']   : '';
  $k_pre          = ( isset( $settings['k_pre'] )          ) ? $settings['k_pre'] . '_'    : '';
  $group          = ( isset( $settings['group'] )          ) ? $settings['group']          : 'rating';
  $group_title    = ( isset( $settings['group_title'] )    ) ? $settings['group_title']    : cs_recall( 'label_rating' );
  $conditions     = ( isset( $settings['conditions'] )     ) ? $settings['conditions']     : [];
  $allow_enable   = ( isset( $settings['allow_enable'] )   ) ? $settings['allow_enable']   : [];
  $controls_setup = ( isset( $settings['controls_setup'] ) ) ? $settings['controls_setup'] : [];
  $type           = ( isset( $settings['type'] )           ) ? $settings['type']           : 'reviewRating'; // 01


  // Groups
  // ------

  $group_rating_setup   = $group . ':setup';
  $group_rating_graphic = $group . ':graphic';
  $group_rating_schema  = $group . ':schema';
  $group_rating_size    = $group . ':size';
  $group_rating_design  = $group . ':design';
  $group_rating_text    = $group . ':text';


  // Individual Conditions
  // ---------------------
  // Not used on actual controls as we need to account for `allow_enable`
  // sometimes. Only setup to make condition management easier.

  $condition_rating                     = ( $allow_enable ) ? [ $k_pre . 'rating' => true ] : [];
  $condition_rating_text                = [ $k_pre . 'rating_text' => true ];
  $condition_rating_graphic_type_icon   = [ $k_pre . 'rating_graphic_type' => 'icon' ];
  $condition_rating_graphic_type_image  = [ $k_pre . 'rating_graphic_type' => 'image' ];
  $condition_rating_schema              = [ $k_pre . 'rating_schema' => true ];


  // Conditions
  // ----------

  $conditions_rating_main               = array_merge( $conditions, [ $condition_rating ] );
  $conditions_rating_text               = array_merge( $conditions, [ $condition_rating, $condition_rating_text ] );
  $conditions_rating_graphic_type_icon  = array_merge( $conditions, [ $condition_rating, $condition_rating_graphic_type_icon ] );
  $conditions_rating_graphic_type_image = array_merge( $conditions, [ $condition_rating, $condition_rating_graphic_type_image ] );
  $conditions_rating_schema             = array_merge( $conditions, [ $condition_rating, $condition_rating_schema ] );


  // Options
  // -------

  $options_rating_graphic_spacing = [
    'available_units' => [ 'px', 'em', 'rem' ],
    'valid_keywords'  => [ 'calc' ],
    'fallback_value'  => '10px',
    'ranges'          => [
      'px'  => [ 'min' => 0, 'max' => 5,   'step' => 1   ],
      'em'  => [ 'min' => 0, 'max' => 0.5, 'step' => 0.1 ],
      'rem' => [ 'min' => 0, 'max' => 0.5, 'step' => 0.1 ],
    ],
  ];

  $options_rating_graphic_image = [
    'height' => 1,
  ];

  $options_rating_image_max_width = [
    'available_units' => [ 'px', 'em', 'rem' ],
    'valid_keywords'  => [ 'calc' ],
    'fallback_value'  => '32px',
    'ranges'          => [
      'px'  => [ 'min' => 10,  'max' => 32, 'step' => 1   ],
      'em'  => [ 'min' => 0.5, 'max' => 2,  'step' => 0.1 ],
      'rem' => [ 'min' => 0.5, 'max' => 2,  'step' => 0.1 ],
    ],
  ];

  $options_rating_schema_item_reviewed          = [ 'placeholder' => cs_recall( 'label_schema_item_reviewed' )               ];
  $options_rating_schema_item_name_content      = [ 'placeholder' => cs_recall( 'label_schema_item_name' )                   ];
  $options_rating_schema_item_telephone_content = [ 'placeholder' => '(555) 555-1234'                                        ];
  $options_rating_schema_item_address_content   = [ 'placeholder' => cs_recall( 'label_schema_item_address' ), 'height' => 3 ];
  $options_rating_schema_item_image_src         = [ 'height' => 3                                                            ];
  $options_rating_schema_author_content         = [ 'placeholder' => cs_recall( 'label_schema_author' )                      ];
  $options_rating_schema_review_body_content    = [ 'height' => 2                                                            ];



  // Settings
  // --------

  $settings_rating_design = [
    'group'      => $group_rating_design,
    'conditions' => $conditions_rating_main,
  ];

  $settings_rating_design_flexbox = [
    'label_prefix' => cs_recall( 'label_content' ),
    'group'        => $group_rating_design,
    'conditions'   => $conditions_rating_text,
    'self_flex'    => true
  ];

  $settings_rating_text_margin = [
    'label_prefix' => cs_recall( 'label_text' ),
    'group'        => $group_rating_text,
    'conditions'   => $conditions_rating_text,
  ];

  $settings_rating_text = [
    'group'      => $group_rating_text,
    'conditions' => $conditions_rating_text,
  ];


  // Individual Controls - Begin
  // ---------------------------

  $control_rating_base_font_size = cs_recall( 'control_mixin_font_size', [ 'key' => 'rating_base_font_size', 'conditions' => $conditions_rating_main ] );

  $control_rating_value_content = [
    'key'        => $k_pre . 'rating_value_content',
    'type'       => 'text',
    'label'      => cs_recall( 'label_rating' ),
    'conditions' => $conditions_rating_main,
    'options'    => $options_rating_value_content,
  ];

  $control_rating_scale_min_content = [
    'key'        => $k_pre . 'rating_scale_min_content',
    'type'       => 'text',
    'label'      => cs_recall( 'label_min_scale' ),
    'conditions' => $conditions_rating_main,
    'options'    => $options_rating_scale_content,
  ];

  $control_rating_scale_max_content = [
    'key'        => $k_pre . 'rating_scale_max_content',
    'type'       => 'text',
    'label'      => cs_recall( 'label_max_scale' ),
    'conditions' => $conditions_rating_main,
    'options'    => $options_rating_scale_content,
  ];

  $control_rating_options = [
    'keys' => [
      'empty_enable' => $k_pre . 'rating_empty',
      'round_enable' => $k_pre . 'rating_round',
      'schema'       => $k_pre . 'rating_schema',
      'text'         => $k_pre . 'rating_text',
    ],
    'type'       => 'checkbox-list',
    'label'      => cs_recall( 'label_options' ),
    'conditions' => $conditions_rating_main,
    'options'    => [
      'list' => [
        [ 'key' => 'empty_enable', 'label' => cs_recall( 'label_empty_icons' ) ],
        [ 'key' => 'round_enable', 'label' => cs_recall( 'label_round_whole' ) ],
        [ 'key' => 'schema',       'label' => cs_recall( 'label_schema' )      ],
        [ 'key' => 'text',         'label' => cs_recall( 'label_text' )        ],
      ],
    ],
  ];

  $control_rating_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => $k_pre . 'rating_bg_color' ], 'conditions' => $conditions_rating_main ] );


  // Individual Controls - Size
  // --------------------------

  $control_rating_width     = cs_recall( 'control_mixin_width',     [ 'key' => $k_pre . 'rating_width', 'conditions' => $conditions_rating_main     ] );
  $control_rating_max_width = cs_recall( 'control_mixin_max_width', [ 'key' => $k_pre . 'rating_max_width', 'conditions' => $conditions_rating_main ] );


  // Individual Controls - Content
  // -----------------------------

  $control_rating_text_content = [
    'key'        => $k_pre . 'rating_text_content',
    'type'       => 'textarea',
    'label'      => cs_recall( 'label_content' ),
    'conditions' => $conditions_rating_text,
    'options'    => [
      'height'  => 2,
      'dc_tags' => [
        [ 'label' => cs_recall( 'label_rating' ), 'value' => '{{rating}}' ],
        [ 'label' => cs_recall( 'label_min' ),    'value' => '{{min}}'    ],
        [ 'label' => cs_recall( 'label_max' ),    'value' => '{{max}}'    ],
      ],
    ],
  ];


  // Individual Controls - Schema
  // ----------------------------

  $control_rating_schema_item_reviewed_type = [
    'key'        => $k_pre . 'rating_schema_item_reviewed_type',
    'type'       => 'text',
    'label'      => cs_recall( 'label_type' ) . '<a href="https://schema.org/Organization" target="_blank" class="tco-control-label-google-maps-styler-link"><span>↪</span></a>',
    'conditions' => $conditions_rating_schema,
    'options'    => $options_rating_schema_item_reviewed,
  ];

  $control_rating_schema_item_name_content = [
    'key'        => $k_pre . 'rating_schema_item_name_content',
    'type'       => 'text',
    'label'      => cs_recall( 'label_item_name' ),
    'conditions' => $conditions_rating_schema,
    'options'    => $options_rating_schema_item_name_content,
  ];

  $control_rating_schema_item_telephone_content = [
    'key'        => $k_pre . 'rating_schema_item_telephone_content',
    'type'       => 'text',
    'label'      => cs_recall( 'label_item_telephone' ),
    'conditions' => $conditions_rating_schema,
    'options'    => $options_rating_schema_item_telephone_content,
  ];

  $control_rating_schema_item_address_content = [
    'key'        => $k_pre . 'rating_schema_item_address_content',
    'type'       => 'textarea',
    'label'      => cs_recall( 'label_item_address' ),
    'conditions' => $conditions_rating_schema,
    'options'    => $options_rating_schema_item_address_content,
  ];

  $control_rating_schema_item_image_src = [
    'key'        => $k_pre . 'rating_schema_item_image_src',
    'type'       => 'image-source',
    'label'      => cs_recall( 'label_item_image' ),
    'conditions' => $conditions_rating_schema,
    'options'    => $options_rating_schema_item_image_src,
  ];

  $control_rating_schema_author_content = [
    'key'        => $k_pre . 'rating_schema_author_content',
    'type'       => 'text',
    'label'      => cs_recall( 'label_author_name' ),
    'conditions' => $conditions_rating_schema,
    'options'    => $options_rating_schema_author_content,
  ];

  $control_rating_schema_review_body_content = [
    'key'        => $k_pre . 'rating_schema_review_body_content',
    'type'       => 'textarea',
    'label'      => cs_recall( 'label_author_review' ),
    'conditions' => $conditions_rating_schema,
    'options'    => $options_rating_schema_review_body_content,
  ];


  // Individual Controls - Graphic
  // -----------------------------

  $control_rating_graphic_type = [
    'key'     => $k_pre . 'rating_graphic_type',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_type' ),
    'options' => [
      'choices' => [
        [ 'value' => 'icon',  'icon' => 'flag'  ],
        [ 'value' => 'image', 'icon' => 'image' ],
      ],
    ],
  ];

  $control_rating_graphic_spacing = [
    'key'       => $k_pre . 'rating_graphic_spacing',
    'type'      => 'unit-slider',
    'label'     => cs_recall( 'label_spacing' ),
    'options'   => $options_rating_graphic_spacing,
  ];


  // Individual Controls - Graphic (Icons)
  // -------------------------------------

  $control_rating_graphic_full_icon = [
    'key'        => $k_pre . 'rating_graphic_full_icon',
    'type'       => 'icon',
    'label'      => cs_recall( 'label_full' ),
    'conditions' => $conditions_rating_graphic_type_icon,
  ];

  $control_rating_graphic_half_icon = [
    'key'        => $k_pre . 'rating_graphic_half_icon',
    'type'       => 'icon',
    'label'      => cs_recall( 'label_half_full' ),
    'conditions' => $conditions_rating_graphic_type_icon,
  ];

  $control_rating_graphic_empty_icon = [
    'key'        => $k_pre . 'rating_graphic_empty_icon',
    'type'       => 'icon',
    'label'      => cs_recall( 'label_empty' ),
    'conditions' => $conditions_rating_graphic_type_icon,
  ];

  $control_rating_graphic_icon_color = [
    'keys'       => [ 'value' => $k_pre . 'rating_graphic_icon_color' ],
    'type'       => 'color',
    'label'      => cs_recall( 'label_graphic' ),
    'conditions' => $conditions_rating_graphic_type_icon,
  ];


  // Individual Controls - Graphic (Images)
  // --------------------------------------

  $control_rating_graphic_full_image_src = [
    'key'        => $k_pre . 'rating_graphic_full_image_src',
    'type'       => 'image-source',
    'label'      => cs_recall( 'label_full' ),
    'conditions' => $conditions_rating_graphic_type_image,
    'options'    => $options_rating_graphic_image,
  ];

  $control_rating_graphic_half_image_src = [
    'key'        => $k_pre . 'rating_graphic_half_image_src',
    'type'       => 'image-source',
    'label'      => cs_recall( 'label_half_full' ),
    'conditions' => $conditions_rating_graphic_type_image,
    'options'    => $options_rating_graphic_image,
  ];

  $control_rating_graphic_empty_image_src = [
    'key'        => $k_pre . 'rating_graphic_empty_image_src',
    'type'       => 'image-source',
    'label'      => cs_recall( 'label_empty' ),
    'conditions' => $conditions_rating_graphic_type_image,
    'options'    => $options_rating_graphic_image,
  ];

  $control_rating_graphic_image_max_width = [
    'key'        => $k_pre . 'rating_graphic_image_max_width',
    'type'       => 'unit',
    'label'      => cs_recall( 'label_max_width' ),
    'options'    => $options_rating_image_max_width,
    'conditions' => $conditions_rating_graphic_type_image,
  ];


  // Control List
  // ------------

  foreach ( $controls_setup as $i => $control ) {
    $controls_setup[$i]['conditions'] = $conditions_rating_main;
  }

  $control_list_rating_setup = array_merge(
    [
      $control_rating_base_font_size,
      $control_rating_value_content,
      [
        'type'     => 'group',
        'label'    => cs_recall( 'label_min_max' ),
        'controls' => [
          $control_rating_scale_min_content,
          $control_rating_scale_max_content,
        ],
      ],
      $control_rating_options,
      $control_rating_bg_color,
    ],
    $controls_setup
  );


  // Control Group
  // -------------

  $control_group_rating_setup = [
    'type'       => 'group',
    'group'      => $group_rating_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_rating_setup,
  ];

  if ( $allow_enable ) {
    $control_group_rating_setup['key']     = $k_pre . 'rating';
    $control_group_rating_setup['options'] = cs_recall( 'options_group_toggle_off_on_bool' );
  }


  // Compose Controls
  // ----------------

  return [
    'controls' => [
      $control_group_rating_setup,
      [
        'type'       => 'group',
        'group'      => $group_rating_graphic,
        'conditions' => $conditions_rating_main,
        'controls'   => [
          $control_rating_graphic_type,
          $control_rating_graphic_full_icon,
          $control_rating_graphic_half_icon,
          $control_rating_graphic_empty_icon,
          $control_rating_graphic_full_image_src,
          $control_rating_graphic_half_image_src,
          $control_rating_graphic_empty_image_src,
          $control_rating_graphic_spacing,
          $control_rating_graphic_icon_color,
          $control_rating_graphic_image_max_width,
        ],
      ],
      [
        'type'       => 'group',
        'group'      => $group_rating_schema,
        'conditions' => $conditions_rating_schema,
        'controls'   => [
          $control_rating_schema_item_reviewed_type,
          $control_rating_schema_item_name_content,
          $control_rating_schema_item_telephone_content,
          $control_rating_schema_item_address_content,
          $control_rating_schema_item_image_src,
          $control_rating_schema_author_content,
          $control_rating_schema_review_body_content,
        ],
      ],
      [
        'type'       => 'group',
        'group'      => $group_rating_size,
        'conditions' => $conditions_rating_main,
        'controls'   => [
          $control_rating_width,
          $control_rating_max_width,
        ],
      ],

      cs_control( 'flexbox',       $k_pre . 'rating', $settings_rating_design_flexbox ),
      cs_control( 'margin',        $k_pre . 'rating', $settings_rating_design ),
      cs_control( 'padding',       $k_pre . 'rating', $settings_rating_design ),
      cs_control( 'border',        $k_pre . 'rating', $settings_rating_design ),
      cs_control( 'border-radius', $k_pre . 'rating', $settings_rating_design ),
      cs_control( 'box-shadow',    $k_pre . 'rating', $settings_rating_design ),

      [
        'type'       => 'group',
        'group'      => $group_rating_text,
        'conditions' => $conditions_rating_main,
        'controls'   => [
          $control_rating_text_content,
        ],
      ],
      cs_control( 'margin',      $k_pre . 'rating_text', $settings_rating_text_margin ),
      cs_control( 'text-format', $k_pre . 'rating', $settings_rating_text ),
      cs_control( 'text-shadow', $k_pre . 'rating', $settings_rating_text )
    ],
    'control_nav' => [
      $group                => $group_title,
      $group_rating_setup   => cs_recall( 'label_setup' ),
      $group_rating_graphic => cs_recall( 'label_graphic' ),
      $group_rating_schema  => cs_recall( 'label_schema' ),
      $group_rating_size    => cs_recall( 'label_size' ),
      $group_rating_design  => cs_recall( 'label_design' ),
      $group_rating_text    => cs_recall( 'label_text' ),
    ]
  ];
}

cs_register_control_partial( 'rating', 'x_control_partial_rating' );
