<?php

/**
 * Commonly used functions and a repository for commonly accessed data.
 */

class Cornerstone_Common extends Cornerstone_Plugin_Component {

  private $font_icons;
  private $env_data;

  /**
   * Instantiate
   */
  public function setup() {

    $this->font_icons = apply_filters('cs_font_icon_data', array_merge($this->plugin->config_group( 'common/font-icons' ), $this->plugin->config_group( 'common/font-icon-aliases' ), array(
      'groups' => array(
        'solid'   => __( 'Solid', 'cornerstone' ),
        'regular' => __( 'Regular', 'cornerstone' ),
        'light'   => __( 'Light', 'cornerstone' ),
        'brands'  => __( 'Brands', 'cornerstone ')
      )
    )));

    add_action( 'init', array( $this, 'init' ) );

    // WP 5.1 fix
    if ( function_exists( 'wp_init_targeted_link_rel_filters' ) &&
         function_exists( 'wp_remove_targeted_link_rel_filters' ) ) {
      add_action( 'cs_before_save_json_content', 'wp_remove_targeted_link_rel_filters' );
      add_action( 'cs_after_save_json_content', 'wp_init_targeted_link_rel_filters' );
    }


  }

  public function init() {

    if ( !is_user_logged_in() ) {
      add_action( 'template_redirect', array( $this, 'loginRedirect' ) );
    }

    register_post_status( 'tco-data', array(
      'label'                     => 'Data', // not localized / not public facing
      'label_count'               => 'Data (%s)',
      'internal'                  => true,
    ) );

    register_post_type( 'cs_global_block', array(
      'labels'          => csi18n( 'common.global-block-labels' ),
      'public'          => false,
      'capability_type' => 'page',
      'supports'        => false
    ) );

    add_filter('cs_save_element_output_section', array( $this, 'section_nextpage_support' ), 10, 3 );

  }

  public function resolveFontAlias( $key ) {
    return isset( $this->font_icons['aliases'][$key] ) ? $this->font_icons['aliases'][$key] : $key;
  }

  /**
   * Get Font Icon Unicode Value as a string
   * @return string
   */
  public function getFontIcon( $key ) {

    $key = $this->resolveFontAlias( $key );

    $set = 's';

    if ( 0 === strpos($key, 'o-' ) ) {
      $key = substr( $key, 2 );
      if ( in_array($key, $this->font_icons['regular']) ) {
        $set = 'o';
      }
    }

    if ( 0 === strpos($key, 'l-' ) ) {
      $key = substr( $key, 2 );
      if ( in_array($key, $this->font_icons['light']) ) {
        $set = 'l';
      }
    }

    if ( in_array($key, $this->font_icons['brands']) ) {
      $set = 'b';
    }

    $icon = ( isset( $this->font_icons['icons'][ $key] ) ) ? $this->font_icons['icons'][$key] : 'f00d';

    return array( $set, $icon );
  }

  function getFontIconKeyFromUnicode( $unicode ) {

    static $flipped = array();

    if ( empty( $flipped ) ) {
      $flipped = array_flip( $this->font_icons['icons'] );
    }

    return isset( $flipped[$unicode] ) ? $flipped[$unicode] : 'remove';

  }

  /**
   * Return font icon cache
   * @return array
   */
  public function getFontIcons() {
    return $this->font_icons['icons'];
  }

  /**
   * Return font icon cache
   * @return array
   */
  public function getFontIds() {

    $ids = array_keys( $this->font_icons['icons'] );

    foreach ($this->font_icons['regular'] as $key) {
      $ids[] = "o-$key";
    }

    foreach ($this->font_icons['light'] as $key) {
      $ids[] = "l-$key";
    }

    return $ids;

  }

  public function getFontIconsData() {
    return $this->font_icons;
  }

  /**
   * Get a URL that can be used to access Cornerstone for a given post.
   * @param  string $post Accepts a post object, or post ID. Uses queried object if one isn't provided
   * @return string
   */
  public function get_edit_url( $post = '' ) {

    $post = $this->locate_post( $post );

    if ( !$post)
      return null;

    $url = $this->get_app_route_url( 'content', $post->ID );

    if ( force_ssl_admin() ) {
      $url = preg_replace( '#^http://#', 'https://', $url );
    }

    return $url;

  }

