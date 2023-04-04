<?php

class Cornerstone_Jetpack extends Cornerstone_Plugin_Component {

  public function setup() {

      //Jetpack integration with CS_CONTENT_SEO, 
      //This is needed since jetpack directly pulls content from post_content instead of using Wordpress generated excerpt bypassing the function that cleans excerpt.
      //Resulting to visible [cs_content_seo], hence, let's clean it here

    add_filter( 'jetpack_open_graph_tags', array($this, 'clean_cs_content_seo'), 999999 );  
      
  }

  public function clean_cs_content_seo ( $opengraph ) {
      
      $description = $opengraph ['og:description'];

      if ( !strpos( $description, '[cs_content_seo]') ) {

        $opengraph ['og:description'] = preg_replace('/\[cs_content_seo\]|\[\/cs_content_seo\]/m', '', $description );
      
      }

      return  $opengraph;

  }
  

}
