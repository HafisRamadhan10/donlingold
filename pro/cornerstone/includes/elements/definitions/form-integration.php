<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/FORM-INTEGRATION.PHP
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
    'form_integration_type'                      => cs_value( 'embed', 'markup', true ),
    'form_integration_width'                     => cs_value( 'auto' ),
    'form_integration_max_width'                 => cs_value( 'none' ),

    'form_integration_embed_content'             => cs_value( '', 'markup', true ),

    'form_integration_wpforms_id'                => cs_value( '', 'markup', true ),
    'form_integration_wpforms_title'             => cs_value( false, 'markup', true ),
    'form_integration_wpforms_description'       => cs_value( false, 'markup', true ),

    'form_integration_contact_form_7_id'         => cs_value( '', 'markup', true ),
    'form_integration_contact_form_7_title'      => cs_value( false, 'markup', true ),

    'form_integration_gravityforms_id'           => cs_value( '', 'markup', true ),
    'form_integration_gravityforms_title'        => cs_value( false, 'markup', true ),
    'form_integration_gravityforms_description'  => cs_value( false, 'markup', true ),
    'form_integration_gravityforms_ajax'         => cs_value( false, 'markup', true ),
    'form_integration_gravityforms_tabindex'     => cs_value( '', 'markup', true ),
    'form_integration_gravityforms_field_values' => cs_value( '', 'markup', true ),

    'form_integration_margin'                    => cs_value( '!0px' ),
  ],
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_form_integration() {
  return [
    'modules' => [
      'form-integration',
      'effects'
    ]
  ];
}

// Render
// =============================================================================

