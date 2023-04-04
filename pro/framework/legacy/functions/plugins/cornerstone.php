<?php

// =============================================================================
// FUNCTIONS/GLOBAL/PLUGINS/CORNERSTONE.PHP
// -----------------------------------------------------------------------------
// Plugin setup for theme compatibility.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   01. MEJS [audio]
//   02. MEJS [video]
//   03. Validation Box Replacement
//   04. Validation Overlay Replacement
//   05. Hide X validation notice on Cornertstone home page
//   06. Remove Cornerstone Validation Notice
//   07. Cornerstone Home Scripts
//   08. Label Replacements
//   09. Typekit output hook
// =============================================================================

// Setup
// =============================================================================

add_filter( 'cornerstone_dashboard_home', '__return_false' );

add_action( 'after_setup_theme', function() {



});



// Builders / App
// =============================================================================


add_filter( 'cs_app_data', function( $data ) {

  $data['siteConfirmMessages'] = [
    'theme_options' => __( 'Installing a site (demo content) will not alter any of your pages or posts, but it will overwrite your Theme Options. This is not reversible unless you have previously made a backup of your settings. Are you sure you want to proceed?', 'cornerstone' )
  ];

  if ( ! class_exists( 'RevSlider' ) ) {
    $data['siteConfirmMessages']['revslider'] = sprintf( __( 'This Site utilizes Revolution Slider. <a href="%s" target="_blank">Install and activate this plugin</a> before continuing to enable slider functionality.', 'cornerstone' ), x_addons_get_link_home() . '#extensions' );
  }

  if ( ! function_exists( 'wpforms' ) ) {
    $data['siteConfirmMessages']['wpforms'] = sprintf( __( 'This Site utilizes WP Forms. <a href="%s" target="_blank">Install and activate this plugin</a> before continuing to enable contact form functionality.', 'cornerstone' ), x_addons_get_link_home() . '#approved-plugins' );
  }

  return $data;
});



// Front End
// =============================================================================


add_filter( 'cornerstone_scrolltop_selector', function() {
  return '.x-navbar-fixed-top';
});

add_filter( 'cs_link_selector', function() {
  return 'a[href*="#"]';
});

add_action( 'cornerstone_load_preview', function () {
  if ( defined( 'X_VIDEO_LOCK_VERSION' ) ) {
    remove_action( 'wp_footer', 'x_video_lock_output' );
  }
});

add_filter( 'cs_fa_config', function ( $fa ) {
  return array_merge( $fa, array(
    'fa_solid_enable'   => (bool) x_get_option( 'x_font_awesome_solid_enable' ),
    'fa_regular_enable' => (bool) x_get_option( 'x_font_awesome_regular_enable' ),
    'fa_light_enable'   => (bool) x_get_option( 'x_font_awesome_light_enable' ),
    'fa_brands_enable'  => (bool) x_get_option( 'x_font_awesome_brands_enable' ),
  ) );
} );


// Remove empty p and br HTML elements for legacy pages not using Cornerstone sections
// This is for compatibility with content created with X shortcodes
function x_cs_legacy_the_content( $the_content ) {

  if ( $the_content && function_exists('cs_noemptyp')) {

    global $cs_shortcode_aliases;

    if ( is_array($cs_shortcode_aliases) ) {
      $legacy = false;

      foreach ($cs_shortcode_aliases as $shortcode) {

        if ( false == strpos($the_content, "[$shortcode" ) ) {
          $legacy = true;
          break;
        }

      }

      if ( $legacy ) {
        return cs_noemptyp($the_content);
      }

    }
  }

  return $the_content;

}

add_filter( 'the_content', 'x_cs_legacy_the_content' );



// Admin
// =============================================================================


add_action( 'admin_menu', function() {

  // global $submenu;


  // $submenu['x-addons-home'][] = [
  //   //data-tco-admin-menu-divider
  //   '<span  class="tco-theme-options">' . csi18n( "common.title.options-theme" ) .'</span>',
  //   'manage_options',
  //   CS()->component('Admin')->get_theme_options_url()
  // ];

  // $submenu['x-addons-home'][] = [
  //   '<span class="tco-design-cloud">' . csi18n( "common.title.design-cloud" ) .'</span>',
  //   'manage_options',
  //   CS()->component('Admin')->get_theme_options_url()
  // ];


});

