<?php

class Cornerstone_Colors_Controller extends Cornerstone_Plugin_Component {

  public function setup() {
    $saving = $this->plugin->component( 'Save_Controller' );
    $saving->add_handler('colors', [$this, 'save']);
  }

  public function save($params) {

    if ( ! $this->plugin->component('App_Permissions')->user_can('colors.change') ) {
      throw new Exception( 'Unauthorized' );
    }

    if ( ! isset( $params['data']) ) {
      throw new Exception( 'Attempting to update colors without specifying data.' );
    }

    update_option('cornerstone_color_items', wp_slash( cs_json_encode( $params['data'] ) ) );

    cornerstone_cleanup_generated_styles();

    return [ 'success' => true ];

  }

}
