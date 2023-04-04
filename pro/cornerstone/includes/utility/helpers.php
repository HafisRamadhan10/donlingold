<?php

// Generate HTML Attributes
// =============================================================================
// 01. Merge all incoming arguments together
// 02. Treat strings as JSON and decode before merging
// 03. Additional consideration when merging the class attribute
// 04. Combine the output into a string
// 05. Values that are explicitly set to false will be omitted
// 06. When attribute is null, treat as an attribute without a value [ 'data-thing' => null ] becomes "data-thing"
// 07. Create attribute name/value pair

function cs_ensure_class_array( $input ) {
  if ( is_string($input ) ) {
    return array_filter( explode(' ', $input ) );
  }

  return array_reduce($input,function($acc,$next) {
    $items = cs_ensure_class_array( $next );
    foreach( $items as $item ) {
      if ( is_array($item ) ) {
        $acc = array_merge( $acc, cs_ensure_class_array( $input ) ) ;
      } else {
        $acc[] = $item;
      }
    }
    return $acc;
  }, []);
}

function cs_atts_merge( $args ) {

  $merged = array();
  foreach($args as $set) { // 01
    if (is_string($set)) {
      $set = json_decode( $set, true ); // 02
    }
    if (!is_array($set)) {
      continue;
    }
    if (isset($merged['class']) && isset($set['class']) ) { // 03
      $set['class'] = array_unique(array_merge( cs_ensure_class_array( $merged['class']), cs_ensure_class_array( $set['class'])));
    }
    $merged = array_merge( $merged, $set );
  }

  return $merged;
}

function cs_atts_flatten($merged) {
  $results = [];

  foreach ( $merged as $attr => $value ) { // 04

    if ($value === false) { // 05
      continue;
    }

    if ( is_null( $value ) ) { // 06
      $results[] = esc_attr($attr);
    } else {
      $results[] = esc_attr($attr) . '="' . esc_attr( is_array( $value ) ? implode( ' ', array_filter( $value ) ) : $value ) . '"'; // 07
    }

  }

  return implode(' ', $results);
}

function cs_atts() {
  return cs_atts_flatten(cs_atts_merge(func_get_args()));
}

// Generate HTML Tag
// =============================================================================
// 01. First argument is the tag like "div"
// 02. Last argument represents the tag contents. Here is how the types are handled:
//       true       - self closing
//       false/null - no children
//       string     - direct output
//       array      - combine
// 03. Intermediate arguments are passed to x_atts allowing multiple sets of attributes to be passed in
// 04. When children is explicitly true, return a self closing tag
// 05. When children is explicitly false or null, return an empty tag
// 06. Combine array children if needed. Default array_filter omits 0 and '0' which might be valid output
// 07. Final string output

// Example usage:
//  cs_tag( 'div', [ 'class' => ['hello', 'world'] ], 'content' ); yields <div class="hello world">content</div>
//  cs_tag( 'div', [ 'class' => 'one', ['first', 'second'] ); yields <div class="one">firstsecond</div>
//  cs_tag( 'div', [ 'class' => 'one' ], [ 'class' => 'two', 'style' => 'display:none;' ], null ); yeilds <div class="one two" style="display:none;"></div>
//  cs_tag( 'br', true); yields <br/>

function cs_tag() { // $tag, ...$atts, $children
  $args = func_get_args();
  $tag = array_shift( $args ); // 01
  $content = array_pop( $args ); // 02

  $atts = cs_atts_merge( $args );
  $atts_str = cs_atts_flatten( $atts );

  if ( $content === true ) { // 04
    return "<$tag $atts_str/>";
  }

  if ( $content === false || $content === null ) { // 05
    return "<$tag $atts_str></$tag>";
  }

  if ( is_array( $content ) ) { // 06
    $content = implode( '', array_filter( $content, function( $child ) { return $child !== null;  } ) );
  }

  $atts = apply_filters('cs_tag_atts', $atts, $content );
  $content = apply_filters('cs_tag_content', $content, $atts );

  return "<$tag $atts_str>$content</$tag>"; // 07
}

function cs_open_tag( $tag, $atts = [], $atts_str = '') {
  $_atts_str = cs_atts($atts) . ' ' . $atts_str;
  return "<$tag $_atts_str>";
}

function csi18n( $key ) {
	return CS()->i18n( $key );
}

function e_csi18n( $key ) {
	echo csi18n( $key );
}

function cs_fa_all() {
  return CS()->common()->getFontIds();
}

/**
 * Get an HTML entity for an icon
 * @param  string $key Icon to lookup
 * @return string      HTML entity
 */

