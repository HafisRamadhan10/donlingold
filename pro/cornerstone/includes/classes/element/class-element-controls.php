<?php


class Cornerstone_Element_Controls extends Cornerstone_Plugin_Component {

  public function control( $type, $key_prefix = null, $control = array() ) {

    if ( ! isset( $control['type'] ) ) {
      $control['type'] = $type;
    }

    $key_prefix = $key_prefix ? $key_prefix . '_' : '';

    return call_user_func_array(
      [ $this, str_replace( '-', '_', $control['type'] ) ],
      [ $key_prefix, $control ]
    );
  }

  public function margin( $key_prefix, $control ) {

    $options = isset( $control['options'] ) ? $control['options'] : [];
    unset( $control['options']);

    return array_merge( array(
      'key'        => $key_prefix . 'margin',
      'type'       => 'margin',
      'options' => array_merge([
        'vertical_label'   => cs_recall('label_margin'),
        'horizontal_label' => cs_recall('label_margin_with_prefix')
      ], $options )
    ), $control );
  }

  public function padding( $key_prefix, $control ) {

    $options = isset( $control['options'] ) ? $control['options'] : [];
    unset( $control['options']);

    return array_merge( array(
      'key'        => $key_prefix . 'padding',
      'type'       => 'padding',
      'options' => array_merge([
        'vertical_label'   => cs_recall('label_padding'),
        'horizontal_label' => cs_recall('label_padding_with_prefix')
      ], $options )
    ), $control );
  }

  public function border_radius( $key_prefix, $control ) {

    $options = isset( $control['options'] ) ? $control['options'] : [];
    unset( $control['options']);

    $prefix_horizontal = isset( $control['prefix_horizontal'] ) && $control['prefix_horizontal'];
    unset( $control['prefix_horizontal'] );
    return array_merge( array(
      'key'        => $key_prefix . 'border_radius',
      'type'       => 'border-radius',
      'options' => array_merge([
        'vertical_label'   => $prefix_horizontal ? cs_recall('label_border_radius_with_prefix') : cs_recall('label_border_radius'),
        'horizontal_label' => cs_recall('label_border_radius_with_prefix')
      ], $options )
    ), $control );
  }

  public function border( $key_prefix, $control ) {

    $options = ( isset( $control['options'] ) ) ? $control['options'] : array();
    unset( $control['options']);

    $keys = array(
      'width' => $key_prefix . 'border_width',
      'style' => $key_prefix . 'border_style',
      'color' => $key_prefix . 'border_color',
    );

    if ( isset( $control['alt_color'] ) && $control['alt_color'] )  {
      $keys['alt_color'] = $key_prefix . 'border_color_alt';
    }

    return array_merge( array(
      'keys'  => $keys,
      'type'  => 'border',
      'options' => array_merge([
        'vertical_label'   => cs_recall('label_border'),
        'horizontal_label' => cs_recall('label_border_with_prefix')
      ], $options )
    ), $control );

  }

  public function box_shadow( $key_prefix, $control ) {

    $keys = array(
      'dimensions' => $key_prefix . 'box_shadow_dimensions',
      'color'      => $key_prefix . 'box_shadow_color',
    );

    $options = ( isset( $control['options'] ) ) ? $control['options'] : array();
    unset( $control['options']);

    if ( isset( $control['alt_color'] ) && $control['alt_color'] )  {
      $keys['alt_color'] = $key_prefix . 'box_shadow_color_alt';
    }

    return array_merge( array(
      'keys'  => $keys,
      'type'  => 'box-shadow',
      'options' => array_merge([
        'vertical_label'   => cs_recall('label_box_shadow'),
        'horizontal_label' => cs_recall('label_box_shadow_with_prefix')
      ], $options )
    ), $control );

  }

  public function flexbox( $key_prefix, $control ) {

    $layout_pre = ( isset( $control['layout_pre'] ) ) ? $key_prefix . $control['layout_pre'] . '_' : $key_prefix;

    $keys = array(
      'direction' => $layout_pre . 'flex_direction',
      'wrap'      => $layout_pre . 'flex_wrap',
      'justify'   => $layout_pre . 'flex_justify',
      'align'     => $layout_pre . 'flex_align'
    );

    if ( isset( $control['toggle'] ) && $control['toggle'] ) {
      $keys['toggle'] = $control['toggle'];
    }

    if ( isset( $control['self_flex'] ) && $control['self_flex'] ) {
      $keys['self'] = $key_prefix . 'flex';
    }

    $options = ( isset( $control['options'] ) ) ? $control['options'] : array();
    unset( $control['options']);

    $output = array_merge( array(
      'keys'       => $keys,
      'type'       => 'flexbox',
      'options' => array_merge([
        'vertical_label'   => cs_recall('label_flexbox'),
        'horizontal_label' => cs_recall('label_flexbox_with_prefix')
      ], $options )
    ), $control );

    // Use boolean toggle by default
    if ( isset( $control['toggle'] ) && $control['toggle'] && !isset($output['options']['toggle'])) {
      $output['options'] = array_merge( $output['options'], cs_recall( 'options_group_toggle_off_on_bool' ) );
    }

    return $output;

  }