// Prevent Cornerstone from messaging about validation
add_filter('_cornerstone_integration_remove_global_validation_notice', '__return_true' );

add_filter( '_cs_validation_url', 'x_addons_get_link_home' );

add_filter( 'pre_option_cs_product_validation_key', function( $key ) {
  return get_option( 'x_product_validation_key', false );
} );

add_action( 'admin_init', function() {
  if ( ! has_action( '_cornerstone_home_not_validated' ) ) {
    add_action( '_cornerstone_home_not_validated', '__return_empty_string' );
  }
});


add_filter( 'cornerstone_config_common_default-settings', function ( $settings ) {
  $settings['enable_legacy_font_classes'] = get_option( 'x_pre_v4', false );
  return $settings;
});


// Misc
// =============================================================================

add_filter( 'cs_recent_posts_post_types', function( $types ) {
  $types['portfolio'] = 'x-portfolio';
  return $types;
});



// Classic Elements
// =============================================================================

add_filter( 'cornerstone_looks_like_support', '__return_true' ); // used on classic elements to output a

// Alias legacy shortcode names.
add_action( 'cornerstone_shortcodes_loaded', function () {

  //
  // Alias [social] to [icon] for backwards compatability.
  //

  cs_alias_shortcode( 'social', 'x_icon', false );

  //
  // Alias deprecated shortcode names.
  //

  // Mk2
  cs_alias_shortcode( array( 'alert', 'x_alert' ), 'cs_alert' );
  cs_alias_shortcode( array( 'x_text' ), 'cs_text' );
  cs_alias_shortcode( array( 'icon_list', 'x_icon_list' ), 'cs_icon_list' );
  cs_alias_shortcode( array( 'icon_list_item', 'x_icon_list_item' ), 'cs_icon_list_item' );

  // Mk1 backwards compatibility pre Cornerstone
  cs_alias_shortcode( 'accordion',            'x_accordion', false );
  cs_alias_shortcode( 'accordion_item',       'x_accordion_item', false );
  cs_alias_shortcode( 'author',               'x_author', false );
  cs_alias_shortcode( 'block_grid',           'x_block_grid', false );
  cs_alias_shortcode( 'block_grid_item',      'x_block_grid_item', false );
  cs_alias_shortcode( 'blockquote',           'x_blockquote', false );
  cs_alias_shortcode( 'button',               'x_button', false );
  cs_alias_shortcode( 'callout',              'x_callout', false );
  cs_alias_shortcode( 'clear',                'x_clear', false );
  cs_alias_shortcode( 'code',                 'x_code', false );
  cs_alias_shortcode( 'column',               'x_column', false );
  cs_alias_shortcode( 'columnize',            'x_columnize', false );
  cs_alias_shortcode( 'container',            'x_container', false );
  cs_alias_shortcode( 'content_band',         'x_content_band', false );
  cs_alias_shortcode( 'counter',              'x_counter', false );
  cs_alias_shortcode( 'custom_headline',      'x_custom_headline', false );
  cs_alias_shortcode( 'dropcap',              'x_dropcap', false );
  cs_alias_shortcode( 'extra',                'x_extra', false );
  cs_alias_shortcode( 'feature_headline',     'x_feature_headline', false );
  cs_alias_shortcode( 'gap',                  'x_gap', false );
  cs_alias_shortcode( 'google_map',           'x_google_map', false );
  cs_alias_shortcode( 'google_map_marker',    'x_google_map_marker', false );
  cs_alias_shortcode( 'highlight',            'x_highlight', false );
  cs_alias_shortcode( 'icon',                 'x_icon', false );
  cs_alias_shortcode( 'image',                'x_image', false );
  cs_alias_shortcode( 'lightbox',             'x_lightbox', false );
  cs_alias_shortcode( 'line',                 'x_line', false );
  cs_alias_shortcode( 'map',                  'x_map', false );
  cs_alias_shortcode( 'pricing_table',        'x_pricing_table', false );
  cs_alias_shortcode( 'pricing_table_column', 'x_pricing_table_column', false );
  cs_alias_shortcode( 'promo',                'x_promo', false );
  cs_alias_shortcode( 'prompt',               'x_prompt', false );
  cs_alias_shortcode( 'protect',              'x_protect', false );
  cs_alias_shortcode( 'pullquote',            'x_pullquote', false );
  cs_alias_shortcode( 'raw_output',           'x_raw_output', false );
  cs_alias_shortcode( 'recent_posts',         'x_recent_posts', false );
  cs_alias_shortcode( 'responsive_text',      'x_responsive_text', false );
  cs_alias_shortcode( 'search',               'x_search', false );
  cs_alias_shortcode( 'share',                'x_share', false );
  cs_alias_shortcode( 'skill_bar',            'x_skill_bar', false );
  cs_alias_shortcode( 'slider',               'x_slider', false );
  cs_alias_shortcode( 'slide',                'x_slide', false );
  cs_alias_shortcode( 'tab_nav',              'x_tab_nav', false );
  cs_alias_shortcode( 'tab_nav_item',         'x_tab_nav_item', false );
  cs_alias_shortcode( 'tabs',                 'x_tabs', false );
  cs_alias_shortcode( 'tab',                  'x_tab', false );
  cs_alias_shortcode( 'toc',                  'x_toc', false );
  cs_alias_shortcode( 'toc_item',             'x_toc_item', false );
  cs_alias_shortcode( 'visibility',           'x_visibility', false );

  Cornerstone_Shortcode_Preserver::preserve( 'code' );

});



