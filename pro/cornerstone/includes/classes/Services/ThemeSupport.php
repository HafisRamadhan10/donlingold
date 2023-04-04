<?php

namespace Themeco\Cornerstone\Services;

class ThemeSupport implements Service {

  public function setup() {
    if ( current_theme_supports('cornerstone' ) ) {
      // No selector prefix for element styles
      add_filter( 'cs_tss_selector_prefixes', '__return_empty_array' );
    }

    if ( current_theme_supports( 'cornerstone-legacy-portfolio' ) ) {
      require_once( CS()->path( 'includes/extend/portfolio.php' ) );
    }

    if ( current_theme_supports( 'cornerstone-legacy-sidebars' ) ) {
      if (! function_exists( 'ups_options_init' ) ) {
        require_once( CS()->path( 'includes/extend/custom-sidebars.php' ) );
      }
    }
  }

}