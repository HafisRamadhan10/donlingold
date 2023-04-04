<?php
class Cornerstone_Index_Controller extends Cornerstone_Plugin_Component {

  public function setup() {

    $routing = $this->plugin->component( 'Routing' );
    $routing->add_route('get', 'index-global-blocks', [$this, 'get_global_blocks']);
    $routing->add_route('get', 'index-content', [$this, 'get_content']);
    $routing->add_route('get', 'index-headers', [$this, 'get_headers']);
    $routing->add_route('get', 'index-footers', [$this, 'get_footers']);
    $routing->add_route('get', 'index-layouts', [$this, 'get_layouts']);

  }

  public function get_content( $data ) {

    if ( ! $this->plugin->component('App_Permissions')->user_can('content') ) {
      return [];
    }

    return $this->plugin->component('Locator')->query_posts( array_merge( $data, [
      'post_types'  => $this->plugin->component('App_Permissions')->get_user_post_types(),
      'post_status' => 'any'
    ] ));

  }

  public function get_global_blocks( $data ) {

    if ( ! $this->plugin->component('App_Permissions')->user_can('content.cs_global_block') ) {
      return [];
    }

    return $this->plugin->component('Locator')->query_posts( array_merge( $data, [
      'post_types'  => ['cs_global_block'],
      'post_status' => 'tco-data'
    ] ));
  }

  public function get_headers( $data ) {

    if ( ! $this->plugin->component('App_Permissions')->user_can('headers') ) {
      return [];
    }

    return $this->plugin->component('Locator')->query_posts( array_merge( $data, [
      'post_types'  => ['cs_header'],
      'post_status' => 'tco-data'
    ] ));

  }

  public function get_footers( $data ) {

    if ( ! $this->plugin->component('App_Permissions')->user_can('footers') ) {
      return [];
    }

    return $this->plugin->component('Locator')->query_posts( array_merge( $data, [
      'post_types'  => ['cs_footer'],
      'post_status' => 'tco-data'
    ] ));

  }

  public function get_layouts( $data ) {

    if ( ! $this->plugin->component('App_Permissions')->user_can('layouts') ) {
      return [];
    }

    return $this->plugin->component('Locator')->query_posts( array_merge( $data, [
      'post_types'  => ['cs_layout'],
      'post_status' => 'tco-data'
    ] ));

  }
}
