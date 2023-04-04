<?php

class Cornerstone_Template_Manager extends Cornerstone_Plugin_Component {

  protected $templates = array();
  protected $deleted;
  protected $hidden;

  public function setup() {

    register_post_type( 'cs_template', array(
      'public'              => false,
      'exclude_from_search' => false,
      'capability_type'     => 'page',
      'supports'            => false
    ) );

    // Classic Cornerstone templates
    register_post_type( 'cs_user_templates', array(
			'public'          => false,
			'capability_type' => 'page',
			'supports'        => false
    ));

    add_action('tco_routes', [$this, 'setup_routes']);
  }

  public function setup_routes() {
    $routing = $this->plugin->component( 'Routing' );
    $routing->add_route('get', 'templates-default-presets', [$this, 'get_default_presets']);
    $routing->add_route('post', 'templates-default-presets-update', [$this, 'update_default_presets']);
  }

  public function lookup_default_presets() {
    global $wpdb;
    $results = $wpdb->get_results( "SELECT pm1.post_id AS id, pm2.meta_value as preset_type FROM $wpdb->postmeta AS pm1 INNER JOIN $wpdb->postmeta AS pm2 ON pm1.post_id = pm2.post_id WHERE pm1.meta_key = '_cs_preset_is_default' AND pm2.meta_key = '_cs_template_subtype_preset'" );
    $default_presets = array();

    foreach ($results as $result) {
      $default_presets[$result->preset_type] = "$result->id";
    }

    return $default_presets;
  }

  public function get_default_presets() {

    $default_presets = $this->lookup_default_presets();
    $presets = array();

    foreach ($default_presets as $type => $id) {
      $presets[] = array(
        'id'   => $id,
        'type' => $type
      );
    }

    return array(
      'defaultPresets' => $presets,
      'success' => true
    );
  }

  public function update_default_presets( $data ) {

    if ( ! $this->plugin->component('App_Permissions')->user_can('templates.manage_default_presets') ) {
      return new WP_Error( 'cornerstone', 'Unauthorized' );
    }

    if ( ! isset( $data['defaultPresets'] ) ) {
      return new WP_Error( 'cornerstone', 'No data' );
    }

    $current = $this->lookup_default_presets();

    $clear = array();
    $update = array();

    foreach ( $data['defaultPresets'] as $key => $id ) {

      if ( ( ! isset( $current[$key] ) && "none" === $id ) || ( isset( $current[$key] ) && $id === $current[$key] ) ) {
        continue;
      }

      $clear[] = $key;

      if ( "none" !== $id ) {
        $update[] = $id;
      }

    }

    $clear = array_map('esc_sql', $clear);
    $clear = implode('", "', $clear );

    global $wpdb;
    $to_delete = $wpdb->get_results( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = \"_cs_template_subtype_preset\" and meta_value IN ( \"$clear\" )" );
    $delete_ids = array();

    foreach ($to_delete as $record) {
      $delete_ids[] = esc_sql( $record->post_id );
    }

    $delete_ids = implode('", "', $delete_ids );

    $wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key = \"_cs_preset_is_default\" AND post_id IN ( \"$delete_ids\" )" );

    foreach ( $update as $id ) {
      update_post_meta( $id, '_cs_preset_is_default', true );
    }

    return array(
      'success' => true
    );

  }

}
