<?php

class Cornerstone_Theme_Options_Controller extends Cornerstone_Plugin_Component {

  public function setup() {
    $saving = $this->plugin->component( 'Save_Controller' );
    $saving->add_handler('themeOptions', [$this, 'save']);
  }

  public function save($params) {

    $options = $this->plugin->component( 'Theme_Options' );
    $permissions = $this->plugin->component( 'App_Permissions' );

    if ( ! ( current_user_can( 'manage_options' ) || $permissions->user_can('theme_options') ) ) {
      throw new Exception( 'Unauthorized' );
    }

    if ( ! isset( $params['data']) || ! $params['data'] ) {
      throw new Exception( 'Attempting to update Theme Options without specifying data.' );
    }

    do_action('cs_theme_options_before_save');

    foreach ($params['data'] as $key => $value) {
      $options->update_value( $key, $value );
    }

    do_action('cs_theme_options_after_save');

    cornerstone_cleanup_generated_styles();
    
    return [ 'success' => true ];

  }

}
