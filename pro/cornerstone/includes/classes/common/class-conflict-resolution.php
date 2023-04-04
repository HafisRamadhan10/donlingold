<?php

class Cornerstone_Conflict_Resolution extends Cornerstone_Plugin_Component {

  public function setup() {

    // Disable NextGEN Resource Manager
    add_filter( 'run_ngg_resource_manager', '__return_false' );

    add_action( 'cornerstone_load_builder', array( $this, 'front_end' ) );
    add_action( 'cornerstone_before_boot_app', array( $this, 'front_end' ) );
    add_action( 'cornerstone_before_ajax', array( $this, 'before_render' ) );
    add_action( 'cs_before_preview_frame', array( $this, 'before_load_preview' ) );

  }

  public function front_end() {

    if ( class_exists( 'UberMenu' ) ) {
      remove_action( 'admin_bar_menu', 'ubermenu_add_toolbar_items', 100 );
      //$this->remove_ubermenu_toolbar();
    }

    if ( class_exists( 'WPSEO_Frontend' ) ) {
      remove_action( 'template_redirect', array( WPSEO_Frontend::get_instance(), 'clean_permalink' ), 1 );
    }

    if( class_exists( 'BuddyPress' ) ){
      remove_action( 'bp_template_redirect', 'bp_screens', 6 );
    }

  }

  public function before_render() {

    if ( class_exists( 'GFForms' ) ) {
      add_filter( 'gform_disable_print_form_scripts', '__return_true' );
    }

  }

  public function before_load_preview() {

    $this->front_end();

    if ( defined( 'JETPACK__VERSION' ) ) {
      remove_filter( 'the_content', 'sharing_display', 19 );
      remove_filter( 'the_excerpt', 'sharing_display', 19 );
      add_filter( 'sharing_show', '__return_false', 9999 );
    }

    if ( function_exists( 'wpseo_frontend_head_init' ) ) {
      remove_action( 'template_redirect', 'wpseo_frontend_head_init', 999 );
    }

    if ( function_exists( 'csshero_add_footer_trigger' ) ) {
      add_filter( 'pre_option_wpcss_hidetrigger', '__return_true' );
    }

    add_action('wp_enqueue_scripts', array($this, 'preview_enqueue'), 100 );

  }

  public function preview_enqueue() {
    if ( wp_script_is('babel-polyfill', 'enqueued') ) {
			wp_dequeue_script('babel-polyfill');
    }

    if ( wp_script_is('wc-geolocation', 'enqueued') ) {
			wp_dequeue_script( 'wc-geolocation' );
    }
  }

}
