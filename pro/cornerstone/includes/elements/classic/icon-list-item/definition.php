<?php

/**
 * Element Definition: Icon List Item
 */

class CSE_Icon_List_Item {

	public function ui() {
		return array(
      'title'       => __( 'Icon List Item', 'cornerstone' ),
    );
	}

	public function flags() {
		return array(
      'alt_breadcrumb' => __( 'Item', 'cornerstone' ),
			'library' => false,
      'protected_keys' => array(
        'title',
        'link_url',
        'link_title',
        'link_new_tab',
			),
			'label_key' => 'title'
		);
	}

	public function register_shortcode() {
  	return false;
  }

	public function update_build_shortcode_atts( $atts ) {
		$atts['content'] = $atts['title'];
		return $atts;
	}
}
