<?php


class Cornerstone_Content_Controller extends Cornerstone_Plugin_Component {

  public function setup() {
    $routing = $this->plugin->component( 'Routing' );
    $routing->add_route('get', 'content', [$this, 'item']);
    $routing->add_route('post', 'content-create', [$this, 'create']);

    $routing->add_route('post', 'content-update', [$this, 'update']);

    $saving = $this->plugin->component( 'Save_Controller' );
    $saving->add_builder_handler('content', [$this, 'update']);

  }

  public function item($params) {

    $post_id = isset($params['id']) ? (int) $params['id'] : null;

    if (!$post_id) {
      throw new Exception( 'Not found');
    }

    if (in_array( $post_id, cs_get_disallowed_ids(), true )) {
      throw new Exception( 'Disallowed post');
    }

    $post = get_post( $post_id );

    $post_type_obj = get_post_type_object( $post->post_type );
    $caps = (array) $post_type_obj->cap;

    if (! current_user_can( $caps['edit_post'], $post->ID ) || ! $this->plugin->component('App_Permissions')->user_can_access_post_type($post->post_type) ) {
      throw new Exception( 'Unauthorized: '  . (current_user_can( $caps['edit_post'], $post->ID ) ? 'true' : 'false'));
    }

    $content = new Cornerstone_Content( $post );

    return $content->serialize();

  }

  public function create($params) {

    $post_type_obj = get_post_type_object( $params['postType'] );

    if ( ! current_user_can( $post_type_obj->cap->edit_posts ) ) {
      throw new Exception( 'Unauthorized' . json_encode($atts) );
    }

    if ( isset( $params['lang'] ) ) {
      $this->plugin->component('Wpml')->switch_lang( $params['lang'] );
    }

    $atts = [
      'title' => $params['title'],
      'post_type' => $params['postType'],
      'post_status' => $params['status'],
    ];

    if (isset($params['slug']) && $params['slug']) {
      $atts['post_name'] = $params['slug'];
    }

    if (isset($params['pageTemplate']) && $params['pageTemplate']) {
      $atts['page_template'] = $params['pageTemplate'];
    }

    if ( isset( $params['clone'] )) {
      $copy_from = new Cornerstone_Content( (int) $params['clone'] );
      $atts['elements'] = $copy_from->get_elements();
      $atts['settings'] = $copy_from->get_settings();
    }

    if ( isset( $params['elements'] )) {
      $atts['elements'] = $params['elements'];
    }

    $record = new Cornerstone_Content( $atts );

    if (isset($params['pageTemplate']) && $params['pageTemplate']) {
      $record->set_settings([ 'general_page_template' => $params['pageTemplate'] ] );
    }

    $result = $record->save();

    if ( isset( $params['lang'] ) ) {
      $this->plugin->component('Wpml')->switch_back();
    }

    return $result;

  }

  public function update($params) {

    if ( ! isset( $params['id']) || ! $params['id'] ) {
      throw new Exception( 'Attempting to update Content without specifying an ID.' );
    }

    $post = get_post( (int) $params['id'] );

    if ( ! $this->plugin->component('App_Permissions')->user_can_access_post_type($post->post_type) ) {
      throw new Exception( 'Unauthorized');
    }

    $content = new Cornerstone_Content( $post );

    if ( isset( $params['title'] ) ) {
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
