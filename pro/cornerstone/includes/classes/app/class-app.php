<?php

use Themeco\Cornerstone\Plugin;

class Cornerstone_App extends Cornerstone_Plugin_Component {

  protected $show_admin_bar = false;

  public function setup() {
    add_action( 'cornerstone_boot_app', array( $this, 'load' ), 0, 1 );
  }

  public function get_env() {
    if (! isset( $this->env ) ) {
      $this->env = $this->plugin->common()->get_env_data();
    }
    return $this->env;
  }

  public function load() {


    $settings = $this->plugin->settings();
    $preferences = $this->plugin->component('App_Preferences')->get_user_preferences();

    add_filter('media_view_settings', function($settings) {
      $settings['defaultProps']['size'] = 'full';
      return $settings;
    });
    add_filter( 'template_include', '__return_empty_string', 999999 );

    remove_all_actions( 'wp_enqueue_scripts' );
    remove_all_actions( 'wp_print_styles' );
    remove_all_actions( 'wp_print_head_scripts' );

    do_action('cornerstone_before_boot_app');

    global $wp_styles;
    global $wp_scripts;

    $wp_styles = new WP_Styles();
    $wp_scripts = new WP_Scripts();

    if ( (bool) $preferences['show_wp_toolbar'] ) {
      add_action( 'add_admin_bar_menus', array( $this, 'update_admin_bar' ) );

      if ( !class_exists('WP_Admin_Bar') ) {
        _wp_admin_bar_init();
      }

      add_action('wp_enqueue_scripts_clean', array( $this, 'adminBarEnqueue' ));
      $this->show_admin_bar = true;
    } else {
      add_filter( 'show_admin_bar', '__return_false' );
    }

    $this->enqueue_styles( $settings );
    $this->enqueue_scripts( $settings );
    nocache_headers();

    $theme = isset($preferences['ui_theme']) ? $preferences['ui_theme'] : 'light';
    $env = $this->get_env();
    $this->view( 'app/boilerplate', true, array(
      'theme' => $theme,
      'body_classes' => $this->body_classes(),
      'title' => $env['title']
    ) );
    exit;

  }

  public function enqueue_styles( $settings ) {

    wp_register_style( 'cs-dashicons', '/wp-includes/css/dashicons.min.css' );
    wp_register_style( 'cs-editor-buttons', '/wp-includes/css/editor.min.css' );

    $app_style_asset = $this->plugin->css( 'app/app' );
    wp_enqueue_style( 'cs-app-style', $app_style_asset['url'], array(
      'cs-dashicons',
      'cs-editor-buttons',
      'code-editor',
      'wp-auth-check'
    ), $app_style_asset['version'] );

    wp_enqueue_style( 'wp-auth-check' );

  }

  public function register_app_scripts( $settings, $isPreview = false ) {

    $app_asset = $this->plugin->versioned_url( 'assets/js/app', 'js' );
    $deps = array( 'wp-api-fetch', 'wp-element', 'jquery', 'lodash', 'moment', 'react', 'react-dom', 'wp-polyfill', 'wp-polyfill-fetch' );

    if ($isPreview) {
      $deps[] = 'cornerstone-site-body';
    }

    wp_register_script( 'cs-app', $app_asset['url'], $deps, $app_asset['version'], false );

    $router = $this->plugin->component( 'Router' );

    $worker_asset = $this->plugin->versioned_url( 'assets/js/worker', 'js' );

    $canGzip = $router->gzip();

    $data = [
      'isPreview'        => $isPreview,
      'featureFlags'     => apply_filters('tco_feature_flags', [] ),
      'fetch'            => $this->plugin->component( 'Routing' )->fetch_config(),
      'ajaxUrl'          => $router->get_ajax_url(),
      'fallbackAjaxUrl'  => $router->get_fallback_ajax_url(),
      'renderDebounce'   => apply_filters( 'cornerstone_render_debounce', 350 ),
      'canGzip'          => $canGzip,
      '_cs_nonce'        => $router->create_nonce(),
      'useLegacyAjax'    => $router->use_legacy_ajax(),
      'debug'            => defined('WP_DEBUG') && WP_DEBUG,
      'workerUrl'        => add_query_arg( array( 'v' => $worker_asset['version'] ), $worker_asset['url'] ),
      'breakpoints' => CS()->novus()->service('Breakpoints')->appData()
    ];

    if ( $isPreview ) {
      $data['preview'] = $this->plugin->component( 'Preview_Frame_Loader' )->data();

      $grid_presets = function_exists('x_layout_grid_presets') ? x_layout_grid_presets() : [];
      foreach($grid_presets as $key => $preset ) {
        $grid_presets[$key]['values'] = CS()->component('Element_Migrations')->migrate( [$preset['values']] )[0];
      }

      $slider_presets = function_exists('x_layout_slider_presets') ? x_layout_slider_presets() : [];
      foreach($slider_presets as $key => $preset ) {
        $slider_presets[$key]['values'] = CS()->component('Element_Migrations')->migrate( [$preset['values']] )[0];
      }

      $data['gridPresets'] = $grid_presets;
      $data['sliderPresets'] = $slider_presets;

    } else {
      $data['app'] = apply_filters( 'cs_app_data', $this->get_app_data() );

      if ($canGzip) {
        $data['app'] = base64_encode( gzcompress( json_encode( $data['app'] ) ) );
      }
    }

    wp_localize_script( 'cs-app', 'csAppConfig', [ 'data' => $data ] );

  }