  public function direct_page_link( $link, $post_id, $sample ) {
    return home_url( '?page_id=' . $post_id );
  }

  public function direct_post_link( $permalink, $post, $leavename ) {
    return home_url('?p=' . $post->ID);
  }

  public function direct_custom_post_type_link( $post_link, $post, $leavename, $sample ) {
    return home_url( add_query_arg(array('post_type' => $post->post_type, 'p' => $post->ID), '') );
  }

  /**
   * Get a WP_Post object from an ID or an automatic source
   * If $post_id is left black, it will be automatically populated (works in dashboard or on front end)
   * @param  string $post_id
   * @return WP_Post
   */
  public function locate_post( $post_id = '') {

    // Allow pass through of full post objects
    if ( isset( $post_id->ID ) )
      return $post_id;

    // Get post by ID
    if ( is_int( $post_id ) )
      return get_post( $post_id );

    // Or, in the dashboard use a query string
    if ( is_admin() && isset($_GET['post']) )
      return get_post( $_GET['post'] );

    // Or, use the queried object
    if ( '' == $post_id ) {
      $post = get_queried_object();
      if ( is_a( $post, 'WP_POST' ))
        return $post;
    }

    // Otherwise there's just no way...
    return false;

  }

  /**
   * Detect if a post has saved Cornerstone data
   * @return bool true is Cornerstone meta exists
   */
  public function uses_cornerstone( $post = false ) {

    if ( ! $post ) {
      return false;
    }

    $data = cs_get_serialized_post_meta( $post->ID, '_cornerstone_data', true );
    $override = get_post_meta( $post->ID, '_cornerstone_override', true );

    return $data && ! $override;

  }

  /**
   * Potentially redirect a logged out user who was attempting to edit a page in Cornerstone.
   * @return none
   */
  public function loginRedirect() {
    if ( isset($_GET['cornerstone']) && $_GET['cornerstone'] == 1 && $this->plugin->component('App_Permissions')->user_can_access_post_type() ) {
      wp_redirect( add_query_arg( array(
        'cornerstone' => '1'
      ), wp_login_url( get_the_permalink() ) ) );
    }
  }


  /**
   * Create an image URI of a blank SVG image to be used as a placeholder
   * @return string
   */
  public function placeholderImage( $height = '300', $width = '250', $color = '#eeeeee' ) {
    return 'data:image/svg+xml;base64,' . base64_encode( "<svg xmlns='http://www.w3.org/2000/svg' width='{$width}px' height='{$height}px' viewBox='0 0 {$width} {$height}' version='1.1'><rect fill='{$color}' x='0' y='0' width='{$width}' height='{$height}'></rect></svg>" );
  }

  public function classMap( $group, $classes ) {

    $single = false;

    if ( ! is_array( $classes ) ) {
      $single = true;
      $classes = array( $classes );
    }

    if ( ! isset( $this->cssClassMap ) ) {
      $this->cssClassMap = $this->plugin->config_group( 'common/class-map' );
    }

    if ( ! isset( $this->cssClassMap[ $group ] ) ) {
      trigger_error( "Cornerstone_Common::classMap group: $group doesn't exist in class map.", E_USER_WARNING );
      return array( '' );
    }

    $this->cssClassMapGroup = $this->cssClassMap[ $group ];

    $map = array_map( array( $this, 'classMapHandler' ), $classes );

    return ( $single ) ? $map[0] : $map;

  }

  protected function classMapHandler( $class ) {

    if ( ! isset( $this->cssClassMapGroup[ $class ] ) ) {
      return '';
    }

    return $this->cssClassMapGroup[ $class ];

  }

  public function is_validated() {
    return ( get_option( 'cs_product_validation_key', false ) !== false );
  }

  public function get_post_capability( $post_id, $cap ) {

    $post = $this->locate_post( $post_id );

    if ( ! is_a( $post, 'WP_POST' ) ) {
      return $cap;
    }

    return $this->get_post_type_capability( $post->post_type, $cap );

  }

  public function get_post_type_capability( $post_type, $cap ) {

    $post_type_object = get_post_type_object( $post_type );
    $caps = (array) $post_type_object->cap;
    return $caps[ $cap ];

  }


