<?php

if ( ! function_exists('cornerstone_boot') ) {

  function cornerstone_boot( $path, $i18n_path, $url ) {

    if ( function_exists('CS') ) {
      return;
    }

    require_once "$path/includes/plugin.php";
    require_once "$path/includes/classes/Plugin.php";
    require_once "$path/includes/classes/Util/IocContainer.php";

    Cornerstone_Plugin::run( $path, $i18n_path, $url );

    \Themeco\Cornerstone\Plugin::instantiate( $path, $url );

    // Boot the plugin. See includes/services/Service.php
    \Themeco\Cornerstone\Plugin::instance()->initialize( apply_filters( 'cs_initialize', [
      'Themeco\Cornerstone\Services\Theming'      => 'preinit',
      'Themeco\Cornerstone\Services\Rivet'        => 'preinit',
      'Themeco\Cornerstone\Services\Admin'        => 'is_admin',
      'Themeco\Cornerstone\Services\Standalone'   => 'init',
      'Themeco\Cornerstone\Services\Styling'      => 'init',
      'Themeco\Cornerstone\Services\ThemeSupport' => 'after_setup_theme',
      'Themeco\Cornerstone\Services\WpCli' => 'preinit'
    ] ) );

  }

}