// MEJS [audio]
// =============================================================================

//
// 1. Library.
// 2. Output.
// 3. Class.
//



if ( !function_exists( 'x_native_wp_audio_shortcode_library' ) ) :

  function x_native_wp_audio_shortcode_library() { // 1
    wp_enqueue_script( 'mediaelement' );
    return false;
  }

  add_filter( 'wp_audio_shortcode_library', 'x_native_wp_audio_shortcode_library' );
endif;


if ( !function_exists( 'x_native_wp_audio_shortcode' ) ) :

  function x_native_wp_audio_shortcode( $html ) { // 2
    return '<div class="x-audio player" data-x-element-mejs>' . $html . '</div>';
  }

  add_filter( 'wp_audio_shortcode', 'x_native_wp_audio_shortcode' );
endif;


if ( !function_exists( 'x_native_wp_audio_shortcode_class' ) ) :

  function x_native_wp_audio_shortcode_class() { // 3
    return 'x-mejs x-wp-audio-shortcode advanced-controls';
  }

  add_filter( 'wp_audio_shortcode_class', 'x_native_wp_audio_shortcode_class' );
endif;

// MEJS [video]
// =============================================================================

//
// 1. Library.
// 2. Output.
// 3. Class.
//

if ( !function_exists( 'x_native_wp_video_shortcode_library' ) ) :

  function x_native_wp_video_shortcode_library() { // 1
    wp_enqueue_script( 'mediaelement' );
    return false;
  }

  add_filter( 'wp_video_shortcode_library', 'x_native_wp_video_shortcode_library' );
endif;


if ( !function_exists( 'x_native_wp_video_shortcode' ) ) :

  function x_native_wp_video_shortcode( $output ) { // 2
    return '<div class="x-video player" data-x-element-mejs>' . preg_replace('/<div(.*?)>/', '<div class="x-video-inner">', $output ) . '</div>';
  }

  add_filter( 'wp_video_shortcode', 'x_native_wp_video_shortcode' );
endif;


if ( !function_exists( 'x_native_wp_video_shortcode_class' ) ) :

  function x_native_wp_video_shortcode_class() { // 3
    return 'x-mejs x-wp-video-shortcode advanced-controls';
  }

  add_filter( 'wp_video_shortcode_class', 'x_native_wp_video_shortcode_class' );