function fa_get_attr( $key ) {
  $icon = CS()->common()->getFontIcon( $key );
  return array(
    'attr' => 'data-x-icon-' . $icon[0],
    'unicode' => $icon[1],
    'entity'  => '&#x' . $icon[1] . ';'
  );
}

function fa_entity( $key ) {
  return fa_get_attr( $key )['entity'];
}

/**
 * Template function that returns a data attribute for an icon
 * @param  string $key Icon to lookup
 * @return string      Data attribute string that can be placed inside an element tag
 */
function fa_data_icon( $key ) {
  $icon = fa_get_attr( $key );
  return $icon['attr']. '="' . $icon['entity'] . '"';
}

/**
 * Get a posts excerpt without the_content filters being applied
 * This is useful if you need to retreive an excerpt from within
 * a shortcode.
 * @return string Post excerpt
 */

function cs_get_excerpt_for_social( $post = null) {

	// Swap wp_trim_excerpt for cs_trim_excerpt_for_social
	add_filter( 'get_the_excerpt', 'cs_trim_excerpt_for_social' );
	remove_filter( 'get_the_excerpt', 'wp_trim_excerpt' );

	$excerpt = get_the_excerpt( $post );

	// Restore original WordPress behavior
	add_filter( 'get_the_excerpt', 'wp_trim_excerpt' );
	remove_filter( 'get_the_excerpt', 'cs_trim_excerpt_for_social' );

	return $excerpt;
}

/**
 * Themeco customized version of the wp_trim_excerpt function in WordPress formatting.php
 * Generates an excerpt from the content, if needed.
 *
 * @param string $text Optional. The excerpt. If set to empty, an excerpt is generated.
 * @return string The excerpt.
 */

function cs_trim_excerpt_for_social( $text = '' ) {

	$raw_excerpt = $text;

	if ( '' === $text ) {

		$text = get_the_content( '' );
		$text = strip_shortcodes( $text );

		$text = str_replace( ']]>', ']]&gt;', $text );

		$excerpt_length = apply_filters( 'excerpt_length', 55 );

		$excerpt_more = apply_filters( 'excerpt_more', ' [&hellip;]' );
		$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
	}

	return apply_filters( 'wp_trim_excerpt', $text, $raw_excerpt );

}


function cs_expand_content( $content = '' ) {
  return apply_filters( 'cs_expand_content', $content );
}

function cs_expand_content_no_wp( $content = '' ) {
  return apply_filters( 'cs_expand_content_no_wp', $content );
}

// Get Unitless Milliseconds
// =============================================================================
// 01. If unit is "seconds", multiply by 1000 to get millisecond value.
// 02. Fallback if we fail.

function cs_get_unitless_ms( $duration = '500ms' ) {

  $unit_matches = array();

  if ( preg_match( '/(s|ms)/', $duration, $unit_matches ) ) {

    $duration_unit = $unit_matches[0];
    $duration_num  = floatval( preg_replace( '/' . $duration_unit . '/', '', $duration ) );

    if ( $duration_unit === 's' ) {
      $duration_num = $duration_num * 1000; // 01
    }

    $the_duration = $duration_num;

  } else {

    $the_duration = 500; // 02

  }

  return $the_duration;

}



// Data Attribute Generator
// =============================================================================

function cs_prepare_json_att( $atts, $filter = false ) {
  return htmlspecialchars( wp_json_encode( $filter ? array_filter( $atts, 'strlen' ) : $atts ), ENT_QUOTES, 'UTF-8' );
}

function cs_element_js_atts( $element, $params = array(), $inline = false ) {

  if ($inline) {
    // We should move all old elements to the "inline" version since cs_atts already handles escaping, and the JS would be less redundant
    $atts['data-x-element-' . $element ] = empty( $params ) ? '' : cs_prepare_json_att( $params );
  } else {
    $atts = array( 'data-x-element' => esc_attr( $element ) );

    if ( ! empty( $params ) ) {
      $atts['data-x-params'] = cs_prepare_json_att( $params );
    }
  }



  return $atts;

}

// Notes
// -----
// 01. Must only start with `x-effect-exit` class because if we add in the
//     "out" animation on load, if using something like "hinge," the default
//     position that is used might be WAYYYYYY down from the actual position
//     of the button. Starting with only the `x-effect-exit` class gives us the
//     correct starting position.

