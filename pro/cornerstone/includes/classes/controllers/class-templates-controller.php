<?php

class Cornerstone_Templates_Controller extends Cornerstone_Plugin_Component {

  public function setup() {
    $routing = $this->plugin->component( 'Routing' );
    $routing->add_route('get', 'template-all', [$this, 'get_all']);
    $routing->add_route('get', 'template-list', [$this, 'get_list']);
    $routing->add_route('get', 'template-item', [$this, 'get_item']);
    $routing->add_route('post', 'template-item-update', [$this, 'update_item'] );
    $routing->add_route('post', 'template-item-create', [$this, 'create_item']);
    $routing->add_route('post', 'templates-delete', [$this, 'delete_items']);
    $routing->add_route('post', 'templates-export', [$this, 'export_items']);
    $routing->add_route('post', 'templates-export-global-blocks', [$this, 'export_global_blocks']);
    $routing->add_route('post', 'templates-export-locate-image-ids', [$this, 'export_locate_image_ids']);
    $routing->add_route('post', 'templates-import', [$this, 'import_items']);
    $routing->add_route('post', 'templates-prepare-global-blocks', [$this, 'prepare_global_blocks_import']);
    $routing->add_route('post', 'templates-upload-media', [$this, 'upload_media']);
    $routing->add_route('post', 'templates-import-classic', [$this, 'import_classic']); // classic import
    $routing->add_route('post', 'migrate-starter-template', [$this, 'migrate_starter_template']);
    // cs_template_list_$type
    add_filter('cs_template_list_content', [$this, 'add_classic_content_templates']);
  }

  public function get_item( $params ) {
    if (! isset($params['id'])) {
      throw new Exception( 'Invalid params' );
    }

    $template = new Cornerstone_Template( (int) $params['id'] );
    $template->get_meta();
    return $template->serialize();
  }

  public function make_templates_from_posts( $posts ) {

    $list = [];

    foreach ($posts as $post) {

      $template = new Cornerstone_Template( $post );

      if ( 'pro' !== csi18n('app.integration-mode') && in_array( $template->get_type(), array('header', 'footer' ) ) ) {
        continue;
      }

      $list[] = $template->serialize();


    }

    return $list;

  }

  public function get_all() {

    if ( ! $this->plugin->component('App_Permissions')->user_can('templates') ) {
      return [];
    }

    return $this->make_templates_from_posts( get_posts( array(
      'post_type' => array( 'cs_template', 'cs_user_templates' ),
      'post_status' => array( 'tco-data', 'publish' ),
      'orderby' => 'type',
      'posts_per_page' => apply_filters( 'cs_query_limit', 2500 ),
      'cs_all_wpml' => true
    ) ) );

  }

  public function get_list( $params ) {

    if (! isset($params['id'])) {
      throw new Exception( 'Invalid params' );
    }

    $type = $params['id'];

    try {
      $this->permission_check_read( $type );
    } catch (Exception $e) {
      return [];
    }

    return apply_filters( "cs_template_list_$type", $this->make_templates_from_posts(get_posts( array(
      'post_type' => array( 'cs_template' ),
      'post_status' => array( 'tco-data', 'publish' ),
      'orderby' => 'title',
      'order' => 'ASC',
      'posts_per_page' => apply_filters( 'cs_query_limit', 2500 ),
      'meta_key' => '_cs_template_type',
      'meta_value' => $type,
      'cs_all_wpml' => true
    ) ) ) );
  }

  public function create_item($params) {

    if ( ! isset( $params['title'] ) ) {
      throw new Exception( 'Attempting to create template without specifying a title.' );
    }

    if ( ! isset( $params['type'] ) ) {
      throw new Exception( 'Attempting to create template without specifying a type.' );
    }

    $this->permission_check_write($params['type'], 'create');

    $template = new Cornerstone_Template( array(
      'title' => $params['title'],
      'type'  => $params['type'],
    ) );

    if ( isset( $params['subtype'] ) ) {
      $template->set_subtype( $params['subtype'] );
    }

    if ( isset( $params['meta'] ) ) {
      $template->set_meta( $params['meta'] );
    }

    $template->get_meta();
    return $template->save();

    return ['success' => true];
  }

