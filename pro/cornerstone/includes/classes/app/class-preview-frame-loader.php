<?php

class Cornerstone_Preview_Frame_Loader extends Cornerstone_Plugin_Component {

  protected $state = false;
  protected $zones = array();
  protected $frame = null;
  protected $timestamp = null;
  protected $prefilter_option_updates = array();
  protected $filter_cs_settings = array();
  protected $prefilter_meta_updates = array();
  protected $content_cache;
  protected $overlays = array();

  public function setup() {

    if ( ! isset( $_POST['cs_preview_state'] ) || ! $_POST['cs_preview_state'] || ! isset( $_POST['cs_preview_time'] )) {
      return;
    }

    // Nonce verification
    if ( ! isset( $_POST['_cs_nonce'] ) || ! wp_verify_nonce( $_POST['_cs_nonce'], 'cornerstone_nonce' ) ) {
      echo -1;
      die();
    }

    $this->timestamp = $_POST['cs_preview_time'];
    $this->state = $this->get_request_state();

    do_action('cs_before_preview_frame', $this->state);

    if ( isset( $this->state['type'] ) ) {
      do_action('cs_before_preview_frame_' . $this->state['type']);
      if ( strpos( $this->state['type'], 'layout') === 0 ) {
        do_action('cs_before_preview_frame_layout');
      }
    }

    add_filter( 'show_admin_bar', '__return_false' );
    add_action( 'template_redirect', array( $this, 'load' ), 0 );
    add_action( 'template_redirect', [$this, 'setup_context'], 9999999 );
    add_action( 'cs_late_template_redirect', array( $this, 'load_late' ), 10000 );
    add_action( 'shutdown', array( $this, 'frame_signature' ), 1000 );
    add_filter( 'wp_die_handler', array( $this, 'remove_preview_signature' ) );

    if ( isset( $this->state['themeOptions'] ) && $this->state['themeOptions'] ) {
      $this->setup_options();
    }

    add_filter( 'cs_preload_font_config', [ $this, 'preload_font_config' ] );
    add_filter( 'cs_preload_font_items', [ $this, 'preload_font_items' ] );

    add_filter('cs_register_entity_styles', function($register, $id, $priority ) {
      if (isset($this->state['entityId']) && (int) $id === (int) $this->state['entityId']) {
        CS()->novus()->service('Styling')->addStyles( "$id-generated", '', $priority);
        CS()->novus()->service('Styling')->addStyles( "$id-element-css", '', $priority + 1);
        return false;
      }
      return $register;
    }, 10, 3 );
  }

  public function get_preview_zones( $regions = [] ) {

    $zones = apply_filters('cs_preview_zones', ['x_before_site_end', 'x_after_site_end', 'cs_deferred' ] );

    if ( in_array( 'content', $regions, true ) ) {
      $zones[] = 'cs_content';
    }

    if ( in_array( 'layout', $regions, true ) ) {
      $zones[] = 'cs_layout';
    }

    if ( in_array( 'footer', $regions, true ) ) {
      $zones[] = 'cs_colophon';
    }

    if ( in_array( 'top', $regions, true ) ) {
      $zones[] = 'cs_masthead';
    }

    if ( in_array( 'left', $regions, true ) || in_array( 'right', $regions, true ) ) {
      $zones[] = 'x_before_site_begin';
    }

    return $zones;
  }

  public function setup_context() {

    if ( in_array( $this->state['type'], array( 'content', 'global-block' ) ) ) {
      $this->setup_content();
    }

  }

  public function get_entity_id() {
    return $this->state['entityId'];
  }

  public function get_request_state() {

    $defaults = array(
      'type'              => null,
      'regions'           => array(),
      'themeOptions'      => false,
      'fontData'          => array(),
      'optionsData'       => array(),
      'settingKeys'       => array(),
      'permissionContext' => '',
      'url'               => home_url(),
      'initialRender'     => false,
      'flags'             => array(),
      'elements'          => array(),
    );

    $decoded = base64_decode( $_POST['cs_preview_state'] );
    $json = ( isset( $_POST['cs_preview_gzip'] ) && $_POST['cs_preview_gzip'] ) ? gzdecode( $decoded ) : $decoded;
    $decoded = json_decode( $json, true );

    if (is_null($decoded)) {
      $error = "Failed to decode preview state";
      trigger_error( $error, E_USER_WARNING );
      $decoded = array( 'error' => $error);
    }

    $decoded['url'] = trailingslashit( $decoded['url'] );

    return array_merge( $defaults, $decoded );
  }

