<?php

class Cornerstone_Element_Front_End extends Cornerstone_Plugin_Component {

  public $element_data;
  protected $excerpt_post_id = null;
  protected $content_entity_cache = array();
  protected $the_content_stack = array();
  protected $the_content_cache = array();

  public function setup() {

    add_action( 'cs_late_template_redirect', array( $this, 'post_loaded' ), 9998, 0 );
    add_filter( 'cs_render_element', [ $this, 'strip_anchors' ] );

    add_shortcode( 'cs_content', array( $this, 'render_content') );
    add_shortcode( 'cs_gb', array( $this, 'global_block_shortcode_output' ) );

    $this->track_excerpt();

    $this->elementService = CS()->novus()->service('Elements');
  }

  public function track_excerpt() {
    add_filter( 'get_the_excerpt', [ $this, 'begin_excerpt'], 0, 2 );
    add_filter( 'get_the_excerpt', [ $this, 'end_excerpt'], 1000 );
  }

  public function untrack_excerpt() {
    remove_filter( 'get_the_excerpt', [ $this, 'begin_excerpt'], 0, 2 );
    remove_filter( 'get_the_excerpt', [ $this, 'end_excerpt'], 1000 );
  }

  public function allow_cs_content( $tags ) {
    $index = array_search( 'cs_content', $tags);
    if ($index) {
      unset( $tags[ $index ] );
    }
    return $tags;
  }

  public function begin_excerpt( $text, $post = 0 ) {
    $this->excerpt_post_id = $post === 0 ? null : $post->ID;
    add_filter( 'strip_shortcodes_tagnames', [ $this, 'allow_cs_content' ] );
    return $text;
  }

  public function end_excerpt( $text ) {
    $this->excerpt_post_id = null;
    remove_filter( 'strip_shortcodes_tagnames', [ $this, 'allow_cs_content' ] );
    return $text;
  }

  public function render_content( $atts, $content ) {

    extract( shortcode_atts( array(
      '_p' => $this->get_post_id(),
      'wrap' => true
    ), $atts, 'cs_content' ) );

    // This stack prevents the possibility of infinite loops
    // 1. do_shortcode('[cs_content]') happens without an ID present causing it to be called with the previous id
    // 2. A post somehow attempts to call itself
    if ( in_array( $_p, $this->the_content_stack, true ) ) {
      return '<!-- the_content loop -->';
    }

    $this->the_content_stack[] = $_p;
    $content = $this->render_the_content_cached($_p, $content);
    array_pop( $this->the_content_stack );

    if ( $wrap && $wrap !== 'false') {
      return cs_tag( 'div', apply_filters( 'cs_content_atts', array(
        'id'    => 'cs-content',
        'class' => 'cs-content',
      ), get_the_ID(), get_post_type() ), $content );
    }

    return $content;

  }

  public function render_the_content_cached($_p, $content) {


    $content_entity = $this->get_content( $_p );

    if ( is_null( $content_entity ) ) {
      return '';
    }

    // If this item is purely classic elements, rely on the shortcode output
    if ($content_entity->get_is_legacy()) {
      return cs_dynamic_content( do_shortcode( $content ) );
    }

    // This cache prevents [cs_content] from being rendered multiple times on the front end. e.g an SEO plugin requesting the_content to generate meta tags
    if ( ! isset( $this->the_content_cache[$_p] ) || $content_entity->get_post_type() === 'cs_global_block') {
      $this->the_content_cache[$_p] = $this->render_the_content( $content_entity, $content );
    }

    return $this->the_content_cache[$_p];

  }