  public function update_item( $params ) {

    if ( ! isset( $params['id'] ) ) {
      throw new Exception( 'Attempting to update Preset without specifying an ID.' );
    }

    $template = new Cornerstone_Template( (int) $params['id'] );

    $this->permission_check_write($params['type'], 'update');

    if ( isset( $params['title'] ) && $this->plugin->component('App_Permissions')->user_can('templates.rename') ) {
      $template->set_title( $params['title'] );
    }

    if ( isset( $params['subtype'] ) ) {
      $template->set_subtype( $params['subtype'] );
    }

    if ( isset( $params['preview'] ) && $this->plugin->component('App_Permissions')->user_can('templates.update_preview_image') ) {
      $template->set_preview( $params['preview'] );
    }

    if ( isset( $params['hidden'] ) && $this->plugin->component('App_Permissions')->user_can('templates.hide') ) {
      $template->set_hidden( $params['hidden'] );
    }

    if ( isset( $params['meta'] ) ) {
      $template->set_meta( $params['meta'] );
    }

    $template->get_meta();
    return $template->save();
  }

  public function permission_check_read( $type ) {

    if ( !in_array($type, ['preset', 'content', 'header', 'footer', 'layout']) ) {
      throw new Exception( 'Invalid template type' );
    }

    if ($type === 'header') {
      if ( ! $this->plugin->component('App_Permissions')->user_can('headers.create_from_template') ) {
       throw new Exception( 'Unauthorized' );
      }
    }


    if ($type === 'footer') {
      if ( ! $this->plugin->component('App_Permissions')->user_can('footers.create_from_template') ) {
       throw new Exception( 'Unauthorized' );
      }
    }

    if ($type === 'layout') {
      if ( ! $this->plugin->component('App_Permissions')->user_can('layouts.create_from_template') ) {
       throw new Exception( 'Unauthorized' );
      }
    }

    if ($type === 'content') {
      if ( ! $this->plugin->component('App_Permissions')->user_can('content') ) {
       throw new Exception( 'Unauthorized' );
      }
    }


    if ( ! $this->plugin->component('App_Permissions')->user_can('footers.create_from_template') ) {
      return [];
    }

    if ('preset' === $type) {
      $post_types = $this->plugin->component('App_Permissions')->get_user_post_types();

      $permissions = array(
        'headers.apply_presets',
        'footers.apply_presets',
        'content.cs_global_block.apply_presets'
      );

      foreach ($post_types as $type) {
        $permissions[] = "content.$type.apply_presets";
      }

      $allowed = false;
      foreach ( $permissions as $permission ) {
        $allowed = $allowed || $this->plugin->component('App_Permissions')->user_can( $permission );
      }

      if ( ! $allowed ) {
        throw new Exception( 'Unauthorized' );
      }
    }

  }

  public function permission_check_write( $type, $mode ) {

    if ( !in_array($type, ['preset', 'content', 'header', 'footer', 'layout']) ) {
      throw new Exception( 'Invalid template type' );
    }

    if ('content' === $type) {
      if ( ! $this->plugin->component('App_Permissions')->user_can('content') ) {
        throw new Exception( 'Unauthorized' );
      }
    }

    if ('header' === $type) {
      if ( ! $this->plugin->component('App_Permissions')->user_can('headers.save_as_template') ) {
        throw new Exception( 'Unauthorized' );
      }
    }

    if ('footer' === $type) {
      if ( ! $this->plugin->component('App_Permissions')->user_can('footers.save_as_template') ) {
        throw new Exception( 'Unauthorized' );
      }
    }

    if ('layout' === $type) {
      if ( ! $this->plugin->component('App_Permissions')->user_can('layouts.save_as_template') ) {
        throw new Exception( 'Unauthorized' );
      }
    }

    if ('preset' === $type) {
      $post_types = $this->plugin->component('App_Permissions')->get_user_post_types();

      $permissions = array(
        'headers.save_presets',
        'footers.save_presets',
        'content.cs_global_block.save_presets'
      );

      foreach ($post_types as $type) {
        $permissions[] = "content.$type.save_presets";
      }

      $allowed = false;
      foreach ( $permissions as $permission ) {
        $allowed = $allowed || $this->plugin->component('App_Permissions')->user_can( $permission );
      }

      if ( ! $allowed ) {
        throw new Exception( 'Unauthorized' );
      }
    }
  }

