<?php

namespace Themeco\Cornerstone\Services;

class Rivet implements Service {

  public function setup() {

    add_filter( 'cs_tag_content', function( $content, $atts ) {
      if (isset($atts['data-rvt-offscreen-reset'])) {
        return "<script type=\"text/rvt-template\">".htmlentities( cs_expand_content( $content ) )."</script>";
      }
      return $content;
    }, 10, 2 );

  }

}