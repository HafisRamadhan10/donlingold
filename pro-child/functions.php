<?php

// =============================================================================
// FUNCTIONS.PHP
// -----------------------------------------------------------------------------
// Overwrite or add your own custom functions to Pro in this file.
// =============================================================================
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style('custom/css', '/wp-content/themes/my-listing-child/custom-style.css', false, null);
    wp_enqueue_script( 'custom-script', '/wp-content/themes/my-listing-child/custom-script.js', array( 'jquery' ) );

    wp_enqueue_style( 'child-style', get_stylesheet_uri() );
    if ( is_rtl() ) {
        wp_enqueue_style( 'mylisting-rtl', get_template_directory_uri() . '/rtl.css', [], wp_get_theme()->get('Version') );
    }
}, 500 );
// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Enqueue Parent Stylesheet
//   02. Additional Functions
// =============================================================================

// Enqueue Parent Stylesheet
// =============================================================================

add_filter( 'x_enqueue_parent_stylesheet', '__return_true' );

// Additional Functions - Bangerter Creative LLC
// =============================================================================

// ACF Repeater Shortcodes
// =======================
function my_acf_repeater($atts, $content='') {
  extract(shortcode_atts(array(
    "field" => null,
    "sub_fields" => null,
    "post_id" => null
  ), $atts));

  if (empty($field) || empty($sub_fields)) {
    // silently fail
    return "";
  }

  $sub_fields = explode(",", $sub_fields);
  
  $_finalContent = '';

  if( have_rows($field, $post_id) ):
    while ( have_rows($field, $post_id) ) : the_row();
      
      $_tmp = $content;
      foreach ($sub_fields as $sub) {
        $subValue = get_sub_field(trim($sub));
        $_tmp = str_replace("%$sub%", $subValue, $_tmp);
      }
      $_finalContent .= do_shortcode( $_tmp );

    endwhile;
  else :  
    $_finalContent = "$field does not have any rows";
  endif;

  return $_finalContent;
}

add_shortcode("acf_repeater", "my_acf_repeater");


// Allow shortcodes in gravityforms
// ================================
add_filter('gform_pre_render', 'walker_do_shortcode_gform_description', 10, 2);

function do_shortcode_gform_description(&$item, $key) {
    $item = do_shortcode($item);
}

function walker_do_shortcode_gform_description($form, $ajax) {

    $form['description'] = do_shortcode($form['description']);
    array_walk_recursive($form['fields'], 'do_shortcode_gform_description');

    return $form;
}

// [covid19] shortcode for displaying a date 14 days in the past
// =============================================================

function displaydate_next(){  

$time = get_the_time('jS F, Y');
$date = strtotime(date("jS F, Y", strtotime($time)) . " -14 day");
return date('F jS, Y', $date); 
}

// Current Openings
// =============================================================================

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Current Openings',
		'menu_title'	=> 'Current Openings',
		'menu_slug' 	=> 'current-openings',
		'icon_url' 		=> 'dashicons-megaphone',
		'position' 		=> '6',
	));
}