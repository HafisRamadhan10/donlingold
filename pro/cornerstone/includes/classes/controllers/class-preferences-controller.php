<?php

class Cornerstone_Preferences_Controller extends Cornerstone_Plugin_Component {

  public function setup() {
    $routing = $this->plugin->component( 'Routing' );
    $saving = $this->plugin->component( 'Save_Controller' );
    $saving->add_handler('preferences', [$this, 'save']);
  }

  public function save($params) {

    if ( ! isset( $params['user_id']) || ! $params['user_id'] ) {
      throw new Exception( 'Attempting to save preferences without specifying user_id.' );
    }

    if ( ! $params['user_id'] === get_current_user_id() && ! current_user_can('manage_options') ) {
      throw new Exception( 'Unauthorized attempt to save preferences of another user' );
    }

    if ( ! isset( $params['data']) || ! $params['data'] ) {
      throw new Exception( 'Attempting to update preferences without specifying data.' );
    }

    $this->plugin->component('App_Preferences')->update_user_preferences( $params['user_id'], $params['data'] );

    return [ 'success' => true ];

  }

}