  public function load() {

    nocache_headers();
    $this->queried_object = $this->detect_queried_object();

    add_action( 'wp_footer', [ $this, 'output_initial_render'], 2000 );

    $this->zones = $this->get_preview_zones( $this->state['regions'] );

    foreach ( $this->zones as $zone ) {
      add_action( $zone, array( $this, 'zone_output' ) );
    }

    add_filter( 'body_class', array( $this, 'body_class' ) );
    add_filter( "get_post_metadata", array( $this, 'prefilter_meta_handler' ), 10, 4 );
    add_filter( 'cs_get_serialized_post_meta', array( $this, 'filter_cs_settings_handler' ), 10, 3);
    add_filter( 'cs_regions_settings', array( $this, 'filter_region_settings' ), 10, 3 );

    $preferences = $this->plugin->component('App_Preferences')->get_user_preferences();

    if ($preferences['dev_toolkit']) {
      add_action( 'wp_head', array( $this, 'react_dev_tools' ), 0 );
    }

    $this->frame = null;

    add_filter('cs_match_' . $this->state['type'] . '_assignment', [ $this, 'get_entity_id'] );

    if ( isset( $state['custom_js'] ) ) {

      $inline_scripts = $this->plugin->component('Inline_Scripts');

      foreach ($state['custom_js'] as $id => $content) {
        if ( $content ) {
          $inline_scripts->add_script_safely($id, $content);
        }
      }

    }

    add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
    add_filter( 'post_class', array( $this, 'observe_post_classes' ), 10, 3 );
    add_action( 'wp_footer', array( $this, 'output_observed_overlays' ), 10000 );
    do_action( 'cs_preview_frame_load' );
  }

  public function load_late() {
    add_filter( 'x_masthead_atts',       array( $this, 'nav_overlay_header' ) );
    add_filter( 'x_colophon_atts',       array( $this, 'nav_overlay_footer' ) );
    add_filter( 'cs_masthead_atts',      array( $this, 'nav_overlay_header' ) );
    add_filter( 'cs_colophon_atts',      array( $this, 'nav_overlay_footer' ) );
    add_filter( 'cs_content_atts',      array( $this, 'nav_overlay_content' ), 10, 3 );
    add_filter( 'cs_global_block_atts', array( $this, 'nav_overlay_global_block' ), 10, 2 );
  }

  public function zone_output() {
    echo '<div data-cs-zone="' . current_action() . '"></div>';
  }

  public function get_state() {
    return $this->state;
  }


  public function setup_options() {

    do_action('cs_options_preview_setup');

    if ( is_array( $this->state['optionsData'] ) ) {
      $this->prefilter_options( $this->state['optionsData'] );
    }

  }

  public function preload_font_config( $result ) {
    if ( isset( $this->state['fontsData'] ) && isset( $this->state['fontsData']['config'] ) ) {
      return $this->state['fontsData']['config'];
    }
    return $result;
  }

  public function preload_font_items( $result ) {
    if ( isset( $this->state['fontsData'] ) && isset( $this->state['fontsData']['items'] ) ) {
      return $this->state['fontsData']['items'];
    }
    return $result;
  }

  // available as window.csAppData.preview
  public function data() {

    return apply_filters( 'cs_preview_frame_config', [
      'themeOptions'           => $this->state['themeOptions'],
      'regions'                => $this->state['regions'],
      'type'                   => $this->state['type'],
      'settingKeys'            => $this->state['settingKeys'],
      'entityId'               => isset($this->state['entityId']) ? $this->state['entityId'] : null,
      'timestamp'              => $this->timestamp,
      'queriedObject'          => $this->queried_object,
      'permissionContext'      => $this->state['permissionContext'],
      'url'                    => $this->state['url']
    ] );

  }

  public function detect_queried_object() {

    $object = get_queried_object();

    if ( is_a( $object, 'WP_Term' ) ) {
      return [
        'type'       => 'term',
        'termId'     => (int) $object->term_id,
        'taxonomyId' => (int) $object->term_taxonomy_id
      ];
    }

    if ( is_a( $object, 'WP_Post' ) ) {
      return [
        'type'   => 'post',
        'postId' => (int) $object->ID
      ];
    }

    if ( is_a( $object, 'WP_Post_Type' ) ) {
      return [
        'type' => 'postType',
        'name' => $object->name
      ];
    }

    if ( is_a( $object, 'WP_User' ) ) {
      return [
        'type' => 'user',
        'id' => (int) $object->ID
      ];
    }

    return null;

  }

