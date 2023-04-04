<?php

if (function_exists( 'wpforms' )) {
  require_once( CS()->path( 'includes/integration/wpforms.php' ) );
}

if ( class_exists( 'WPCF7_ContactForm' ) ) {
  require_once( CS()->path( 'includes/integration/contact-form-7.php' ) );
}

if ( class_exists( 'RGFormsModel' ) ) {
  require_once( CS()->path( 'includes/integration/gravityforms.php' ) );
}

if ( class_exists( 'Vc_Manager' ) ) {
  require_once( CS()->path( 'includes/integration/wp-bakery.php' ) );
}

if ( class_exists( 'ACF' ) ) {
  require_once( CS()->path( 'includes/integration/acf.php' ) );
}
