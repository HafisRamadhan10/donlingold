<?php

class Cornerstone_Rankmath extends Cornerstone_Plugin_Component {

  protected $postID = 0;

  public function setup() {

  		add_filter('rest_pre_dispatch', [$this, 'pre'], 0, 3);

  }

  public function pre ( $null, $server, $request ) {
        
    if ( $request->get_route() == '/rankmath/v1/updateMeta' ){
      $this->postID = $request->get_param( 'objectID' );
      add_filter('the_content', [$this, 'content'], 0 );
    }

  }

  public function content ( $content ) {

    if ( doing_action('rank_math/pre_update_metadata') && $this->postID > 0 ) {
      $content = strpos( $content, "[cs_content]", 0 ) === false ? $content : str_replace("[cs_content]", "[cs_content _p=\"{$this->postID}\" no_wrap=true ]" , $content );
    }

    return $content;
  }


}