  public function text_shadow( $key_prefix, $control ) {

    $keys = array(
      'dimensions' => $key_prefix . 'text_shadow_dimensions',
      'color'      => $key_prefix . 'text_shadow_color',
    );

    if ( isset( $control['alt_color'] ) && $control['alt_color'] )  {
      $keys['alt_color'] = $key_prefix . 'text_shadow_color_alt';
    }

    $options = ( isset( $control['options'] ) ) ? $control['options'] : array();
    unset( $control['options']);

    return array_merge( array(
      'keys'       => $keys,
      'type'       => 'text-shadow',
      'options' => array_merge([
        'vertical_label'   => cs_recall('label_shadow'),
        'horizontal_label' => cs_recall('label_text_shadow_with_prefix')
      ], $options )
    ), $control );

  }

  public function text_format( $key_prefix, $control ) {

    // Setup
    // -----

    $alt_color          = isset( $control['alt_color'] ) && $control['alt_color'];

    $no_font_family     = isset( $control['no_font_family'] ) && $control['no_font_family'];
    $no_font_weight     = isset( $control['no_font_weight'] ) && $control['no_font_weight'];
    $no_font_size       = isset( $control['no_font_size'] ) && $control['no_font_size'];
    $no_line_height     = isset( $control['no_line_height'] ) && $control['no_line_height'];
    $no_letter_spacing  = isset( $control['no_letter_spacing'] ) && $control['no_letter_spacing'];

    $no_font_style      = isset( $control['no_font_style'] ) && $control['no_font_style'];
    $no_text_align      = isset( $control['no_text_align'] ) && $control['no_text_align'];
    $no_text_decoration = isset( $control['no_text_decoration'] ) && $control['no_text_decoration'];
    $no_text_transform  = isset( $control['no_text_transform'] ) && $control['no_text_transform'];
    $no_text_color      = isset( $control['no_text_color'] ) && $control['no_text_color'];

    // Keys
    // ----

    $keys = array(
      'font_family'     => $key_prefix . 'font_family',
      'font_weight'     => $key_prefix . 'font_weight',
      'font_size'       => $key_prefix . 'font_size',
      'line_height'     => $key_prefix . 'line_height',
      'letter_spacing'  => $key_prefix . 'letter_spacing',
      'font_style'      => $key_prefix . 'font_style',
      'text_align'      => $key_prefix . 'text_align',
      'text_decoration' => $key_prefix . 'text_decoration',
      'text_transform'  => $key_prefix . 'text_transform',
      'text_color'      => $key_prefix . 'text_color',
    );

    // Format
    if ( $no_font_family )    { unset( $keys['font_family'] );    }
    if ( $no_font_weight )    { unset( $keys['font_weight'] );    }
    if ( $no_font_size )      { unset( $keys['font_size'] );      }
    if ( $no_line_height )    { unset( $keys['line_height'] );    }
    if ( $no_letter_spacing ) { unset( $keys['letter_spacing'] ); }

    // Style
    if ( $alt_color )          { $keys['alt_color'] = $key_prefix . 'text_color_alt'; }
    if ( $no_font_style )      { unset( $keys['font_style'] );                   }
    if ( $no_text_align )      { unset( $keys['text_align'] );                   }
    if ( $no_text_decoration ) { unset( $keys['text_decoration'] );              }
    if ( $no_text_transform )  { unset( $keys['text_transform'] );               }
    if ( $no_text_color )      { unset( $keys['text_color'] );                   }


    $options = ( isset( $control['options'] ) ) ? $control['options'] : array();
    unset( $control['options']);

    return array_merge( array(
      'keys'       => $keys,
      'type'       => 'text-format',
      'options' => array_merge([
        'vertical_label'   => cs_recall('label_format'),
        'horizontal_label' => cs_recall('label_text_format_with_prefix')
      ], $options )
    ), $control );

  }
}