  public function get_app_data() {

    $options_manager = $this->plugin->component( 'Options_Manager' );
    $fonts = $this->plugin->component( 'Font_Manager' );
    $permissions = $this->plugin->component('App_Permissions');
    $settings = $this->plugin->settings();


    $wpml = $this->plugin->component('Wpml');

    //Only use home_url() for both single and multi-site
    $rootSlug = parse_url(home_url(), PHP_URL_PATH); //Don't use one-line trim, parse_url can return NULL which will trigger notices and warning.
    $rootSlug = empty( $rootSlug ) || $rootSlug == '/' ? '/' : '/'.trim( $rootSlug , '/').'/';

    $rootUrl = $rootSlug . trim( $this->plugin->common()->get_app_slug(), '/\\' );

    $text_editor_style_asset = $this->plugin->css( 'app/tinymce-content' );

    $locator = $this->plugin->component('Locator');

    $elementIcons = include( $this->plugin->path('includes/elements/icons.php') );
    $elementManager = CS()->novus()->service('Elements')->manager();

    return array(
      'rootURL'                   => $rootUrl,
      'dashboardUrl'              => admin_url(),
      'date_format'               => get_option( 'date_format' ),
      'time_format'               => get_option( 'time_format' ),
      'isRTL'                     => is_rtl(),
      'homePageId'                => $this->get_home_page_id(),
      'countdownTBD'              => date( 'Y-m-d H:i:s', strtotime( current_time( 'mysql' ) ) + WEEK_IN_SECONDS),
      'faConfig'                  => $this->plugin->common()->get_fa_config(),
      'home_url'                  => home_url(),
      'today'                     => date_i18n( get_option( 'date_format' ), time() ),
      'wpmlLanguages'             => $wpml->get_languages(),
      'wpmlDefault'               => $wpml->get_default_language(),
      'wpmlTranslateableTypes'    => $wpml->get_translateable_post_types(),
      'designCloudApiUrl'         => 'https://demo.theme.co/designcloud/wp-json/design-cloud/v3',
      'designCloudApiParams'      => apply_filters( 'cs_design_cloud_index_params', new stdClass ),
      'validationUrl'             => apply_filters('_cs_validation_url', admin_url( 'admin.php?page=cornerstone-home' ) ),
      'siteUrl'                   => esc_attr( trailingslashit( network_home_url() ) ),
      'postStatuses'              => get_post_statuses(),
      'creatablePostTypes'        => $this->plugin->component('App_Permissions')->get_user_creatable_post_types(),
      'load_google_fonts'         => apply_filters('cs_load_google_fonts', true ),
      'max_action_history_items'  => apply_filters('cs_max_action_history_items', 1000 ),
      'themeOptionsValues'        => $this->plugin->component( 'Theme_Options' )->get_values(),

      'socialShareOptions'        => $this->plugin->component( 'Social' )->get_social_share_options(),
      'pageTemplates'             => $this->get_page_templates(),
      'defaultPageTemplate'       => apply_filters( 'cs_default_page_template', 'default' ),
      'defaultImageWidth'         => apply_filters( 'cs_default_image_width', 48 ),
      'defaultImageHeight'        => apply_filters( 'cs_default_image_height', 48 ),

      'jsHintConfig'              => apply_filters( 'cs_jshint_config', array( 'esversion' => 6, 'asi' => true ) ),
      'textEditorContentCss'      => $text_editor_style_asset['url'],
      'locatorLimit'              => $locator->get_limit(),
      'orderbyOptions'            => $locator->get_orderby_options(),

      // These are shared with the preview frame via Redux
      'preferences'               => $this->plugin->component('App_Preferences')->get_user_preferences(),
      'fonts'                     => $this->plugin->component( 'Font_Manager' )->get_app_data(),
      'colors'                    => $this->plugin->component('Color_Manager')->get_app_data(),

      // These are candidates for moving to late data
      'dynamicContentFields'   => $this->plugin->component('Dynamic_Content')->get_dynamic_fields(),
      'conditionContexts'      => $this->plugin->component('Conditionals')->get_condition_contexts(),
      'assignmentContexts'     => $this->plugin->component('Conditionals')->get_assignment_contexts(),
      'previewContexts'        => $this->plugin->component('Conditionals')->get_preview_contexts(),

      'passThroughControlGroups' => [
        'gap:setup',
        'raw_content:setup',
        'add_to_cart_form:design',
        'shop_notices:design',
        'shop_sort:design',
        'effects:setup',
        'omega:setup'
      ],

      // Still available via window.csAppData[key] but will only be generated
      // once and passed into the preview iframe client side
      'shared' => [
        'env'                         => $this->get_env(),
        'app_i18n'                    => $this->plugin->i18n_group( 'app' ),
        'common_i18n'                 => $this->plugin->i18n_group( 'common' ),
        'permissions'                 => $this->plugin->component('App_Permissions')->get_user_permissions(),
        'current_user'                => get_current_user_id(),
        'keybindings'                 => $this->plugin->config_group( 'builder/keybindings' ),
        'themeOptionsConfig'          => $this->plugin->component( 'Theme_Options' )->get_config(),

        'css_class_map'               => $this->plugin->config_group( 'common/class-map' ),
        'tssConfig'                   => CS()->novus()->service('Tss')->previewConfig(),
        'rowPresets'                  => array(
          '100%',
          '50% 50%',
          '33.33% 33.33% 33.33%',
          '25% 25% 25% 25%',
          '33.33% 66.66%',
          '66.66% 33.33%',
          '25% 50% 25%',
          '25% 75%',
          '75% 25%',
        ),

        // this is also managed over redux, but the extended colors are not

        'colorsExtended' => $this->plugin->component('Color_Manager')->get_extended(),
        'elements'      => $elementManager->get_element_definitions(),
        'components'    => $elementManager->get_components(),
        'elementIcons'  => $elementIcons, // 8kb
      ]
    );
  }

