<?php
/**
 * This class manages all Dashboard related activity.
 * It handles the Options page, and adds the "Edit with Cornerstone"
 * links to the list table screens, and the toolbar.
 */

class Cornerstone_Admin extends Cornerstone_Plugin_Component {

  /**
   * Cache settings locally
   * @var array
   */
  public $settings;

  /**
   * Shortcut to our folder
   * @var string
   */
  public $path = 'includes/admin/';

  /**
   * Store script data potentially used by multiple modules
   * @var array
   */
  public $script_data = array();


  protected $front_end_toolbar_items = [];

  /**
   * Initialize, and add hooks
   */
  public function setup() {

    add_action( 'cs_late_template_redirect', [ $this, 'populate_admin_toolbar' ], 100 );
    add_action( 'admin_bar_menu', array( $this, 'addToolbarLinks' ), 999 );
    add_action( 'admin_bar_init', array( $this, 'admin_bar_css' ) );

    if ( ! is_admin() ) {
      return;
    }

    add_action( 'admin_menu',            array( $this, 'dashboard_menu' ) );
    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
    add_filter( 'page_row_actions',      array( $this, 'addRowActions' ), 10, 2 );
    add_filter( 'post_row_actions',      array( $this, 'addRowActions' ), 10, 2 );
    add_action( 'admin_notices',         array( $this, 'notices' ), 20 );
    add_action( 'admin_print_scripts',   array( $this, 'admin_print_scripts' ), 9999);

  }

  public function ajax_override() {

    if ( isset( $_POST['post_id'] ) && current_user_can( $this->plugin->common()->get_post_capability( $_POST['post_id'], 'edit_post' ), $_POST['post_id'] ) ) {
      update_post_meta( $_POST['post_id'], '_cornerstone_override', true );
    }

    return cs_send_json_success();

  }

  public function ajax_dismiss_validation_notice() {
    update_option( 'cornerstone_dismiss_validation_notice', true );
    return cs_send_json_success();
  }

  public function add_script_data( $handle, $callback ) {
    $this->script_data[$handle] = $callback;
  }

  public function get_script_data() {

    $modules = array();

    foreach ($this->script_data as $handle => $callback ) {
      if ( is_callable( $callback ) ) {
        $modules[$handle] = call_user_func( $callback );
      }
    }

    $notices = array();
    if ( isset( $_REQUEST['notice'] ) ) {
      $notices = explode( '|', sanitize_text_field( $_REQUEST['notice'] ) );
    }

    return array(
      'modules' => $modules,
      'notices' => $notices
    );

  }

  /**
   * Enqueue Admin Scripts and Styles
   */
  public function enqueue( $hook ) {

    $admin_js_config = apply_filters( 'cs_admin_app_data', $this->detect_admin_js( $hook ), $hook );


    if ( ! empty( $admin_js_config ) ) {
      $admin_script_asset = $this->plugin->js( 'admin' );
      wp_register_script( 'cs-admin-js', $admin_script_asset['url'], array_unique( $admin_js_config['deps'] ), $admin_script_asset['version'], true );
      wp_localize_script( 'cs-admin-js', 'csAdminData', $admin_js_config['data'] );
      wp_enqueue_script( 'cs-admin-js' );

      if (isset($admin_js_config['data']['post-editor'])) {
        wp_register_style( 'cs-post-editor', false );
        wp_add_inline_style( 'cs-post-editor', $this->get_post_editor_css() );
        wp_enqueue_style( 'cs-post-editor' );
      }
    }

    wp_add_inline_style( 'admin-menu', $this->get_admin_menu_css() );
    wp_add_inline_style( 'admin-menu', $this->get_admin_miscellaneous_css() );

  }