  public function get_app_slug() {

    $settings = $this->plugin->settings();

    $slug = apply_filters( 'cornerstone_default_app_slug', 'cornerstone' );

    if ( isset( $settings['custom_app_slug'] ) && '' !== $settings['custom_app_slug'] ) {
      $slug = sanitize_title_with_dashes( $settings['custom_app_slug'] );
    }

    return $slug;

  }

  public function get_app_url() {
    return untrailingslashit( home_url( $this->plugin->common()->get_app_slug() ) );
  }

  public function get_launch_url() {
    return $this->get_app_route_url();
  }

  public function get_app_route_url( $route = '', $model_id = '', $route_context = '') {

    if ( ! $this->plugin->component( 'Router' )->is_permalink_structure_valid() ) {
      $args = array('cs-launch' => 1);
      if ( $route ) {
        $args['cs_route'] = esc_attr($route);
        if ( $route_context ) {
          $args['cs_route'] .= ".$route_context";
        }
        if ( $model_id ) {
          $args['cs_route'] .= "/$model_id";
        }
      }
      return add_query_arg( $args, home_url() );
    }

    $url = $this->get_app_url();

    if ( $route ) {
      $route = str_replace('.', '/', $route );
      $url .= "/$route";
      if ( $model_id ) {
        $url .= "/$model_id";
      }
    }

    return $url;

  }

  public function sanitize($value) {

    if ( is_array( $value ) ) {
      $clean = [];
      foreach( $value as $key => $value) {
        $clean[ is_string($key) ? sanitize_text_field( $key) : $key ] = $this->sanitize($value);
      }
      return $clean;
    }

    if ( is_string( $value ) && ! current_user_can( 'unfiltered_html' ) ) {
      return wp_kses( $value, $this->ksesTags() );
    }

    return $value;

  }

  public function ksesTags() {

    $tags = wp_kses_allowed_html( 'post' );

    $tags['iframe'] = array (
      'align'       => true,
      'frameborder' => true,
      'height'      => true,
      'width'       => true,
      'sandbox'     => true,
      'seamless'    => true,
      'scrolling'   => true,
      'srcdoc'      => true,
      'src'         => true,
      'class'       => true,
      'id'          => true,
      'style'       => true,
      'border'      => true,
      'list'        => true //YouTube embeds
    );

    return $tags;

  }

  /**
   * Call inside the template_include filter to replace the global $post
   */
  public function override_global_post( $post_id, $args = array() ) {

    $args = array_merge( array(
      'post_count'    => 1,
      'found_posts'   => 1,
      'max_num_pages' => 0,
      'is_404'        => false,
      'is_page'       => true,
      'is_singular'   => true
    ), $args );

    $target_post = get_post( $post_id );

    if ( ! is_a( $target_post, 'WP_Post' ) ) {
      return false;
    }

    global $wp_query;
    global $post;

    $post = $target_post;

    $wp_query->posts             = array( $post );
    $wp_query->queried_object_id = $post->ID;
    $wp_query->queried_object    = $post;

    foreach ($args as $key => $value) {
      $wp_query->$key = $value;
    }

    setup_postdata( $post );

    return true;
  }

  public function fix_script_tags( $handle, $src) {
    $safe_handles = array( 'x-google-map' );
    if ( in_array( $handle, $safe_handles, true ) ) {
      $src = preg_replace('/(&#038;|&amp;)/', '&', $src );
    }
    return $src;
  }

  public function get_env_data() {

    if ( ! isset( $this->env_data ) ) {
      $this->env_data = apply_filters('_cornerstone_app_env', [] );
    }

    return $this->env_data;

  }

  public function get_fa_config() {
    return apply_filters( 'cs_fa_config', array(
      'fa_font_path'      => CS()->url( 'assets/fonts/' ),
      'fa_solid_enable'   => true,
      'fa_regular_enable' => true,
      'fa_light_enable'   => true,
      'fa_brands_enable'  => true,
    ) );
  }

  public function section_nextpage_support( $shortcode, $data, $content ) {

    $data_string = json_encode( $data );

    if ( false !== strpos( $data_string, '<!--nextpage-->' ) ) {
      $shortcode .= '[/cs_content]<!--nextpage-->[cs_content]';
    }

    return $shortcode;

  }

}
