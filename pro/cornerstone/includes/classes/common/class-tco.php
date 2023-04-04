<?php

/**
 * Loads the Themeco shared library
 */

class Cornerstone_Tco extends Cornerstone_Plugin_Component {

	public function setup() {
		add_action( 'init', array( $this, 'tco_init' ) );
		add_action( 'admin_init', array( $this, 'tco_init' ) );
	}

	public function tco_init() {

		tco_common()->init( array(
			'url' => $this->url( 'assets/tco' )
		) );

	}

}