function x_element_render_form_integration( $data ) {

  // Prepare Atts
  // ------------

  $type = $data['form_integration_type'];

  $atts = [
    'class' => array_merge( [
      'x-form-integration',
      'x-form-integration-' . $type,
    ], $data['classes'] )
  ];

  if ( isset( $data['id'] ) && ! empty( $data['id'] ) ) {
    $atts['id'] = $data['id'];
  }

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }

  $atts = cs_apply_effect( $atts, $data );


  // Content
  // -------

  $content = '';


  // Embed
  // -----

  if ( $type === 'embed' ) {
    $content = $data['form_integration_embed_content'];
  } else {
    $message_inactive = sprintf( '<div class="x-form-integration-message">%s</div>', __( '%s not active', 'cornerstone' ) );
    $message_select   = sprintf( '<div class="x-form-integration-message">%s</div>', __( 'Select a form (%s)', 'cornerstone' ) );
    $message_error    = '<div class="x-form-integration-message x-form-integration-message-error">%s</div>';


    // WPForms
    // -------

    if ( $type === 'wpforms' ) {
      $plugin_title = __( 'WPForms', 'cornerstone' );

      if ( function_exists( 'wpforms' ) ) {
        if ( $data['form_integration_wpforms_id'] ) {
          $content = cs_render_shortcode( 'wpforms', [
            'id'          => $data['form_integration_wpforms_id'],
            'title'       => $data['form_integration_wpforms_title'] ? 'true' : 'false',
            'description' => $data['form_integration_wpforms_description'] ? 'true' : 'false',
          ] );
        } else {
          $content = sprintf( $message_select, $plugin_title );
        }
      } else {
        $content = sprintf( $message_inactive, $plugin_title );
      }
    }


    // Contact Form 7
    // --------------

    if ( $type === 'contact-form-7' ) {
      $plugin_title = __( 'Contact Form 7', 'cornerstone' );

      if ( class_exists('WPCF7_ContactForm') ) {
        if ( $data['form_integration_contact_form_7_id'] ) {
          $items = WPCF7_ContactForm::find( [ 'p' => $data['form_integration_contact_form_7_id'] ] );
          $shortcode_atts  = [ 'id' => $items[0]->id() ];

          if ( $data['form_integration_contact_form_7_title'] ) {
            $shortcode_atts['title'] = $items[0]->title();
          }

          $content = cs_render_shortcode( 'contact-form-7', $shortcode_atts );
        } else {
          $content = sprintf( $message_select, $plugin_title );
        }
      } else {
        $content = sprintf( $message_inactive, $plugin_title );
      }
    }


    // Gravity Forms
    // -------------

    if ( $type === 'gravity-forms' ) {
      $plugin_title = __( 'Gravity Forms', 'cornerstone' );

      if ( class_exists( 'GFForms' ) ) {
        if ( $data['form_integration_gravityforms_id'] ) {
          $shortcode_atts = [
            'id'          => $data['form_integration_gravityforms_id'],
            'title'       => $data['form_integration_gravityforms_title'] ? 'true' : 'false',
            'description' => $data['form_integration_gravityforms_description'] ? 'true' : 'false',
          ];

          if ( $data['form_integration_gravityforms_tabindex'] ) {
            $shortcode_atts['tabindex'] = $data['form_integration_gravityforms_tabindex'];
          }

          if ( $data['form_integration_gravityforms_field_values'] ) {
            $shortcode_atts['field_values'] = $data['form_integration_gravityforms_field_values'];
          }

          $content = cs_render_shortcode( 'gravityform', $shortcode_atts );
        } else {
          $content = sprintf( $message_select, $plugin_title );
        }
      } else {
        $content = sprintf( $message_inactive, $plugin_title );
      }
    }
  }


  // Output
  // ------

  return cs_tag( 'div', $atts, $data['custom_atts'], $content );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_form_integration() {

  // Setup
  // -----

  $group       = 'form_integration';
  $group_title = __( 'Form Integration', 'cornerstone' );


  // Messaging
  // ---------

  $message_activate_plugin = __( 'Activate Plugin', 'cornerstone' );
  $message_required        = __( '%s must be installed and activated to use this form type.', 'cornerstone' );

  $title_wpforms           = __( 'WPForms', 'cornerstone' );
  $title_contact_form_7    = __( 'Contact Form 7', 'cornerstone' );
  $title_gravity_forms     = __( 'Gravity Forms', 'cornerstone' );

  $label_form              = __( 'Form', 'cornerstone' );
  $label_show              = __( 'Show', 'cornerstone' );
  $label_title             = __( 'Title', 'cornerstone' );
  $label_description       = __( 'Description', 'cornerstone' );


  // Conditions
  // ----------

  $conditions_form_integration_embed          = [ [ 'form_integration_type' => 'embed'          ] ];
  $conditions_form_integration_wpforms        = [ [ 'form_integration_type' => 'wpforms'        ] ];
  $conditions_form_integration_contact_form_7 = [ [ 'form_integration_type' => 'contact-form-7' ] ];
  $conditions_form_integration_gravity_forms  = [ [ 'form_integration_type' => 'gravity-forms'  ] ];


  // Groups
  // ------

  $group_form_integration_setup  = $group . ':setup';
  $group_form_integration_size   = $group . ':size';
  $group_form_integration_design = $group . ':design';



  $control_layout_div_width      = cs_recall( 'control_mixin_width',      [ 'key' => 'layout_div_width'      ] );
  $control_layout_div_min_width  = cs_recall( 'control_mixin_min_width',  [ 'key' => 'layout_div_min_width'  ] );
  $control_layout_div_max_width  = cs_recall( 'control_mixin_max_width',  [ 'key' => 'layout_div_max_width'  ] );


  // Controls
  // --------

  $controls_form_integration = [
    [
      'type'     => 'group',
      'group'    => $group_form_integration_setup,
      'controls' => [
        [
          'key'     => 'form_integration_type',
          'type'    => 'select',
          'label'   => __( 'Type', 'cornerstone' ),
          'options' => [
            'choices' => [
              [ 'value' => 'embed',          'label' => __( 'Embed', 'cornerstone' )          ],
              [ 'value' => 'wpforms',        'label' => __( 'WPForms', 'cornerstone' )        ],
              [ 'value' => 'contact-form-7', 'label' => __( 'Contact Form 7', 'cornerstone' ) ],
              [ 'value' => 'gravity-forms',  'label' => __( 'Gravity Forms', 'cornerstone' )  ],
            ],
          ],
        ],
        [
          'key'        => 'form_integration_embed_content',
          'type'       => 'text-editor',
          'label'      => __( 'Content', 'cornerstone' ),
          'conditions' => $conditions_form_integration_embed,
          'options'    => [
            'mode'   => 'html',
            'height' => 4,
          ],
        ],
      ],
    ],
    [
      'type'     => 'group',
      'group'    => $group_form_integration_size,
      'controls' => [
        cs_recall( 'control_mixin_width',     [ 'key' => 'form_integration_width'     ] ),
        cs_recall( 'control_mixin_max_width', [ 'key' => 'form_integration_max_width' ] )
      ]
    ]
  ];


  // WPForms
  // -------

  if ( function_exists( 'wpforms' ) ) {

    $controls_form_integration[] = [
      'type'       => 'group',
      'label'      => $title_wpforms,
      'group'      => $group_form_integration_setup,
      'conditions' => $conditions_form_integration_wpforms,
      'controls'   => [
        [
          'key'     => 'form_integration_wpforms_id',
          'type'    => 'select',
          'label'   => $label_form,
          'options' => [
            'choices' => 'dynamic:wpforms'
          ],
        ],
        [
          'keys' => [
            'title'       => 'form_integration_wpforms_title',
            'description' => 'form_integration_wpforms_description',
          ],
          'label'   => $label_show,
          'type'    => 'checkbox-list',
          'options' => [
            'list' => [
              [ 'key' => 'title',       'label' => $label_title       ],
              [ 'key' => 'description', 'label' => $label_description ],
            ],
          ],
        ],
      ],
    ];

  } else {

    $controls_form_integration[] = [
      'type'       => 'message',
      'label'      => $title_wpforms,
      'group'      => $group_form_integration_setup,
      'conditions' => $conditions_form_integration_wpforms,
      'options'    => [
        'title'   => $message_activate_plugin,
        'message' => sprintf( $message_required, $title_wpforms )
      ]
    ];

  }


  // Contact Form 7
  // --------------

  if ( class_exists('WPCF7_ContactForm') ) {

    $controls_form_integration[] = [
      'type'       => 'group',
      'label'      => $title_contact_form_7,
      'group'      => $group_form_integration_setup,
      'conditions' => $conditions_form_integration_contact_form_7,
      'controls'   => [
        [
          'key'     => 'form_integration_contact_form_7_id',
          'type'    => 'select',
          'label'   => $label_form,
          'options' => [
            'choices' => 'dynamic:contact_form_7'
          ],
        ],
        [
          'keys' => [
            'title' => 'form_integration_contact_form_7_title',
          ],
          'label'   => $label_show,
          'type'    => 'checkbox-list',
          'options' => [
            'list' => [
              [ 'key' => 'title', 'label' => $label_title ],
            ],
          ],
        ],
      ],
    ];

  } else {

    $controls_form_integration[] = [
      'type'       => 'message',
      'label'      => $title_contact_form_7,
      'group'      => $group_form_integration_setup,
      'conditions' => $conditions_form_integration_contact_form_7,
      'options'    => [
        'title'   => $message_activate_plugin,
        'message' => sprintf( $message_required, $title_contact_form_7 )
      ],
    ];

  }


  // Gravity Forms
  // -------------

  if ( class_exists( 'GFForms' ) ) {

    $controls_form_integration[] = [
      'type'       => 'group',
      'label'      => $title_gravity_forms,
      'group'      => $group_form_integration_setup,
      'conditions' => $conditions_form_integration_gravity_forms,
      'controls'   => [
        [
          'key'     => 'form_integration_gravityforms_id',
          'type'    => 'select',
          'label'   => $label_form,
          'options' => [
            'choices' => 'dynamic:gravityforms'
          ],
        ],
        [
          'keys' => [
            'title'       => 'form_integration_gravityforms_title',
            'description' => 'form_integration_gravityforms_description',
          ],
          'label'   => $label_show,
          'type'    => 'checkbox-list',
          'options' => [
            'list' => [
              [ 'key' => 'title',       'label' => $label_title       ],
              [ 'key' => 'description', 'label' => $label_description ],
            ],
          ],
        ],
        [
          'keys' => [
            'ajax' => 'form_integration_gravityforms_ajax',
          ],
          'type'    => 'checkbox-list',
          'label'   => __( 'Ajax', 'cornerstone' ),
          'options' => [
            'list' => [
              [ 'key' => 'ajax', 'label' => __( 'Enabled', 'cornerstone' ) ],
            ],
          ],
        ],
        [
          'key'     => 'form_integration_gravityforms_tabindex',
          'type'    => 'text',
          'label'   => __( 'Tab Index', 'cornerstone' ),
          'options' => [
            'placeholder' => __( 'Starting tab index', 'cornerstone' )
          ],
        ],
        [
          'key'     => 'form_integration_gravityforms_field_values',
          'type'    => 'text',
          'label'   => __( 'Field Values', 'cornerstone' ),
          'options' => [
            'placeholder' => __( 'Prefill field values', 'cornerstone' )
          ],
        ],
      ],
    ];

  } else {

    $controls_form_integration[] = [
      'type'       => 'message',
      'label'      => $title_gravity_forms,
      'group'      => $group_form_integration_setup,
      'conditions' => $conditions_form_integration_gravity_forms,
      'options'    => [
        'title'   => $message_activate_plugin,
        'message' => sprintf( $message_required, $title_gravity_forms )
      ],
    ];

  }


  // Design
  // ------

  $controls_form_integration[] = cs_control( 'margin', 'form_integration', [ 'group' => $group_form_integration_design ] );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    [
      'controls'    => $controls_form_integration,
      'control_nav' => [
        $group                         => $group_title,
        $group_form_integration_setup  => __( 'Setup', 'cornerstone' ),
        $group_form_integration_size   => __( 'Size', 'cornerstone' ),
        $group_form_integration_design => __( 'Design', 'cornerstone' ),
      ],
    ],
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true ] )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'form-integration', [
  'title'      => __( 'Form Integration', '__x__' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_form_integration',
  'tss'        => 'x_element_tss_form_integration',
  'render'     => 'x_element_render_form_integration',
  'icon'       => 'native',
  'options'    => [
    'inline' => [
      'content' => [
        'selector' => 'root'
      ],
    ],
  ]
] );