  public function detect_admin_js( $hook ) {


    $post = $this->plugin->common()->locate_post();
    $post_id = ( $post ) ? $post->ID : 'new';

    $data = [
      'tco' => [
        'strings' => $this->plugin->i18n_group( 'admin', false ),
        'logo' => tco_common()->get_themeco_svg()
      ],
      'common' => [
        'ajax_url'  => admin_url( 'admin-ajax.php' ),
        'homeURL'   => preg_replace('/\?lang=.*/' , '', home_url()),
        'post_id'   => $post_id,
        '_cs_nonce' => wp_create_nonce( 'cornerstone_nonce' ),
        'strings'   => $this->plugin->i18n_group( 'admin', false ),
      ]
    ];

    $deps = [ 'wp-util' ];

    if ( false !== strpos( $hook, 'cornerstone-home' ) ) {
      $deps = array_merge( $deps, [ 'react', 'react-dom' ] );
      $data['home'] = $this->get_script_data();
      $dashboard_home_script_asset = $this->plugin->js( 'admin/dashboard-home' );
    }


    if ( false !== strpos( $hook, 'cornerstone-settings' ) ) {

      $app_permissions = $this->plugin->component('App_Permissions');

      $deps = array_merge( $deps, [ 'wp-api-fetch', 'wp-element', 'jquery', 'lodash', 'moment', 'react', 'react-dom', 'wp-polyfill', 'wp-polyfill-fetch' ] );
      $data['settings'] = [
        'data' => $this->plugin->settings(),
        'controls' => $this->plugin->config_group( 'admin/settings-controls' ),
        'role-manager' => $this->plugin->component('App_Permissions')->get_app_data()
      ];

    }


    if ( $this->isPostEditor( $hook ) ) {

      if ( $post ) {
        $skip = array();
        $skip[] = (int) get_option( 'page_for_posts' );

        if ( function_exists('wc_get_page_id') ) {
          $skip[] = (int) wc_get_page_id( 'shop' );
        }

        if ( ! in_array( (int) $post->ID, $skip, true ) ) {
          $data['post-editor'] = [
            'editUrl' => CS()->component('Common')->get_app_route_url( 'content', '{{post_id}}'),
            'usesCornerstone' => ( $this->plugin->common()->uses_cornerstone( $post ) ) ? 'true' : 'false',
            'editorTabMarkup' => $this->view( 'admin/editor-tab', false ),
            'editorTabContentMarkup' => $this->view( 'admin/editor-tab-content', false ),
          ];
        }

      }

    }

    return [ 'data' => $data, 'deps' => $deps ];
  }


  /**
   * Determine if the post editor is being viewed, and Cornerstone is available
   * @param  string  $hook passed through from admin_enqueue_scripts hook
   * @return boolean
   */
  public function isPostEditor( $hook ) {

    if ( 'post.php' === $hook && isset( $_GET['action'] ) && 'edit' === $_GET['action'] ) {
      return $this->plugin->component('App_Permissions')->user_can_access_post_type();
    }

    if ( 'post-new.php' === $hook && isset( $_GET['post_type'] ) ) {
      return in_array( $_GET['post_type'], $this->plugin->component('App_Permissions')->get_user_post_types(), true );
    }

    if ( 'post-new.php' === $hook && ! isset( $_GET['post_type'] ) ) {
      return in_array( 'post', $this->plugin->component('App_Permissions')->get_user_post_types(), true );
    }

    return false;
  }

