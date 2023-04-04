<?php

/**
 * Element Definition: Pricing Table Column
 */

class CSE_Pricing_Table_Column {

	public function ui() {
		return array(
      'title'       => __( 'Pricing Table Column', 'cornerstone' ),
    );
	}

	public function flags() {
		return array(
			'library' => false,
			'empty_placeholder' => false,
      'protected_keys' => array(
        'title',
        'content',
        'featured_sub',
        'currency',
        'price',
        'interval',
			),
			'label_key' => 'title'
		);
	}

	public function register_shortcode() {
  	return false;
  }

	public function update_build_shortcode_atts( $atts ) {
		return $atts;
	}
}