  // This is available in the app as csAppDataLate
  // It can't be used in the preview because it is requested after the preview starts to load
  public function get_late_data() {

    do_action( 'cs_before_late_data' );

    return array(

      'fontAwesome'           => $this->plugin->common()->getFontIconsData(), // 39kb
      'fontData'              => apply_filters( 'cs_font_data', [] ), // 23kb
      'themeOptionsControls'  => $this->plugin->component( 'Theme_Options' )->get_controls(), // 12kb
      'preferenceControls'    => $this->plugin->component('App_Preferences')->get_preference_controls(), // 2kb

      'elementLibrary'        => $this->plugin->component( 'Element_Library' )->get_library(), // 8kb
      'defaultPresets'        => CS()->component('Template_Manager')->lookup_default_presets(), // 0kb
      'elementsInspectorData' => CS()->novus()->service('Elements')->manager()->get_element_inspector_data(), // 354kb
      // 'tss' => CS()->novus()->service('Tss')->previewData()
    );
  }

  public function get_home_page_id() {
    if (get_option('show_on_front') === 'page') {
      return get_option('page_on_front');
    }
    return null;
  }



  public function get_page_templates() {

    $choices = array();
    $page_templates = wp_get_theme()->get_page_templates();
    ksort( $page_templates );

    $choices[] = array( 'value' => 'default', 'label' => apply_filters( 'default_page_template_title',  __( 'Default Template' ), 'cornerstone' ) );

    foreach ($page_templates as $value => $label) {
      $choices[] = array( 'value' => $value, 'label' => $label );
    }

    return $choices;

  }

