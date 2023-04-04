<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/COUNTDOWN.PHP
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
    'countdown_end'                              => cs_value( 'TBD', 'markup' ),
    'countdown_base_font_size'                   => cs_value( '1em' ),
    'countdown_width'                            => cs_value( 'auto' ),
    'countdown_max_width'                        => cs_value( 'none' ),
    'countdown_bg_color'                         => cs_value( 'transparent', 'style:color' ),

    'countdown_units_display'                    => cs_value( 'd h m s', 'markup' ),
    'countdown_hide_on_end'                      => cs_value( false, 'markup' ),
    'countdown_hide_empty'                       => cs_value( false, 'markup' ),
    'countdown_leading_zeros'                    => cs_value( true, 'markup' ),
    'countdown_labels'                           => cs_value( true, 'markup' ),
    'countdown_labels_output'                    => cs_value( 'compact', 'markup' ),
    'countdown_aria_content'                     => cs_value( __( 'Countdown ends in {{d}} days, {{h}} hours, and {{m}} minutes.', '__x__' ), 'markup' ),

    'countdown_margin'                           => cs_value( '!0em' ),
    'countdown_padding'                          => cs_value( '!0em' ),
    'countdown_border_width'                     => cs_value( '!0px' ),
    'countdown_border_style'                     => cs_value( 'solid' ),
    'countdown_border_color'                     => cs_value( 'transparent', 'style:color' ),
    'countdown_border_radius'                    => cs_value( '!0px' ),
    'countdown_box_shadow_dimensions'            => cs_value( '!0em 0em 0em 0em' ),
    'countdown_box_shadow_color'                 => cs_value( 'transparent', 'style:color' ),

    'countdown_unit_width'                       => cs_value( 'auto' ),
    'countdown_unit_gap_column'                  => cs_value( '2rem' ),
    'countdown_unit_gap_row'                     => cs_value( '1rem' ),
    'countdown_unit_bg_color'                    => cs_value( 'transparent', 'style:color' ),
    'countdown_unit_padding'                     => cs_value( '!0em' ),
    'countdown_unit_border_width'                => cs_value( '!0px' ),
    'countdown_unit_border_style'                => cs_value( 'solid' ),
    'countdown_unit_border_color'                => cs_value( 'transparent', 'style:color' ),
    'countdown_unit_border_radius'               => cs_value( '!0px' ),
    'countdown_unit_box_shadow_dimensions'       => cs_value( '!0em 0em 0em 0em' ),
    'countdown_unit_box_shadow_color'            => cs_value( 'transparent', 'style:color' ),

    'countdown_number_bg_color'                  => cs_value( 'transparent', 'style:color' ),
    'countdown_number_margin'                    => cs_value( '!0em' ),
    'countdown_number_padding'                   => cs_value( '!0em' ),
    'countdown_number_border_width'              => cs_value( '!0px' ),
    'countdown_number_border_style'              => cs_value( 'solid' ),
    'countdown_number_border_color'              => cs_value( 'transparent', 'style:color' ),
    'countdown_number_border_radius'             => cs_value( '!0px' ),
    'countdown_number_box_shadow_dimensions'     => cs_value( '!0em 0em 0em 0em' ),
    'countdown_number_box_shadow_color'          => cs_value( 'transparent', 'style:color' ),

    'countdown_digit_bg_color'                   => cs_value( 'transparent', 'style:color' ),
    'countdown_digit_margin'                     => cs_value( '!0em' ),
    'countdown_digit_padding'                    => cs_value( '!0em' ),
    'countdown_digit_border_width'               => cs_value( '!0px' ),
    'countdown_digit_border_style'               => cs_value( 'solid' ),
    'countdown_digit_border_color'               => cs_value( 'transparent', 'style:color' ),
    'countdown_digit_border_radius'              => cs_value( '!0px' ),
    'countdown_digit_box_shadow_dimensions'      => cs_value( '!0em 0em 0em 0em' ),
    'countdown_digit_box_shadow_color'           => cs_value( 'transparent', 'style:color' ),
    'countdown_digit_font_family'                => cs_value( 'inherit', 'style:font-family' ),
    'countdown_digit_font_weight'                => cs_value( 'inherit:700', 'style:font-weight' ),
    'countdown_digit_font_size'                  => cs_value( '3em' ),
    'countdown_digit_line_height'                => cs_value( '1' ),
    'countdown_digit_font_style'                 => cs_value( 'normal' ),
    'countdown_digit_text_align'                 => cs_value( 'center' ),
    'countdown_digit_text_decoration'            => cs_value( 'none' ),
    'countdown_digit_text_transform'             => cs_value( 'none' ),
    'countdown_digit_text_color'                 => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'countdown_digit_text_shadow_dimensions'     => cs_value( '!0px 0px 0px' ),
    'countdown_digit_text_shadow_color'          => cs_value( 'transparent', 'style:color' ),

    'countdown_label_spacing'                    => cs_value( '0.1em' ),
    'countdown_label_font_family'                => cs_value( 'inherit', 'style:font-family' ),
    'countdown_label_font_weight'                => cs_value( 'inherit:400', 'style:font-weight' ),
    'countdown_label_font_size'                  => cs_value( '1.25em' ),
    'countdown_label_letter_spacing'             => cs_value( '0em' ),
    'countdown_label_line_height'                => cs_value( '1' ),
    'countdown_label_font_style'                 => cs_value( 'normal' ),
    'countdown_label_text_align'                 => cs_value( 'center' ),
    'countdown_label_text_decoration'            => cs_value( 'none' ),
    'countdown_label_text_transform'             => cs_value( 'none' ),
    'countdown_label_text_color'                 => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'countdown_label_text_shadow_dimensions'     => cs_value( '!0px 0px 0px' ),
    'countdown_label_text_shadow_color'          => cs_value( 'transparent', 'style:color' ),

    'countdown_complete_content'                 => cs_value( 'Showtime!', 'markup' ),
    'countdown_complete_font_family'             => cs_value( 'inherit', 'style:font-family' ),
    'countdown_complete_font_weight'             => cs_value( 'inherit:400', 'style:font-weight' ),
    'countdown_complete_font_size'               => cs_value( '1em' ),
    'countdown_complete_letter_spacing'          => cs_value( '0em' ),
    'countdown_complete_line_height'             => cs_value( '1' ),
    'countdown_complete_font_style'              => cs_value( 'normal' ),
    'countdown_complete_text_align'              => cs_value( 'center' ),
    'countdown_complete_text_decoration'         => cs_value( 'none' ),
    'countdown_complete_text_transform'          => cs_value( 'none' ),
    'countdown_complete_text_color'              => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'countdown_complete_text_shadow_dimensions'  => cs_value( '!0px 0px 0px' ),
    'countdown_complete_text_shadow_color'       => cs_value( 'transparent', 'style:color' ),

    'countdown_delimiter'                        => cs_value( false ),
    'countdown_delimiter_content'                => cs_value( ':' ),
    'countdown_delimiter_vertical_adjustment'    => cs_value( '0em' ),
    'countdown_delimiter_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'countdown_delimiter_font_family'            => cs_value( 'inherit', 'style:font-family' ),
    'countdown_delimiter_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
    'countdown_delimiter_font_size'              => cs_value( '1em' ),
    'countdown_delimiter_text_shadow_dimensions' => cs_value( '!0px 0px 0px' ),
    'countdown_delimiter_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  ],
  'omega',
  'omega:custom-atts'
);