  public function add_classic_content_templates( $templates ) {

    $classic_templates = $this->make_templates_from_posts( get_posts( array(
      'post_type'      => array( 'cs_user_templates' ),
      'post_status'    => array( 'tco-data', 'publish' ),
      'orderby'        => 'type',
      'posts_per_page' => apply_filters( 'cs_query_limit', 2500 ),
    ) ) );

    return array_merge( $classic_templates, $templates );

  }

  public function delete_items( $params ) {

    if ( ! $this->plugin->component('App_Permissions')->user_can('templates.delete') ) {
      throw new Exception( 'Unauthorized' );
    }

    if (! isset($params['ids'])) {
      throw new Exception( 'Ids to delete missing' );
    }

    foreach ( $params['ids'] as $id ) {
      $template = new Cornerstone_Template( $id );
      $template->delete();
    }

    return array( 'success' => true );
  }

  public function export_items( $data ) {

    if ( ! $this->plugin->component('App_Permissions')->user_can('templates.download') ) {
      throw new Exception( 'Unauthorized' );
    }

    if ( ! isset( $data['ids'] ) ) {
      throw new Exception( 'Ids to export missing.' );
    }

    $templates = array();

    foreach ( $data['ids'] as $id ) {

      $template = new Cornerstone_Template( $id );
      $template->get_meta();
      $serialized = $template->serialize();

      if ( 'preset' === $template->get_type() ) {
        $serialized['meta']['atts'] = is_string( $serialized['meta']['atts'] ) ? json_decode( $serialized['meta']['atts'] ) : $serialized['meta']['atts'];
      }

      $templates[] = $serialized;
    }

    return array(
      'templates' => $templates,
      'success'   => true
    );
  }



  public function export_global_blocks( $data ) {

    if ( ! $this->plugin->component('App_Permissions')->user_can('templates.download') ) {
      throw new Exception( 'Unauthorized' );
    }

    if ( ! isset( $data['ids'] ) ) {
      throw new Exception( 'Ids to export missing.' );
    }

    $global_blocks = array();
    $pending = $data['ids'];
    $completed = array();

    while ( count( $pending ) > 0 ) {

      $id = array_pop($pending);

      $global_block = new Cornerstone_Content( (int) $id );

      if ( 'cs_global_block' !== $global_block->get_post_type() ) {
        throw new Exception( 'Attempting to export non global block.' );
      }

      $serialized = $global_block->serialize();
      $global_blocks[] = $serialized;
      $completed[] = $id;

      $more_ids = $this->find_more_global_blocks( $serialized['elements']['data'] );

      foreach ($more_ids as $another_id) {
        if ( ! in_array( $another_id, $completed ) ) {
          array_push($pending, $another_id);
        }
      }

    }

    return array(
      'globalBlocks' => $global_blocks,
      'success'      => true
    );

  }

  public function export_locate_image_ids( $data ) {

    if ( ! $this->plugin->component('App_Permissions')->user_can('templates.download') ) {
      throw new Exception( 'Unauthorized' );
    }

    if ( ! isset( $data['hashMap'] ) ) {
      throw new Exception( 'Ids to locate missing.' );
    }

    foreach ( $data['hashMap'] as $hash => $source) {
      $img_atts = cs_apply_image_atts( [ 'src' => $source, 'size' => null ]);
      $resolved[$hash] = isset( $img_atts['src'] ) && $img_atts['src'] ? $img_atts['src'] : null;
    }

    return array(
      'resolved' => $resolved,
      'success'  => true
    );

  }

  protected function find_more_global_blocks( $elements ) {

    $more = array();

    foreach( $elements as $element ) {

      if ( ! isset( $element['_type'] ) ) {
        continue;
      }

      if ( isset( $element['_modules'] ) ) {
        $more = array_merge($more, $this->find_more_global_blocks( $element['_modules']) );
      }

      if ( 'global-block' === $element['_type'] && isset( $element['global_block_id']) ) {
        array_push($more, $element['global_block_id']);
      }

    }

    return array_unique( $more );

  }

  public function import_classic( $params ) {

    $this->permission_check_write('content', 'create');

    if ( !isset( $params['elements'] ) ) {
      throw new Exception( 'Elements missing' );
    }

    if ( !isset( $params['title'] ) ) {
      throw new Exception( 'Title missing' );
    }

		$migrated = $this->plugin->component('Element_Migrations')->migrate( $params['elements'] );

		if ( is_wp_error( $migrated ) ) {
      throw new Exception( $migrated->get_error_message() );
    }

    $template = new Cornerstone_Template( array(
      'title' => $params['title'],
      'type'  => 'content',
    ) );

    $template->set_meta( [ 'elements' => $migrated ] );

    return $template->save();

  }

