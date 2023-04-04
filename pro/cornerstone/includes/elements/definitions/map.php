<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/MAP.PHP
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
    'map_type'              => cs_value( 'embed', 'markup' ),
    'map_embed_code'        => cs_value( '', 'markup', true ),
    'map_google_api_key'    => cs_value( '', 'markup', true ),
    'map_google_lat'        => cs_value( '40.674', 'markup', true ),
    'map_google_lng'        => cs_value( '-73.945', 'markup', true ),
    'map_google_drag'       => cs_value( true, 'markup' ),
    'map_google_zoom'       => cs_value( true, 'markup' ),
    'map_google_zoom_level' => cs_value( 12, 'markup' ),
    'map_google_styles'     => cs_value( '', 'markup' ),
  ],
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_map() {
  return [
    'modules' => [ 'frame', 'effects' ]
  ];
}


// Render
// =============================================================================

function x_element_render_map( $data ) {

  extract( $data );

  $is_preview = apply_filters( 'cs_is_preview', false );


  // Prepare Atts
  // ------------

  $map_atts = array(
    'class' => [ 'x-map', 'x-map-' . $map_type ],
  );


  // Content
  // -------

  switch ( $map_type ) {

    // Embed
    // -----

    case 'embed' :

      $map_embed_content = ( ! empty( $map_embed_code ) ) ? $map_embed_code : '<img style="object-fit: cover; width: 100%; height: 100%;" src="' . cornerstone_make_placeholder_pixel() . '" width="1" height="1" alt="Placeholder">';

      break;


    // Google
    // ------
    // 01. Setup and enqueue Google Maps API script.
    // 02. Populate Google Map API data attributes.

    case 'google' :

      $map_google_api_script = 'https://maps.googleapis.com/maps/api/js?v=3'; // 01

      if ( $map_google_api_key ) {
        $map_google_api_script = add_query_arg( array( 'key' => esc_attr( $map_google_api_key ) ), $map_google_api_script );
      }

      if ( $map_google_api_key || ( ! $is_preview && ! $map_google_api_key ) ) {
        wp_enqueue_script( 'x-google-map', $map_google_api_script );
      }


      $map_google_data = array(
        'lat'       => cs_dynamic_content( $map_google_lat ) ,
        'lng'       => cs_dynamic_content( $map_google_lng ) ,
        'drag'      => cs_dynamic_content( $map_google_drag ) ,
        'zoom'      => cs_dynamic_content( $map_google_zoom ) ,
        'zoomLevel' => cs_dynamic_content( $map_google_zoom_level ) ,
        'styles'    => cs_dynamic_content( $map_google_styles )
      );

      $map_atts = array_merge( $map_atts, cs_element_js_atts( 'map_google', $map_google_data ) ); // 02

      break;

  }


  // Output
  // ------

  $map_content = [];


  switch ( $map_type ) {

    case 'embed' :
      $map_content[] = $map_embed_content;
      break;

    case 'google' :

      $map_content[] = cs_render_child_elements( $data );

      if ( $is_preview && ! $map_google_api_key ) {
        $map_content[] = '<img style="object-fit: cover; width: 100%; height: 100%;" src="' . cornerstone_make_placeholder_pixel() . '" width="1" height="1" alt="Placeholder">';
      }

      break;

  }

  $frame_content = cs_tag( 'div', $map_atts, $map_content );

  // Output
  // ------

  $atts = [
    'class' => $data['classes']
  ];

  if ( isset( $id ) && ! empty( $id ) ) {
    $atts['id'] = $id;
  }

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $framt_atts['style'] = $data['style'];
  }

  $atts = cs_apply_effect( $atts, $data );

  return cs_get_partial_view( 'frame', array_merge(
    cs_extract( $data, [ 'frame' => ''  ] ),
    [
      'atts' => $atts,
      'custom_atts' => $custom_atts,
      'frame_content_type' => 'map-' . $data['map_type'],
      'frame_content'      => $frame_content
    ]
  ) );

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_map() {

  $control_map_type = [
    'key'     => 'map_type',
    'type'    => 'choose',
    'label'   => cs_recall( 'label_type' ),
    'options' => [
      'choices' => [
        [ 'value' => 'embed',  'label' => cs_recall( 'label_embed' )  ],
        [ 'value' => 'google', 'label' => cs_recall( 'label_google' ) ],
      ],
    ],
  ];

  $control_map_embed_code = [
    'key'        => 'map_embed_code',
    'type'       => 'textarea',
    'label'      => cs_recall( 'label_code' ),
    'condition'  => [ 'map_type' => 'embed' ],
    'options'    => [
      'height'    => 5,
      'monospace' => true,
    ]
  ];

  $control_map_google_api_key = [
    'key'        => 'map_google_api_key',
    'type'       => 'text',
    'label'      => cs_recall( 'label_api_key' ),
    'condition'  => [ 'map_type' => 'google' ],
  ];

  $control_map_google_lat = [
    'key'       => 'map_google_lat',
    'type'      => 'text',
    'label'     => cs_recall( 'label_latitude' ),
    'condition' => [ 'map_type' => 'google' ],
  ];

  $control_map_google_lng = [
    'key'       => 'map_google_lng',
    'type'      => 'text',
    'label'     => cs_recall( 'label_longitude' ),
    'condition' => [ 'map_type' => 'google' ],
  ];

  $control_map_google_controls = [
    'keys' => [
      'drag' => 'map_google_drag',
      'zoom' => 'map_google_zoom',
    ],
    'type'      => 'checkbox-list',
    'label'     => cs_recall( 'label_controls' ),
    'condition' => [ 'map_type' => 'google' ],
    'options'   => [
      'list' => [
        [ 'key' => 'drag', 'label' => cs_recall( 'label_drag' ) ],
        [ 'key' => 'zoom', 'label' => cs_recall( 'label_zoom' ) ],
      ],
    ],
  ];

  $control_map_google_zoom_level = [
    'key'        => 'map_google_zoom_level',
    'type'       => 'unit-slider',
    'label'      => cs_recall( 'label_zoom_level' ),
    'condition'  => [ 'map_type' => 'google' ],
    'options'    => [
      'unit_mode' => 'unitless',
      'min'       => 0,
      'max'       => 18,
      'step'      => 1
    ],
  ];

  $control_map_google_styles = [
    'key'     => 'map_google_styles',
    'type'    => 'textarea',
    'label'   => cs_recall( 'label_json' ) . '<a href="https://mapstyle.withgoogle.com/" target="_blank" class="tco-control-label-google-maps-styler-link"><span>↪</span></a>',
    'options' => [
      'monospace' => true,
    ],
  ];

  $control_map_markers = [
    'type'       => 'sortable',
    'label'      => cs_recall( 'label_markers' ),
    'group'      => 'map:setup',
    'condition'  => [ 'map_type' => 'google' ]
  ];


  // Control Groups (Advanced)
  // -------------------------

  $control_group_map_adv_setup = [
    'type'     => 'group',
    'group'    => 'map:setup',
    'controls' => [
      $control_map_type,
      $control_map_embed_code,
      $control_map_google_api_key,
      $control_map_google_lat,
      $control_map_google_lng,
      $control_map_google_zoom_level,
      $control_map_google_controls,
    ],
  ];

  $control_group_map_google_styles = [
    'type'       => 'group',
    'label'      => cs_recall( 'label_google_map_styles' ),
    'group'      => 'map:setup',
    'condition'  => [ 'map_type' => 'google' ],
    'controls'   => [
      $control_map_google_styles,
    ],
  ];



  // Control Groups (Standard)
  // -------------------------

  return cs_compose_controls(
    [
      'controls' => [
        $control_group_map_adv_setup,
        $control_map_markers,
        $control_group_map_google_styles
      ],
      'control_nav' => [
        'map'       => cs_recall( 'label_map' ),
        'map:setup' => cs_recall( 'label_setup' ),
      ],
    ],
    cs_partial_controls( 'frame', [ 'frame_content_type' => 'map' ] ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [ 'add_custom_atts' => true ] )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'map', [
  'title'      => __( 'Map', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'frame', 'effects' ],
  'builder'    => 'x_element_builder_setup_map',
  'tss'        => 'x_element_tss_map',
  'render'     => 'x_element_render_map',
  'icon'       => 'native',
  'options'    => [
    'cache'             => false,
    'render_children'   => true,
    'empty_placeholder' => false,
    'default_children'  => [],
    'valid_children'    => [ 'map-marker' ],
    'add_new_element'   => [ '_type' => 'map-marker' ]
  ]
] );