  public function enqueue_scripts( $settings ) {

    $this->prime_editor();

    $this->register_app_scripts( $settings );
    wp_enqueue_script( 'cs-app' );

    // Dependencies
    wp_enqueue_script( 'wp-auth-check' );
    wp_enqueue_script( 'csslint' );
    wp_enqueue_script( 'jshint' );
    wp_enqueue_script( 'jsonlint' );
    wp_enqueue_script( 'htmlhint' );
    wp_enqueue_script( 'code-editor' );
    wp_enqueue_script( 'heartbeat' );
    wp_enqueue_media();
  }

  public function update_admin_bar() {
    remove_action( 'admin_bar_menu', 'wp_admin_bar_customize_menu', 40 );
  }

  public function body_classes() {

    $classes = array( 'no-customize-support' );

    if ( is_rtl() ) {
      $classes[] = 'rtl';
    }

    if ( $this->show_admin_bar ) {
      $classes[] = 'admin-bar';
    }

    if ( empty( $classes ) ) {
      return;
    }

    $classes = array_map( 'esc_attr', array_unique( $classes ) );
    $class = join( ' ', $classes );
    return "class=\"$class\"";

  }

  /**
   * Prepare the WordPress Editor (wp_editor) for use as a control
   * This thing does NOT like to be used in multiple contexts where it's added and removed dynamically.
   * We're creating some initial settings here to be used later.
   * Callings this function also triggers all the required styles/scripts to be enqueued.
   * @return none
   */
  public function prime_editor() {

    // Remove all 3rd party integrations to prevent plugin conflicts.
    remove_all_actions('before_wp_tiny_mce');
    remove_all_filters('mce_external_plugins');
    remove_all_filters('mce_buttons');
    remove_all_filters('mce_buttons_2');
    remove_all_filters('mce_buttons_3');
    remove_all_filters('mce_buttons_4');
    remove_all_filters('tiny_mce_before_init');
    add_filter( 'tiny_mce_before_init', '_mce_set_direction' );

    // Cornerstone's editor is modified, so we will allow visual editing for all users.
    add_filter( 'user_can_richedit', '__return_true' );

    if( apply_filters( 'cornerstone_use_br_tags', false ) ) {
      add_filter('tiny_mce_before_init', array( $this, 'allow_br_tags' ) );
    }

    // Allow integrations to use hooks above before the editor is primed.
    do_action('cornerstone_before_wp_editor');

    add_filter('mce_buttons', array( $this, 'mce_buttons' ) );

    ob_start();
    wp_editor( '%%PLACEHOLDER%%','cswpeditor', array(
      'quicktags' => false,
      'tinymce'=> array(
        'toolbar1' => 'bold,italic,strikethrough,underline,bullist,numlist,forecolor,cs_media,wp_adv',
        'toolbar2' => 'link,unlink,alignleft,aligncenter,alignright,alignjustify,outdent,indent',
        'toolbar3' => 'formatselect,pastetext,removeformat,charmap,superscript,subscript,undo,redo'
      ),
      'editor_class' => 'cs-wp-editor',
      'drag_drop_upload' => true
    ) );
    ob_clean();
  }

  public function mce_buttons( $buttons ) {
    $end = array_pop($buttons);
    array_push($buttons,'cs_media', $end);
    return $buttons;
  }

  /**
   * Depending on workflow, users may wish to allow <br> tags.
   * This can be conditionally enabled with a filter.
   * add_filter( 'cornerstone_use_br_tags', '__return_true' );
   */
  public function allow_br_tags( $init ) {
    $init['forced_root_block'] = false;
    return $init;
  }

}
