<?php

namespace Themeco\Theme\Templating;

class ViewRouter {

  public function setup() {

    add_action( 'tco_footer', function() {
      do_action('cs_footer');
    });

    add_action( 'tco_header', function() {
      do_action('cs_header');
    });

    add_action( 'cs_body_begin', [ $this, 'siteBegin' ], 20 );
    add_action( 'cs_body_end', [ $this, 'siteEnd' ], -20 );
    add_filter( 'cs_root_atts', [ $this, 'rootAtts']);

    add_filter( 'cs_masthead_atts', [ $this, 'mastheadAtts'] );
    add_filter( 'cs_colophon_atts', [ $this, 'colophonAtts'] );
    add_filter( 'cs_layout_atts', [ $this, 'layoutAtts'] );
  }

  public function rootAtts($atts) {
    $atts['class'] = ['tco-root'];
    return $atts;
  }

  public function mastheadAtts($atts) {
    $atts['class'] = 'tco-masthead';
    return $atts;
  }

  public function colophonAtts($atts) {
    $atts['class'] = 'tco-colophon';
    return $atts;
  }

  public function layoutAtts($atts) {
    $atts['class'] = array_map( function($class) {
      return str_replace('cs-layout', 'tco-layout', $class);
    }, $atts['class'] );
    return $atts;
  }

  public function siteBegin() {
    echo cs_open_tag(
      apply_filters( 'tco_site_tag', 'div'),
      apply_filters( 'tco_site_atts', [ 'class' => 'tco-site' ] )
    );
  }

  public function siteEnd() {
    echo '</' . apply_filters( 'tco_site_tag', 'div' ) . '>';
  }

}