// Style
// =============================================================================

function x_element_tss_countdown() {
  return [
    'require' => [ 'elements-legacy' ],
    'modules' => [ 'countdown', 'effects' ]
  ];
}

// Render
// =============================================================================

function x_element_render_countdown( $data ) {

  extract( $data );


  // Prepare Attr Values
  // -------------------

  $is_compact      = $countdown_labels_output === 'compact';
  $singular_labels = cs_get_countdown_labels( false, $is_compact );
  $plural_labels   = cs_get_countdown_labels( true, $is_compact );

  $countdown_end = cs_dynamic_content( $countdown_end );

  if ( 'TBD' === strtoupper( $countdown_end ) ) {
    $current_time = strtotime( current_time( 'mysql', true ) ) ;
    $countdown_end = date( 'Y-m-d H:i:s', $current_time + WEEK_IN_SECONDS );
  } else {
    $has_gmt_offset = strpos( $countdown_end, "GMT" ) !== false;
    $current_time = strtotime( current_time( 'mysql', $has_gmt_offset ) );
  }


  // Timestamp Diff
  // --------------

  $timestamp_diff = strtotime( $countdown_end ) - $current_time;


  // Prepare Atts
  // ------------

  $atts = array(
    'class' => array_merge( ['x-countdown', 'has-' . $countdown_labels_output . '-labels'], $classes )
  );

  if ( ! empty( $countdown_aria_content ) ) {
    $atts = array_merge( $atts, array(
      'role'        => 'timer',
      'aria-live'   => 'polite',
      'aria-atomic' => 'true',
    ) );
  }

  if ( isset( $id ) && ! empty( $id ) ) {
    $atts['id'] = $id;
  }

  if ( isset( $data['style'] ) && ! empty( $data['style'] ) ) {
    $atts['style'] = $data['style'];
  }

  $atts = cs_apply_effect( $atts, $data );

  if ( $timestamp_diff > 0 ) {
    $counter_data = array(
      'end'                    => date( 'Y-m-d\TH:i:s', strtotime( $countdown_end ) ), // reformat the date to ensure it can be parsed by all browsers (Safari)
      'serverTime'             => date( 'Y-m-d\TH:i:s', $current_time ),
      'hideEmpty'              => $countdown_hide_empty,
      'hideOnComplete'         => $countdown_hide_on_end,
      'leadingZeros'           => $countdown_leading_zeros,
      'completeMessageContent' => cs_expand_content( $countdown_complete_content ),
      'singularLabels'         => $singular_labels,
      'pluralLabels'           => $plural_labels,
      'ariaLabel'              => $countdown_aria_content,
    );

    $atts = array_merge( $atts, cs_element_js_atts( 'countdown', $counter_data, true ) );
  }


  // Units
  // -----

  $units_content           = '';
  $countdown_units_display = explode( ' ', trim( $countdown_units_display ) );

  if ( $timestamp_diff > 0 ) {

    $units_content .= '<div class="x-countdown-units" aria-hidden="true">';

      foreach( $countdown_units_display as $unit ) :

        if ( $countdown_hide_empty ) {
          if (
            $unit === 'd' && $timestamp_diff <  ( 60 * 60 * 24 ) ||
            $unit === 'h' && $timestamp_diff <  ( 60 * 60      ) ||
            $unit === 'm' && $timestamp_diff <  ( 60 * 1       ) ||
            $unit === 's' && $timestamp_diff <= ( 60 * 0       )
          ) {
            continue;
          }
        }

        $units_label = $countdown_labels ? '<div class="x-countdown-label"><div data-x-countdown-label-' . $unit . '>' . $plural_labels[$unit] . '</div></div>' : '';

        $units_content .= '<div class="x-countdown-unit x-countdown-' . $unit . '" data-x-countdown-unit>'
                          . '<div class="x-countdown-unit-content">'
                            . '<div class="x-countdown-number" data-x-countdown-' . $unit . '>'
                              . '<span class="x-countdown-digit">0</span>'
                              . '<span class="x-countdown-digit">0</span>'
                            . '</div>'
                            . $units_label
                          . '</div>'
                        . '</div>';

      endforeach;

    $units_content .= '</div>';

  }


  // Complete
  // --------

  $complete_content = '';

  if ( $timestamp_diff <= 0 ) {
    $complete_content .= '<div class="x-countdown-complete">' . $countdown_complete_content . '</div>';
  }


  // Output
  // ------

  return cs_tag('div', $atts, $custom_atts, [
    $units_content,
    $complete_content,
    !empty( $countdown_aria_content ) ? '<div class="visually-hidden" data-x-countdown-aria></div>' : ''
  ]);

}



