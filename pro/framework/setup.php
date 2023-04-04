<?php

// Versions
// =============================================================================

if ( ! defined( 'X_VERSION' ) ) {
  define( 'X_VERSION', '5.1.5' );
}

if ( ! defined( 'CS_VERSION' ) ) {
  define( 'CS_VERSION', '6.1.5' );
}

// Theme Constants
// =============================================================================

define( 'X_SLUG', 'pro' );
define( 'X_TITLE', 'Pro' );
define( 'X_I18N_PATH', X_TEMPLATE_PATH . '/framework/functions/pro/i18n');


// App Environment Data
// =============================================================================

function pro_cornerstone_app_env( $env ) {
  $env['product'] = 'pro';
  $env['title'] = X_TITLE;
  $env['version'] = X_VERSION;
  $env['productKey'] = esc_attr( get_option( 'x_product_validation_key', '' ) );
  return $env;
}

add_filter( '_cornerstone_app_env', 'pro_cornerstone_app_env' );


// Load Cornerstone
// =============================================================================


function pro_load_cornerstone() {

  $cs_path = X_TEMPLATE_PATH . '/cornerstone';

  if ( ! file_exists( "$cs_path/includes/boot.php" ) ) {
    return;
  }

  if ( class_exists('Cornerstone_Plugin') ) {
    add_action('admin_init', 'pro_deactivate_cornerstone');
    return;
  }

  require_once("$cs_path/includes/boot.php");

  cornerstone_boot(
    X_TEMPLATE_PATH . '/cornerstone/',
    X_TEMPLATE_PATH . '/framework/functions/pro/i18n',
    X_TEMPLATE_URL . '/cornerstone/'
  );

  CS()->component('Pro_Setup');

}

pro_load_cornerstone();

// add_filter( 'cornerstone_default_app_slug', function() {
//   return 'pro';
// });

function pro_deactivate_cornerstone() {
  if ( function_exists('deactivate_plugins') ) {
    deactivate_plugins('cornerstone/cornerstone.php');
    deactivate_plugins('cornerstone-page-builder  /cornerstone.php');
  }
}

add_filter( 'cs_app_preference_defaults', function ( $defaults ) {

  $defaults['dynamic_content'] = true;

  return $defaults;

} );

if ( ! function_exists( 'x_body_class_version' ) ) :
  function x_body_class_version( $output ) {

    $output[] = 'pro-v' . str_replace( '.', '_', X_VERSION );
    return $output;

  }
  add_filter( 'body_class', 'x_body_class_version', 10000 );
endif;


function pro_load_preinit() {
  require_once X_TEMPLATE_PATH . '/framework/functions/pro/migration.php';
}

add_action('x_boot_preinit', 'pro_load_preinit' );



function pro_scandir_exclusions( $exclusions ) {
  $exclusions[] = 'cornerstone';
  return $exclusions;
}

add_filter('theme_scandir_exclusions', 'pro_scandir_exclusions' );



// Admin Menu
// =============================================================================

function pro_admin_menu_logo() {
  // shoooooooooould work...
  //
  // global $_wp_admin_css_colors;
  // $color = get_user_option( 'admin_color' );

  // if ( empty( $color ) || ! isset( $_wp_admin_css_colors[ $color ] ) ) {
  //   $color = 'fresh';
  // }

  // $fill = $_wp_admin_css_colors[ $color ]->icon_colors['base'];

  $fill = '#a7aaad';

  ob_start();
  ?>
    <svg fill="<?php echo $fill; ?>" viewBox="0 0 400 450" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
      <g transform="translate(-10.000000, -600.000000)">
        <path d="M230.016931,605.368943 L308.738808,650.870363 L390.016931,697.849298 C402.383432,704.997163 410,718.196895 410,732.480534 L410,917.519466 C410,931.803105 402.383432,945.002837 390.016931,952.150702 L230.016931,1044.63106 C217.632285,1051.78941 202.367715,1051.78941 189.983069,1044.63106 L29.983069,952.150702 C17.616568,945.002837 10,931.803105 10,917.519466 L10,732.480534 C10,718.196895 17.616568,704.997163 29.983069,697.849298 L189.983069,605.368943 C202.367715,598.21059 217.632285,598.21059 230.016931,605.368943 Z M214,881.001863 L139,881.001863 C134.029437,881.001863 130,885.0313 130,890.001863 L130,890.001863 L130.003837,890.267824 C130.144209,895.115648 134.118197,899.002462 139,899.002462 L139,899.002462 L214,899.002462 C218.970563,899.002462 223,894.973024 223,890.002462 L223,890.002462 L222.996163,889.736501 C222.855791,884.888676 218.881803,881.001863 214,881.001863 L214,881.001863 Z M214,848.000765 L139,848.000765 C134.029437,848.000765 130,852.030202 130,857.000765 L130,857.000765 L130.003837,857.266726 C130.144209,862.11455 134.118197,866.001364 139,866.001364 L139,866.001364 L214,866.001364 C218.970563,866.001364 223,861.971927 223,857.001364 L223,857.001364 L222.996163,856.735403 C222.855791,851.887579 218.881803,848.000765 214,848.000765 L214,848.000765 Z M274,815.999701 L139,815.999701 C134.029437,815.999701 130,820.029138 130,824.999701 L130,824.999701 L130.003837,825.265662 C130.144209,830.113486 134.118197,834.000299 139,834.000299 L139,834.000299 L274,834.000299 C278.970563,834.000299 283,829.970862 283,825.000299 L283,825.000299 L282.996163,824.734338 C282.855791,819.886514 278.881803,815.999701 274,815.999701 L274,815.999701 Z M298,783.998636 L139,783.998636 C134.029437,783.998636 130,788.028073 130,792.998636 L130,792.998636 L130.003837,793.264597 C130.144209,798.112421 134.118197,801.999235 139,801.999235 L139,801.999235 L298,801.999235 C302.970563,801.999235 307,797.969798 307,792.999235 L307,792.999235 L306.996163,792.733274 C306.855791,787.88545 302.881803,783.998636 298,783.998636 L298,783.998636 Z M274,750.997538 L139,750.997538 C134.029437,750.997538 130,755.026976 130,759.997538 L130,759.997538 L130.003837,760.263499 C130.144209,765.111324 134.118197,768.998137 139,768.998137 L139,768.998137 L274,768.998137 C278.970563,768.998137 283,764.9687 283,759.998137 L283,759.998137 L282.996163,759.732176 C282.855791,754.884352 278.881803,750.997538 274,750.997538 L274,750.997538 Z"></path>
      </g>
    </svg>
  <?php

  return ob_get_clean();
}

function pro_admin_menu() {
  $title = __( 'Validation', '__x__' );
  add_menu_page( $title, X_TITLE, 'manage_options', 'x-addons-home', 'x_addons_page_home', 'data:image/svg+xml;base64,' . base64_encode( pro_admin_menu_logo() ), 3 );
  add_submenu_page( 'x-addons-home', $title, $title, 'manage_options', 'x-addons-home', 'x_addons_page_home' );
}

add_action( 'admin_menu', 'pro_admin_menu', 5 );

function pro_content_layout_grid_option ( $choices ) {
  array_splice( $choices, 1, 0, [ [ 'value' => 'layout-grid', 'label' => __( 'Grid', 'cornerstone' ) ] ] );
  return $choices;
}

add_filter('cs_content_layout_element_options', 'pro_content_layout_grid_option', 5 );
