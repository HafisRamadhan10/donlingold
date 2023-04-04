<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/COMMENT-LIST.PHP
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
    'comment_list_type'                          => cs_value( 'all', 'markup' ),
    'comment_list_style'                         => cs_value( 'ol', 'markup' ),
    'comment_list_order'                         => cs_value( 'oldest', 'markup' ),
    'comment_list_messages'                      => cs_value( true, 'markup' ),
    // 'comment_list_base_font_size'                => cs_value( '1em' ),
    // 'comment_list_width'                         => cs_value( 'auto' ),
    // 'comment_list_max_width'                     => cs_value( 'none' ),
    // 'comment_list_bg_color'                      => cs_value( 'transparent', 'style:color' ),
    'comment_list_margin'                        => cs_value( '!0em' ),
    // 'comment_list_padding'                       => cs_value( '!0em' ),
    // 'comment_list_border_width'                  => cs_value( '!0px' ),
    // 'comment_list_border_style'                  => cs_value( 'solid' ),
    // 'comment_list_border_color'                  => cs_value( 'transparent', 'style:color' ),
    // 'comment_list_border_radius'                 => cs_value( '!0px' ),
    // 'comment_list_box_shadow_dimensions'         => cs_value( '!0em 0em 0em 0em' ),
    // 'comment_list_box_shadow_color'              => cs_value( 'transparent', 'style:color' ),
    'comment_list_no_comments_content'           => cs_value( __( 'There are currently no comments. Why don\'t you kick things off?' , '__x__' ), 'markup' ),
    'comment_list_closed_content'                => cs_value( __( 'Comments are closed at this time.' , '__x__' ), 'markup' ),
    'comment_list_message_bg_color'              => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'comment_list_message_padding'               => cs_value( '1.25em' ),
    'comment_list_message_border_width'          => cs_value( '!0px' ),
    'comment_list_message_border_style'          => cs_value( 'solid' ),
    'comment_list_message_border_color'          => cs_value( 'transparent', 'style:color' ),
    'comment_list_message_border_radius'         => cs_value( '4px' ),
    'comment_list_message_box_shadow_dimensions' => cs_value( '0em 0.65em 1.5em 0em' ),
    'comment_list_message_box_shadow_color'      => cs_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
    'comment_list_message_font_family'           => cs_value( 'inherit', 'style:font-family' ),
    'comment_list_message_font_weight'           => cs_value( 'inherit:400', 'style:font-weight' ),
    'comment_list_message_font_size'             => cs_value( '1em' ),
    'comment_list_message_letter_spacing'        => cs_value( '0em' ),
    'comment_list_message_line_height'           => cs_value( '1.6' ),
    'comment_list_message_font_style'            => cs_value( 'normal' ),
    'comment_list_message_text_align'            => cs_value( 'center' ),
    'comment_list_message_text_decoration'       => cs_value( 'none' ),
    'comment_list_message_text_transform'        => cs_value( 'none' ),
    'comment_list_message_text_color'            => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  ],
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_comment_list() {
  return [
    'require' => [ 'elements-wp' ],
    'modules' => [ 'comment-list', 'effects' ]
  ];
}


// Render
// =============================================================================