function cs_apply_effect( $atts, $_cd, $options = [] ) {
  $json_data                   = [];
  $has_effect_provider         = isset($_cd['effects_provider'] )    && $_cd['effects_provider']    === true;
  $has_effect_alt              = isset($_cd['effects_alt'] )         && $_cd['effects_alt']         === true;
  $has_effect_scroll           = isset($_cd['effects_scroll'] )      && $_cd['effects_scroll']      === true;
  $has_effect_transform_alt    = isset($_cd['effects_type_alt'] )    && $_cd['effects_type_alt']    === 'transform';
  $has_effect_animation_alt    = isset($_cd['effects_type_alt'] )    && $_cd['effects_type_alt']    === 'animation';
  $has_effect_animation_scroll = isset($_cd['effects_type_scroll'] ) && $_cd['effects_type_scroll'] === 'animation';

  if ( $has_effect_scroll && ! apply_filters( 'cs_is_element_preview', false )) {
    if ( is_array( $atts['class'] ) ) {
      $atts['class'][] = 'x-effect-exit';
    } else {
      $atts['class'] .= ' x-effect-exit';
    }
  }

  if ( $has_effect_provider && isset( $_cd['effects_provider_targets'] ) ) {
    $atts['data-x-effect-provider'] = $_cd['effects_provider_targets'];
  }

  if ( $has_effect_alt || $has_effect_scroll ) {
    if ( $has_effect_alt ) {
      if ( $has_effect_transform_alt ) {
        $json_data['durationBase'] = $_cd['effects_duration'];
      }

      if ( $has_effect_animation_alt ) {
        $json_data['animationAlt'] = $_cd['effects_animation_alt'];
      }
    }

    if ( $has_effect_scroll ) {

      $json_data['scroll'] = true;
      $json_data['offsetTop']      = $_cd['effects_offset_top'];
      $json_data['offsetBottom']   = $_cd['effects_offset_bottom'];
      $json_data['behaviorScroll'] = $_cd['effects_behavior_scroll'];

      if ( $has_effect_animation_scroll ) {
        $json_data['animationEnter'] = $_cd['effects_animation_enter'];
        $json_data['animationExit']  = $_cd['effects_animation_exit'];
      }

      $force_scroll_effects = apply_filters( 'cs_preview_force_scroll_effects', '' );

      if ( $force_scroll_effects ) {
        $json_data['forceScrollEffect'] = $force_scroll_effects;
      }

    }


    return array_merge( $atts, [ 'data-x-effect' => cs_prepare_json_att( array_merge( $json_data, $options ) ) ] );

  }

  return $atts;
}

// Notes
// -----
// 01. Applies the link attributes to an element.

function cs_apply_link( $atts, $_cd, $k_pre ) {

  if ( isset( $_cd["{$k_pre}_href"]) && ! empty( $_cd["{$k_pre}_href"] ) ) {
    $atts['href'] = $_cd["{$k_pre}_href"];
  }

  if ( isset( $_cd["{$k_pre}_nofollow"] ) && $_cd["{$k_pre}_nofollow"] === true ) {
    $atts['rel'] = 'nofollow';
  }

  if ( isset( $_cd["{$k_pre}_blank"] ) && $_cd["{$k_pre}_blank"] === true ) {
    $atts['target'] = '_blank';
    $atts = cs_atts_with_targeted_link_rel( $atts );
  }

  return $atts;

}



// Data Attribute Generator - Legacy Shortcodes
// =============================================================================

function cs_generate_data_attributes( $element, $params = array(), $inline = false ) {
  return cs_atts( cs_element_js_atts( $element, $params, $inline ) );
}

function cs_generate_data_attributes_extra( $type, $trigger, $placement, $title = '', $content = '' ) {

	if ( ! in_array( $type, array( 'tooltip', 'popover' ), true ) ) {
		return '';
	}

	$js_params = array(
		'type'      => ( 'tooltip' === $type ) ? 'tooltip' : 'popover',
		'trigger'   => $trigger,
		'placement' => $placement,
		'title'     => wp_specialchars_decode( $title ), // to avoid double encoding.
		'content'   => wp_specialchars_decode( $content ),
	);

	return cs_generate_data_attributes( 'extra', $js_params );

}



// Background Video Output
// =============================================================================

function cs_bg_video( $video, $poster, $loop = true ) {

	$output = do_shortcode( '[x_video_player class="bg transparent" src="' . $video . '" poster="' . $poster . '" hide_controls="true" autoplay="true"'.( $loop ? ' loop="true"' : '' ).' muted="true" no_container="true"]' );

	return $output;

}








// Animation Base Class
// =============================================================================

function cs_animation_base_class( $animation_string ) {

	if ( false !== strpos( $animation_string, 'In' ) ) {
		$base_class = ' animated-hide';
	} else {
		$base_class = '';
	}

	return $base_class;

}

/**
 * Sanitize a value for use in a shortcode attribute
 * @param  string $value Value to clean
 * @return string        Value ready for use in shortcode markup
 */