  public function upload_media( $data ) {

    if ( ! $this->plugin->component('App_Permissions')->user_can('templates.import') ) {
      throw new Exception( 'Unauthorized' );
    }

    if ( ! isset( $data['files'] ) ) {
      throw new Exception( 'File reference missing.' );
    }

    $file_id = $data['files'][0]['key'];

    global $wpdb;
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_cs_attachment_tmpl_id' AND meta_value = %s", $file_id ) );

    if ( $results ) {
      $post_id = $results[0]->post_id;
    } else {

      //Fix media import issue due to other 3rd party plugins that uses wp_handle_upload_prefilter
      global $wp_filter;
      unset($wp_filter['wp_handle_upload_prefilter']);

      require_once( ABSPATH . 'wp-admin/includes/image.php' );
	    require_once( ABSPATH . 'wp-admin/includes/file.php' );
	    require_once( ABSPATH . 'wp-admin/includes/media.php' );

      $post_id = media_handle_upload( '_files_' . $data['files'][0]['value'], 0 );

      if ( is_wp_error( $post_id ) ) {
        return $post_id;
      }

      update_post_meta( $post_id, '_cs_attachment_tmpl_id', $file_id );

    }

    return array(
      'attachment_id' => $post_id,
      'url' => wp_get_attachment_url( $post_id )
    );

  }

  public function import_items( $data ) {

    if ( ! $this->plugin->component('App_Permissions')->user_can('templates.import') ) {
      throw new Exception( 'Unauthorized' );
    }

    if ( ! isset( $data['packageSignature'] ) ) {
      throw new Exception( 'Package signature missing.' );
    }

    if ( ! isset( $data['files'] ) || ! $this->validate_import_files( $data['files'] ) ) {
      throw new Exception( 'Files failed validation.' );
    }

    $response = [ 'done' => true, 'templates' => [] ];

    foreach ($data['files'] as $file) {

      if ( 'template' === $file['type'] ) {
        $template_data = $file['data'];
        $template_data['package_signature'] = $data['packageSignature'];
        $template = new Cornerstone_Template( $template_data );
        if ( isset( $data['saveToLibrary'] ) && $data['saveToLibrary'] ) {
          $template->save();
        } else {
          $response['templates'][] = $template->serialize();
        }

      }

      if ( 'global-block' === $file['type'] ) {
        $global_block = new Cornerstone_Content( (int) $file['data']['id'] );
        $global_block->set_elements( $file['data']['elements'] );

        $global_block->set_settings( $file['data']['settings'] );
        $global_block->save();
      }

    }

    return $response;

  }

  public function migrate_starter_template( $data ) {

    if ( ! $this->plugin->component('App_Permissions')->user_can('templates') ) {
      throw new Exception( 'Unauthorized' );
    }

    if ( ! isset( $data['regions'] ) ) {
      throw new Exception( 'No regions set' );
    }

    $regions = [];
    foreach ($data['regions'] as $region => $elements) {
      $regions[$region] = CS()->component('Element_Migrations')->migrate( $elements );
    }

    return [
      'regions' => $regions
    ];

  }

  protected function validate_import_files( $files ) {

    foreach ($files as $file) {

      if ( ! isset( $file['type'] ) ) {
        return false;
      }

    }

    return true;

  }

  public function prepare_global_blocks_import( $data ) {

    if ( ! $this->plugin->component('App_Permissions')->user_can('templates.import') ) {
      throw new Exception( 'Unauthorized' );
    }

    $global_blocks = array();

    if ( ! isset( $data['globalBlockRequests'] ) ) {
      throw new Exception( 'No global blocks' );
    }

    foreach ($data['globalBlockRequests'] as $global_block_request) {

      $global_block = new Cornerstone_Content( array(
        'post_type'   => 'cs_global_block',
        'post_status' => 'tco-data',
        'title'       => $global_block_request['title']
      ));

      $global_block->save();

      $global_blocks[$global_block_request['id']] = $global_block->get_id();

    }

    return array(
      'globalBlockIDs' => $global_blocks,
      'success'        => true
    );

  }

}
