<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/COMMENT-FORM.PHP
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
    'comment_form_title_reply_content'       => cs_value( __( 'Leave a Reply', 'cornerstone' ), 'markup' ),
    'comment_form_title_reply_to_content'    => cs_value( __( 'Leave a Reply to %s', 'cornerstone' ), 'markup' ),
    'comment_form_logged_in_as'              => cs_value( false, 'markup' ),
    'comment_form_cancel_reply_link_content' => cs_value( __( 'Cancel Reply', 'cornerstone' ), 'markup' ),
    'comment_form_label_submit_content'      => cs_value( __( 'Submit', 'cornerstone' ), 'markup' ),
    // 'comment_form_base_font_size'            => cs_value( '1em' ),
    // 'comment_form_width'                     => cs_value( 'auto' ),
    // 'comment_form_max_width'                 => cs_value( 'none' ),
    // 'comment_form_bg_color'                  => cs_value( 'transparent', 'style:color' ),
    'comment_form_margin'                    => cs_value( '!0em' ),
    // 'comment_form_padding'                   => cs_value( '!0em' ),
    // 'comment_form_border_width'              => cs_value( '!0px' ),
    // 'comment_form_border_style'              => cs_value( 'solid' ),
    // 'comment_form_border_color'              => cs_value( 'transparent', 'style:color' ),
    // 'comment_form_border_radius'             => cs_value( '!0px' ),
    // 'comment_form_box_shadow_dimensions'     => cs_value( '!0em 0em 0em 0em' ),
    // 'comment_form_box_shadow_color'          => cs_value( 'transparent', 'style:color' ),
  ],
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_comment_form() {
  return [
    'require' => [ 'elements-wp' ],
    'modules' => [ 'comment-form', 'effects' ]
  ];
}


// Render
// =============================================================================

function x_element_render_comment_form( $data ) {

  extract( $data );

  // Prepare Atts
  // ------------

  $atts = [
    'class' => array_merge( ['x-comment-form'], $data['classes'] )
  ];

  if ( isset( $id ) && ! empty( $id ) ) {
    $atts['id'] = $id;
  }

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }

  $atts = cs_apply_effect( $atts, $_view_data );


  // Prepare Args
  // ------------

  $args = array(
    'format'               => 'html5',
    'id_form'              => 'commentform',
    'class_container'      => 'comment-respond',
    'class_form'           => 'comment-form',
    'title_reply'          => $comment_form_title_reply_content,
    'title_reply_to'       => $comment_form_title_reply_to_content,
    'comment_notes_before' => '',
    'comment_notes_after'  => '',
    'cancel_reply_link'    => $comment_form_cancel_reply_link_content,
    'cancel_reply_before'  => '',
    'cancel_reply_after'   => '',
    'id_submit'            => 'entry-comment-submit', // 'submit'
    'class_submit'         => 'x-comment-form-submit',
    'name_submit'          => 'submit',
    'label_submit'         => $comment_form_label_submit_content,
  );

  if ( $comment_form_logged_in_as === false ) {
    $args['logged_in_as'] = '';
  }


  // Output
  // ------

  ob_start();
  comment_form( apply_filters( 'x_comment_form_args', $args ) );
  $content = ob_get_clean();

  return cs_tag('div', $atts, $content );

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_comment_form() {

  // Groups
  // ------

  $group        = 'comment_form';
  $group_setup  = $group . ':setup';
  $group_design = $group . ':design';


  // Options
  // -------

  $options_comment_form_title_reply = [
    'placeholder' => cs_recall( 'label_leave_a_reply' )
  ];

  $options_comment_form_title_reply_to = [
    'placeholder' => cs_recall( 'label_leave_a_reply_to_sprintf' )
  ];

  $options_comment_form_logged_in_as = cs_recall( 'options_choices_off_on_bool' );

  $options_comment_form_cancel_reply_link_content = [
    'placeholder' => cs_recall( 'label_cancel_reply' )
  ];

  $options_comment_form_label_submit_content = [
    'placeholder' => cs_recall( 'label_submit' )
  ];


  // Settings
  // --------

  $settings_comment_form_design = [
    'group' => $group_design,
  ];


  // Individual Controls
  // -------------------

  $control_comment_form_title_reply_content = [
    'key'     => 'comment_form_title_reply_content',
    'type'    => 'text',
    'label'   => cs_recall( 'label_reply_title' ),
    'options' => $options_comment_form_title_reply,
  ];

  $control_comment_form_title_reply_to_content = [
    'key'     => 'comment_form_title_reply_to_content',
    'type'    => 'text',
    'label'   => cs_recall( 'label_reply_to_title' ),
    'options' => $options_comment_form_title_reply_to,
  ];

  $control_comment_form_logged_in_as = [
    'key'     => 'comment_form_logged_in_as',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_logged_in_as_label' ),
    'options' => $options_comment_form_logged_in_as,
  ];

  $control_comment_form_cancel_reply_link_content = [
    'key'     => 'comment_form_cancel_reply_link_content',
    'type'    => 'text',
    'label'   => cs_recall( 'label_cancel_reply_link' ),
    'options' => $options_comment_form_cancel_reply_link_content,
  ];

  $control_comment_form_label_submit_content = [
    'key'     => 'comment_form_label_submit_content',
    'type'    => 'text',
    'label'   => cs_recall( 'label_submit_label' ),
    'options' => $options_comment_form_label_submit_content,
  ];

  $control_comment_form_base_font_size = cs_recall( 'control_mixin_font_size',     [ 'key' => 'comment_form_base_font_size'           ] );
  $control_comment_form_width          = cs_recall( 'control_mixin_width',         [ 'key' => 'comment_form_width'                    ] );
  $control_comment_form_max_width      = cs_recall( 'control_mixin_max_width',     [ 'key' => 'comment_form_max_width'                ] );
  $control_comment_form_bg_color       = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'comment_form_bg_color' ] ] );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    [

      'controls' => [
        [
          'type'     => 'group',
          'group'    => $group_setup,
          'controls' => [
            $control_comment_form_title_reply_content,
            $control_comment_form_title_reply_to_content,
            $control_comment_form_logged_in_as,
            $control_comment_form_cancel_reply_link_content,
            $control_comment_form_label_submit_content,
            // $control_comment_form_base_font_size,
            // $control_comment_form_width,
            // $control_comment_form_max_width,
            // $control_comment_form_bg_color,
          ],
        ],
        cs_control( 'margin', 'comment_form', $settings_comment_form_design ),
        // cs_control( 'padding', 'comment_form', $settings_comment_form_design ),
        // cs_control( 'border', 'comment_form', $settings_comment_form_design ),
        // cs_control( 'border-radius', 'comment_form', $settings_comment_form_design ),
        // cs_control( 'box-shadow', 'comment_form', $settings_comment_form_design ),
      ],
      'control_nav' => [
        $group        => cs_recall( 'label_comment_form' ),
        $group_setup  => cs_recall( 'label_setup' ),
        $group_design => cs_recall( 'label_design' ),
      ],

    ],
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'comment-form', [
  'title'      => __( 'Comment Form', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_comment_form',
  'tss'        => 'x_element_tss_comment_form',
  'render'     => 'x_element_render_comment_form',
  'icon'       => 'native',
  'group'      => 'dynamic'
] );
