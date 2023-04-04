<?php

class Cornerstone_Controller_Media extends Cornerstone_Plugin_Component {

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

      $post_id = media_handle_upload( '_files_' . $data['files'][0]['index'], 0 );

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

}
