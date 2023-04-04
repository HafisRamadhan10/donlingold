<?php

$controls = array(
  array(
    'type'       => 'group',
    'label'      => __( 'Compatibility', 'cornerstone' ),
    'controls'   => array(
      array(
        'label' => __('Safe Headers/Footers', 'cornerstone' ),
        'key' => 'cs_safe_layouts',
        'type' => 'toggle'
      )
    ),
  ),
  array(
    'type'       => 'group',
    'label'      => __( 'Colors', 'cornerstone' ),
    'controls'   => array(
      array(
        'key' => 'cs_v1_text_color',
        'type' => 'color',
        'label' => __( 'Text', 'cornerstone' )
      ),
      array(
        'key' => 'cs_v1_link_color',
        'type' => 'color',
        'label' => __( 'Link', 'cornerstone' )
      ),
      array(
        'key' => 'cs_v1_link_color_hover',
        'type' => 'color',
        'label' => __( 'Link Hover', 'cornerstone' )
      )
    ),
  ),
  array(
    'type'       => 'group',
    'label'      => __( 'Layout', 'cornerstone' ),
    'controls'   => array(
      array(
        'key' => 'cs_v1_base_margin',
        'type' => 'text',
        'label' => __( 'Base Margin', 'cornerstone' )
      ),
      array(
        'type'       => 'group',
        'label'      => '&nbsp;',
        'controls'   => array(
          array(
            'type'    => 'label',
            'label'   => __( 'Width', '__x__' ),
            'options' => array(
              'columns' => 1
            )
          ),
          array(
            'type'    => 'label',
            'label'   => __( 'Max Width', '__x__' ),
            'options' => array(
              'columns' => 1
            )
          ),
        ),
      ),
      array(
        'type' => 'group',
        'label' => __( 'Container', 'cornerstone' ),
        'controls' => array(
          array(
            'key' => 'cs_v1_container_width',
            'type' => 'text',
            'options'    => array( 'grouped' => true ),
          ),
          array(
            'key' => 'cs_v1_container_max_width',
            'type' => 'text',
            'options'    => array( 'grouped' => true ),
          ),
        )
      )
    ),
  ),
);


if ( CS()->component('App_Permissions')->user_can('element.classic:button') ) {

  $color_options = array(
    'label'     => __('Base', 'cornerstone'),
    'alt_label' => __('Interaction', 'cornerstone')
  );

  $controls[] = array(
    'type'       => 'group',
    'label'      => __( 'Classic Buttons', 'cornerstone' ),
    'controls'   => array(
      array(
        'key' => 'cs_v1_button_style',
        'type' => 'select',
        'label' => __( 'Style', 'cornerstone' ),
        'options' => array(
          'choices' => array(
            array( 'value' => 'real', 'label'        => __( '3D', 'cornerstone' )),
            array( 'value' => 'flat', 'label'        => __( 'Flat', 'cornerstone' )),
            array( 'value' => 'transparent', 'label' => __( 'Transparent', 'cornerstone' ))
          )
        )
      ),
      array(
        'key' => 'cs_v1_button_shape',
        'type' => 'select',
        'label' => __( 'Shape', 'cornerstone' ),
        'options' => array(
          'choices' => array(
            array( 'value' => 'square', 'label'  => __( 'Square', 'cornerstone' ) ),
            array( 'value' => 'rounded', 'label' => __( 'Rounded', 'cornerstone' ) ),
            array( 'value' => 'pill', 'label'    => __( 'Pill', 'cornerstone' ) )
          )
        )
      ),
      array(
        'key' => 'cs_v1_button_size',
        'type' => 'select',
        'label' => __( 'Size', 'cornerstone' ),
        'options' => array(
          'choices' => array(
            array( 'value' => 'mini', 'label'    => __( 'Mini', 'cornerstone' )),
            array( 'value' => 'small', 'label'   => __( 'Small', 'cornerstone' )),
            array( 'value' => 'regular', 'label' => __( 'Regular', 'cornerstone' )),
            array( 'value' => 'large', 'label'   => __( 'Large', 'cornerstone' )),
            array( 'value' => 'x-large', 'label' => __( 'Extra Large', 'cornerstone' )),
            array( 'value' => 'jumbo', 'label'   => __( 'Jumbo', 'cornerstone' ))
          )
        )
      ),

      array(
        'keys'    => array(
          'value' => 'cs_v1_button_color',
          'alt' => 'cs_v1_button_color_hover'
        ),
        'type'    => 'color',
        'label'   => __( 'Text Color', '__x__' ),
        'options' => $color_options
      ),

      array(
        'keys'    => array(
          'value' => 'cs_v1_button_bg_color',
          'alt' => 'cs_v1_button_bg_color_hover'
        ),
        'type'    => 'color',
        'label'   => __( 'Background', '__x__' ),
        'options' => $color_options,
        'condition' => array( 'key' => 'cs_v1_button_style', 'value' => 'transparent', 'op' => '!=' )
      ),

      array(
        'keys'    => array(
          'value' => 'cs_v1_button_border_color',
          'alt' => 'cs_v1_button_border_color_hover'
        ),
        'type'    => 'color',
        'label'   => __( 'Border', '__x__' ),
        'options' => $color_options
      ),

      array(
        'keys'    => array(
          'value' => 'cs_v1_button_bottom_color',
          'alt' => 'cs_v1_button_bottom_color_hover'
        ),
        'type'    => 'color',
        'label'   => __( 'Bottom', '__x__' ),
        'options' => $color_options,
        'condition' => array( 'key' => 'cs_v1_button_style', 'value' => array( 'flat', 'transparent' ), 'op' => 'NOT IN' )
      )
    )
  );
}

return [
  [
    'type' => 'group-module',
    'label' => __( 'Theme Integration', 'cornerstone' ),
    'controls' => $controls
  ]
];
