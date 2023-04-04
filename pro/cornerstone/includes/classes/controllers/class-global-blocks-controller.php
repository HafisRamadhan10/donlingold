<?php

class Cornerstone_Global_Blocks_Controller extends Cornerstone_Plugin_Component {

  public function setup() {
    $routing = $this->plugin->component( 'Routing' );
    $routing->add_route('get', 'global-block', [$this, 'read']);
    $routing->add_route('post', 'global-block-create', [$this, 'create']);
    $routing->add_route('post', 'global-block-update', [$this, 'update']);
    $routing->add_route('post', 'global-block-delete', [$this, 'delete']);

    $saving = $this->plugin->component( 'Save_Controller' );
    $saving->add_builder_handler('global-block', [$this, 'update']);
  }

  public function read($params) {

    $post_id = isset($params['id']) ? (int) $params['id'] : null;

    if (!$post_id) {
      throw new Exception( 'Not found' );
    }

    if ( ! $this->plugin->component('App_Permissions')->user_can('content.cs_global_block') ) {
      throw new Exception( 'Unauthorized' );
    }

    $content = new Cornerstone_Content( $post_id );
    return $content->serialize();

  }

  public function create($params) {

    if ( ! $this->plugin->component('App_Permissions')->user_can('content.cs_global_block.create') ) {
      throw new Exception( 'Unauthorized' );
    }

    $atts = [
      'post_type' => 'cs_global_block',
      'post_status' => 'tco-data',
    ];

    if ( isset( $params['lang'] ) ) {
      $this->plugin->component('Wpml')->switch_lang( $params['lang'] );
    }

    if ( isset( $params['clone'] )) {
      $copy_from = new Cornerstone_Content( (int) $params['clone'] );
      $atts['elements'] = $copy_from->get_elements();
      $atts['settings'] = $copy_from->get_settings();
    }

    $record = new Cornerstone_Content( $atts );

    if (isset( $params['title'] ) ) {
      $record->set_title( $params['title'] );
    }

    $result = $record->save();

    if ( isset( $params['lang'] ) ) {
      $this->plugin->component('Wpml')->switch_back();
    }

    return $result;

  }

  public function delete($params) {

    if ( ! $this->plugin->component('App_Permissions')->user_can('content.cs_global_block.delete') ) {
      throw new Exception( 'Unauthorized' );
    }

    if ( ! isset($params['id']) || ! $params['id'] ) {
      throw new Exception( 'Attempting to delete Global Block without specifying an ID.' );
    }

    $content = new Cornerstone_Content( (int) $params['id'] );
    return $content->delete();
  }

  public function update($params) {

    if ( ! $this->plugin->component('App_Permissions')->user_can('content.cs_global_block') ) {
      throw new Exception( 'Unauthorized' );
    }

    if ( ! isset($params['id']) || ! $params['id'] ) {
      throw new Exception( 'Attempting to update Global Block without specifying an ID.' );
    }

    $id = (int) $params['id'];

    $content = new Cornerstone_Content( $id );

    if ( isset( $params['title'] ) && $this->plugin->component('App_Permissions')->user_can('content.cs_global_block.rename') ) {
      $content->set_title( $params['title'] );
    }

    if ( isset( $params['elements'] ) ) {
      $content->set_elements( $params['elements'] );
    }

    if ( isset( $params['settings'] ) ) {
      $content->set_settings( $params['settings'] );
    }

    return $content->save();

  }

}
