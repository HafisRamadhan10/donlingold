<?php

class Cornerstone_Fonts_Controller extends Cornerstone_Plugin_Component {

  public function setup() {
    $saving = $this->plugin->component( 'Save_Controller' );
    $saving->add_handler('fontItems', [$this, 'save_items']);
    $saving->add_handler('fontConfig', [$this, 'save_config']);
  }

  public function save( $option, $params ) {

    if ( ! $this->plugin->component('App_Permissions')->user_can('fonts.change') ) {
      throw new Exception( 'Unauthorized' );
    }

    if ( ! isset( $params['data']) ) {
      throw new Exception( 'Attempting to update fonts without specifying data.' );
    }

    update_option($option, wp_slash( cs_json_encode( $params['data'] ) ) );

    cornerstone_cleanup_generated_styles();
    
    return [ 'success' => true ];

  }

  public function save_items( $params ) {
    return $this->save( 'cornerstone_font_items', $params );
  }

  public function save_config( $params ) {
    return $this->save( 'cornerstone_font_config', $params );
  }

}