function x_element_render_comment_list( $data ) {

  extract( $data );

  // Prepare Atts
  // ------------

  $atts = [
    'class' => array_merge( [ 'x-comment-list' ], $data['classes'] )
  ];

  if ( isset( $id ) && ! empty( $id ) ) {
    $atts['id'] = $id;
  }

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }

  $atts = cs_apply_effect( $atts, $data );

  // Prepare Args
  // ------------

  $args = array(
    'style'             => $comment_list_style,
    // 'format'            => 'html5',
    // 'type'              => 'comment',//$comment_list_type,
    'avatar_size'       => 32,
    'short_ping'        => false,
    // 'echo'              => true,
    // 'walker'            => null,
    // 'max_depth'         => null,
    // 'end-callback'      => null,
    // 'page'              => null,
    // 'per_page'          => null,
    // 'reverse_children'  => null,
  );

  if ( function_exists( 'x_get_stack' ) ) {
    $args['callback'] = 'x_' . x_get_stack() . '_comment';
  }

  if ( $comment_list_order === 'newest' ) {
    $args['reverse_top_level'] = true;
  }




  // Simulate wp-comments.php to populate query
  $shim_template = function() { return CS()->path('includes/views/app/shim.php'); };
  add_filter( 'comments_template', $shim_template );
  comments_template();
  remove_filter( 'comments_template', $shim_template );

  $count = intval(get_comments_number());

  // Output
  // ------
  // 01. Comments are open, has comments.
  // 02. Comments are open, no comments.
  // 03. Comments are closed.

  $list = null;
  $output_list_comments = null;
  $output_no_comments = null;
  $output_closed = null;

  ob_start();
  echo wp_list_comments( $args );
  $list_template = ob_get_clean();

  $list_args = [ 'class' => 'x-comments-list', 'id' => 'comments'];

  if ( have_comments() && comments_open() && $count > 0 ) { // 01
    $list = cs_tag( $comment_list_style, $list_args, $list_template );
  }

  if ( $comment_list_messages === true ) {

    $list_args['class'] = 'x-comment-list-message';

    if ( comments_open() && $count === 0) {
      $output_no_comments = cs_tag( 'div', $list_args, $comment_list_no_comments_content );
    }

    if ( ! comments_open() && get_comments_number() ) {
      $output_closed = cs_tag( 'div', $list_args, $comment_list_closed_content );
    }

  }

  return cs_tag( 'div', $atts, [
    $list,
    $output_no_comments,
    $output_closed
  ]);


}



// Builder Setup
// =============================================================================

