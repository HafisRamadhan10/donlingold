<?php

namespace Themeco\Cornerstone\Services;

use Themeco\Cornerstone\Plugin;

class Theming implements Service {

  protected $plugin;

  public function __construct(Plugin $plugin) {
    $this->plugin = $plugin;
  }

  public function setup() {

    // Connect

    // Root
    // ----

    add_action( 'cs_body_begin', [ $this, 'rootBegin' ] );
    add_action( 'cs_body_end', [ $this, 'rootEnd' ], 1000 );

    // Masthead / Colophon
    // -------------------

    add_action( 'cs_masthead_begin', [$this, 'mastheadOpen'] );
    add_action( 'cs_masthead_end', [$this, 'mastheadClose'] );
    add_action( 'cs_colophon_begin', [$this, 'colophonOpen'] );
    add_action( 'cs_colophon_end', [$this, 'colophonClose'] );
    add_action( 'template_redirect', [ $this, 'connectMastheadAndColophon' ], - 100 );

    // Layouts
    // -------

    add_action( 'cs_layout_begin', [ $this, 'layoutOpen' ] );
    add_action( 'cs_layout_end', [ $this, 'layoutClose' ] );
    add_action( 'cs_layout_begin_single', [ $this, 'layoutOpenSingle' ] );
    add_action( 'cs_layout_end_single', [ $this, 'layoutCloseSingle' ] );



    // Deferred Markup
    add_action( 'cs_body_end', [ $this, 'defer' ], 20 );
    add_action( 'wp_footer', [$this, 'ensureDeferred'], -1000); // used for live preview

  }

  public function connectMastheadAndColophon() {

    // Load the <header> and <footer> templates
    add_action('cs_header', function() {
      include $this->plugin->path . '/includes/views/theming/header.php';
    });

    add_action('cs_footer', function() {
      include $this->plugin->path .'/includes/views/theming/footer.php';
    });

    // Render masthead inside <header>
    add_action('cs_connect_masthead', function() {
      add_action('cs_body_begin', function() {
        include $this->plugin->path . '/includes/views/theming/masthead.php';
      }, 100 );
    });

    // Render colophon inside <footer>
    add_action('cs_connect_colophon', function() {
      add_action('cs_body_end', function() {
        include $this->plugin->path . '/includes/views/theming/colophon.php';
      }, -100 );
    });
  }

  public function rootBegin() {
    echo cs_open_tag(
      apply_filters( 'cs_root_tag', 'div'),
      apply_filters( 'cs_root_atts', [ 'class' => 'cs-root' ] )
    );
  }

  public function rootEnd() {
    echo '</' . apply_filters( 'cs_root_tag', 'div' ) . '>';
  }

  public function defer() {
    do_action( 'cs_deferred' );
  }

  public function ensureDeferred() {
		if ( ! did_action( 'cs_deferred' ) ) {
			ob_start();
      $this->defer();
      echo cs_tag('div', [ 'id' => 'cs-footer'], ob_get_clean() ); // needs to be inside cs-footer for standalone Cornerstone styling
		}
	}



  public function mastheadOpen() {
    echo cs_open_tag(
      apply_filters( 'cs_masthead_tag', 'header'),
      apply_filters( 'cs_masthead_atts', [
        'class' => 'cs-masthead',
        'role'  => 'banner'
      ] )
    );
  }

  public function mastheadClose() {
    echo '</' . apply_filters( 'cs_masthead_tag', 'header' ) . '>';
  }

  public function colophonOpen() {
    echo cs_open_tag(
      apply_filters( 'cs_colophon_tag', 'footer'),
      apply_filters( 'cs_colophon_atts', [
        'class' => 'cs-colophon',
        'role'  => 'contentinfo'
      ] )
    );
  }

  public function colophonClose() {
    echo '</' . apply_filters( 'cs_colophon_tag', 'footer' ) . '>';
  }

  public function layoutOpen() {

    $atts = [
      'class' => [ 'cs-layout' ],
      'role' => 'main'
    ];

    if (is_singular() || is_single() ) {
      $atts['class'][] = 'cs-layout-single';
    }

    if ( is_archive() ) {
      $atts['class'][] = 'cs-layout-archive';
    }

    echo apply_filters( 'cs_layout_output_before', cs_open_tag(
      apply_filters( 'cs_layout_tag', 'main' ),
      apply_filters( 'cs_layout_atts', $atts )
    ) );
  }

  public function layoutClose() {
    $tag = apply_filters( 'cs_layout_tag', 'main' );
    echo apply_filters( 'cs_layout_output_after', "</$tag>" );
  }

  public function layoutOpenSingle() {
    ob_start();
    if (is_singular()) {
      ?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>> <?php
    }
    echo apply_filters( 'cs_layout_output_before_single', ob_get_clean() );
  }

  public function layoutCloseSingle() {
    ob_start();
    if (is_singular()) {
      ?></article> <?php
    }
    echo apply_filters( 'cs_layout_output_after_single', ob_get_clean() );
  }

}