function cs_clean_shortcode_att( $value ) {

  if ( ! is_scalar( $value ) ) {
    return '';
  }

	$value = wp_kses( $value, wp_kses_allowed_html( 'post' ) );
	$value = esc_html( $value );
	$value = str_replace( ']', '&rsqb;', str_replace( '[', '&lsqb;', $value ) );

	return $value;
}

/**
 * Remove <p> and <br> tags added by wpautop around shortcodes.
 * This is used for anything within a Cornerstone section to keep
 * the markup clean and predictable.
 * @param  string $content Content to be cleaned
 * @return string          Cleaned content
 */

function cs_shortcode_att( $attribute, $content, $echo = false ) {

	$att = '';

	if ( $content ) {
		$att = esc_attr( $attribute ) . '="' . cs_clean_shortcode_att( $content ) . '" ';
	}

	if ( is_null( $content ) ) {
		$att = esc_attr( $attribute ) . ' ';
	}

	if ( $echo ) {
		echo $att;
	}

	return $att;

}

function cs_shortcode_atts( $atts, $echo = false ) {
	$result = '';
	foreach ( $atts as $att => $content) {
		$result .= cs_shortcode_att( $att, $content, false );
	}
	if ( $echo ) {
		echo $result;
	}
	return $result;
}

// Build Shortcode
// =============================================================================

function cs_build_shortcode( $name, $attributes, $extra = '', $content = '', $require_content = false ) {

	$output = "[{$name} " . cs_shortcode_atts( $attributes );

	if ( '' !== $extra ) {
		$output .= " {$extra}";
	}

	if ( '' === $content && ! $require_content ) {
		$output .= ']';
	} else {
    $content = apply_filters( 'cs_element_update_build_shortcode_content', $content, null );
		$output .= "]{$content}[/{$name}]";
	}

	return $output;

}


function cs_render_shortcode( $name, $attributes, $extra = '', $content = '', $require_content = false ) {
  return cs_expand_content( cs_build_shortcode( $name, $attributes, $extra, $content, $require_content ) );
}


function cs_alias_shortcode( $new_tag, $existing_tag, $filter_atts = true ) {

  global $cs_shortcode_aliases;

  if ( ! $cs_shortcode_aliases ) {
    $cs_shortcode_aliases = array();
  }

	if ( is_array( $new_tag ) ) {
		foreach ($new_tag as $tag) {
			cs_alias_shortcode( $tag, $existing_tag, $filter_atts );
		}
		return;
	}

	if ( ! shortcode_exists( $existing_tag ) ) {
		return;
	}

	global $shortcode_tags;
	add_shortcode( $new_tag, $shortcode_tags[ $existing_tag ] );

  if ( ! in_array($new_tag, $cs_shortcode_aliases) ) {
    $cs_shortcode_aliases[] = $new_tag;
  }

  if ( ! in_array($existing_tag, $cs_shortcode_aliases) ) {
    $cs_shortcode_aliases[] = $existing_tag;
  }


	if ( ! $filter_atts || ! has_filter( $tag = "shortcode_atts_$existing_tag" ) ) {
		return;
	}

	global $wp_filter;

	foreach ( $wp_filter[ $tag ] as $priority => $filter ) {
		foreach ($filter as $tag => $value) {
			add_filter( "shortcode_atts_$new_tag", $value['function'], $priority, $value['accepted_args'] );
		}
	}

}

function cs_array_filter_use_keys( $array, $callback ) {
	return array_intersect_key( $array, array_flip( array_filter( array_keys( $array ), $callback ) ) );
}

/**
 * Runs wp_parse_args, then applies key whitelisting based on keys from defaults
 * @param  array $args     User arguments
 * @param  array $defaults Default keys ans values
 * @return array           Arguments with defaults and key whitelisting applied.
 */
function cs_define_defaults( $args, $defaults ) {
	return array_intersect_key( wp_parse_args( $args, $defaults ), array_flip( array_keys( $defaults ) ) );
}



function cs_noemptyp( $content ) {

	$array = array(
		'<p>['    => '[',
		']</p>'   => ']',
		']<br />' => ']',
	);

	$content = strtr( $content, $array );

	return $content;

}


/**
 * Wrap wp_send_json_success allowing for a filterable response
 * @param mixed $data Data to encode as JSON, then print and die.
 */
function cs_send_json_success( $data = null ) {

	$response = array( 'success' => true );

	if ( isset( $data ) ) {
		$response['data'] = $data;
	}

	wp_send_json( apply_filters( '_cornerstone_send_json_response', $response ) );

}

