<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/GLOBAL-BLOCK.PHP
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
    'global_block_id' => cs_value( '', 'markup', true )
  ],
  'omega',
  'omega:custom-atts'
);


// Render
// =============================================================================

function x_element_render_global_block( $data ) {

  $global_block_id = apply_filters( 'cs_global_block_id', $data['global_block_id'] );


  // Prepare Attr Values
  // -------------------

  $classes = [ 'cs-content', 'x-global-block', "x-global-block-$global_block_id", ];

  // Prepare Atts
  // ------------

  $atts = [ 'class' => array_merge( $classes, $data['classes'] ) ];

  if ( isset( $data['id'] ) && ! empty( $data['id'] ) ) {
    $atts['id'] = $data['id'];
  }

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }


  // Validation
  // ----------

  $error = false;

  if ( ! $global_block_id ) {
    return;
  } else {
    $current_id = (int) get_the_ID();
    $global_block_post = get_post( $global_block_id );
    if ( ! is_a($global_block_post, 'WP_Post' ) ) {
      $error = 'Unable to locate Global Block';
    } else if ( 'cs_global_block' !== $global_block_post->post_type ) {
      $error = 'The Global Block element was passed a non Global Block ID.';
    }
  }

  // Prepare Content
  // ---------------
  // 01. Start Rendering Isolation.
  // 02. End Rendering Isolation.

  if ( ! $error ) {

    $gb_top_level = false; // 01

    if ( ! apply_filters( '_cs_rendering_global_block', false ) ) {
      $gb_top_level = true;
      add_filter('_cs_rendering_global_block', '__return_true' );
    }


    $content = '';
    try {
      $content = cs_render_shortcode( 'cs_content', [ '_p' => $global_block_id, 'wrap' => 'false' ]);
    } catch( Exception $e ) {
      $error = $e->getMessage();
    }

    $global_block_entity = CS()->component('Element_Front_End')->get_content( $global_block_id );
    $settings = is_null($global_block_entity) ? [] : $global_block_entity->get_settings();

    CS()->novus()->service('Styling')->addStyles( "$global_block_id-custom", isset($settings['custom_css']) ? $settings['custom_css'] : '', 110 );

    if ( isset( $settings['custom_js'] ) && $settings['custom_js'] ) {
      $content .= '<script>' . $settings['custom_js'] . '</script>';
    }

    if ( strpos( $content, '<!-- the_content loop -->' ) === 0 ) {
      $error = 'Global Blocks can not reference themselves';
    }
    if ( ! $content ) {
      $error = 'This Global Block does not have any content.';
    }

    if ( $gb_top_level ) { // 02
      remove_filter('_cs_rendering_global_block', '__return_true' );

      if ( apply_filters( 'cs_is_preview', false ) ) {
        $atts['data-cs-nav-btn'] = cs_prepare_json_att( array(
          'action' => array(
            'route'   => "global-blocks/$global_block_id",
            'context' => csi18n( 'common.global-blocks.entity' )
          ),
          'label' => sprintf( csi18n( 'common.edit' ), csi18n( 'common.global-blocks.entity' ) ),
          'icon' => 'edit'
        ) );
      }

    }
  }

  if ( $error ) {
    $content = apply_filters( 'cs_global_block_error', "<div style=\"padding: 35px; line-height: 1.5; text-align: center; color: #000; background-color: #fff;\">$error</div>");
  }



  // Output
  // ------

  return cs_tag('div', apply_filters( 'cs_global_block_atts', $atts, $global_block_id ), isset( $data['custom_atts'] ) ? $data['custom_atts'] : [], $content );

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_global_block() {

  $controls = [
    [
      'type'     => 'group',
      'group'    => 'global_block:setup',
      'controls' => [
        [
          'key'     => 'global_block_id',
          'type'    => 'post-picker',
          'label'   => cs_recall( 'label_select' ),
          'options' => [
            'post_type'         => 'cs_global_block',
            'post_status'       => 'tco-data',
            'empty_placeholder' => cs_recall( 'label_no_global_blocks' ),
            'placeholder'       => cs_recall( 'label_global_block' )
          ],
        ],
      ],
    ],
  ];

  return cs_compose_controls(
    [
      'controls'             => $controls,
      'control_nav'          => [
        'global_block'       => cs_recall( 'label_global_block' ),
        'global_block:setup' => cs_recall( 'label_setup' )
      ],
    ],
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true ] )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'global-block', [
  'title'      => __( 'Global Block', 'cornerstone' ),
  'values'     => $values,
  'builder'    => 'x_element_builder_setup_global_block',
  'render'     => 'x_element_render_global_block',
  'icon'       => 'native',
  'options'    => [
    'preview_nav' => true
  ]
] );
