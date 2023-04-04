<?php

add_filter( 'vc_gitem_template_attribute_post_excerpt', function( $value ) {
  CS()->component('Element_Front_End')->untrack_excerpt();
  return $value;
}, 0 );


add_filter( 'vc_gitem_template_attribute_post_excerpt', function( $value ) {
  CS()->component('Element_Front_End')->track_excerpt();
  return $value;
}, 1000 );
