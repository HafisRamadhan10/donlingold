<?php

class Cornerstone_Locator_Controller extends Cornerstone_Plugin_Component {

  public function setup() {
    $routing = $this->plugin->component( 'Routing' );
    $routing->add_route('get', 'locator', [$this, 'query']);
    $routing->add_route('get', 'locate-attachment', [$this, 'attachment']);
  }

  public function query($data) {
    return $this->plugin->component( 'Locator' )->query($data);
  }

  public function attachment($data) {
    if ( isset( $data['attachment'] ) ) {
      $parts = explode(':', $data['attachment']);
      return cs_apply_image_atts( [ 'src' => $parts[0] ] );
    }

    return [ 'url' => '' ];

  }

}
