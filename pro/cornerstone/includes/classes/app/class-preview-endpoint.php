<?php

class Cornerstone_Preview_Endpoint extends Cornerstone_Plugin_Component {

  public function setup() {
    add_action( 'template_redirect', [ $this, 'detect_request' ], 0 );
  }

  public function detect_request() {

    if (!isset($_REQUEST['cs-render'])) {
      return;
    }

    $this->plugin->component('Routing')->handle_errors();

    $this->begin_response();

    if ( ! is_user_logged_in() ) {
      return cs_send_json_error( array(
        'invalid_user' => true,
        'message' => 'No logged in user.'
      ) );
    }

    do_action( 'cs_preview_before_render' );

    try {

      cs_send_json_success(
        $this->plugin->component('Preview_Rendering')->render(
          $this->get_json()
        )
      );

    } catch( Exception $e ) {
      return cs_send_json_error( array(
        'message' => $e->getMessage()
      ) );
    }

    wp_die();

  }

  /**
   * Mark the start of a response. Start output buffering so we can do error
   * detection later, and register the wp_die handler.
   * @return none
   */
  public function begin_response() {

    if ( ! defined( 'DOING_AJAX' ) ) {
      define( 'DOING_AJAX', true );
    }

    do_action( 'cornerstone_before_custom_endpoint' );

    send_origin_headers();
    header( 'X-Robots-Tag: noindex' );
    send_nosniff_header();
    nocache_headers();

    ob_start();

    do_action( 'cornerstone_before_ajax' );

  }

  public function get_json() {

    $data = json_decode($this->get_raw_data(), true);

    if ( ! isset( $data['_nonce'] ) || ! wp_verify_nonce( $data['_nonce'], 'cornerstone_nonce' ) ) {
      throw new Exception( 'nonce verification failed' );
    }

    if ( isset( $data['request'] ) ) {

      if ( isset( $data['gzip'] ) && $data['gzip'] ) {
        return json_decode( gzdecode( base64_decode( $data['request'] ) ), true );
      }

      if ( is_array( $data['request'] ) ) {
        return $data['request'];
      }

    }

    throw new Exception( 'invalid request' );

  }

  public function get_raw_data() {
		// phpcs:disable PHPCompatibility.Variables.RemovedPredefinedGlobalVariables.http_raw_post_dataDeprecatedRemoved
		global $HTTP_RAW_POST_DATA;

		// $HTTP_RAW_POST_DATA was deprecated in PHP 5.6 and removed in PHP 7.0.
		if ( ! isset( $HTTP_RAW_POST_DATA ) ) {
			return file_get_contents( 'php://input' );
		}

		return $HTTP_RAW_POST_DATA;
		// phpcs:enable
  }

}
