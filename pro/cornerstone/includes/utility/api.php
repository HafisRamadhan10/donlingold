<?php

/**
 * Public API
 * These functions expose Cornerstone APIs, allowing it to be extended.
 * The processes represented here are otherwise handled internally.
 */

/**
 * Set which post types should be enabled by default when Cornerstone is first
 * activated.
 * @param  array $types Array of strings specifying post type names.
 * @return none
 */
function cornerstone_set_default_post_types( $types ) {
	// Deprecated
}

/**
 * Allows integrating themes to disable Themeco cross-promotion, and other
 * presentational items. Example:
 *
		cornerstone_theme_integration( array(
			'remove_global_validation_notice' => true,
			'remove_themeco_offers'           => true,
			'remove_purchase_link'            => true,
			'remove_support_box'              => true
		) );
 *
 * @param  array $args List of items to flag
 * @return none
 */
function cornerstone_theme_integration( $args ) {
	$args = cs_define_defaults( $args, array(
    'remove_global_validation_notice' => false,
    'remove_themeco_offers'           => false,
    'remove_purchase_link'            => false,
    'remove_support_box'              => false,
  ) );

  foreach ( $args as $key => $value ) {
    if ( $value ) {
      add_filter( "_cornerstone_integration_$key", '__return_true' );
    }
  }
}


function cornerstone_register_styles( $id, $css, $priority = 1) {
  return CS()->novus()->service('Styling')->addStyles( $id, $css, $priority );
}

function cornerstone_register_static_style( $handle ) {
  return CS()->novus()->service('Styling')->addStaticDependency( $handle );
}


function cornerstone_options_register_option( $name, $default_value = null, $options = array() ) {
  $options_bootstrap = CS()->component( 'Theme_Options' );
  $options_bootstrap->register_option( $name, $default_value, $options );
}

function cornerstone_options_register_options( $group, $options = array() ) {
  $options_bootstrap = CS()->component( 'Theme_Options' );
  $options_bootstrap->register_options( $group, $options );
}

function cornerstone_enqueue_custom_script( $id, $content, $type = 'text/javascript' ) {
	return CS()->component( 'Inline_Scripts' )->add_script( $id, $content, $type );
}

function cornerstone_dequeue_custom_script( $id ) {
	return CS()->component( 'Inline_Scripts' )->remove_script( $id );
}

function cornerstone_post_process_css( $css ) {
	CS()->component('Font_Manager');
  CS()->component('Color_Manager');
	return CS()->novus()->service('Styling')->postProcess( $css );
}

function cornerstone_post_process_color( $value ) {
  CS()->component('Color_Manager');
	return apply_filters('cs_css_post_process_color', $value);
}

function cornerstone_cleanup_generated_styles() {
  return CS()->component('Cleanup')->clean_generated_styles();
}

function cornerstone_queue_font( $font ) {
  return CS()->component('Font_Manager')->queue_font( $font );
}

function cornerstone_dynamic_content_register_field( $field ) {
  CS()->component('Dynamic_Content')->register_field( $field );
}

function cornerstone_dynamic_content_register_group( $group ) {
  CS()->component('Dynamic_Content')->register_group( $group );
}

function cs_dynamic_content_array( $content ) {
  return apply_filters( 'cs_dynamic_content_array', $content );
}

function cs_dynamic_content( $content ) {
  return apply_filters( 'cs_dynamic_content', $content );
}



/**
 * Deprecated
 */
function cornerstone_add_element( $class_name ) {
	CS()->component( 'Element_Orchestrator' )->add_mk1_element( $class_name );
}

function cornerstone_make_placeholder_pixel( $color = 'rgba(0, 0, 0, 0.35)' ) {
  return CS()->common()->placeholderImage( 1, 1, $color );
}

function cornerstone_make_placeholder_image_uri( $color = '#eeeeee', $height = null, $width = null ) {
	return CS()->common()->placeholderImage(
    is_null( $height ) ? apply_filters('cs_default_image_height', 48 ) : $height,
    is_null( $width ) ? apply_filters('cs_default_image_width', 48 ) : $width,
    $color
  );
}

function cornerstone_get_element( $name ) {
  return cs_get_element( $name );
}

function cornerstone_register_element( $type, $atts, $deprecated = null ) {
  if ( null !== $deprecated || is_string( $atts ) ) {
    /**
     * Override for old method. Register a new element
     * @param  $class_name Name of the class you've created in definition.php
     * @param  $name       slug name of the element. "alert" for example.
     * @param  $path       Path to the folder containing a definition.php file.
     */
  	CS()->component( 'Element_Orchestrator' )->add( $type, $atts, $deprecated );
    return;
  }

  cs_register_element( $type, $atts );
}

function cornerstone_remove_element( $name ) {
	CS()->component( 'Element_Orchestrator' )->remove( $name );
}

function cornerstone_register_integration( $name, $class_name ) {
  trigger_error( "cornerstone_register_integration is deprecated", E_USER_WARNING );
}

function cornerstone_unregister_integration( $name ) {
  trigger_error( "cornerstone_unregister_integration is deprecated", E_USER_WARNING );
}

function cornerstone_options_get_defaults() {
  trigger_error( "cornerstone_options_get_defaults is deprecated", E_USER_WARNING );
  return array();
}

function cornerstone_options_get_default( $name ) {
  trigger_error( "cornerstone_options_get_default is deprecated", E_USER_WARNING );
  return '';
}

function cornerstone_options_get_value( $name ) {
  trigger_error( "cornerstone_options_get_value is deprecated", E_USER_WARNING );
  return '';
}

function cornerstone_options_update_value( $name, $value ) {
  trigger_error( "cornerstone_options_update_value is deprecated", E_USER_WARNING );
  return '';
}

function cornerstone_options_register_section( $name, $value = array() ) {
  trigger_error( "cornerstone_options_register_section is deprecated", E_USER_WARNING );
}

function cornerstone_options_register_sections( $groups ) {
  trigger_error( "cornerstone_options_register_sections is deprecated", E_USER_WARNING );
}

function cornerstone_options_register_control( $option_name, $control ) {
  trigger_error( "cornerstone_options_register_control is deprecated", E_USER_WARNING );
}

function cornerstone_options_unregister_option( $name ) {
  trigger_error( "cornerstone_options_unregister_option is deprecated", E_USER_WARNING );
}

function cornerstone_options_unregister_section( $name ) {
  trigger_error( "cornerstone_options_unregister_section is deprecated", E_USER_WARNING );
}

function cornerstone_options_unregister_control( $option_name ) {
  trigger_error( "cornerstone_options_unregister_control is deprecated", E_USER_WARNING );
}

function cornerstone_options_enable_custom_css( $option_name, $selector = '' ) {
  trigger_error( "cornerstone_options_enable_custom_css is deprecated", E_USER_WARNING );
}

function cornerstone_options_enable_custom_js( $option_name ) {
  trigger_error( "cornerstone_options_enable_custom_js is deprecated", E_USER_WARNING );
}