/**
 * Wrap wp_send_json_error allowing for a filterable response
 * @param mixed $data Data to encode as JSON, then print and die.
 */
function cs_send_json_error( $data = null ) {

	$response = array( 'success' => false );

	if ( isset( $data ) ) {
		if ( is_wp_error( $data ) ) {
			$result = array();
			foreach ( $data->errors as $code => $messages ) {
				foreach ( $messages as $message ) {
					$result[] = array( 'code' => $code, 'message' => $message );
				}
			}

			$response['data'] = $result;
		} else {
			$response['data'] = $data;
		}
	}

	wp_send_json( apply_filters( '_cornerstone_send_json_response', $response ) );

}

/**
 * Allows HTML to be passed through shortcode attributes by decoding entities.
 * We apply the cs_decode_shortcode_attribute filter to allow other
 * components to process and expand directives if needed.
 * @param  string $content Original content from shortcode attribute.
 * @return string          HTML ready to use in shortcode output
 */
function cs_decode_shortcode_attribute( $content ) {
  if ( ! is_string( $content ) ) {
    return $content;
  }
	return apply_filters( 'cs_decode_shortcode_attribute', wp_specialchars_decode( $content, ENT_QUOTES ) );
}


function cs_update_serialized_post_meta( $post_id, $meta_key, $meta_value, $prev_value = '', $allow_revision_updates = false, $filter = '' ) {


	if ( is_array( $meta_value ) && apply_filters( 'cornerstone_store_as_json', true ) ) {
		$meta_value = wp_slash( cs_json_encode( $meta_value ) );
	}

  if ( $filter ) {
    $meta_value = apply_filters( $filter, $meta_value );
  }

  if ( $allow_revision_updates ) {
    return update_metadata('post', $post_id, $meta_key, $meta_value, $prev_value );
  }

	return update_post_meta( $post_id, $meta_key, $meta_value, $prev_value );

}


function cs_json_encode( $value ) {

  if ( apply_filters( 'cornerstone_json_unescaped_slashes', true ) ) {
    return wp_json_encode( $value, JSON_UNESCAPED_SLASHES );
  }

  return wp_json_encode( $value );

}

function cs_get_serialized_post_meta( $post_id, $key = '', $single = false, $filter = '' ) {
  $meta_value = get_post_meta( $post_id, $key, $single );
  if ( $filter ) {
    $meta_value = apply_filters( $filter, $meta_value );
  }
  return apply_filters('cs_get_serialized_post_meta', cs_maybe_json_decode( $meta_value ), $post_id, $key );
}

function cs_maybe_json_decode( $value ) {
	if ( is_string( $value ) ) {
		$value = json_decode( $value, true );
	}
	return $value;
}

function cs_to_component_name( $name ) {
  return str_replace( ' ', '_', ucwords( strtolower( preg_replace('/[-_:\/]/', ' ', str_replace(' ', '', $name ) ) ) ) );
}


/**
 * Add 'noopener noreferrer' to a string if it doesn't exist yet
 */
function cs_targeted_link_rel( $rel = '', $is_target_blank = true ) {

	if ( $is_target_blank && apply_filters( 'tco_targeted_link_rel', ! is_ssl() ) ) {

		$more = apply_filters( 'tco_targeted_link_rel', array( 'noopener', 'noreferrer' ) );

		foreach ($more as $str ) {
			if ( false === strpos($rel, $str ) ) {
				$rel .= " $str";
			}
		}

	}

	return ltrim($rel);

}


function cs_atts_for_social_sharing( $atts, $type, $title ) {
	return CS()->component('Social')->setup_atts( $atts, $type, $title );
}

/**
 * Maybe add rel att
 */
function cs_atts_with_targeted_link_rel( $atts = array(), $is_target_blank = true ) {

	$rel = cs_targeted_link_rel( isset($atts['rel']) ? $atts['rel'] : '', $is_target_blank );

	if ( $rel ) {
		$atts['rel'] = $rel;
	}

	return $atts;
}

function cs_output_target_blank($echo = true) {
	$output = 'target="_blank" rel="' . cs_targeted_link_rel() .'"';
	if ($echo) {
		echo $output;
	}
	return $output;
}

function cs_get_countdown_labels( $plural = true, $compact = false ) {
	if ($compact) {
		return array(
			'd' => __( 'D', 'cornerstone' ),
			'h' => __( 'H', 'cornerstone' ),
			'm' => __( 'M', 'cornerstone' ),
			's' => __( 'S', 'cornerstone' )
		);
	}

	return array(
    'd' => _n( 'Day', 'Days', $plural ? 2 : 1, 'cornerstone' ),
    'h' => _n( 'Hour', 'Hours', $plural ? 2 : 1, 'cornerstone' ),
    'm' => _n( 'Minute', 'Minutes', $plural ? 2 : 1, 'cornerstone' ),
    's' => _n( 'Second', 'Seconds', $plural ? 2 : 1, 'cornerstone' )
	);
}


