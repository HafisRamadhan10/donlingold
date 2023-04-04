<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/VIDEO.PHP
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
    'video_type'        => cs_value( 'embed', 'markup' ),
    'video_embed_code'  => cs_value( '', 'markup', true ),
    'mejs_type'         => cs_value( 'video', 'style' ),
  ],
  'omega',
  'omega:custom-atts',
  'omega:looper-consumer'
);



// Style
// =============================================================================

function x_element_tss_video() {
  return [
    'require' => [ 'elements-extra' ],
    'modules' => [ 'frame', 'mejs', 'effects' ]
  ];
}


// Render
// =============================================================================

function x_element_render_video( $data ) {

  extract( $data );

  // Content
  // -------

  switch ( $video_type ) {

    // Embed
    // -----

    case 'embed' :
      global $wp_embed;
      $video_content = ( ! empty( $video_embed_code ) ) ? $wp_embed->autoembed( cs_expand_content( $video_embed_code ) ) : '<img style="object-fit: cover; width: 100%; height: 100%;" src="' . cornerstone_make_placeholder_pixel() . '" width="1" height="1" alt="Placeholder">';
      break;


    // Player
    // ------

    case 'player' :

      wp_enqueue_script( 'mediaelement' );


      // Variable Markup
      // ---------------

      $video_is_bg = isset( $video_is_bg ) ? $video_is_bg : false;
      $mejs_bg_start = ( $video_is_bg ) ? '<script type="text/template">' : '';
      $mejs_bg_end   = ( $video_is_bg ) ? '</script>' : '';

      $mejs_poster_atts = cs_apply_image_atts( [ 'src' => cs_dynamic_content( $mejs_poster ) ] );
      $mejs_poster_src = isset( $mejs_poster_atts['src'] ) ? $mejs_poster_atts['src'] : '';


      // Build Source Elements
      // ---------------------

      $mejs_source_files      = explode( "\n", esc_attr( cs_dynamic_content( $mejs_source_files ) ) );
      $mejs_source_elements   = array();
      $mejs_source_is_vimeo   = false;
      $mejs_source_is_youtube = false;

      foreach( $mejs_source_files as $file ) {

        if ( ! $file ) {
          continue;
        }

        if ( ! preg_match( '#webm|mp4|ogv#', $file ) ) {
          $mejs_source_is_vimeo   = preg_match( '#^https?://(.+\.)?vimeo\.com/.*#', $file );
          $mejs_source_is_youtube = preg_match( '#^https?://(?:www\.)?(?:youtube\.com/watch|youtu\.be/)#', $file );
        }

        if ( $mejs_source_is_vimeo ) {
          wp_enqueue_script( 'mediaelement-vimeo' );
          $mime = array( 'type' => 'video/vimeo' );
        } else if ( $mejs_source_is_youtube ) {
          $mime = array( 'type' => 'video/youtube' );
        } else {
          $parts  = parse_url( $file );
          $scheme = isset( $parts['scheme'] ) ? $parts['scheme'] . '://' : '//';
          $host   = isset( $parts['host'] )   ? $parts['host']           : '';
          $path   = isset( $parts['path'] )   ? $parts['path']           : '';
          $mime   = wp_check_filetype( $scheme . $host . $path, wp_get_mime_types() );
        }

        $mejs_source_element_atts = array( array(
          'src'  => esc_url( $file ),
          'type' => $mime['type']
        ) );

        if ( preg_match( '#mov#', $file ) ) {
          $mov_type = $mime['type'] == 'video/quicktime' ? 'video/mov' : 'video/quicktime';
          $mejs_source_element_atts = array_merge( $mejs_source_element_atts, array(
            array( 'src' => esc_url( $file ), 'type' => $mov_type ),
            array( 'src' => esc_url( $file ), 'type' => 'video/mp4' ),
          ) );
        }

        foreach ($mejs_source_element_atts as $element_atts) {
          $mejs_source_elements[] = '<source ' . cs_atts( $element_atts ) . '>';
        }


      }


      // Build Video Element
      // -------------------
      // 01. Check if current v4.9 is greater than current WordPress version and
      //     include legacy class if so. Needed due to MEJS library update in
      //     v4.9, which includes updated styling and APIs.

      if ( ! empty( $mejs_source_elements ) ) {

        $mejs_classes = array( 'x-mejs' );

        if ( $video_is_bg ) $mejs_classes[] = 'transparent';
        if ( $mejs_advanced_controls ) $mejs_classes[] = 'advanced-controls';

        $mejs_element_atts = array(
          'class'   => $mejs_classes,
          'poster'  => $mejs_poster_src,
          'preload' => $mejs_preload,
        );

        if ( $mejs_loop )  $mejs_element_atts['loop']  = '';
        if ( $mejs_muted ) $mejs_element_atts['muted'] = '';

        $video_content = $mejs_bg_start
                        . '<video ' . cs_atts( $mejs_element_atts ) . '>'
                          . implode( '', $mejs_source_elements )
                        . '</video>'
                      . $mejs_bg_end;

      } else {

        $video_content = $mejs_bg_start
                        . '<img style="object-fit: cover; width: 100%; height: 100%;" src="' . cornerstone_make_placeholder_pixel() . '" width="1" height="1" alt="Placeholder">'
                      . $mejs_bg_end;

      }

      break;


    // Fallback
    // --------

    default :

      $video_content = '';

      break;

  }


  // Prepare Attr Values
  // -------------------

  $_classes = [ 'x-video', 'x-video-' . $video_type ];

  if ( $video_type === 'player' ) {
    if ( $video_is_bg )            $_classes[] = 'x-video-bg';
    if ( $mejs_hide_controls )     $_classes[] = 'hide-controls';
    if ( $mejs_autoplay )          $_classes[] = 'autoplay';
    if ( $mejs_loop )              $_classes[] = 'loop';
    if ( $mejs_muted )             $_classes[] = 'muted';
    if ( $mejs_source_is_vimeo )   $_classes[] = 'vimeo';
    if ( $mejs_source_is_youtube ) $_classes[] = 'youtube';
  }

  // Prepare Atts
  // ------------

  $content_atts = array(
    'class' => $_classes,
  );

  if ( $video_type === 'player' ) {
    $content_atts = array_merge( $content_atts, cs_element_js_atts( 'mejs', [ 'poster' => $mejs_poster ], true ) );
  }


  // Output
  // ------

  $atts = [
    'class' => $data['classes']
  ];

  if ( isset( $id ) && ! empty( $id ) ) {
    $atts['id'] = $id;
  }

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }

  $atts = cs_apply_effect( $atts, $data );


  return cs_get_partial_view( 'frame',
    array_merge(
      cs_extract( $data, [ 'frame' => '' ] ),
      [
        'atts' => $atts,
        'custom_atts' => $custom_atts,
        'frame_content' => cs_tag( 'div', $content_atts, $video_content ),
        'frame_content_type' => 'video-' . $data['video_type']
      ]
    )
  );
}