// Builder Setup
// =============================================================================

function x_element_builder_setup_countdown() {

  // Individual Controls - Setup
  // ---------------------------

  $control_countdown_base_font_size = cs_recall( 'control_mixin_font_size', [ 'key' => 'countdown_base_font_size' ] );

  $control_countdown_end = [
    'key'   => 'countdown_end',
    'type'  => 'date-time',
    'label' => cs_recall( 'label_end_date' ),
  ];

  $control_countdown_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'countdown_bg_color' ] ] );


  // Individual Controls - Format
  // ----------------------------

  $control_countdown_units_display = [
    'key'     => 'countdown_units_display',
    'type'    => 'multi-choose',
    'label'   => cs_recall( 'label_units' ),
    'options' => [
      'choices' => [
        [ 'value' => 'd', 'label' => cs_recall( 'label_d' ) ],
        [ 'value' => 'h', 'label' => cs_recall( 'label_h' ) ],
        [ 'value' => 'm', 'label' => cs_recall( 'label_m' ) ],
        [ 'value' => 's', 'label' => cs_recall( 'label_s' ) ],
      ],
    ],
  ];

  $control_countdown_options = [
    'keys' => [
      'hide_on_end'   => 'countdown_hide_on_end',
      'hide_empty'    => 'countdown_hide_empty',
      'labels'        => 'countdown_labels',
      'delimiter'     => 'countdown_delimiter',
      'leading_zeros' => 'countdown_leading_zeros',
    ],
    'type'    => 'checkbox-list',
    'label'   => cs_recall( 'label_options' ),
    'options' => [
      'list' => [
        [ 'key' => 'hide_on_end',   'label' => cs_recall( 'label_hide_on_end' )  ],
        [ 'key' => 'hide_empty',    'label' => cs_recall( 'label_hide_empty' )   ],
        [ 'key' => 'labels',        'label' => cs_recall( 'label_labels' )       ],
        [ 'key' => 'delimiter',     'label' => cs_recall( 'label_delimiter' )    ],
        [ 'key' => 'leading_zeros', 'label' => cs_recall( 'label_leading_zero' ) ],
      ],
    ],
  ];

  $control_countdown_labels_output = [
    'key'       => 'countdown_labels_output',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_label_placement' ),
    'condition' => [ 'countdown_labels' => true ],
    'options'   => [
      'choices' => [
        [ 'value' => 'compact', 'label' => cs_recall( 'label_brief' ) ],
        [ 'value' => 'top',     'label' => cs_recall( 'label_above' ) ],
        [ 'value' => 'bottom',  'label' => cs_recall( 'label_below' ) ],
      ],
    ],
  ];

  $control_countdown_aria_content = [
    'key'     => 'countdown_aria_content',
    'type'    => 'textarea',
    'label'   => cs_recall( 'label_aria_content' ),
    'options' => [
      'height' => 3,
    ],
  ];


  // Individual Controls - Size
  // --------------------------

  $control_countdown_width     = cs_recall( 'control_mixin_width',     [ 'key' => 'countdown_width'     ] );
  $control_countdown_max_width = cs_recall( 'control_mixin_max_width', [ 'key' => 'countdown_max_width' ] );


  // Individual Controls - Units
  // ---------------------------

  $control_countdown_unit_width      = cs_recall( 'control_mixin_width',         [ 'key' => 'countdown_unit_width'                                                 ] );
  $control_countdown_unit_gap_column = cs_recall( 'control_mixin_gap',           [ 'key' => 'countdown_unit_gap_column', 'label' => cs_recall( 'label_gap_width' ) ] );
  $control_countdown_unit_gap_row    = cs_recall( 'control_mixin_gap',           [ 'key' => 'countdown_unit_gap_row', 'label' => cs_recall( 'label_gap_height' )   ] );
  $control_countdown_unit_bg_color   = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'countdown_unit_bg_color' ]                              ] );


  // Individual Controls - Number
  // ----------------------------

  $control_countdown_number_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'countdown_number_bg_color' ] ] );


  // Individual Controls - Digit
  // ---------------------------

  $control_countdown_digit_bg_color = cs_recall( 'control_mixin_bg_color_solo', [ 'keys' => [ 'value' => 'countdown_digit_bg_color' ] ] );


  // Individual Controls - Label
  // ---------------------------

  $control_countdown_label_spacing  = cs_recall( 'control_mixin_gap', [ 'key' => 'countdown_label_spacing', 'label' => cs_recall( 'label_label_spacing' ) ] );


  // Individual Controls - Complete
  // ------------------------------

  $control_countdown_complete_content = array(
    'key'     => 'countdown_complete_content',
    'type'    => 'text-editor',
    'label'   => cs_recall( 'label_content' ),
    'options' => array(
      'height'                => 4,
      'disable_input_preview' => false,
    ),
  );


  // Individual Controls - Delimiter
  // -------------------------------

  $control_countdown_delimiter_content = array(
    'key'       => 'countdown_delimiter_content',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_delimiter' ),
    'condition' => array( 'countdown_delimiter' => true ),
    'options'   => array(
      'choices' => array(
        array( 'value' => ':', 'label' => ':' ),
        array( 'value' => '/', 'label' => '/' ),
        array( 'value' => '|', 'label' => '|' ),
        array( 'value' => '•', 'label' => '•' ),
      ),
    ),
  );

  $control_countdown_delimiter_vertical_adjustment = cs_recall( 'control_mixin_gap',        [ 'key' => 'countdown_delimiter_vertical_adjustment', 'label' => cs_recall( 'label_align_vertical' ), 'condition' => array( 'countdown_delimiter' => true ) ] );
  $control_countdown_delimiter_text_color          = cs_recall( 'control_mixin_color_solo', [ 'keys' => [ 'value' => 'countdown_delimiter_text_color' ], 'condition' => array( 'countdown_delimiter' => true )                                          ] );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls' => array(
        array(
          'type'       => 'group',
          'group'      => 'countdown:setup',
          'controls'   => array(
            $control_countdown_base_font_size,
            $control_countdown_end,
            $control_countdown_units_display,
            $control_countdown_options,
            $control_countdown_labels_output,
            $control_countdown_aria_content,
            $control_countdown_bg_color,
          ),
        ),
        array(
          'type'       => 'group',
          'group'      => 'countdown:size',
          'controls'   => array(
            $control_countdown_width,
            $control_countdown_max_width,
          ),
        ),

        cs_control( 'margin',        'countdown', array( 'group' => 'countdown:design' ) ),
        cs_control( 'padding',       'countdown', array( 'group' => 'countdown:design' ) ),
        cs_control( 'border',        'countdown', array( 'group' => 'countdown:design' ) ),
        cs_control( 'border-radius', 'countdown', array( 'group' => 'countdown:design' ) ),
        cs_control( 'box-shadow',    'countdown', array( 'group' => 'countdown:design' ) ),

        array(
          'type'     => 'group',
          'group'    => 'countdown_unit:setup',
          'controls' => array(
            $control_countdown_unit_width,
            $control_countdown_unit_gap_column,
            $control_countdown_unit_gap_row,
            $control_countdown_unit_bg_color,
          ),
        ),

        cs_control( 'padding',       'countdown_unit', array( 'group' => 'countdown_unit:design' ) ),
        cs_control( 'border',        'countdown_unit', array( 'group' => 'countdown_unit:design' ) ),
        cs_control( 'border-radius', 'countdown_unit', array( 'group' => 'countdown_unit:design' ) ),
        cs_control( 'box-shadow',    'countdown_unit', array( 'group' => 'countdown_unit:design' ) ),

        array(
          'type'     => 'group',
          'group'    => 'countdown_number:setup',
          'controls' => array(
            $control_countdown_number_bg_color,
          ),
        ),

        cs_control( 'margin',        'countdown_number', array( 'group' => 'countdown_number:design' ) ),
        cs_control( 'padding',       'countdown_number', array( 'group' => 'countdown_number:design' ) ),
        cs_control( 'border',        'countdown_number', array( 'group' => 'countdown_number:design' ) ),
        cs_control( 'border-radius', 'countdown_number', array( 'group' => 'countdown_number:design' ) ),
        cs_control( 'box-shadow',    'countdown_number', array( 'group' => 'countdown_number:design' ) ),

        array(
          'type'     => 'group',
          'group'    => 'countdown_digit:setup',
          'controls' => array(
            $control_countdown_digit_bg_color,
          ),
        ),

        cs_control( 'margin',        'countdown_digit', array( 'group' => 'countdown_digit:design' ) ),
        cs_control( 'padding',       'countdown_digit', array( 'group' => 'countdown_digit:design' ) ),
        cs_control( 'border',        'countdown_digit', array( 'group' => 'countdown_digit:design' ) ),
        cs_control( 'border-radius', 'countdown_digit', array( 'group' => 'countdown_digit:design' ) ),
        cs_control( 'box-shadow',    'countdown_digit', array( 'group' => 'countdown_digit:design' ) ),

        cs_control( 'text-format', 'countdown_digit', array( 'group' => 'countdown_digit:text', 'no_letter_spacing' => true ) ),
        cs_control( 'text-shadow', 'countdown_digit', array( 'group' => 'countdown_digit:text' ) ),

        array(
          'type'     => 'group',
          'group'    => 'countdown_label:setup',
          'controls' => array(
            $control_countdown_label_spacing,
          ),
        ),

        cs_control( 'text-format', 'countdown_label', array( 'group' => 'countdown_label:text' ) ),
        cs_control( 'text-shadow', 'countdown_label', array( 'group' => 'countdown_label:text' ) ),

        array(
          'type'     => 'group',
          'group'    => 'countdown_complete:setup',
          'controls' => array(
            $control_countdown_complete_content,
          ),
        ),

        cs_control( 'text-format', 'countdown_complete', array( 'group' => 'countdown_complete:text' ) ),
        cs_control( 'text-shadow', 'countdown_complete', array( 'group' => 'countdown_complete:text' ) ),

        array(
          'type'      => 'group',
          'group'     => 'countdown_delimiter:setup',
          'condition' => array( 'countdown_delimiter' => true ),
          'controls'  => array(
            $control_countdown_delimiter_content,
            $control_countdown_delimiter_vertical_adjustment,
            $control_countdown_delimiter_text_color,
          ),
        ),

        cs_control( 'text-format', 'countdown_delimiter', array(
          'group'              => 'countdown_delimiter:text',
          'conditions'         => array( array( 'countdown_delimiter' => true ) ),
          'no_font_style'      => true,
          'no_letter_spacing'  => true,
          'no_line_height'     => true,
          'no_text_align'      => true,
          'no_text_decoration' => true,
          'no_text_transform'  => true,
        ) ),
        cs_control( 'text-shadow', 'countdown_delimiter', array(
          'group'      => 'countdown_delimiter:text',
          'conditions' => array( array( 'countdown_delimiter' => true ) ),
        ) )
      ),

      'control_nav' => array(
        'countdown'                 => cs_recall( 'label_countdown' ),
        'countdown:setup'           => cs_recall( 'label_setup' ),
        'countdown:design'          => cs_recall( 'label_design' ),

        'countdown_unit'            => cs_recall( 'label_unit' ),
        'countdown_unit:setup'      => cs_recall( 'label_setup' ),
        'countdown_unit:design'     => cs_recall( 'label_design' ),

        'countdown_number'          => cs_recall( 'label_number' ),
        'countdown_number:setup'    => cs_recall( 'label_setup' ),
        'countdown_number:design'   => cs_recall( 'label_design' ),

        'countdown_digit'           => cs_recall( 'label_digit' ),
        'countdown_digit:setup'     => cs_recall( 'label_setup' ),
        'countdown_digit:design'    => cs_recall( 'label_design' ),
        'countdown_digit:text'      => cs_recall( 'label_text' ),

        'countdown_label'           => cs_recall( 'label_label' ),
        'countdown_label:setup'     => cs_recall( 'label_setup' ),
        'countdown_label:text'      => cs_recall( 'label_text' ),

        'countdown_complete'        => cs_recall( 'label_complete' ),
        'countdown_complete:setup'  => cs_recall( 'label_setup' ),
        'countdown_complete:text'   => cs_recall( 'label_text' ),

        'countdown_delimiter'       => cs_recall( 'label_delimiter' ),
        'countdown_delimiter:setup' => cs_recall( 'label_setup' ),
        'countdown_delimiter:text'  => cs_recall( 'label_text' ),
      )
    ),
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', array( 'add_custom_atts' => true ) )
  );
}



// Register Element
// =============================================================================

cs_register_element( 'countdown', [
  'title'      => __( 'Countdown', 'cornerstone' ),
  'values'     => $values,
  'components' => [ 'effects' ],
  'builder'    => 'x_element_builder_setup_countdown',
  'tss'        => 'x_element_tss_countdown',
  'render'     => 'x_element_render_countdown',
  'icon'       => 'native',
  'options'    => [
    'empty_preview_min_height' => 3
  ]
] );