function cs_make_particle( $data, $class, $k_pre, $always_active ) {

  if ( ! isset( $data[$k_pre] ) || ! $data[$k_pre] ) {
    return '';
  }

  // x_preview_props doesn't work here anymore because by the time we get to this level, key prefixes have been removed
  // in the preview, everything is "undefined" because it doesn't map to the original element key

  // $args = cs_extract( x_preview_props([
  //   $k_pre . '_location',
  //   $k_pre . '_placement',
  //   $k_pre . '_scale',
  //   $k_pre . '_style',
  // ], $data), [ $k_pre => 'particle' ] );

  $args = cs_extract( $data, [ $k_pre => 'particle' ] );

  $particle_class = $always_active ? 'is-' . $class . ' x-always-active' : 'is-' . $class;
  $particle_scale = ( $args['particle_scale'] != 'none'  ) ? $args['particle_scale'] . ' ' : '';

  $atts = [
    'class'           => [ 'x-particle', $particle_class ],
    'data-x-particle' => $particle_scale . $args['particle_placement'] . '-' . $args['particle_location'],
    'aria-hidden'     => 'true',
  ];

  return cs_tag( 'span', $atts, cs_tag('span', [ 'style' => $args['particle_style'] ], '' ) );

}


function cs_make_particles( $data, $k_pre, $primary_always_active = false, $secondary_always_active = false ) {

  $primary = cs_make_particle( $data, 'primary', $k_pre . '_primary_particle', $primary_always_active );
  $secondary = cs_make_particle( $data, 'secondary', $k_pre . '_secondary_particle', $secondary_always_active );
  return $primary . $secondary;

}

function cs_make_bg( $data, $k_pre = '' ) {
  $pre = $k_pre ? $k_pre . '_' : '';
  return cs_get_partial_view( 'bg',
    cs_extract(
      x_preview_props([
        $pre . 'bg_lower_color',
        $pre . 'bg_lower_image_repeat',
        $pre . 'bg_lower_image_size',
        $pre . 'bg_lower_image_position',
        $pre . 'bg_lower_img_alt',
        $pre . 'bg_lower_img_object_fit',
        $pre . 'bg_lower_img_object_position',
        $pre . 'bg_lower_custom_aria_hidden',
        $pre . 'bg_upper_color',
        $pre . 'bg_upper_image_repeat',
        $pre . 'bg_upper_image_size',
        $pre . 'bg_upper_image_position',
        $pre . 'bg_upper_img_alt',
        $pre . 'bg_upper_img_object_fit',
        $pre . 'bg_upper_img_object_position',
        $pre . 'bg_upper_custom_aria_hidden',
        $pre . 'bg_border_radius',
      ], $data ),
      $k_pre ? [ "{$k_pre}_bg" => 'bg'] : [ 'bg' => '' ]
    )
  );
}


function cs_anchor_text_content( $_cd, $type = 'main' ) {

  $p_atts = array( 'class' => 'x-anchor-text-primary'   );
  $s_atts = array( 'class' => 'x-anchor-text-secondary' );

  if ( $_cd['anchor_text_interaction'] != 'none' ) {
    $the_interaction              = str_replace( 'anchor-', '', $_cd['anchor_text_interaction'] );
    $p_atts['data-x-single-anim'] = $the_interaction;
    $s_atts['data-x-single-anim'] = $the_interaction;
  }

  $p_text     = ( $type == 'main' ) ? $_cd['anchor_text_primary_content']   : $_cd['anchor_interactive_content_text_primary_content'];
  $s_text     = ( $type == 'main' ) ? $_cd['anchor_text_secondary_content'] : $_cd['anchor_interactive_content_text_secondary_content'];
	$tag = ( $type == 'main' ) ? 'span' : 'div';
	$p_markup   = ( ! empty( $p_text ) ) ? '<' . $tag . ' ' . cs_atts( $p_atts ) . '>' . $p_text . '</' . $tag . '>' : '';
  $s_markup   = ( ! empty( $s_text ) ) ? '<' . $tag . ' ' . cs_atts( $s_atts ) . '>' . $s_text . '</' . $tag . '>' : '';
  $the_order  = ( $_cd['anchor_text_reverse'] == true ) ? $s_markup . $p_markup : $p_markup . $s_markup;
  $the_markup = ( ! empty( $p_markup ) || ! empty( $s_markup ) ) ? '<div class="x-anchor-text">' . $the_order . '</div>' : '';

  return $the_markup;

}

