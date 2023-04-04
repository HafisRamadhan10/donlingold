<?php

namespace Themeco\Cornerstone\Services;

class Standalone implements Service {

  public function __construct(Styling $styling) {
    $this->stylingService = $styling;
  }

  public function setup() {

    if ( current_theme_supports( 'cornerstone-theming' ) ) {
      return;
    }

    add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ], 5 );
    add_action( 'wp_head', [ $this,  'generatedCss' ], 9998, 0 );
  }

  public function enqueue() {
    $style_asset = CS()->css( 'site/style' );
		wp_enqueue_style( 'cornerstone-shortcodes', $style_asset['url'], [], $style_asset['version'] );
    $this->stylingService->addStaticDependency( 'cornerstone-shortcodes' );
  }

  public function generatedCss() {
    $this->stylingService->addStyles('cs-standalone', CS()->view( 'frontend/styles', false, $this->getOptions(), true ), 0);
	}

  public function getOptions() {
    $defaults = CS()->config_group( 'options/defaults' );
    $retrieved = array();
    foreach ($defaults as $name => $default) {
      $retrieved[$name] = get_option( $name, $default );
    }
    return $retrieved;
  }

}