  public function get_post_editor_css() {

    ob_start(); ?>

    .cornerstone-active .switch-cornerstone {
      background-color: white;
      color: #555;
      border-bottom-color: white;
    }

    .cs-editor-container {
      margin: 0;
      border: 15px solid #fff;
      padding: 14vmin 1rem;
      text-align: center;
      background-color: #f1f1f1;
    }

    .cs-editor-container-logo {
      width: 120px;
      margin: 0 auto 15px;
    }


    .cs-disable-gutenburg #editor .edit-post-visual-editor .editor-block-list__layout,
    .cs-disable-gutenburg #editor .edit-post-text-editor__body .editor-post-text-editor,
    .cs-disable-gutenburg #editor .edit-post-header-toolbar,
    .cs-disable-gutenburg #editor .edit-post-text-editor__toolbar,
    .cs-disable-gutenburg #editor .interface-interface-skeleton__body .editor-styles-wrapper {
      display: none!important;
    }
    <?php return ob_get_clean();
  }

  /**
   * Register the Dashboard Menu items
   */
  public function dashboard_menu() {

    $title = csi18n('admin.dashboard-title');
    $is_standalone = apply_filters( 'cornerstone_dashboard_home', true );
    $menu_page_slug = $is_standalone ? 'cornerstone-home' : 'cornerstone-settings';

    add_menu_page(
      $title,
      $title,
      'manage_options',
      $menu_page_slug,
      $is_standalone ? array( $this, 'render_home_page' ) : array( $this, 'render_settings_page' ),
      $this->make_menu_icon(),
      4
    );

    if ($is_standalone) {
      add_submenu_page( 'cornerstone-home', $title, csi18n('admin.dashboard-menu-title'), 'manage_options', 'cornerstone-home', array( $this, 'render_home_page' ) );
    }

    $custom_items = $this->get_custom_menu_items('dashboard');

    $settings_path = csi18n('admin.dashboard-settings-path');
    $settings_title = csi18n('admin.dashboard-settings-title');
    $divider = ( count($custom_items) > 1 ) ? 'data-tco-admin-menu-divider' : '';
    $settings_title = "<span $divider>$settings_title</span>";

    add_submenu_page( $menu_page_slug, $title, $settings_title, 'manage_options', 'cornerstone-settings', array( $this, 'render_settings_page' ) );

    global $submenu;

    $previous = null;
    $prev_index;
    $permitted_items = array();


    foreach ($custom_items as $key => $value) {

      $item = array(
        'parent' => $menu_page_slug,
        'divider' => '',
        'class' => $key,
        'title' => $value['title'],
        'capability' => isset( $value['capability'] ) ? $value['capability'] : 'read',
        'url' => $value['url'],
      );

      if ( ! is_null($previous) && $custom_items[$previous]['group'] !== $value['group'] ) {
        $permitted_items[$prev_index]['divider'] = 'data-tco-admin-menu-divider';
      }

      $permitted_items[] = $item;

      $previous = $key;
      $prev_index = count($permitted_items) - 1;

    }

    $end = count($permitted_items) - 1;
    if ( isset( $permitted_items[$end] ) ) {
      $permitted_items[$end]['divider'] = 'data-tco-admin-menu-divider';
    }

    foreach ($permitted_items as $item) {
      $title = '<span ' . $item['divider'] . ' class="' . $item['class'] .'">' . $item['title'] .'</span>';
      $submenu[$item['parent']][] = array( $title, $item['capability'], $item['url'] );
    }

  }

  public function get_theme_options_url() {
    $theme_options_url = $this->plugin->common()->get_app_route_url('theme-options');

    global $wp;

    if ( ! is_admin() && $wp->request ) {
      $theme_options_url .= '?url=' . esc_url( home_url( $wp->request ));
    }

    return $theme_options_url;

  }

  public function get_custom_menu_items( $context ) {

    $permissions = $this->plugin->component('App_Permissions');
    $items = array();

    $is_site_builder = 'pro' === csi18n('app.integration-mode');

    if ( $is_site_builder && $permissions->user_can('headers') ) {
      $items['tco-headers'] = array(
        'title' => csi18n( "common.title.header-builder" ),
        'url' => $this->plugin->common()->get_app_route_url('launch/headers'),
        'group' => 'builders'
      );
    }

    $user_post_types = $permissions->get_user_post_types();

    if ( ! empty( $user_post_types ) ) {
      $items['tco-content'] = array(
        'title' => csi18n( "common.title.page-builder" ),
        'url' => $this->plugin->common()->get_app_route_url('launch/content'),
        'group' => 'builders'
      );
    }

    if ( $is_site_builder && $permissions->user_can('footers') ) {
      $items['tco-footers'] = array(
        'title' => csi18n( "common.title.footer-builder" ),
        'url' => $this->plugin->common()->get_app_route_url('launch/footers'),
        'group' => 'builders'
      );
    }

    if ( $is_site_builder && $permissions->user_can('layouts') ) {
      $items['tco-layouts'] = array(
        'title' => csi18n( "common.title.layout-builder" ),
        'url' => $this->plugin->common()->get_app_route_url('launch/layouts'),
        'group' => 'builders'
      );
    }

    // if ( !current_theme_supports( 'cornerstone-theme-options' ) || $context === 'toolbar') {
      if ( $permissions->user_can('theme_options') ) {
        $items['tco-options'] = array(
          'title' => csi18n( "common.title.options-theme" ),
          'url' => $this->get_theme_options_url(),
          'group' => 'theme-options'
        );
      }
    // }

    if ( $permissions->user_can('templates') ) {
      $items['tco-templates'] = array(
        'title' => csi18n( "common.title.template-manager" ),
        'url' => $this->plugin->common()->get_app_route_url('launch/template-manager'),
        'group' => 'manage'
      );
    }

    if ( $permissions->user_can('content.cs_global_block') ) {
      $items['tco-global-blocks'] = array(
        'title' => csi18n( "common.title.global-blocks" ),
        'url' => $this->plugin->common()->get_app_route_url('launch/global-blocks'),
        'group' => 'manage'
      );
    }

    if ( $permissions->user_can('templates.design_cloud') ) {
      $items['tco-design-cloud'] = array(
        'title' => csi18n( "common.title.design-cloud" ),
        'url' => $this->plugin->common()->get_app_route_url('launch/design-cloud'),
        'group' => 'manage'
      );
    }

    return $items;
  }

  public function render_home_page() {

    if ( ! has_action( '_cornerstone_home_not_validated' ) ) {
      add_action( '_cornerstone_home_not_validated', array( $this, 'render_not_validated' ) );
    }

    do_action( '_cornerstone_home_before' );

    $is_validated             = $this->plugin->common()->is_validated();
    $status_icon_dynamic      = ( $is_validated ) ? '<div class="tco-box-status tco-box-status-validated">' . tco_common()->get_admin_icon( 'unlocked' ) . '</div>' : '<div class="tco-box-status tco-box-status-unvalidated">' . tco_common()->get_admin_icon( 'locked' ) . '</div>';

    include( $this->locate_view( 'admin/home' ) );

    do_action( '_cornerstone_home_after' );

  }

  public function render_not_validated() {
    $this->view( 'admin/home-validation' );
  }

  /**
   * Callback to render the settings page.
   */
  public function render_settings_page() {
    echo cs_tag('div', [ 'class' => 'tco-reset tco-wrap tco-wrap-settings tco-alt-cs', 'data-tco-admin-app' => 'settings' ], '' );
  }

  /**
   * Add "Edit With Cornerstone" links to the WP List tables
   * Filter applied to page_row_actions and post_row_actions
   * @param array $actions
   * @param object $post
   */
  public function addRowActions( $actions, $post ) {

    $skip = array();
    $skip[] = (int) get_option( 'page_for_posts' );

    if ( function_exists('wc_get_page_id') ) {
      $skip[] = (int) wc_get_page_id( 'shop' );
    }

    if ( ! in_array( (int) $post->ID, $skip, true ) && $this->plugin->component('App_Permissions')->user_can_access_post_type( $post ) ) {
      // $url = $this->plugin->common()->get_edit_url( $post );
      $url = preg_replace('/\?lang=.*\/\#/' , '#', $this->plugin->common()->get_edit_url( $post ));
      $label = csi18n('admin.edit-with-cornerstone');
      $actions['edit_cornerstone'] = "<a href=\"$url\">$label</a>";
    }

    return $actions;
  }


  public function populate_admin_toolbar() {

    if ( ! is_user_logged_in() ) {
      return;
    }

    $permissions = $this->plugin->component('App_Permissions');

    $items = array();

    /**
     * Add "Edit with Cornerstone" button on the toolbar
     * This is only added on singlular views, and if the post type is supported
     */

    if ( is_singular() ) {

      $post = $this->plugin->common()->locate_post();

      if ( $post && $permissions->user_can_access_post_type( $post->post_type ) && $this->plugin->common()->uses_cornerstone( $post ) ) {

        $post_type_obj = get_post_type_object( $post->post_type );

        $items['tco-edit-link'] = array(
          'title' => sprintf( csi18n('common.toolbar-edit-link'), $post_type_obj->labels->singular_name ),
          'url' => preg_replace('/\?lang=.*\/\#/' , '#', $this->plugin->common()->get_edit_url( $post )),
          'group' => 'contextual'
        );

      }
    }

    $assignments = CS()->component('Assignments');

    $header = $assignments->get_last_active_header();
    $footer = $assignments->get_last_active_footer();
    $layout = $assignments->get_last_active_layout();

    if ( ! is_null( $header ) && $permissions->user_can('headers') ) {
      $items['tco-edit-header-link'] = array(
        'title' => sprintf( csi18n('common.toolbar-edit-link'), __('Header', '__x__') ),
        'url' => $this->plugin->common()->get_app_route_url( 'headers', $header->get_id(), 'header' ),
        'group' => 'contextual'
      );
    }

    if ( ! is_null( $footer ) && $permissions->user_can('footers')) {
      $items['tco-edit-footer-link'] = array(
        'title' => sprintf( csi18n('common.toolbar-edit-link'), __('Footer', '__x__') ),
        'url' => $this->plugin->common()->get_app_route_url( 'footers', $footer->get_id(), 'footer' ),
        'group' => 'contextual'
      );
    }

    if ( ! is_null( $layout ) && $permissions->user_can('layouts')) {
      $items['tco-edit-layout-link'] = array(
        'title' => sprintf( csi18n('common.toolbar-edit-link'), __('Layout', '__x__') ),
        'url' => $this->plugin->common()->get_app_route_url( 'layouts', $layout->get_id(), 'layout' ),
        'group' => 'contextual'
      );
    }

    $this->front_end_toolbar_items = $items;

  }

  public function addToolbarLinks() {

    global $wp_admin_bar;

    $permitted_items = array();

    $custom_items = $this->get_custom_menu_items('toolbar');

    $settings = [
      'tco-settings' => [
        'title' => csi18n('admin.dashboard-settings-title'),
        'group' => 'settings',
        'capability' => 'manage_options',
        'url' => admin_url( 'admin.php?page=cornerstone-settings' )
      ]
    ];

    $items = array_merge(
      $this->front_end_toolbar_items,
      $settings,
      $this->get_custom_menu_items('toolbar')
    );

    $previous = null;

    foreach ($items as $key => $value) {

      if ( isset( $value['capability'] ) && ! current_user_can( $value['capability'] ) ) {
        continue;
      }

      $item = array(
        'id'     => $key,
        'parent' => 'tco-main',
        'title'  => $value['title'],
        'href'   => $value['url'],
      );

      if ( ! is_null( $previous ) && $items[$previous]['group'] !== $value['group'] ) {
        if ( ! isset( $permitted_items[$prev_index]['meta'] ) ) {
          $permitted_items[$prev_index]['meta'] = array();
        }
        if ( ! isset( $permitted_items[$prev_index]['meta']['class'] ) ) {
          $permitted_items[$prev_index]['meta']['class'] = '';
        }
        $permitted_items[$prev_index]['meta']['class'] .= 'tco-ab-item-divider';
      }

      $previous = $key;

      $permitted_items[] = $item;
      $prev_index = count($permitted_items) - 1;

    }


    if ( empty( $permitted_items ) ) {
      return;
    }

    $logo = $this->make_menu_icon();
    // $logo = $logo ? "<span class=\"tco-admin-bar-logo\">$logo</span>" : '';
    $logo = $logo ? "<span class=\"tco-admin-bar-logo ab-item\" style=\"background-image: url($logo)\"></span>" : '';
    $title = csi18n('common.toolbar-title');

    $wp_admin_bar->add_menu( array(
      'id'    => 'tco-main',
      'title' => $logo . $title,
      'href'  => $this->plugin->common()->get_app_route_url('launch')
    ) );

    foreach ($permitted_items as $permitted_item) {
      $wp_admin_bar->add_menu( $permitted_item );
    }

  }

  public function dashboard_logo() {
    // shoooooooooould work...
    // 
    // global $_wp_admin_css_colors;
    // $color = get_user_option( 'admin_color' );

    // if ( empty( $color ) || ! isset( $_wp_admin_css_colors[ $color ] ) ) {
    //   $color = 'fresh';
    // }

    // $fill = $_wp_admin_css_colors[ $color ]->icon_colors['base'];

    $fill = '#a7aaad';

    ob_start(); ?>

    <svg fill="<?php echo $fill; ?>" viewBox="0 0 792 780" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
      <g stroke="none" stroke-width="1" fill-rule="evenodd">
        <path d="M43.3636095,86.9641283 L736.363609,0.386827599 C763.490826,-3.00220732 788.229136,16.2413912 791.618171,43.3686079 C791.872478,45.4041834 792,47.4535991 792,49.5049985 L792,729.625941 C792,756.964036 769.838095,779.125941 742.5,779.125941 C740.653098,779.125941 738.807643,779.022576 736.972292,778.816331 L43.9722921,700.941331 C18.9307987,698.127325 -1.0349541e-13,676.950049 -1.0658141e-13,651.750941 L-1.13686838e-13,136.082299 C-1.16744203e-13,111.117019 18.5909046,90.0590113 43.3636095,86.9641283 Z M373.599475,463.342808 C355.383475,481.548777 328.059475,491.443326 303.903475,491.443326 C235.395475,491.443326 208.863475,443.553711 208.467475,397.643005 C208.071475,351.336517 236.979475,301.467992 303.903475,301.467992 C328.059475,301.467992 352.611475,309.779413 370.827475,327.5896 L405.675475,293.948135 C377.163475,265.847617 341.523475,251.599467 303.903475,251.599467 C203.715475,251.599467 156.591475,325.214909 156.987475,397.643005 C157.383475,469.675319 200.943475,540.520287 303.903475,540.520287 C343.899475,540.520287 380.727475,527.459483 409.239475,499.358965 L373.599475,463.342808 Z M638.919475,302.655338 C617.931475,259.910888 573.183475,247.641647 530.019475,247.641647 C478.935475,248.037429 422.703475,271.388564 422.703475,328.381164 C422.703475,390.51893 474.975475,405.558644 531.603475,412.286937 C568.431475,416.244756 595.755475,426.930869 595.755475,453.052477 C595.755475,483.131905 564.867475,494.609582 531.999475,494.609582 C498.339475,494.609582 466.263475,481.152995 453.987475,450.677786 L410.427475,473.237357 C431.019475,523.897446 474.579475,541.311851 531.207475,541.311851 C592.983475,541.311851 647.631475,514.794461 647.631475,453.052477 C647.631475,386.956892 593.775475,371.917178 535.959475,364.793103 C502.695475,360.835284 474.183475,354.106991 474.183475,329.964292 C474.183475,309.383631 492.795475,293.156571 531.603475,293.156571 C561.699475,293.156571 587.835475,308.196285 597.339475,324.027563 L638.919475,302.655338 Z"></path>
      </g>
    </svg>

    <?php return ob_get_clean();
  }

  /**
   * Load View files
   */

  public function notices() {

    $show_cornerstone_validation_notice = ( false === get_option( 'cornerstone_dismiss_validation_notice', false ) && ! $this->plugin->common()->is_validated() && ! in_array( get_current_screen()->parent_base, apply_filters( 'cornerstone_validation_notice_blocked_screens', array( 'cornerstone-home' ) ) ) );

    if ( $show_cornerstone_validation_notice && ! apply_filters( '_cornerstone_integration_remove_global_validation_notice', false ) && ! defined( 'X_VERSION') ) {

      tco_common()->admin_notice( array(
        'message' => sprintf( csi18n('admin.validation-global-notice'), admin_url( 'admin.php?page=cornerstone-home' ) ),
        'dismissible' => true,
        'ajax_dismiss' => 'cs_dismiss_validation_notice'
      ) );

    }

  }

  public function make_menu_icon() {
    return 'data:image/svg+xml;base64,' . base64_encode( $this->dashboard_logo() );
  }

  //
  // Style admin menu items (Dashboard only)
  //

  public function get_admin_menu_css() {
    ob_start();
    ?>

      #adminmenu li.toplevel_page_cornerstone-home .wp-menu-image img,
      #adminmenu li.toplevel_page_cornerstone-settings .wp-menu-image img {
        width: 18px;
        height: auto;
        padding: 9px 0 0 0;
        opacity: 1;
      }
    <?php

    return ob_get_clean();
  }


  //
  // Other admin miscellaneous CSS
  //

  public function get_admin_miscellaneous_css() {
    ob_start();

    //Fix menu item's margin
    ?>
      .menu-item-settings .description-thin, .menu-item-settings .description-wide {
          margin-right: 10px !important;
      }
      .menu-item-settings .description-thin[class*="_alt"]:not([class*="image_alt"]),
      .menu-item-settings .description-thin[class*="_alt_alt"],
      .menu-item-settings .description-thin[class*="image_height"] {
          margin-right: 0 !important;
      }
    <?php

    return ob_get_clean();

  }

  //
  // Style admin bar items (Dashboard / Front End + Logged In)
  //

  public function admin_bar_css() {

    ob_start();
    ?>

      .tco-ab-item-divider:not(:last-child) {
        margin-bottom: 5px !important;
        border-bottom: 1px solid rgba(0,0,0,0.1);
        padding-bottom: 5px !important;
        box-shadow: 0 1px 0 rgba(255,255,255,0.05)
      }
      #adminmenu li.menu-top > .wp-submenu > li.tco-menu-divider:not(:last-child) {
        position: relative;
        margin-bottom: 5px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        padding-bottom: 6px;
        box-shadow: 0 1px 0 rgba(255, 255, 255, 0.05);
      }
      #wpadminbar .tco-admin-bar-logo svg {
        width: 19px;
        height: 19px;
        transform: translateY(4px);
      }
      #wp-admin-bar-tco-main {
        line-height: 1 !important;
      }
      #wp-admin-bar-tco-main .ab-item[aria-haspopup] {
        display: inline-flex !important;
        flex-flow: row nowrap !important;
        justify-content: flex-start !important;
        align-items: center !important;
      }
      #wp-admin-bar-tco-main .tco-admin-bar-logo.ab-item {
        display: block !important;
        width: 20px !important;
        height: 20px !important;
        margin-right: 6px !important;
        background-repeat: no-repeat;
      }

    <?php

    wp_add_inline_style( 'admin-bar', ob_get_clean() );

  }



  public function admin_print_scripts() { ?>

    <script>
    jQuery(function($){

      // Add menu dividers
      $('[data-tco-admin-menu-divider]').closest('li').addClass('tco-menu-divider');

      // Fix WordPress "Theme Options" button
      var themeOptionsUrl = '<?php echo $this->plugin->common()->get_app_route_url('theme-options'); ?>';

      $('body').on('click', '.button[href="themes.php?page=' + themeOptionsUrl + '"]', function( e ) {
        e.preventDefault();
        window.location.href = themeOptionsUrl;
      });

    });
    </script>

  <?php

  }

}