endif;





// Validation Box Replacement
// =============================================================================


function x_cornerstone_validation_box() {

  ?>

  <div class="tco-box tco-box-validation">
    <div class="tco-box-content">
      <div class="tco-validation">
        <div class="tco-validation-graphic">
          <?php tco_common()->admin_icon( 'locked', 'tco-validation-graphic-icon' ); ?>
          <?php tco_common()->admin_icon( 'arrow-right', 'tco-validation-graphic-icon' ); ?>
          <?php tco_common()->admin_icon( 'key', 'tco-validation-graphic-icon' ); ?>
          <?php tco_common()->admin_icon( 'arrow-right', 'tco-validation-graphic-icon' ); ?>
          <?php tco_common()->admin_icon( 'unlocked', 'tco-validation-graphic-icon' ); ?>
        </div>
        <h1 class="tco-validation-title"><?php _e( 'You&apos;re almost finished!', '__x__' ); ?></h1>
        <p class="tco-validation-text"><?php _e( 'Great to see you&apos;re using Cornerstone with X, but it is ​<strong>not validated</strong>. Once X is validated, Cornerstone will automatically be validated as well. You&apos;ll also have instant access to support, automatic updates, custom templates, and more.', '__x__' ); ?></p>
        <a class="tco-btn tco-btn-lg" href="<?php echo x_addons_get_link_home(); ?>"><?php _e( 'CLICK HERE TO VALIDATE', '__x__' ); ?></a>
      </div>
    </div>
  </div>

  <?php

}

add_action( '_cornerstone_home_not_validated', 'x_cornerstone_validation_box' );



// Validation Box Replacement
// =============================================================================


function x_cornerstone_validation_overlay() {

  ?>

  <h4 class="tco-box-content-title"><?php _e( 'How do I unlock this feature?', '__x__' ); ?></h4>
  <p><?php printf( __( 'By validating X. Once X is validated, Cornerstone will automatically be validated as well.<br><br>You can validate X <a href="%s">here</a>.', '__x__' ), x_addons_get_link_home() ); ?></p>

  <?php

}

add_action( '_cornerstone_validation_overlay', 'x_cornerstone_validation_overlay' );



// Hide X validation notice on Cornertstone home page
// =============================================================================

function x_cornerstone_block_validation_notice( $screens ) {
  $screens[] = 'cornerstone-home';
  return $screens;
}

add_filter( 'x_validation_notice_blocked_screens', 'x_cornerstone_block_validation_notice' );



// Remove Cornerstone Validation Notice
// =============================================================================

if ( function_exists( 'cornerstone_theme_integration' ) ) {

  cornerstone_theme_integration( array( 'remove_global_validation_notice' => true ) );

}



// Cornerstone Home Scripts
// =============================================================================

//
// 1. Output.
// 2. Hook admin_print_scripts.
//

function x_cornerstone_home_page_scripts_output() {

  ?>

  <script type="text/javascript">

    jQuery( '[data-tco-module="cs-validation-revoke"]').remove();
    jQuery( '[data-tco-module="cs-purchase-another-license"]' ).on( 'click', function( e ) {

      e.preventDefault();

      tco.confirm( {
        accept:  { url: "https://theme.co/go/join-validation.php", newTab: true },
        decline: { url: jQuery( this ).attr( 'href' ), newTab: true },
        message: "<?php _e( 'We see this is an X site, would you like to purchase another X license? Cornerstone is always included for free with X.', '__x__' ); ?>",
        acceptClass: 'tco-btn-yep',
        acceptBtn: "<?php _e( 'Purchase X (includes Cornerstone)', '__x__' ); ?>",
        declineBtn: "<?php _e( 'Just Cornerstone', '__x__' ); ?>",
      } );

    } );

  </script>

  <?php
}

function x_cornerstone_home_page_scripts() {
  add_action( 'admin_print_footer_scripts', 'x_cornerstone_home_page_scripts_output' ); // 1
}

add_action( '_cornerstone_home_after', 'x_cornerstone_home_page_scripts' );
