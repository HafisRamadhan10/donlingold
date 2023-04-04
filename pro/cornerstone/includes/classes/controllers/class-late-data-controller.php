<?php

class Cornerstone_Late_Data_Controller extends Cornerstone_Plugin_Component {

  public function setup() {
    $routing = $this->plugin->component( 'Routing' );
    $routing->add_route('post', 'late-data', [$this, 'get_late_data']);
  }

  public function get_late_data( $params ) {
    return $this->plugin->component( 'App' )->get_late_data();
  }


}
