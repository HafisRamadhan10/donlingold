<?php

class Cornerstone_Dynamic_Content_Rivet extends Cornerstone_Plugin_Component {

  public function setup() {
    add_filter('cs_dynamic_content_rivet', array( $this, 'supply_field' ), 10, 3 );
    add_filter('cs_dynamic_content_rvt', array( $this, 'supply_field' ), 10, 3 );
    add_action('cs_dynamic_content_setup', array( $this, 'register' ) );
  }

  public function register() {
    // cornerstone_dynamic_content_register_group(array(
    //   'name'  => 'rivet',
    //   'label' => csi18n('app.dc.group-title-rivet')
    // ));


  }

  public function supply_field( $result, $field, $args) {

    switch ($field) {
      case 'outlet':

        if (isset( $args['state'] ) && $args['state'] ) {
          $tag = isset($args['tag']) ? esc_html( $args['tag'] ) : 'span';
          $initial = isset($args['initial']) ? $args['initial'] : '';



          $atts = [ 'data-rvt-outlet-' . $args['state'] => isset($args['key']) ? $args['key'] : '' ];

          // if ( isset($args['debug']) ) {
          //   $atts['data-rvt-outlet-debug'] = '';
          // }

          $result = cs_tag( $tag, $atts, $initial );
        }
        break;
    }

    return $result;
  }

}
