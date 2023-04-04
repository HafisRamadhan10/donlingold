<?php

// =============================================================================
// FUNCTIONS.PHP
// -----------------------------------------------------------------------------
// Theme functions for X.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Autoloader
//   02. Bootstrap Theme
// =============================================================================

if ( file_exists( get_template_directory() . '/dev.php' ) ) {
  require_once( get_template_directory() . '/dev.php' );
}

// Bootstrap Theme
// =============================================================================

require_once( __DIR__ . '/framework/classes/Theme.php' );
require_once( __DIR__ . '/framework/classes/Util/IocContainer.php' );

\Themeco\Theme\Theme::instantiate(
  get_template_directory(),
  get_template_directory_uri()
);

function x_bootstrap() {
  return \Themeco\Theme\Theme::instance();
}

\Themeco\Theme\Theme::instance()->boot([
  // Global Services
  'preinit' => [
    '\Themeco\Theme\Templating\ViewRouter'
  ]
],[

  // Main Includes

  'preinit' => [
    'functions/i18n',
    'functions/plugins/setup'
  ]
],[

  // Legacy Includes (Classic Stacks)
  'preinit' => [
    'legacy/stack-defaults',
    'legacy/functions/helpers',
    'legacy/functions/frontend/view-routing',
    'legacy/functions/thumbnails',
    'legacy/functions/setup',
    'legacy/functions/fonts',

    'legacy/functions/plugins/setup',

    'legacy/functions/updates/class-x-tgmpa-integration',
    'legacy/functions/updates/class-tgm-plugin-activation',
    'legacy/cranium/setup',
    'legacy/setup',

  ],
  'init' => [
    'legacy/functions/frontend/conditionals',
  ],
  'front_end' => array(
    'legacy/functions/frontend/breadcrumbs',
    // Theme
    'legacy/functions/frontend/portfolio',
    'legacy/functions/frontend/view-routing',
    'legacy/functions/frontend/styles',
    'legacy/functions/frontend/scripts',
    'legacy/functions/frontend/content',
    'legacy/functions/frontend/classes',
    'legacy/functions/frontend/meta',
    'legacy/functions/frontend/integrity',
    'legacy/functions/frontend/renew',
    'legacy/functions/frontend/icon',
    'legacy/functions/frontend/ethos',
    'legacy/functions/frontend/social',
    'legacy/functions/frontend/breadcrumbs',
    'legacy/functions/frontend/pagination',
    'legacy/functions/frontend/featured'
  ),
  'logged_in' => [],
  'admin' => [
    'legacy/functions/admin/class-validation',
    'legacy/functions/updates/class-theme-updater',
    'legacy/functions/updates/class-plugin-updater',
    'legacy/functions/admin/class-validation-updates',
    'legacy/functions/admin/class-validation-theme-options-manager',
    'legacy/functions/admin/class-validation-extensions',
    'legacy/functions/admin/setup',

    // Theme
    'legacy/functions/admin/customizer',
    'legacy/functions/admin/meta-boxes',
    'legacy/functions/admin/meta-entries',
    'legacy/functions/admin/taxonomies'
  ],
  'app_init' => [
    'legacy/functions/theme-options',
  ],
  'ajax' => array()
]);