function cs_bg_layer( $_cd, $layer, $hide_lower, $hide_upper, $hide_all ) {

  $k_pre    = "bg_{$layer}_";
  $the_type = $_cd["{$k_pre}type"];


  // No Output
  // ---------

  if ( empty( $the_type ) || is_null( $the_type ) || $the_type === 'none' ) {
    return null;
  }


  // Setup
  // -----

  $hide_this_layer  = $layer === 'lower' ? $hide_lower : $hide_upper;
  $bg_layer_content = '';
  $bg_layer_atts    = array(
    'class' => 'x-bg-layer-' . $layer . '-' . $the_type,
  );

  if ( $hide_this_layer && ! $hide_all ) {
    $bg_layer_atts['aria-hidden'] = 'true';
  }


  // Parallax
  // --------

  $the_p_bool = $_cd["{$k_pre}parallax"];

  if ( $the_p_bool && $the_type !== 'none' && $the_type !== 'color' ) {
    $the_p_size = $_cd["{$k_pre}parallax_size"];
    $the_p_dir  = $_cd["{$k_pre}parallax_direction"];
    $the_p_rev  = $_cd["{$k_pre}parallax_reverse"];

    $bg_layer_data = array( 'parallaxSize' => $the_p_size, 'parallaxDir' => $the_p_dir, 'parallaxRev' => $the_p_rev );
    $bg_layer_atts = array_merge( $bg_layer_atts, cs_element_js_atts( 'bg-layer', $bg_layer_data, true ) );
  }


  // Content
  // -------

  switch ( $the_type ) {

    // Color
    // -----

    case 'color' :
      $bg_layer_atts['style'] = ' background-color: ' . cornerstone_post_process_color( $_cd["{$k_pre}color"] ) . ';';
      break;


    // Image
    // -----

    case 'image' :
      $the_image_url      = $_cd["{$k_pre}image"];
      $the_image_repeat   = $_cd["{$k_pre}image_repeat"];
      $the_image_position = $_cd["{$k_pre}image_position"];
      $the_image_size     = $_cd["{$k_pre}image_size"];
      if ($the_image_url) {
        $image_atts         = cs_apply_image_atts( [ 'src' => $the_image_url ] );
        $bg_layer_atts['style'] = ' background-image: url(' . $image_atts['src'] . '); background-repeat: ' . $the_image_repeat . '; background-position: ' . $the_image_position . '; background-size: ' . $the_image_size . ';';
      }

      break;


    // <img/>
    // ------

    case 'img' :
      $the_img_src             = $_cd["{$k_pre}img_src"];
      $the_img_alt             = $_cd["{$k_pre}img_alt"];
      $the_img_object_fit      = $_cd["{$k_pre}img_object_fit"];
      $the_img_object_position = $_cd["{$k_pre}img_object_position"];

      $bg_layer_img_atts = cs_apply_image_atts( [ 'src' => $the_img_src, 'alt' => $the_img_alt ] );

      unset($bg_layer_img_atts['width']);
      unset($bg_layer_img_atts['height']);

      $bg_layer_img_atts['style'] = 'object-fit: ' . $the_img_object_fit . '; object-position: ' . $the_img_object_position . ';';

      $bg_layer_content = '<img ' . cs_atts( $bg_layer_img_atts ) . '/>';
      break;


    // Video
    // -----

    case 'video' :
      $video_src = cs_expand_content( $_cd["{$k_pre}video"] );
      $video_poster = cs_expand_content( $_cd["{$k_pre}video_poster"] );
      $bg_layer_content = ( function_exists( 'cs_bg_video' ) ) ? cs_bg_video( $video_src, $video_poster, $_cd["{$k_pre}video_loop"] ) : '';
      break;


    // Custom
    // ------

    case 'custom' :
      $bg_layer_content = $_cd["{$k_pre}custom_content"];
      break;

  }

  return cs_tag( 'div', $bg_layer_atts, $bg_layer_content);

}


function cs_get_disallowed_ids() {
  $skip = array();

	$page_for_posts = (int) get_option( 'page_for_posts' );

	if ($page_for_posts > 0) {
		$skip[] = $page_for_posts;
	}

  if ( function_exists('wc_get_page_id') ) {
		$shop_page_id = (int) wc_get_page_id( 'shop' );
		if ( $shop_page_id > 0) {
			$skip[] = $shop_page_id;
		}
  }

  return $skip;
}

