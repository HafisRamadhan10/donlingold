<?php

class Cornerstone_Dynamic_Content_Looper extends Cornerstone_Plugin_Component {

  public function setup() {
    add_filter('cs_dynamic_content_looper', array( $this, 'supply_field' ), 10, 3 );
    add_action('cs_dynamic_content_setup', array( $this, 'register' ) );
  }

  public function register() {
    cornerstone_dynamic_content_register_group(array(
      'name'  => 'looper',
      'label' => csi18n('app.dc.group-title-looper')
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'item',
      'group' => 'looper',
      'type'  => 'mixed',
      'label' => csi18n( 'app.dc.looper.item' ),
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'index',
      'group' => 'looper',
      'label' => csi18n( 'app.dc.looper.index' ),
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'count',
      'group' => 'looper',
      'label' => csi18n( 'app.dc.looper.count' ),
    ));

    // cornerstone_dynamic_content_register_field(array(
    //   'name'  => 'debug_provider',
    //   'group' => 'looper',
    //   'label' => csi18n( 'app.dc.looper.debug-provider' ),
    // ));

    // cornerstone_dynamic_content_register_field(array(
    //   'name'  => 'debug_consumer',
    //   'group' => 'looper',
    //   'label' => csi18n( 'app.dc.looper.debug-consumer' ),
    // ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'field',
      'group' => 'looper',
      'type'  => 'mixed',
      'label' => csi18n( 'app.dc.looper.field' ),
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
    
    $looper_manager = $this->plugin->component('Looper_Manager');
    
    switch ($field) {
      case 'debug_provider':
        $result = $looper_manager->debug_provider();
        break;
      case 'debug_consumer':
        $result = $looper_manager->debug_consumer();
        break;
      case 'index':
        $result = $looper_manager->get_index() + 1;
        break;
      case 'count':
        $result = $looper_manager->get_size();
        break;
      case 'item':
        $result = $looper_manager->get_current_data();
        break;
      case 'field':
        if (isset($args['key']) && $args['key']) {
          $lookup = apply_filters( 'cs_looper_field', cs_get_path($looper_manager->get_current_data(), $args['key']), $args );
          if (!is_null($lookup)) {
            $result = is_string( $lookup ) ? cs_dynamic_content( $lookup ) : $lookup;
          }
        }
        
        break;
    }

    return $result;
  }

}
