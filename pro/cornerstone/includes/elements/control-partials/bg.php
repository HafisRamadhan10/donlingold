<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/BG.PHP
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

function x_control_partial_bg( $settings ) {

  // Setup
  // -----

  $label_prefix = ( isset( $settings['label_prefix'] ) ) ? $settings['label_prefix'] : '';
  $k_pre        = ( isset( $settings['k_pre'] )        ) ? $settings['k_pre'] . '_'  : '';
  $group        = ( isset( $settings['group'] )        ) ? $settings['group']        : 'bg';
  $conditions   = ( isset( $settings['conditions'] )   ) ? $settings['conditions']   : [];


  // Conditions
  // ----------

  $condition_bg_lower_on_base      = [ 'key' => $k_pre . 'bg_lower_type', 'op' => 'NOT IN', 'value' => [ 'none' ] ];
  $condition_bg_lower_on_not_color = [ 'key' => $k_pre . 'bg_lower_type', 'op' => 'NOT IN', 'value' => [ 'none', 'color' ] ];
  $condition_bg_lower_color        = [ $k_pre . 'bg_lower_type' => 'color' ];
  $condition_bg_lower_image        = [ $k_pre . 'bg_lower_type' => 'image' ];
  $condition_bg_lower_img          = [ $k_pre . 'bg_lower_type' => 'img' ];
  $condition_bg_lower_video        = [ $k_pre . 'bg_lower_type' => 'video' ];
  $condition_bg_lower_custom       = [ $k_pre . 'bg_lower_type' => 'custom' ];
  $condition_bg_lower_parallax     = [ $condition_bg_lower_on_not_color, [ $k_pre . 'bg_lower_parallax' => true ] ];

  $condition_bg_upper_on_base      = [ 'key' => $k_pre . 'bg_upper_type', 'op' => 'NOT IN', 'value' => [ 'none' ] ];
  $condition_bg_upper_on_not_color = [ 'key' => $k_pre . 'bg_upper_type', 'op' => 'NOT IN', 'value' => [ 'none', 'color' ] ];
  $condition_bg_upper_color        = [ $k_pre . 'bg_upper_type' => 'color' ];
  $condition_bg_upper_image        = [ $k_pre . 'bg_upper_type' => 'image' ];
  $condition_bg_upper_img          = [ $k_pre . 'bg_upper_type' => 'img' ];
  $condition_bg_upper_video        = [ $k_pre . 'bg_upper_type' => 'video' ];
  $condition_bg_upper_custom       = [ $k_pre . 'bg_upper_type' => 'custom' ];
  $condition_bg_upper_parallax     = [ $condition_bg_upper_on_not_color, [ $k_pre . 'bg_upper_parallax' => true ] ];

  $conditions_bg_border_radius = array_merge( $conditions, [ $condition_bg_lower_on_base, array_merge( $condition_bg_upper_on_base, [ 'or' => true ] ) ] );


  // Options
  // -------

  $options_bg_type = array(
    'choices' => array(
      array( 'value' => 'none',   'label' => cs_recall( 'label_none' )             ),
      array( 'value' => 'color',  'label' => cs_recall( 'label_color' )            ),
      array( 'value' => 'image',  'label' => cs_recall( 'label_background_image' ) ),
      array( 'value' => 'img',    'label' => cs_recall( 'label_img_element' )      ),
      array( 'value' => 'video',  'label' => cs_recall( 'label_video' )            ),
      array( 'value' => 'custom', 'label' => cs_recall( 'label_custom' )           ),
    )
  );

  $options_bg_image_repeat = array(
    'choices' => array(
      array( 'value' => 'no-repeat', 'label' => cs_recall( 'label_none' ) ),
      array( 'value' => 'repeat-x',  'label' => cs_recall( 'label_x' )    ),
      array( 'value' => 'repeat-y',  'label' => cs_recall( 'label_y' )    ),
      array( 'value' => 'repeat',    'label' => cs_recall( 'label_both' ) ),
    )
  );

  $options_bg_img_alt = array(
    'placeholder' => cs_recall( 'label_describe_your_image' ),
  );

  $options_bg_img_object_fit = array(
    'choices' => array(
      array( 'value' => 'contain',    'label' => cs_recall( 'label_contain' )    ),
      array( 'value' => 'cover',      'label' => cs_recall( 'label_cover' )      ),
      array( 'value' => 'fill',       'label' => cs_recall( 'label_fill' )       ),
      array( 'value' => 'none',       'label' => cs_recall( 'label_none' )       ),
      array( 'value' => 'scale-down', 'label' => cs_recall( 'label_scale_down' ) ),
    )
  );

  $options_bg_video_placeholder = array(
    'placeholder' => 'http://example.com/a.mp4'
  );

  $options_bg_parallax_size = array(
    'available_units' => array( '%' ),
    'fallback_value'  => '150%',
    'ranges'          => array(
      '%' => array( 'min' => 100, 'max' => 250, 'step' => 5 ),
    ),
  );

  $options_bg_parallax_direction = array(
    'choices' => array(
      array( 'value' => 'v', 'icon' => 'ui:resize-ns' ),
      array( 'value' => 'h', 'icon' => 'ui:resize-ew' ),
    )
  );


  // Individual Controls (Lower)
  // ---------------------------

  $control_bg_lower_type = array(
    'key'     => $k_pre . 'bg_lower_type',
    'type'    => 'select',
    'label'   => cs_recall( 'label_type' ),
    'options' => $options_bg_type,
  );

  $control_bg_lower_color = array(
    'key'       => $k_pre . 'bg_lower_color',
    'type'      => 'color',
    'label'     => cs_recall( 'label_color' ),
    'condition' => $condition_bg_lower_color,
  );

  $control_bg_lower_image = array(
    'keys' => array(
      'img_source' => $k_pre . 'bg_lower_image',
    ),
    'type'      => 'image',
    'label'     => cs_recall( 'label_image' ),
    'condition' => $condition_bg_lower_image,
    'options'   => array(
      'height' => 2,
    ),
  );

  $control_bg_lower_image_repeat = array(
    'key'       => $k_pre . 'bg_lower_image_repeat',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_repeat' ),
    'condition' => $condition_bg_lower_image,
    'options'   => $options_bg_image_repeat,
  );

  $control_bg_lower_image_size = array(
    'key'       => $k_pre . 'bg_lower_image_size',
    'type'      => 'text',
    'label'     => cs_recall( 'label_size' ),
    'condition' => $condition_bg_lower_image,
    'options'   => array( 'dynamic_content' => false ),
  );

  $control_bg_lower_image_position = array(
    'key'       => $k_pre . 'bg_lower_image_position',
    'type'      => 'text',
    'label'     => cs_recall( 'label_position' ),
    'condition' => $condition_bg_lower_image,
    'options'   => array( 'dynamic_content' => false ),
  );

  $control_bg_lower_img_src = array(
    'keys' => array(
      'img_source' => $k_pre . 'bg_lower_img_src',
    ),
    'type'      => 'image',
    'label'     => cs_recall( 'label_image' ),
    'condition' => $condition_bg_lower_img,
    'options'   => array(
      'height' => 2,
    ),
  );

  $control_bg_lower_img_alt = array(
    'key'       => $k_pre . 'bg_lower_img_alt',
    'type'      => 'text',
    'label'     => cs_recall( 'label_alt_text' ),
    'options'   => $options_bg_img_alt,
    'condition' => $condition_bg_lower_img,
  );

  $control_bg_lower_img_object_fit = array(
    'key'       => $k_pre . 'bg_lower_img_object_fit',
    'type'      => 'select',
    'label'     => cs_recall( 'label_object_fit' ),
    'options'   => $options_bg_img_object_fit,
    'condition' => $condition_bg_lower_img,
  );

  $control_bg_lower_img_object_position = array(
    'key'       => $k_pre . 'bg_lower_img_object_position',
    'type'      => 'text',
    'label'     => cs_recall( 'label_position' ),
    'condition' => $condition_bg_lower_img,
  );

  $control_bg_lower_video = array(
    'key'       => $k_pre . 'bg_lower_video',
    'type'      => 'text',
    'label'     => cs_recall( 'label_source' ),
    'condition' => $condition_bg_lower_video,
    'options'   => $options_bg_video_placeholder,
  );

  $control_bg_lower_video_poster = array(
    'keys' => array(
      'img_source' => $k_pre . 'bg_lower_video_poster',
    ),
    'type'      => 'image',
    'label'     => cs_recall( 'label_poster' ),
    'condition' => $condition_bg_lower_video,
    'options'   => array(
      'height' => 3
    ),
  );

  $control_bg_lower_video_loop = array(
    'key'       => $k_pre . 'bg_lower_video_loop',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_loop' ),
    'condition' => $condition_bg_lower_video,
    'options'   => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_bg_lower_custom_content = array(
    'key'       => $k_pre . 'bg_lower_custom_content',
    'type'      => 'text-editor',
    'label'     => cs_recall( 'label_content' ),
    'condition' => $condition_bg_lower_custom,
    'options'   => array(
      'height'                => 4,
      'mode'                  => 'html',
      'no_rich_text'          => true,
      'disable_input_preview' => false,
    ),
  );

  $control_bg_lower_custom_aria_hidden = array(
    'key'       => $k_pre . 'bg_lower_custom_aria_hidden',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_aria_hidden' ),
    'options'   => cs_recall( 'options_choices_off_on_bool' ),
    'condition' => $condition_bg_lower_custom,
  );

  $control_bg_lower_parallax = array(
    'key'       => $k_pre . 'bg_lower_parallax',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_parallax' ),
    'options'   => cs_recall( 'options_choices_off_on_bool' ),
    'condition' => $condition_bg_lower_on_not_color,
  );

  $control_bg_lower_parallax_size = array(
    'key'        => $k_pre . 'bg_lower_parallax_size',
    'type'       => 'slider',
    'label'      => cs_recall( 'label_scale' ),
    'options'    => $options_bg_parallax_size,
    'conditions' => $condition_bg_lower_parallax,
  );

  $control_bg_lower_parallax_direction = array(
    'key'        => $k_pre . 'bg_lower_parallax_direction',
    'type'       => 'choose',
    'conditions' => $condition_bg_lower_parallax,
    'options'    => $options_bg_parallax_direction,
  );

  $control_bg_lower_parallax_reverse = array(
    'keys' => array(
      'lower_parallax_reverse' => $k_pre . 'bg_lower_parallax_reverse',
    ),
    'type'       => 'checkbox-list',
    'conditions' => $condition_bg_lower_parallax,
    'options'    => array(
      'list' => array(
        array( 'key' => 'lower_parallax_reverse', 'label' => cs_recall( 'label_reverse' ) ),
      ),
    ),
  );

  $control_bg_lower_parallax_direction_and_reverse = array(
    'type'       => 'group',
    'label'      => cs_recall( 'label_direction' ),
    'conditions' => $condition_bg_lower_parallax,
    'controls'   => array(
      $control_bg_lower_parallax_direction,
      $control_bg_lower_parallax_reverse,
    ),
  );


  // Individual Controls (Upper)
  // ---------------------------

  $control_bg_upper_type = array(
    'key'     => $k_pre . 'bg_upper_type',
    'type'    => 'select',
    'label'   => cs_recall( 'label_type' ),
    'options' => $options_bg_type,
  );

  $control_bg_upper_color = array(
    'key'       => $k_pre . 'bg_upper_color',
    'type'      => 'color',
    'label'     => cs_recall( 'label_color' ),
    'condition' => $condition_bg_upper_color,
  );

  $control_bg_upper_image = array(
    'keys' => array(
      'img_source' => $k_pre . 'bg_upper_image',
    ),
    'type'      => 'image',
    'label'     => cs_recall( 'label_image' ),
    'condition' => $condition_bg_upper_image,
    'options'   => array(
      'height' => 2
    ),
  );

  $control_bg_upper_image_repeat = array(
    'key'       => $k_pre . 'bg_upper_image_repeat',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_repeat' ),
    'condition' => $condition_bg_upper_image,
    'options'   => $options_bg_image_repeat,
  );

  $control_bg_upper_image_size = array(
    'key'       => $k_pre . 'bg_upper_image_size',
    'type'      => 'text',
    'label'     => cs_recall( 'label_size' ),
    'condition' => $condition_bg_upper_image,
    'options'   => array( 'dynamic_content' => false ),
  );

  $control_bg_upper_image_position = array(
    'key'       => $k_pre . 'bg_upper_image_position',
    'type'      => 'text',
    'label'     => cs_recall( 'label_position' ),
    'condition' => $condition_bg_upper_image,
    'options'   => array( 'dynamic_content' => false ),
  );

  $control_bg_upper_img_src = array(
    'keys' => array(
      'img_source' => $k_pre . 'bg_upper_img_src',
    ),
    'type'      => 'image',
    'label'     => cs_recall( 'label_image' ),
    'condition' => $condition_bg_upper_img,
    'options'   => array(
      'height' => 2,
    ),
  );

  $control_bg_upper_img_alt = array(
    'key'       => $k_pre . 'bg_upper_img_alt',
    'type'      => 'text',
    'label'     => cs_recall( 'label_alt_text' ),
    'options'   => $options_bg_img_alt,
    'condition' => $condition_bg_upper_img,
  );

  $control_bg_upper_img_object_fit = array(
    'key'       => $k_pre . 'bg_upper_img_object_fit',
    'type'      => 'select',
    'label'     => cs_recall( 'label_object_fit' ),
    'options'   => $options_bg_img_object_fit,
    'condition' => $condition_bg_upper_img,
  );

  $control_bg_upper_img_object_position = array(
    'key'       => $k_pre . 'bg_upper_img_object_position',
    'type'      => 'text',
    'label'     => cs_recall( 'label_position' ),
    'condition' => $condition_bg_upper_img,
  );

  $control_bg_upper_video = array(
    'key'       => $k_pre . 'bg_upper_video',
    'type'      => 'text',
    'label'     => cs_recall( 'label_source' ),
    'condition' => $condition_bg_upper_video,
    'options'   => $options_bg_video_placeholder,
  );

  $control_bg_upper_video_poster = array(
    'keys' => array(
      'img_source' => $k_pre . 'bg_upper_video_poster',
    ),
    'type'      => 'image',
    'label'     => cs_recall( 'label_poster' ),
    'condition' => $condition_bg_upper_video,
    'options'   => array(
      'height' => 3
    )
  );

  $control_bg_upper_video_loop = array(
    'key'       => $k_pre . 'bg_upper_video_loop',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_loop' ),
    'condition' => $condition_bg_upper_video,
    'options'   => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_bg_upper_custom_content = array(
    'key'       => $k_pre . 'bg_upper_custom_content',
    'type'      => 'text-editor',
    'label'     => cs_recall( 'label_content' ),
    'condition' => $condition_bg_upper_custom,
    'options'   => array(
      'height'                => 4,
      'mode'                  => 'html',
      'no_rich_text'          => true,
      'disable_input_preview' => false,
    ),
  );

  $control_bg_upper_custom_aria_hidden = array(
    'key'       => $k_pre . 'bg_upper_custom_aria_hidden',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_aria_hidden' ),
    'options'   => cs_recall( 'options_choices_off_on_bool' ),
    'condition' => $condition_bg_upper_custom,
  );

  $control_bg_upper_parallax = array(
    'key'       => $k_pre . 'bg_upper_parallax',
    'type'      => 'choose',
    'label'     => cs_recall( 'label_parallax' ),
    'options'   => cs_recall( 'options_choices_off_on_bool' ),
    'condition' => $condition_bg_upper_on_not_color,
  );

  $control_bg_upper_parallax_size = array(
    'key'        => $k_pre . 'bg_upper_parallax_size',
    'type'       => 'slider',
    'label'      => cs_recall( 'label_scale' ),
    'options'    => $options_bg_parallax_size,
    'conditions' => $condition_bg_upper_parallax,
  );

  $control_bg_upper_parallax_direction = array(
    'key'        => $k_pre . 'bg_upper_parallax_direction',
    'type'       => 'choose',
    'conditions' => $condition_bg_upper_parallax,
    'options'    => $options_bg_parallax_direction,
  );

  $control_bg_upper_parallax_reverse = array(
    'keys' => array(
      'upper_parallax_reverse' => $k_pre . 'bg_upper_parallax_reverse',
    ),
    'type'       => 'checkbox-list',
    'conditions' => $condition_bg_upper_parallax,
    'options'    => array(
      'list' => array(
        array( 'key' => 'upper_parallax_reverse', 'label' => cs_recall( 'label_reverse' ) ),
      ),
    ),
  );

  $control_bg_upper_parallax_direction_and_reverse = array(
    'type'       => 'group',
    'label'      => cs_recall( 'label_direction' ),
    'conditions' => $condition_bg_upper_parallax,
    'controls'   => array(
      $control_bg_upper_parallax_direction,
      $control_bg_upper_parallax_reverse,
    ),
  );


  // Control Groups (Advanced)
  // -------------------------

  $control_group_bg_adv_lower_layer = [
    'type'       => 'group',
    'label'      => cs_recall( 'label_lower' ),
    'label_vars' => [ 'prefix' => $label_prefix ],
    'group'      => $group,
    'conditions' => $conditions,
    'controls'   => [
      $control_bg_lower_type,
      $control_bg_lower_color,
      $control_bg_lower_image,
      $control_bg_lower_image_repeat,
      $control_bg_lower_image_size,
      $control_bg_lower_image_position,
      $control_bg_lower_img_src,
      $control_bg_lower_img_alt,
      $control_bg_lower_img_object_fit,
      $control_bg_lower_img_object_position,
      $control_bg_lower_video,
      $control_bg_lower_video_poster,
      $control_bg_lower_video_loop,
      $control_bg_lower_custom_content,
      $control_bg_lower_custom_aria_hidden,
      $control_bg_lower_parallax,
      $control_bg_lower_parallax_size,
      $control_bg_lower_parallax_direction_and_reverse,
    ],
  ];

  $control_group_bg_adv_upper_layer = [
    'type'       => 'group',
    'label'      => cs_recall( 'label_upper' ),
    'label_vars' => [ 'prefix' => $label_prefix ],
    'group'      => $group,
    'conditions' => $conditions,
    'controls'   => [
      $control_bg_upper_type,
      $control_bg_upper_color,
      $control_bg_upper_image,
      $control_bg_upper_image_repeat,
      $control_bg_upper_image_size,
      $control_bg_upper_image_position,
      $control_bg_upper_img_src,
      $control_bg_upper_img_alt,
      $control_bg_upper_img_object_fit,
      $control_bg_upper_img_object_position,
      $control_bg_upper_video,
      $control_bg_upper_video_poster,
      $control_bg_upper_video_loop,
      $control_bg_upper_custom_content,
      $control_bg_upper_custom_aria_hidden,
      $control_bg_upper_parallax,
      $control_bg_upper_parallax_direction,
      $control_bg_upper_parallax_direction_and_reverse,
    ],
  ];

  // Compose Controls
  // ----------------

  return [
    'controls' => [
      $control_group_bg_adv_lower_layer,
      $control_group_bg_adv_upper_layer,
      cs_control( 'border-radius', $k_pre . 'bg', [
        'group'      => $group,
        'conditions' => $conditions_bg_border_radius,
      ] )
    ]
  ];

}

cs_register_control_partial( 'bg', 'x_control_partial_bg' );