function cs_make_options_from_object($obj) {
	$options = [];

	foreach ($obj as $value => $label) {
		$options[] = ['value' => $value, 'label' => $label];
	}

	return $options;
}

function cs_get_page_template_options( $post_type = 'page', $post = null) {
	$page_templates = wp_get_theme()->get_page_templates( $post, $post_type );
	ksort( $page_templates );

	return array_merge(array( array(
		'value' => 'default', 'label' => apply_filters( 'default_page_template_title',  __( 'Default Template' ), 'cornerstone' )
	)), cs_make_options_from_object( $page_templates ) );
}

function cs_get_post_status_options() {
	return cs_make_options_from_object(get_post_statuses());
}

function cs_get_post_format_options() {
	return cs_make_options_from_object(get_post_format_strings());
}

function cs_get_wp_roles_options() {

	$wp_roles = wp_roles();
	$roles = array();

	foreach ($wp_roles->roles as $key => $value) {
		$roles[] = array( 'value' => $key, 'label' => $value['name'] );
	}

	return $roles;

}

// Action Defer Helper
// =============================================================================

function cs_action_defer( $action, $function, $args = array(), $priority = 10, $array_args = false  ) {
  CS_Action_Defer::defer( $action, $function, $args, $priority, $array_args );
}



// Action Defer Class
// =============================================================================

class CS_Action_Defer {

  static $instance;

  public $memory = array();


  // Route
  // -----

  public function add_action( $action, $function, $args = array(), $priority = 10, $array_args = false ) {

    if ( ! isset( $this->memory[$action] ) ) {
      $this->memory[$action] = array();
    }

    $key = $this->generate_key( array( $action, $priority ) );

    while ( isset( $this->memory[$action][$key] ) ) {
      $key = $this->generate_key( array( $action, $priority++ ) );
    }

    $this->memory[$action][$key] = array( $function, $array_args ? $args : array( $args ) );

    add_action( $action, array( $this, $key ), $priority );

  }


  // Generate Key
  // ------------

  public function generate_key( $array ) {
    return $this->sanitize( implode( '_', $array ) );
  }


  // Call
  // ----

  public function __call( $name, $args ) {

    $action = current_filter();

    if ( ! isset( $this->memory[$action] ) || ! isset( $this->memory[$action][$name] ) ) {
			return;
    }

    $recalled = $this->memory[$action][$name];

    if ( is_callable( $recalled[0] ) ) {
      call_user_func_array( $recalled[0], is_array( $recalled[1] ) ? $recalled[1] : array() );
    }

  }


  // Sanitize
  // --------

  public function sanitize( $key ) {
    return preg_replace( '/[^a-z0-9_]/', '', strtolower( str_replace( '-', '_', $key ) ) );
  }


  // Set
  // ---

  public static function defer( $action, $function, $args = array(), $priority = 10, $array_args = false  ) {

    if ( ! isset( self::$instance ) ) {
      self::init();
    }

    return self::$instance->add_action( $action, $function, $args, $priority, $array_args );

  }

  // Init
  // ----

  public static function init() {
    if ( ! isset( self::$instance ) ) {
      self::$instance = new self();
    }
  }

}




// Element Views
// =============================================================================

function cs_render_view( $_template_file, $_view_data = array()) {

  global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $comment, $user_ID;

  if ( is_array( $wp_query->query_vars ) ) {
    extract( $wp_query->query_vars, EXTR_SKIP );
  }

  if ( isset( $s ) ) {
    $s = esc_attr( $s );
  }

  $_extractable_data = ( is_callable( $_view_data ) ) ? call_user_func( $_view_data ) : $_view_data;

  if ( is_array( $_extractable_data ) ) {
    extract( $_extractable_data );
  }

  include( $_template_file );

}

function cs_get_view( $path, $view_data = array(), $echo = true ) {

  $file = CS()->path( 'includes/views/' . $path . '.php' );

  if ( ! file_exists( $file ) ) {
    return;
  }

  ob_start();
  cs_render_view( $file, $view_data );
  $output = ob_get_clean();

  if ( $echo ) {
    echo $output;
  }

  return $output;

}


function cs_get_partial_view( $name, $data = array() ) {
  return cs_get_view( "partials/$name", $data, false );
}

function cs_defer_partial( $name, $data = array(), $priority = 100 ) {
  cs_defer_view('cs_deferred', "partials/$name", $data, $priority);
}

function cs_defer_view( $action, $path, $data = NULL, $priority = 10 ) {

  $content = apply_filters( 'cs_defer_view', cs_get_view( $path, $data, false ), $action, $data );

  add_action( $action, function() use ($content) {
    echo $content;
  }, $priority );

}