  public function frame_signature() {
    echo 'CORNERSTONE_FRAME';
  }

  public function remove_preview_signature( $return = null ) {
    remove_action( 'shutdown', array( $this, 'frame_signature' ), 1000 );
    return $return;
  }

  public function enqueue() {

    $this->plugin->component( 'App' )->register_app_scripts( $this->plugin->settings(), true );
    wp_enqueue_script( 'mediaelement' );

    add_filter( 'user_can_richedit', '__return_true' );

    ob_start();
    wp_editor( '%%PLACEHOLDER%%','cspreviewwpeditor', array(
      'quicktags' => false,
      'tinymce'=> array(
        'toolbar1' => 'bold,italic,strikethrough,underline,bullist,numlist,forecolor,cs_media,wp_adv',
        'toolbar2' => 'link,unlink,alignleft,aligncenter,alignright,alignjustify,outdent,indent',
        'toolbar3' => 'formatselect,pastetext,removeformat,charmap,undo,redo'
      ),
      'media_buttons' => false,
      'editor_class'  => 'cs-preview-wp-editor',
      'drag_drop_upload' => true
    ) );
    ob_clean();

    wp_enqueue_script( 'cs-app' );

    $preview_style_asset = $this->plugin->css( 'app/preview' );
    wp_register_style( 'cs-dashicons', '/wp-includes/css/dashicons.min.css' );
    wp_register_style( 'cs-editor-buttons', '/wp-includes/css/editor.min.css' );

    wp_enqueue_style( 'cs-preview', $preview_style_asset['url'], array(
      'cs-dashicons',
      'cs-editor-buttons',
    ), $preview_style_asset['version'] );
  }

  public function prefilter_options( $updates ) {
    $this->prefilter_option_updates = array_merge( $this->prefilter_option_updates, $updates );
    $exclude = apply_filters( 'cs_theme_option_preview_exclusions', [] );
    foreach ($updates as $key => $value) {
      if ( in_array( $key, $exclude, true ) ) continue;
      add_filter( "pre_option_$key", array( $this, 'prefilter_option_handler' ) );
    }
  }

  public function prefilter_option_handler($value) {

    $option_name = preg_replace( '/^pre_option_/', '', current_filter() );

    if ( isset( $this->prefilter_option_updates[ $option_name ] ) ) {
      $value = apply_filters( 'option_' . $option_name, $this->prefilter_option_updates[ $option_name ] );
    }

    return $value;
  }

  public function prefilter_meta( $id, $updates ) {

    $key = 'o' . $id;

    if ( ! isset( $this->prefilter_meta_updates[ $key ] ) ) {
      $this->prefilter_meta_updates[ $key ] = array();
    }

    $this->prefilter_meta_updates[ $key ] = array_merge( $this->prefilter_meta_updates[ $key ], $updates );

  }

  public function prefilter_meta_handler( $value, $object_id, $meta_key, $single ) {
    if ( isset( $this->prefilter_meta_updates['o' . $object_id ] ) && isset( $this->prefilter_meta_updates['o' . $object_id ][$meta_key] ) ) {
      $value = $this->prefilter_meta_updates['o' . $object_id ][$meta_key];
      if ( ! $single ) {
        $value = array( $value );
      }
    }
    return $value;
  }

  public function filter_cs_settings( $id, $key, $updates = array() ) {

    $key = 'o' . $id . ':' . $key;

    if ( ! isset( $this->filter_cs_settings[ $key ] ) ) {
      $this->filter_cs_settings[ $key ] = array();
    }

    $this->filter_cs_settings[ $key ] = array_merge( $this->filter_cs_settings[ $key ], $updates );

  }

  public function filter_cs_settings_handler( $value, $post_id, $key ) {
    $filter_key = 'o' . $post_id . ':' . $key;
    if ( isset( $this->filter_cs_settings[$filter_key] ) ) {
      if (is_array($value) && is_array($this->filter_cs_settings[$filter_key])) {
        return array_merge( $value, $this->filter_cs_settings[$filter_key] );
      }
    }
    return $value;
  }

  public function filter_region_settings( $settings, $type, $id ) {

    if (isset($this->state['entityId']) && (int) $this->state['entityId'] === (int) $id) {
      return array_merge( $settings, $this->state['settings'] );
    }

    return $settings;

  }