  public function render_the_content( $content_entity, $content ) {


    do_action( 'cs_preview_the_content_begin' );

    $element_output = '';

    try {

      // If this item is purely classic elements, rely on the shortcode output
      if ($content_entity->is_cornerstone_content()) {

        $populated = $this->elementService->loadEntity( $content_entity );
        $this->elementService->registerEntityStyles( $content_entity );
        foreach ($populated[0] as $region) {
          if ( $region['_region'] === 'content') {

            $element_output = $this->elementService->renderer()->renderRegion($region['_modules'], false);
            break;
          }
        }

        $element_output .= do_shortcode( $content_entity->get_responsive_text( $content_entity->get_settings() ) );

      }

    } catch ( Exception $e ) {
      trigger_error( $e->getMessage(), E_USER_WARNING );
    }

    do_action( 'cs_preview_the_content_end' );

    return $element_output;
  }

  public function post_loaded() {
    if (is_singular()) {
      $post_id = $this->get_post_id();
      $content = $this->get_content( $post_id );

      if ( is_null( $content ) ) {
        return;
      }

      if ( ! $content->is_cornerstone_content() && ! did_action( 'cs_before_preview_frame' ) ) {
        return;
      }

      $this->elementService->registerEntityStyles( $content );

      $settings = $content->get_settings();


      CS()->novus()->service('Styling')->addStyles( get_the_ID() . '-custom', isset( $settings['custom_css'] ) ? $settings['custom_css'] : '', 100 );

      if ( isset( $settings['custom_js'] ) && $settings['custom_js'] ) {
        CS()->component('Inline_Scripts')->add_script('cornerstone-custom-content-js', $settings['custom_js'] );
      }

    }
  }

  public function get_post_id() {
    $id = get_the_ID();
    if ( $this->excerpt_post_id ) {
      $id = $this->excerpt_post_id;
    }
    return (int) apply_filters( 'cs_element_post_id', $id );
  }

  public function global_block_shortcode_output( $atts ) {

    $atts = shortcode_atts( array(
      'id'    => '',
      'class' => '',
      'name'  => '',
    ), $atts, 'cs_gb' );

    if ( !empty($atts['name']) ) {
      $posts = get_posts( [ 'name'=>$atts['name'], 'post_type' => 'cs_global_block', 'posts_per_page' => 1, 'post_status' => 'tco-data' ] );
      $atts['id'] = empty( $posts ) ? $atts['id'] : $posts[0]->ID;
    }

    ob_start();

    do_action( 'cs_gb_shortcode_before', $atts );

    $this->elementService->renderer()->renderElements([
      [
        '_id'             => '',
        'style_id'        => $atts['id'],
        '_type'           => 'global-block',
        '_p'              => $atts['id'],
        'global_block_id' => $atts['id'],
        'class'           => $atts['class']
      ]
    ]);

    do_action( 'cs_gb_shortcode_after', $atts );

    return ob_get_clean();

  }

  public function get_content( $_id ) {


    $id = (int) $_id;

    if ( ! isset( $this->content_entity_cache[ $id ] ) ) {
      try {
        $this->content_entity_cache[ $id ] = new Cornerstone_Content( $id );
      } catch (Exception $e) {
        trigger_error( 'Exception: ' .  $e->getMessage(), E_USER_WARNING );
        $this->content_entity_cache[ $id ] = null;
      }
    }

    return $this->content_entity_cache[ $id ];

  }

  public function strip_anchors($html) {

    if ( apply_filters('cs_in_link', false ) ) {
      return preg_replace_callback('/<a[\s]+([^>]+)>((?:.(?!\<\/a\>))*.)<\/a>/', [ $this, 'strip_anchors_callback'], $html );
    }

    return $html;

  }

  public function strip_anchors_callback( $matches ) {

    $atts = trim(preg_replace_callback('/(\w*) *= *(([\'"])?((\\\3|[^\3])*?)\3|(\w+))/', [$this, 'clean_anchor_atts_callback'], $matches[1]));
    return "<span $atts>" . $matches[2] . '</span>';

  }

  public function clean_anchor_atts_callback( $matches ) {
    return in_array( $matches[1], [ 'href', 'target', 'download', 'ping', 'rel', 'hreflang', 'type', 'referrerpolicy']) ? '' : $matches[0];
  }

}
