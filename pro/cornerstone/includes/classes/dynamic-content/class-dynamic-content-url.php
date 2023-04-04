<?php

class Cornerstone_Dynamic_Content_Url extends Cornerstone_Plugin_Component {

  public function setup() {
    add_filter('cs_dynamic_content_url', array( $this, 'supply_field' ), 10, 3 );
    add_action('cs_dynamic_content_setup', array( $this, 'register' ) );
  }

  public function register() {
    cornerstone_dynamic_content_register_group(array(
      'name'  => 'url',
      'label' => csi18n('app.dc.group-title-url')
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'path',
      'group' => 'url',
      'label' => csi18n( 'app.dc.url.path' ),
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'segment',
      'group' => 'url',
      'label' => csi18n( 'app.dc.url.segment' ),
      'controls' => array(
        array(
          'key' => 'index',
          'type' => 'text',
          'label' => csi18n('app.dc.index'),
          'options' => array( 'placeholder' => '0' )
        ),
        array(
          'key' => 'fallback',
          'type' => 'text',
          'label' => csi18n('app.dc.fallback'),
          'options' => array( 'placeholder' => csi18n('app.dc.fallback') )
        )
      ),
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'param',
      'group' => 'url',
      'label' => csi18n( 'app.dc.url.param' ),
      'controls' => array(
        array(
          'key' => 'key',
          'type' => 'text',
          'label' => csi18n('app.dc.key'),
          'options' => array( 'placeholder' => csi18n('app.dc.key') )
        ),
        array(
          'key' => 'fallback',
          'type' => 'text',
          'label' => csi18n('app.dc.fallback'),
          'options' => array( 'placeholder' => csi18n('app.dc.fallback') )
        )
      ),
      'deep' => true
    ));

  }

  public function supply_field( $result, $field, $args) {

    global $wp;

    switch ($field) {
      case 'path':
        $result = esc_html( $wp->request );
        break;
      case 'segment':
        $parts = explode('/', $wp->request);
        $index = isset( $args['index'] ) ? $args['index'] : 0;
        if ( isset($parts[$index])) {
          $result = esc_html($parts[$index]);
        }
        break;
      case 'param':
        if ( isset( $args['key'] ) && isset( $_REQUEST[$args['key']] ) ) {
          $result = esc_html( $_REQUEST[$args['key']] );
        } 
        break;
    }

    return $result;
    
  }

}
