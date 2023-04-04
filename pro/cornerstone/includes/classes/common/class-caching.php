<?php

class Cornerstone_Caching extends Cornerstone_Plugin_Component {

  public function setup() {
    add_action( 'cornerstone_before_boot_app', array( $this, 'disable_caching_for_app' ) );
    add_action( 'cornerstone_before_custom_endpoint', array( $this, 'disable_caching_for_app' ) );
    add_action( 'cs_preview_before_render', array( $this, 'disable_caching_for_app' ) );
    add_action( 'cs_preview_frame_load', array( $this, 'disable_caching_for_app' ) );
  }

  public function disable_caching_for_app() {

    // Define constants shared throughout many caching and performance plugins.

    if ( ! defined( 'DONOTCACHEPAGE' ) ) {
      define( 'DONOTCACHEPAGE', true );
    }

    if ( ! defined( 'DONOTMINIFY' ) ) {
      define( 'DONOTMINIFY', true );
    }

    if ( ! defined( 'DONOTCDN' ) ) {
      define( 'DONOTCDN', true );
    }

    // Outliers who don't use the constants
    add_filter( 'bwp_minify_is_loadable', '__return_false' );

    // Optionally Disable CloudFlare Rocket Loader. This should in most cases
    // already be avoided by the no-cache headers.
    if ( apply_filters( 'cornerstone_compat_cloudflare', false ) ) {
      add_filter( 'script_loader_tag', array( $this, 'disable_cloudflare_rocket_loader' ), 10, 3 );
    }
  }

  public function disable_cloudflare_rocket_loader( $tag, $handle, $src ) {
    return str_replace( "type='text/javascript'", "type='text/javascript' data-cfasync=\"false\"", $tag );
  }

  public function clear_all_caches() {

    // W3TC

    // WP Super Cache

    // Autoptimize

    // WP Fastest Cache

    // WP Rocket

    // Comet Cache

    // batcache

    //
    // WP Engine
    //

    if ( class_exists( 'WpeCommon' ) ) {
      if ( method_exists( 'WpeCommon', 'purge_memcached' ) ) {
        WpeCommon::purge_memcached();
      }
      if ( method_exists( 'WpeCommon', 'clear_maxcdn_cache' ) ) {
        WpeCommon::clear_maxcdn_cache();
      }
      if ( method_exists( 'WpeCommon', 'purge_varnish_cache' ) ) {
        WpeCommon::purge_varnish_cache();
      }
    }

    //
    // WP Object Cache
    //

    wp_cache_flush();


  }

}
