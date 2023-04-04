<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/AUDIO.PHP
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
    'audio_type'        => cs_value( 'embed', 'markup' ),
    'audio_width'       => cs_value( '100%' ),
    'audio_max_width'   => cs_value( 'none' ),
    'audio_embed_code'  => cs_value( '', 'markup', true ),
    'audio_margin'      => cs_value( '!0px' ),
    'mejs_type'         => cs_value( 'audio' ),
  ],
  'omega',
  'omega:custom-atts',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_tss_audio() {
  return [
    'require' => [ 'elements-extra' ],
    'modules' => [ 'audio', 'mejs', 'effects']
  ];
}



// Render
// =============================================================================

function x_element_render_audio( $data ) {

  extract($data);

  // Content
  // -------

  switch ( $audio_type ) {

    // Embed
    // -----

    case 'embed' :
      global $wp_embed;
      $audio_content = ( ! empty( $audio_embed_code ) ) ? $wp_embed->autoembed( cs_expand_content( $audio_embed_code ) ) : '<div style="height: 32px;"><img style="object-fit: cover; width: 100%; height: 100%;" src="' . cornerstone_make_placeholder_pixel() . '" width="1" height="1" alt="Placeholder"></div>';
      break;


    // Player
    // ------

    case 'player' :

      wp_enqueue_script( 'mediaelement' );


      // Build Source Elements
      // ---------------------

      $mejs_source_files    = explode( "\n", esc_attr( cs_dynamic_content( $mejs_source_files ) ) );
      $mejs_source_elements = array();

      foreach( $mejs_source_files as $file ) {

        if ( ! $file ) {
          continue;
        }

        $parts  = parse_url( $file );
        $scheme = isset( $parts['scheme'] ) ? $parts['scheme'] . '://' : '//';
        $host   = isset( $parts['host'] )   ? $parts['host']           : '';
        $path   = isset( $parts['path'] )   ? $parts['path']           : '';
        $mime   = wp_check_filetype( $scheme . $host . $path, wp_get_mime_types() );

        $mejs_source_element_atts = array(
          'src'  => esc_url( $file ),
          'type' => $mime['type']
        );

        $mejs_source_elements[] = '<source ' . cs_atts( $mejs_source_element_atts ) . '>';

      }


      // Build Audio Element
      // -------------------
      // 01. Check if current v4.9 is greater than current WordPress version and
      //     include legacy class if so. Needed due to MEJS library update in
      //     v4.9, which includes updated styling and APIs.

      if ( ! empty( $mejs_source_elements ) ) {

        $mejs_classes = array( 'x-mejs' );

        if ( $mejs_advanced_controls ) $mejs_classes[] = 'advanced-controls';

        $mejs_element_atts = array(
          'class'   => $mejs_classes,
          'preload' => $mejs_preload,
        );

        if ( $mejs_loop ) $mejs_element_atts['loop'] = '';

        $audio_content = '<audio ' . cs_atts( $mejs_element_atts ) . '>'
                        . implode( '', $mejs_source_elements )
                      . '</audio>';

      } else {

        $audio_content = '<div style="height: 32px;">'
                        . '<img style="object-fit: cover; width: 100%; height: 100%;" src="' . cornerstone_make_placeholder_pixel() . '" width="1" height="1" alt="Placeholder">'
                      . '</div>';

      }

      break;


    // Fallback
    // --------

    default :

      $audio_content = '';

      break;

  }


  // Prepare Attr Values
  // -------------------

  $_classes = array(
    'x-audio',
    'x-audio-' . $audio_type
  );

  if ( $audio_type === 'player' ) {
    if ( $mejs_autoplay ) $_classes[] = 'autoplay';
    if ( $mejs_loop )     $_classes[] = 'loop';
  }

  // Prepare Atts
  // ------------

  $atts = [
    'class' => array_merge( $_classes, $data['classes'] )
  ];

  if ( isset( $id ) && ! empty( $id ) ) {
    $atts['id'] = $id;
  }

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }

  $atts = cs_apply_effect( $atts, $data );

  if ( $audio_type === 'player' ) {
    $atts = array_merge( $atts, cs_element_js_atts( 'mejs', [], true ) );
  }


  // Output
  // ------

  return cs_tag( 'div', $atts, $custom_atts, $audio_content );

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_audio() {

  // Settings
  // --------

  $settings_audio = [
    'k_pre' => 'audio',
    'group' => 'audio:setup',
  ];

  $settings_audio_mejs = [
    'group'      => 'audio:mejs',
    'conditions' => [ [ 'audio_type' => 'player' ] ],
    'type'       => 'audio',
  ];


  // Individual Controls
  // -------------------

  $control_audio_type = [
    'key'     => 'audio_type',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_type' ),
    'options' => [
      'choices' => [
        [ 'value' => 'embed',  'label' => cs_recall( 'label_embed' ) ],
        [ 'value' => 'player', 'label' => cs_recall( 'label_player' ) ],
      ],
    ],
  ];

  $control_audio_width     = cs_recall( 'control_mixin_width',     [ 'key' => 'audio_width'     ] );
  $control_audio_max_width = cs_recall( 'control_mixin_max_width', [ 'key' => 'audio_max_width' ] );

  $control_audio_embed_code = [
    'key'       => 'audio_embed_code',
    'type'      => 'textarea',
    'label'     => cs_recall( 'label_code' ),
    'condition' => [ 'audio_type' => 'embed' ],
    'options'   => [
      'height'    => 5,
      'monospace' => true,
    ],
  ];

  $control_audio_mejs_source_files = [
    'key'       => 'mejs_source_files',
    'type'      => 'textarea',
    'label'     => cs_recall( 'label_sources_1_per_line' ),
    'condition' => [ 'audio_type' => 'player' ],
    'options'   => [
      'height'    => 5,
      'monospace' => true,
    ],
  ];


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    [
      'controls' => [
        [
          'type'     => 'group',
          'group'    => 'audio:setup',
          'controls' => [
            $control_audio_type,
            $control_audio_embed_code,
            $control_audio_mejs_source_files
          ],
        ],
        [
          'type'     => 'group',
          'group'    => 'audio:size',
          'controls' => [
            $control_audio_width,
            $control_audio_max_width,
          ],
        ],
        cs_control( 'margin', 'audio', [ 'group' => 'audio:design' ] )
      ],
      'control_nav' => [
        'audio'        => cs_recall( 'label_audio' ),
        'audio:setup'  => cs_recall( 'label_setup' ),
        'audio:size'   => cs_recall( 'label_size' ),
        'audio:design' => cs_recall( 'label_design' ),
      ],
    ],
    cs_partial_controls( 'mejs', [
      'group'      => 'audio',
      'conditions' => [ [ 'audio_type' => 'player' ] ],
      'type'       => 'audio',
    ] ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true, 'add_looper_consumer' => true ] )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'audio', [
  'title'      => __( 'Audio', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'mejs', 'effects' ],
  'builder'    => 'x_element_builder_setup_audio',
  'tss'        => 'x_element_tss_audio',
  'render'     => 'x_element_render_audio',
  'icon'       => 'native',
  'options'    => [
    'empty_placeholder' => false
  ]
] );
