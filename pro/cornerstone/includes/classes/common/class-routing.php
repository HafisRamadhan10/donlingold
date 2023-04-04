<?php

class Cornerstone_Routing extends Cornerstone_Plugin_Component {

  public function setup() {
    add_action( 'rest_api_init', [ $this, 'register' ]);
    add_action( 'wp_ajax_cs_nonce', [ $this, 'make_nonce' ] );
    add_action( 'wp_ajax_nopriv_cs_nonce', [ $this, 'make_nonce' ] );
  }

  public function register() {
    $params = [
      'callback' => [$this, 'data'],
      'methods' => ['GET', 'POST'],
      'permission_callback' => 'is_user_logged_in'
    ];

    register_rest_route( 'themeco', 'data/(?P<path>[a-zA-Z0-9-_]+)/(?P<id>[a-zA-Z0-9-_]+)', $params );
    register_rest_route( 'themeco', 'data/(?P<path>[a-zA-Z0-9-_]+)', $params );
  }

  public function handle_errors() {
    if ( defined('WP_DEBUG') && WP_DEBUG ) {
      add_filter('wp_php_error_message', [$this, 'append_error_data'], 10, 2 );
    }
  }

  public function process_params( $params ) {

    $gzip = isset( $params['gzip'] ) && $params['gzip'];
    $result = [];

    if ( isset( $params['request'] ) ) {
      if ( $gzip ) {
        $result = json_decode( gzdecode( base64_decode( $params['request'], true ) ), true );
      } else if ( is_array( $params['request'] ) ) {
        $result = $params['request'];
      }
    }

    unset( $params['gzip'] );
    unset( $params['request'] );

    return array_merge( $params, $result );
  }

  public function data($request) {

    $this->handle_errors();

    $path = $request->get_param('path');
    $no_gzip = $request->get_param('gzip') === '0';

    $data = null;


    $this->plugin->loadComponents('controllers');

    ob_start();
    do_action( 'tco_routes', $this );
    do_action( 'cornerstone_before_custom_endpoint' );
    $extraneous = ob_get_clean();

    send_origin_headers();
    header( 'X-Robots-Tag: noindex' );
    send_nosniff_header();
    nocache_headers();

    try {
      $method = strtolower($_SERVER['REQUEST_METHOD']);
      ob_start();
      $data = apply_filters( "tco_routing_$method/$path", null, $this->process_params( $request->get_params() ) );
      $extraneous .= ob_get_clean();
    } catch (Exception $e) {
      $data = new WP_Error( 'tco-routing', $e->getMessage() );
    }

    if (is_null($data)) {
      $data = new WP_Error( 'tco-routing', "No response for path: $path" );
    }

    $response = [];

    if ($extraneous) {
      $response['extraneous'] = $extraneous;
    }

    if (is_wp_error($data)) {
      $response['error'] = $data->get_error_message();
    } else {
      if ($no_gzip || !$this->gzip()) {
        $response['gzip'] = false;
        $response['data'] = $data;
      } else {
        $response['data'] = base64_encode( gzcompress( json_encode( $data ) ) );
      }
    }

    return $response;

  }

  public function make_nonce() {
    echo wp_create_nonce( 'wp_rest' );
    die;
  }

  public function fetch_config() {
    return [
      'rootUrl' => esc_url_raw( rest_url() ),
      'nonce' => wp_create_nonce('wp_rest'),
      'nonceUrl' => esc_url_raw(add_query_arg(
        [ 'action' => 'cs_nonce'],
        admin_url('admin-ajax.php')
      ) )
    ];
  }

  public function add_route($method, $path, $callback) {
    add_filter("tco_routing_$method/$path", function( $result, $params ) use ($callback) {
      return call_user_func_array($callback, [$params]);
    }, 10, 2);
  }

  public function gzip() {
    return ( ! defined('CS_DISABLE_GZIP') || ! CS_DISABLE_GZIP ) && function_exists('gzcompress') && function_exists('gzdecode');
  }

  public function append_error_data( $message, $error ) {
    $type = $this->lookup_error_type( $error['type'] );
    return $type . ': ' . $error['message'] . ' in ' . $error['file'] . ' on line ' . $error['line'] . '. ' . $message;
  }

  public function lookup_error_type( $type ) {

    switch ( $type ) {
      case E_ERROR:
        return 'E_ERROR';
      case E_WARNING:
        return 'E_WARNING';
      case E_PARSE:
        return 'E_PARSE';
      case E_NOTICE:
        return 'E_NOTICE';
      case E_CORE_ERROR:
        return 'E_CORE_ERROR';
      case E_CORE_WARNING:
        return 'E_CORE_WARNING';
      case E_COMPILE_ERROR:
        return 'E_COMPILE_ERROR';
      case E_COMPILE_WARNING:
        return 'E_COMPILE_WARNING';
      case E_USER_ERROR:
        return 'E_USER_ERROR';
      case E_USER_WARNING:
        return 'E_USER_WARNING';
      case E_USER_NOTICE:
        return 'E_USER_NOTICE';
      case E_STRICT:
        return 'E_STRICT';
      case E_RECOVERABLE_ERROR:
        return 'E_RECOVERABLE_ERROR';
      case E_DEPRECATED:
        return 'E_DEPRECATED';
      case E_USER_DEPRECATED:
        return 'E_USER_DEPRECATED';
    }

    return '';

  }
}