function x_element_builder_setup_comment_list() {

  // Groups
  // ------

  $group                  = 'comment_list';
  $group_setup            = $group . ':setup';
  $group_design           = $group . ':design';

  $group_messaging        = $group . '_messaging';
  $group_messaging_setup  = $group_messaging . ':setup';
  $group_messaging_design = $group_messaging . ':design';
  $group_messaging_text   = $group_messaging . ':text';


  // Conditions
  // ----------

  $condition_comment_list_messages = [ 'comment_list_messages' => true ];


  // Options
  // -------

  $options_comment_list_type = [
    'choices' => [
      [ 'value' => 'all',       'label' => cs_recall( 'label_all' )        ],
      [ 'value' => 'comment',   'label' => cs_recall( 'label_comments' )   ],
      [ 'value' => 'pingback',  'label' => cs_recall( 'label_pingbacks' )  ],
      [ 'value' => 'trackback', 'label' => cs_recall( 'label_trackbacks' ) ],
      [ 'value' => 'pings',     'label' => cs_recall( 'label_pings' )      ],
    ]
  ];

  $options_comment_list_style = [
    'choices' => [
      [ 'value' => 'ol', 'label' => '<ol>' ],
      [ 'value' => 'ul', 'label' => '<ul>' ],
    ]
  ];

  $options_comment_list_order = [
    'choices' => [
      [ 'value' => 'oldest', 'label' => cs_recall( 'label_oldest' ) ],
      [ 'value' => 'newest', 'label' => cs_recall( 'label_newest' ) ],
    ]
  ];

  $options_comment_list_no_comments_content = [
    'height' => 2,
  ];

  $options_comment_list_closed_content = [
    'height' => 2,
  ];


  // Settings
  // --------

  $settings_comment_list_design = [
    'group' => $group_design,
  ];

  $settings_comment_list_message_design = [
    'group'     => $group_messaging_design,
    'condition' => $condition_comment_list_messages,
  ];

  $settings_comment_list_message_text = [
    'group'     => $group_messaging_text,
    'condition' => $condition_comment_list_messages,
  ];


  // Individual Controls (Base)
  // --------------------------

  $control_comment_list_type = [
    'key'     => 'comment_list_type',
    'type'    => 'select',
    'label'   => cs_recall( 'label_type' ),
    'options' => $options_comment_list_type,
  ];

  $control_comment_list_style = [
    'key'     => 'comment_list_style',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_html_tag' ),
    'options' => $options_comment_list_style,
  ];

  $control_comment_list_order = [
    'key'     => 'comment_list_order',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_order_by' ),
    'options' => $options_comment_list_order,
  ];

  $control_comment_list_messages = [
    'key'     => 'comment_list_messages',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_messaging' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  ];

  $control_comment_list_base_font_size = cs_recall( 'control_mixin_font_size',     [ 'key' => 'comment_list_base_font_size'           ] );
  $control_comment_list_width          = cs_recall( 'control_mixin_width',         [ 'key' => 'comment_list_width'                    ] );
  $control_comment_list_max_width      = cs_recall( 'control_mixin_max_width',     [ 'key' => 'comment_list_max_width'                ] );
  $control_comment_list_bg_color       = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'comment_list_bg_color' ] ] );


  // Individual Controls (Message)
  // -----------------------------

  $control_comment_list_no_comments_content = [
    'key'     => 'comment_list_no_comments_content',
    'type'    => 'textarea',
    'label'   => cs_recall( 'label_no_available_comments' ),
    'options' => $options_comment_list_no_comments_content,
  ];

  $control_comment_list_closed_content = [
    'key'     => 'comment_list_closed_content',
    'type'    => 'textarea',
    'label'   => cs_recall( 'label_comments_closed' ),
    'options' => $options_comment_list_closed_content,
  ];

  $control_comment_list_message_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'comment_list_message_bg_color' ] ] );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    [

      'controls' => [
        [
          'type'     => 'group',
          'group'    => $group_setup,
          'controls' => [
            $control_comment_list_type,
            $control_comment_list_style,
            $control_comment_list_order,
            $control_comment_list_messages,
            // $control_comment_list_base_font_size,
            // $control_comment_list_width,
            // $control_comment_list_max_width,
            // $control_comment_list_bg_color,
          ],
        ],
        cs_control( 'margin', 'comment_list', $settings_comment_list_design ),
        // cs_control( 'padding', 'comment_list', $settings_comment_list_design ),
        // cs_control( 'border', 'comment_list', $settings_comment_list_design ),
        // cs_control( 'border-radius', 'comment_list', $settings_comment_list_design ),
        // cs_control( 'box-shadow', 'comment_list', $settings_comment_list_design ),
        [
          'type'      => 'group',
          'group'     => $group_messaging_setup,
          'condition' => $condition_comment_list_messages,
          'controls'  => [
            $control_comment_list_no_comments_content,
            $control_comment_list_closed_content,
            $control_comment_list_message_bg_color,
          ],
        ],
        cs_control( 'padding', 'comment_list_message', $settings_comment_list_message_design ),
        cs_control( 'border', 'comment_list_message', $settings_comment_list_message_design ),
        cs_control( 'border-radius', 'comment_list_message', $settings_comment_list_message_design ),
        cs_control( 'box-shadow', 'comment_list_message', $settings_comment_list_message_design ),
        cs_control( 'text-format', 'comment_list_message', $settings_comment_list_message_text ),
      ],

      'control_nav' => [
        $group                  => cs_recall( 'label_comment_list' ),
        $group_setup            => cs_recall( 'label_setup' ),
        $group_design           => cs_recall( 'label_design' ),

        $group_messaging        => cs_recall( 'label_messaging' ),
        $group_messaging_setup  => cs_recall( 'label_setup' ),
        $group_messaging_design => cs_recall( 'label_design' ),
        $group_messaging_text   => cs_recall( 'label_text' ),
      ],

    ],
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'comment-list', [
  'title'      => __( 'Comment List', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_comment_list',
  'tss'        => 'x_element_tss_comment_list',
  'render'     => 'x_element_render_comment_list',
  'icon'       => 'native',
  'group'      => 'dynamic'
] );