// Builder Setup
// =============================================================================

function x_element_builder_setup_video() {

  $control_video_type = [
    'key'     => 'video_type',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_type' ),
    'options' => [
      'choices' => [
        [ 'value' => 'embed',  'label' => cs_recall( 'label_embed' ) ],
        [ 'value' => 'player', 'label' => cs_recall( 'label_player' ) ],
      ],
    ],
  ];

  $control_video_embed_code = [
    'key'       => 'video_embed_code',
    'type'      => 'textarea',
    'label'     => cs_recall( 'label_code' ),
    'condition' => [ 'video_type' => 'embed' ],
    'options'   => [
      'height'    => 5,
      'monospace' => true,
    ],
  ];

  $control_video_mejs_source_files = [
    'key'       => 'mejs_source_files',
    'type'      => 'textarea',
    'label'     => cs_recall( 'label_sources_1_per_line' ),
    'condition' => [ 'video_type' => 'player' ],
    'options'   => [
      'height'    => 2,
      'monospace' => true,
    ],
  ];

  $control_video_mejs_poster = [
    'key'       => 'mejs_poster',
    'type'      => 'image-source',
    'label'     => cs_recall( 'label_poster' ),
    'condition' => [ 'video_type' => 'player' ],
    'options'   => [
      'height' => 3,
    ],
  ];

  $control_video_setup = [
    'type'     => 'group',
    'group'    => 'video:setup',
    'controls' => [
      $control_video_type,
      $control_video_embed_code,
      $control_video_mejs_source_files,
      $control_video_mejs_poster,
    ],
  ];


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    [
      'controls' => [ $control_video_setup ],
      'control_nav' => [
        'video'       => cs_recall( 'label_video' ),
        'video:setup' => cs_recall( 'label_setup' ),
      ],
    ],
    cs_partial_controls( 'mejs', [
      'group'      => 'video',
      'conditions' => [ [ 'video_type' => 'player' ] ],
      'type'       => 'video',
    ] ),
    cs_partial_controls( 'frame', [ 'frame_content_type' => 'video' ] ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true, 'add_looper_consumer' => true ] )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'video', [
  'title'      => __( 'Video', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'frame', 'mejs', 'effects' ],
  'builder'    => 'x_element_builder_setup_video',
  'tss'        => 'x_element_tss_video',
  'render'     => 'x_element_render_video',
  'icon'       => 'native',
  'options'    => [
    'empty_placeholder' => false
  ]
] );