  public function nav_overlay_header( $atts ) {

    $header = $this->plugin->component('Assignments')->get_last_active_header();

    if ( $header && $this->state['type'] !== 'header' && $this->component('App_Permissions')->user_can('headers') ) {

      $post_type_obj = get_post_type_object( 'cs_header' );

      $atts['data-cs-observeable-nav'] = cs_prepare_json_att( array(
        'action' => array(
          'route'   => 'headers/' . $header->get_id(),
          'context' => $post_type_obj->labels->singular_name
        ),
        'label' => sprintf( csi18n( 'common.edit' ), $post_type_obj->labels->singular_name )
      ) );
    }

    return $atts;
  }

  public function nav_overlay_footer( $atts ) {

    $footer = $this->plugin->component('Assignments')->get_last_active_footer();

    if ( $footer && $this->state['type'] !== 'footer' && $this->component('App_Permissions')->user_can( 'footers' ) ) {

      $post_type_obj = get_post_type_object( 'cs_footer' );

      $atts['data-cs-observeable-nav'] = cs_prepare_json_att( array(
        'action' => array(
          'route'   => 'footers/' . $footer->get_id(),
          'context' => $post_type_obj->labels->singular_name
        ),
        'label' => sprintf( csi18n( 'common.edit' ), $post_type_obj->labels->singular_name )
      ) );
    }

    return $atts;

  }

  public function nav_overlay_content( $atts, $id, $post_type ) {

    if ( $id && $post_type && $this->component('App_Permissions')->user_can( "content.$post_type" ) ) {

      $post_type_obj = get_post_type_object( $post_type );

      $atts['data-cs-observeable-nav'] = cs_prepare_json_att( array(
        'action' => array(
          'route'   => "content/$id",
          'context' => $post_type_obj->labels->singular_name
        ),
        'label' => sprintf( csi18n( 'common.edit' ), $post_type_obj->labels->singular_name )
      ) );
    }

    return $atts;

  }

  public function nav_overlay_global_block( $atts, $global_block_id ) {

    if ( $global_block_id && $this->component('App_Permissions')->user_can('content.cs_global_block') ) {

      $post_type_obj = get_post_type_object( 'cs_global_block' );

      $atts['data-cs-observeable-nav'] = cs_prepare_json_att( array(
        'action' => array(
          'route'   => "global-blocks/$global_block_id",
          'context' => $post_type_obj->labels->singular_name
        ),
        'label' => sprintf( csi18n( 'common.edit' ), $post_type_obj->labels->singular_name )
      ) );

    }

    return $atts;

  }

  public function body_class( $classes ) {
    $classes[] = 'tco-preview';
    return $classes;
  }

  public function react_dev_tools() {
    ?>
    <script>if (window.parent !== window) window.__REACT_DEVTOOLS_GLOBAL_HOOK__ = window.parent.__REACT_DEVTOOLS_GLOBAL_HOOK__;</script>
    <?php
  }

  public function setup_content() {

    $this->preview_content_general_settings();
    add_filter( 'the_content', array( $this, 'output_content_zone' ), -9999999 );
    add_action( 'wp_footer', array( $this, 'process_content' ), -999999 );

    if ($this->state['type'] === 'global-block') {
      $this->setup_global_block();
    }
  }

  public function setup_global_block() {
    if ( isset( $this->state['entityId'] )  ) {
      remove_all_filters('template_include');
      remove_action( 'x_after_site_end', 'x_legacy_header_widget_areas' );
      remove_action( 'x_after_site_end', 'x_scroll_top_anchor' );
      add_action('cs_output_header', '__return_false' );
      add_action('cs_output_footer', '__return_false' );
      add_filter('template_include', array( $this->plugin->component('Front_End'), 'setup_after_template_include' ), 99998 );
      add_filter('template_include', array( $this, 'global_block_set_blank_preview_template' ) );
      add_action( 'wp_enqueue_scripts', array( $this, 'global_block_css') );

      add_filter('builder_class', array( $this, 'global_block_class' ), 11 );
    }
  }

  public function global_block_class(){
    return 'cs-content cs-global-block-builder x-global-block x-global-block-' . $this->state['entityId'];
  }

  public function global_block_css(){
    $css = '.cs-global-block-builder { font-size: ' . get_option( 'x_content_font_size_rem', '1' ) . 'rem; }';
    CS()->novus()->service('Styling')->addStyles( 'global-block-preview', $css, 1000);
  }

  public function global_block_set_blank_preview_template( $template ) {
    $this->plugin->common()->override_global_post( (int) $this->state['entityId'] );
    return $this->plugin->path('includes/views/app/preview-global-blocks.php');
  }

