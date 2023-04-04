<?php

// =============================================================================
// FUNCTIONS/PRO/MIGRATION.PHP
// -----------------------------------------------------------------------------
// Handles theme migration.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Version Migration
//   02. Version Migration Notice
//   03. Theme Migration
// =============================================================================

// Version Migration
// =============================================================================

function pro_version_migration() {

  $prior = get_option( 'pro_version', false );


  // Store the version on first install
  // ----------------------------------

  if ( false === $prior ) {
    update_option( 'pro_version', X_VERSION, true );
    update_option( 'x_dismiss_update_notice', true );
    return;
  }

  // Run migrations
  // --------------

  pro_version_migration_1_1_0( $prior );


  // Operations run for every update
  // -------------------------------
  // 01. Update stored version number. Save as autoloading value.
  // 02. Enable validation reminder.
  // 03. Bust Google Font cache.
  // 04. Purge all generated CSS
  // 05. Don't show the update notice on new installs
  // 06. Show update notice after an update

  if ( version_compare( $prior, X_VERSION, '<' ) ) {

    update_option( 'pro_version', X_VERSION, true ); // 01
    delete_option( 'x_dismiss_validation_notice' );  // 02
    x_bust_google_fonts_cache();                     // 03

    do_action( 'cornerstone_updated', 999 );

    if ( false === $prior ) {
      update_option( 'pro_dismiss_update_notice', true ); // 05
    } else {
      delete_option( 'pro_dismiss_update_notice' ); // 06
    }
  }

}

add_action( 'init', 'pro_version_migration' );



//
// 1.1.0
//

function pro_version_migration_1_1_0( $prior ) {

  if ( version_compare( $prior, '1.1.0', '<' ) ) {

    $body_font_size    = intval( get_option( 'x_body_font_size', '14' ) );
    $content_font_size     = intval( get_option( 'x_content_font_size', '14' ) );
    $content_font_size_rem = round( $content_font_size / $body_font_size, 3 );

    $updated = array(
      'x_root_font_size_stepped_xs'  => get_option( 'x_root_font_size_stepped_xs', $body_font_size ),
      'x_root_font_size_stepped_sm'  => get_option( 'x_root_font_size_stepped_sm', $body_font_size ),
      'x_root_font_size_stepped_md'  => get_option( 'x_root_font_size_stepped_md', $body_font_size ),
      'x_root_font_size_stepped_lg'  => get_option( 'x_root_font_size_stepped_lg', $body_font_size ),
      'x_root_font_size_stepped_xl'  => get_option( 'x_root_font_size_stepped_xl', $body_font_size ),
      'x_root_font_size_scaling_min' => get_option( 'x_root_font_size_scaling_min', $body_font_size ),
      'x_root_font_size_scaling_max' => get_option( 'x_root_font_size_scaling_max', $body_font_size ),
      'x_content_font_size_rem'      => get_option( 'x_content_font_size_rem', $content_font_size_rem )
    );

    foreach ( $updated as $key => $value ) {
      update_option( $key, $value );
    }
  }

}


// Version Migration Notice
// =============================================================================

//
// 1. Output notice.
// 2. Dismiss notice.
//

function pro_version_migration_notice() { // 1

  if ( false === get_option( 'pro_dismiss_update_notice', false ) ) {

    tco_common()->admin_notice( array(
      'message' => sprintf(
        __( 'Congratulations, you&apos;ve successfully updated Pro! <strong><a href="%s" target="_blank">Release Notes</a></strong>.', '__x__' ),
        '//theme.co/release-notes/pro-' . str_replace('.','-', X_VERSION)
      ),
      'dismissible' => true,
      'ajax_dismiss' => 'pro_dismiss_update_notice'
    ) );

  }

}

add_action( 'admin_notices', 'pro_version_migration_notice' );


function pro_version_migration_notice_dismiss() { // 2

  update_option( 'pro_dismiss_update_notice', true );
  wp_send_json_success();

}

add_action( 'wp_ajax_pro_dismiss_update_notice', 'pro_version_migration_notice_dismiss' );

// Product Notice
// =============================================================================

function pro_product_notice_info() {
  return [
    '5.1',
    sprintf(
      __( 'Take the Slider Element to the next level with <strong><a href="%s" target="_blank">Modern Sliders</a></strong> — our new course and expansion pack!', '__x__' ),
      '//demo.theme.co/modern-sliders'
    )
  ];
}

function pro_product_notice() {

  if (strpos(X_VERSION,'-') !== false) { // ignore on prerelease builds
    return;
  }

  $stored = get_option( 'pro_dismiss_product_notice', false );

  if (false === $stored) {
    $stored = [];
  }

  list($version, $message) = pro_product_notice_info();

  if ( ! isset($stored[$version])) {

    tco_common()->admin_notice( array(
      'message' => $message,
      'dismissible' => true,
      'ajax_dismiss' => 'pro_dismiss_product_notice'
    ) );

  }

}

add_action( 'admin_notices', 'pro_product_notice' );


function pro_product_notice_dismiss() {

  $stored = get_option( 'pro_dismiss_product_notice', false );

  if (false === $stored) {
    $stored = [];
  }
  list($version) = pro_product_notice_info();
  $stored[$version] = true;

  update_option( 'pro_dismiss_product_notice', $stored );
  wp_send_json_success();

}

add_action( 'wp_ajax_pro_dismiss_product_notice', 'pro_product_notice_dismiss' );






// // Theme Migration
// // =============================================================================

// function pro_theme_migration( $new_name, $new_theme ) {

//   if ( $new_theme == 'Pro' || $new_theme->get( 'Template' ) == 'pro' ) {
//     return false;
//   }

//   // Leaving Pro

// }

// add_action( 'switch_theme', 'pro_theme_migration', 10, 2 );
