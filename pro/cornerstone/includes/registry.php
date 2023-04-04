<?php

// =============================================================================
// REGISTRY.PHP
// -----------------------------------------------------------------------------
// Pseudo autoloading system.
//
// `files`:
// Contains groups of files to require at different points in WordPress
// execution. Generally, these files should only contain class and function
// definitions without initiating any application logic.
//
// `components`
// Groups of componenets to load into our main plugin at different points in
// WordPress execution. Component names must match their class name, prefixed
// by the plugin name for example:
//
//   Class: Cornerstone_MyComponent
//   Component: MyComponent
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Registry
//       a. Files
//       b. Components
//       c. Elements
//       d. Classic Elements
// =============================================================================

// Registry
// =============================================================================

return array(

  // Files
  // -----

  'files' => array(
    'preinit' => array(
      'tco',
      'utility/helpers',
      'utility/element-api',
      'utility/api',
    ),
    'after_setup_theme' => array(
      // 'integration/setup-themes',
    ),
    'init' => array(
      'integration/setup-plugins',
      'extend/menu-item-custom-fields/menu-item-custom-fields',
      'extend/menu-item-custom-fields/menu-item-custom-fields-map',
    ),
  ),


  // Components
  // ----------

  'components' => array(
    'preinit' => array(
      'Tco',
      'Common',
      'Updates',
      'Conflict_Resolution',
      'CLI',
    ),
    'init' => array(
      'Legacy_Elements',
      'Element_Orchestrator',
      'Dynamic_Content',
      'Front_End',
      'Element_Front_End',
      'App_Boot',
      'Router',
      'Routing',
      'Revision_Manager',
      'Template_Manager',
      'Layouts_Manager',
      'Looper_Manager',
      'Wpml',
      'Social',
      'Yoast',
      'Rankmath',
      'Shortcode_Finder',
      'WooCommerce',
      'Offload_S3',
      'Jetpack',
      'Caching',
      'Legacy_Assignments',
      'Assignments',
      'Color_Manager',
      'Font_Manager',
    ),
    'after_setup_theme' => array(
      'Theme_Options',
    ),
    'loggedin' => array(
      'Admin',
      'Status',
      'Wp_Export',
      'Options_Manager',
      'App',
      'Preview_Frame_Loader',
      'Preview_Endpoint',
      'Validation',
      'Layout_Manager',
    ),
    'controllers' => array(
      'Save_Controller',
      'Content_Controller',
      'Global_Blocks_Controller',
      'Templates_Controller',
      'Preferences_Controller',
      'Colors_Controller',
      'Fonts_Controller',
      'Typekit_Controller',
      'Late_Data_Controller',
      'Choices_Controller',
      'Index_Controller',
      'Headers_Controller',
      'Footers_Controller',
      'Layouts_Controller',
      'Theme_Options_Controller',
      'Locator_Controller',
      'Formatting_Controller'
    ),
  ),


  // Elements
  // --------

  'elements' => array(
    'base' => array(
      'helpers',
      'sample',
    ),
    'control-partials' => array(
      'anchor',
      'bg',
      'cart',
      'content-area',
      'dropdown',
      'effects',
      'frame',
      'graphic',
      'icon',
      'image',
      'mejs',
      'menu',
      'modal',
      'off-canvas',
      'omega',
      'products',
      'pagination',
      'particle',
      'rating',
      'search',
      'separator',
      'text',
      'toggle'
    ),
    'definitions' => array(
      'button',
      'content-area',
      'content-area-dropdown',
      'content-area-modal',
      'content-area-off-canvas',
      'comment-form',
      'comment-list',
      'comment-pagination',
      'form-integration',
      'global-block',
      'accordion',
      'accordion-item',
      'tabs',
      'tab',
      'icon',
      'image',
      'nav-collapsed',
      'nav-dropdown',
      'nav-inline',
      'nav-modal',
      'nav-layered',
      'layout-div',
      'layout-row',
      'layout-column',
      'layout-modal',
      'layout-dropdown',
      'layout-off-canvas',
      'layout-slide-container',
      'layout-slide',
      'post-pagination',
      'post-nav',
      'search-inline',
      'search-dropdown',
      'search-modal',
      'card',
      'creative-cta',
      'map',
      'map-marker',
      'audio',
      'video',
      'social',
      'text',
      'headline',
      'quote',
      'testimonial',
      'breadcrumbs',
      'alert',
      'counter',
      'countdown',
      'rating',
      'raw-content',
      'the-content',
      'statbar',
      'slide-pagination',
      'line',
      'gap',
      'widget-area',
      'tp-wc-add-to-cart-form',
      'tp-wc-cart',
      'tp-wc-cart-dropdown',
      'tp-wc-cart-modal',
      'tp-wc-cart-off-canvas',
      'tp-wc-cross-sells',
      'tp-wc-product-gallery',
      'tp-wc-product-pagination',
      'tp-wc-products',
      'tp-wc-related-products',
      'tp-wc-shop-notices',
      'tp-wc-shop-sort',
      'tp-wc-upsells',
      'section',
      'classic-row-v2',
      'classic-column-v2',
    ),
    'classic' => [
      // 'alert'
    ]
  ),


  // Classic Elements
  // ----------------

  'classic-elements' => array(
    'mk2' => array( 'alert', 'block-grid', 'block-grid-item', 'column', 'icon-list', 'icon-list-item', 'pricing-table', 'pricing-table-column', 'row', 'section', 'text' ),
    'mk1' => array( 'accordion-item', 'accordion', 'author', 'blockquote', 'button', 'callout', 'card', 'clear', 'code', 'columnize', 'contact-form-7', 'counter', 'creative-cta', 'custom-headline', 'embedded-audio', 'embedded-video', 'envira-gallery', 'essential-grid', 'feature-box', 'feature-headline', 'feature-list-item', 'feature-list', 'gap', 'google-map-marker', 'google-map', 'gravity-forms', 'icon', 'image', 'layerslider', 'line', 'mailchimp', 'map-embed', 'promo', 'prompt', 'protect', 'raw-content', 'recent-posts', 'revolution-slider', 'search', 'self-hosted-audio', 'self-hosted-video', 'skill-bar', 'slide', 'slider', 'social-sharing', 'soliloquy', 'tab','tabs', 'text-type', 'toc-item', 'toc', 'visibility', 'widget-area' ),
  ),

);