  /**
	 * Replace the page content with a wrapping div that will be re-populated
	 * with our javascript application.
	 */
	public function output_content_zone( $content ) {
    $this->content_cache = $content;
    return $this->get_content_zone();
  }

  public function get_content_zone() {
    $builder_class = apply_filters( 'builder_class', 'cs-content cs-content-builder' );
    ob_start();
    echo '<div id="cs-content" class="' . $builder_class . '">';
    do_action('cs_content');
    echo '</div>';
    return ob_get_clean();
  }

	/**
	 * Process all the page shortcodes, but don't output anything.
	 * This allows shortcodes to enqueue scripts to the footer even if they
	 * were previously removed by the content wrapper.
	 */
	public function process_content() {
		apply_filters( 'the_content', $this->content_cache );
	}

  public function preview_content_general_settings() {

    global $post;
    if ( !$post || (int) $post->ID !== (int) $this->state['entityId'] ) {
      return;
    }

    if ( isset( $this->state['settings']['general_post_title'] ) ) {
      $post->post_title = $this->state['settings']['general_post_title'];
    }

    if ( isset( $this->state['settings']['general_allow_comments'] ) ) {
      $post->comment_status = ( $this->state['settings']['general_allow_comments'] ) ? 'open' : 'closed';
    }

    $updates = array();

    if ( isset( $this->state['settings']['general_page_template'] ) ) {
      $updates['_wp_page_template'] = $this->state['settings']['general_page_template'];
    }

    if ( ! empty( $updates ) ) {
      $this->prefilter_meta( get_the_ID(), $updates );
    }

    $settings = array();

    if ( isset( $this->state['settings']['custom_css'] ) ) {
      $settings['custom_css'] = $this->state['settings']['custom_css'];
    }

    if ( isset( $this->state['settings']['custom_js'] ) ) {
      $settings['custom_js'] = $this->state['settings']['custom_js'];
    }

    if ( ! empty( $settings ) ) {
      $this->filter_cs_settings( get_the_ID(), '_cornerstone_settings', $settings );
    }

  }

  public function detect_content_overlay( $post_id ) {

    if ( isset( $this->overlays[".cs-nav-overlay-post-$post_id"] ) || ( $this->state['type'] === 'content' && $this->queried_object['type'] === 'post' && (int) $post_id === $this->queried_object['postId'] ) ) {
      return false;
    }

    $post_type = get_post_type( $post_id === get_the_ID() ? null : $post_id );

    if ( !$post_type || !$this->component('App_Permissions')->user_can( "content.$post_type" ) ) {
      return false;
    }

    $post_type_obj = get_post_type_object( $post_type );

    $this->overlays[".cs-nav-overlay-post-$post_id"] = array(
      'action' => array(
        'route'   => "content/$post_id",
        'context' => $post_type_obj->labels->singular_name
      ),
      'label' => sprintf( csi18n( 'common.edit-context' ), $post_type_obj->labels->singular_name, get_the_title( $post_id ) )
    );

    return true;

  }

  public function observe_post_classes( $classes, $class, $post_id ) {
    if ( $this->detect_content_overlay( $post_id ) ) {
      $classes[] = "cs-nav-overlay-post-$post_id";
    }
    return $classes;
  }

  public function output_observed_overlays() {

    if ( count( $this->overlays ) > 0 ) {
      $data = json_encode( $this->overlays );
      echo "<script>window.csAppPreviewOverlays=$data</script>";
    }

  }

  public function output_initial_render() {
    if ($this->state['initialRender']) {
      try {
        $this->initial_render_content = $this->plugin->component('Preview_Rendering')->render([
          'rootElement' => $this->state['rootElement'],
          'config' => [
            'type'          => $this->state['type'],
            'regions'       => $this->state['regions'],
            'entityId'       => $this->state['entityId'],
            'queriedObject' => $this->queried_object
          ],
          'flags' => $this->state['flags']
        ], true );
      } catch( Exception $e ) {
        $this->initial_render_content = [ 'error' => $e->getMessage() ];
      }

      $json = json_encode( $this->initial_render_content );
      $gzip = $this->plugin->component('Router')->gzip();

      $content = base64_encode( $gzip ? gzcompress( $json ) : $json );

      $atts = cs_atts([
        'data-cs-initial-render' => true,
        'type' => 'text/template',
        'data-cs-gzip' => $gzip
      ]);

      echo "<script $atts >$content</script>";
    }

  }

}
