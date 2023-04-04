<?php

/**
 * Plugin boilerplate.
 * This bootstraps the plugin and activates the required components.
 */

use Themeco\Cornerstone\Plugin;

abstract class Cornerstone_Plugin_Base {

  // Optionally override in a child class to adjust behavior
  protected $init_priority = 10;
  protected $admin_init_priority = 10;
  protected $includes_folder = 'includes';
  protected $config_folder = 'includes/config';
  protected $i18n_folder = 'includes/i18n';
  protected $templates_folder = 'templates';
  protected $theme_template_folder = ''; // defaults to slug

  // These should never be overriden by the child class
  protected $registry;
  protected $components = array();
  protected $config_store = array();
  protected $i18n_strings = array();
  protected $name = 'Cornerstone';
  protected $slug = 'cornerstone';
  protected $path;
  protected $url;
  protected $i18n_path;

  /**
   * Assign plugin variables
   */
  public function __construct( $path, $i18n_path, $url ) {
    $this->path = $path;
    $this->i18n_path = $i18n_path;
    $this->url = $url;
  }

  public function novus() {
    return Plugin::instance();
  }

  /**
   * Run after plugin instantiation
   */
  public function superPreinit() {

    $this->preinitBefore();

    $plugin_setup = apply_filters( '_cs_plugin_setup', $this->path('includes/setup.php' ) );
    if ( file_exists ( $plugin_setup ) ) {
      require_once( $plugin_setup );
    }

    // Load WP-CLI commands
    if ( defined( 'WP_CLI' ) && WP_CLI ) {
      $this->loadFiles( 'wp-cli' );
      $this->loadComponents( 'wp-cli' );
    }

    $this->components = array();
    $this->registry = include $this->path( $this->includes_folder . '/registry.php' );

    // Load preinit files and components
    $this->loadFiles( 'preinit' );
    $this->loadComponents( 'preinit' );
    do_action( 'cornerstone_integrations' );

    // Defer actions
    add_action( 'init', array( $this, 'init' ), $this->init_priority );
    add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );
    add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
    add_action( 'admin_init', array( $this, 'adminInit' ), $this->admin_init_priority );
    $this->preinitAfter();
    $this->maybe_deactivate_x_shortcodes();

  }

  public function maybe_deactivate_x_shortcodes() {
    if (defined( 'X_SHORTCODES_VERSION' )) {
      include_once( ABSPATH . '/wp-admin/includes/plugin.php' );
      deactivate_plugins( array( 'x-shortcodes/x-shortcodes.php' ) );
      remove_action( 'init', 'x_shortcodes_init' );
    }
  }

  /**
   * Perform boilerplate init actions
   * @return none
   */
  public function init() {

    $this->initBefore();

    // Load init files and components
    $this->loadFiles( 'init' );
    $this->loadComponents( 'init' );
    $this->versionMigration();

    $this->initAfter();

    // Load user/admin classes
    if ( ! is_user_logged_in() ) {
      return;
    }

    $this->loggedinBefore();

    // Load logged-in files and components
    $this->loadFiles( 'loggedin' );
    $this->loadComponents( 'loggedin' );

    $this->loggedinAfter();

  }

  /**
   * Perform boilerplate init actions
   * @return none
   */
  public function after_setup_theme() {

    // Load after_setup_theme files and components
    $this->loadFiles( 'after_setup_theme' );
    $this->loadComponents( 'after_setup_theme' );

  }

  public function adminInit() {

    $this->adminBefore();

    // Load logged-in files and components
    $this->loadFiles( 'admin' );
    $this->loadComponents( 'admin' );

    $this->adminAfter();

  }

  public function plugins_loaded() {
    do_action( 'cornerstone_integrations' );
  }

  /**
   * Require a set of registered files
   * @param  string  $group A group of files found in registry.php
   * @return bool whether or not the operation suceeded
   */
  public function loadFiles( $group ) {

    if ( ! isset( $this->registry['files'][ $group ] ) ) {
      return false;
    }

    $includes = $this->registry['files'][ $group ];

    if ( ! is_array( $includes ) ) {
      return false;
    }

    try {
      foreach ( $includes as $filename ) {
        require_once $this->path( "$this->includes_folder/$filename.php" );
      }
    } catch ( Exception $e ) {
      trigger_error( 'Exception: ' .  $e->getMessage() );
      return false;
    }

    return true;

  }

  /**
   * Instantiate a set of component classes
   * @param  string  $group A group of componenets found in registry.php
   * @return bool whether or not the operation suceeded
   */
  public function loadComponents( $group ) {

    if ( ! isset( $this->registry['components'][ $group ] ) ) {
      return false;
    }

    $components = $this->registry['components'][ $group ];

    if ( ! is_array( $components ) ) {
      return;
    }

    foreach ( $components as $component ) {
      $this->component( $component );
    }

  }

  public function get_registry() {
    $args = func_get_args();
    $registry = null;
    $args = array_reverse($args);
    $level = $this->registry;
    while(count($args)) {
      $key = array_pop( $args );
      if ( isset( $level[$key] ) ) {
        $level = $level[$key];
      } else {
        return null;
      }
    }

    return $level;
  }

  public function loadComponent( $name ) {

    if ( ! isset( $this->components[ $name ] ) ) {

      $class = $this->name . '_' . $name;
      $exists = false;

      try {
        $exists = class_exists( $class );
      } catch ( Exception $e ) {
        trigger_error( 'Exception: ' . $e->getMessage() . "\n" );
      }

      if ( ! $exists ) {
        return false;
      }

      $name = $this->componentConditions( $name );

      if ( false === $name ) {
        return false;
      }

      $instance = new $class( $this );
      $this->components[ $name ] = $instance;
      $instance->beforeDependencies();

      if ( is_array( $instance->dependencies ) ) {
        foreach ( $instance->dependencies as $component ) {
          $this->component( $component );
        }
      }

      $instance->setup();

    }

    return $this->components[ $name ];

  }

  public function componentConditions( $name ) {

    $name = explode( ':', $name );

    if ( count( $name ) === 1 ) {
      return $name[0];
    }

    if ( $name[1] == 'theme-support' ) {

      if ( isset( $name[2] ) && current_theme_supports( $name[2] ) ) {
        return $name[0];
      }

    }

    return false;
  }

  /**
   * Returns a component instance via its name
   * @return object Component instance
   */
  public function component( $handle ) {
    return $this->loadComponent( $handle );
  }

  /**
   * Gets the path to the Cornerstone plugin directory.
   * Should be used in combination with the instance wrapper funciton.
   * For example: $path = CS()->path();
   * This will include a trailing slash, so do not include one when using $to
   * @param  string  $to Path to desired location relative to the plugin path.
   * @return string filterable equivilent of plugin_dir_path( __FILE__ )
   */
  public function path( $to = '' ) {
    return apply_filters( $this->slug . '_path', $this->path ) . $to;
  }

  /**
   * Gets the url to the plugin directory.
   * Should be used in combination with the instance wrapper funciton.
   * This will include a trailing slash, so do not include one when using $to
   * @param  string  $to URL to desired location relative to the plugin URL.
   * @return string filterable equivilent of plugin_dir_url( __FILE__ )
   */
  public function url( $to = '' ) {
    return apply_filters( $this->slug . '_url', $this->url ) . $to;
  }


  /**
   * Returns the plugin name
   * @return string
   */
  public function name() {
    return $this->name;
  }

  /**
   * Returns the plugin slug
   * @return string
   */
  public function slug() {
    return $this->slug;
  }

  /**
   * Simple version migration system
   * Hook into `myplugin_updated` and test against the supplied
   * version number to conditionally run migration logic
   * @return none
   */
  public function versionMigration() {
    $prior = get_option( $this->slug . '_version', 0 );

    if ( version_compare( $prior, CS_VERSION, '>=' ) ) {
      return;
    }

    do_action( $this->slug .'_updated', $prior );

    update_option( $this->slug . '_version', CS_VERSION, true );

  }

  public function get_template_part( $slug, $name = null, $load = true ) {

    do_action( 'get_template_part_' . $slug, $slug, $name );

    $templates = array();
    if ( isset( $name ) ) {
      $templates[] = $slug . '-' . $name . '.php';
    }
    $templates[] = $slug . '.php';

    $templates = apply_filters( $this->slug . '_get_template_part', $templates, $slug, $name );

    return $this->locate_template( $templates, $load, false );

  }

  /**
   * Retrieve the name of the highest priority template file that exists.
   *
   * Searches in the STYLESHEETPATH before TEMPLATEPATH so that themes which
   * inherit from a parent theme can just overload one file. If the template is
   * not found in either of those, it looks in the theme-compat folder last.
   *
   * @param string|array $template_names Template file(s) to search for, in order.
   * @param bool $load If true the template file will be loaded if it is found.
   * @param bool $require_once Whether to require_once or require. Default true.
   *                            Has no effect if $load is false.
   * @return string The template filename if one is located.
   */
  public function locate_template( $template_names, $load = false, $require_once = true ) {

    $filename = false;

    foreach ( (array) $template_names as $template_name ) {

      if ( empty( $template_name ) ) {
        continue;
      }

      $template_name = untrailingslashit( $template_name );

      $theme_template_folder = trailingslashit( ( '' !== $this->theme_template_folder ) ?
      $this->theme_template_folder : $this->slug );

      // Check child theme first
      $child = get_stylesheet_directory() . '/' . $theme_template_folder . $template_name;
      if ( file_exists( $child ) ) {
        $filename = $child;
        break;
      }

      $parent = get_template_directory() . '/' . $theme_template_folder . $template_name;
      if ( file_exists( $parent ) ) {
        $filename = $parent;
        break;
      }

      $plugin = $this->path( "$this->templates_folder/$template_name" );
      if ( file_exists( $plugin ) ) {
        $filename = $plugin;
        break;
      }
    }

    if ( $load && ! empty( $filename ) ) {
      load_template( $filename, $require_once );
    }

    return $filename;

  }

  /**
   * Find a template so we can include it ourselves.
   * Doesn't run through `load_template` so some globals may need to be declared.
   * This can be used to load markup used in the dashboard.
   */
  public function template( $slug, $name = null, $echo = true ) {

    ob_start();

    $template = $this->get_template_part( $slug, $name, false );

    if ( $template ) {
      include( $template );
    }

    $contents = ob_get_clean();

    if ( $echo ) {
      echo $contents;
    }

    return $contents;

  }

  /**
   * Include a view file, optionally outputting its contents.
   */
  public function view( $name, $echo = true, $data = array(), $extract = false ) {

    ob_start();

    $view = $this->locate_view( $name );

    if ( $extract ) {
      extract( $data );
    }

    if ( $view ) {
      include( $view );
    }

    $contents = ob_get_clean();

    if ( $echo ) {
      echo $contents;
    }

    return $contents;

  }

  public function locate_view( $name ) {

    $file = $this->path( 'includes/views/' . $name . '.php' );

    if ( ! file_exists( $file ) ) {
      return false;
    }

    return $file;

  }

/**
   *
   * @param
   * @param  string path to config file
   * @return array
   */
  /**
   * Retrieve a particular configuration set and apply filters.
   * @param  string $name      string path to config file
   * @param  string $namespace namespace to prepend to key for caching
   * @param  string $path      alternate path
   * @return array            requested configuration values
   */
  public function config_group( $name = '', $namespace = '', $path = '', $abs_path = false ) {

    $key = ( $namespace ) ? "{$namespace}.{$name}" : $name;
    $path = ( $path ) ? $path : $this->config_folder;
    if ( ! isset( $this->config_store[ $key ] ) ) {

      $config_path = trailingslashit( $path ) . $name . '.php';
      if ( ! $abs_path ) {
        $config_path = $this->path( $config_path );
      }
      $value = include( $config_path );
      $data = is_array( $value ) ? $value : array();

      /**
       * Filter example: $name == 'folder/defaults-file'
       * 'plugin_config_folder_defaults-file'
       * 'plugin_config_folder_defaults-file'
       */
      $filter_name = sanitize_key( str_replace( '.', '_', str_replace( '/', '_', $key ) ) );
      $this->config_store[ $key ] = apply_filters( "{$this->slug}_config_{$filter_name}", $data );

    }

    return $this->config_store[ $key ];

  }

  public function config( $group_name, $item ) {
    $group = $this->config_group( $group_name );
    return ( isset( $group[$item] ) ) ? $group[$item] : null;
  }

  /**
   * Get a named set of localized strings from the i18n directory
   * @param  string  $group      Name of the strings file to load
   * @param  boolean $namespace Should we prepend a namespace to the keys?
   * @return array              Localized strings
   */
  public function i18n_group( $group, $namespace = true, $filter = '' ) {

    $strings = $this->config_group( $group, 'i18n', $this->i18n_path, true );

    if ( $filter ) {

      $filtered = array();

      foreach ($strings as $key => $value) {
        if ( 0 === strpos($key,"$filter.") ) {
          $k = substr($key, strlen($filter) + 1);
          $filtered[$k] = $value;
        }
      }

      $strings = $filtered;

    }

    if ( ! $namespace ) {
      return $strings;
    }

    $namespaced = array();
    $namespace = $filter ? $filter : $group;

    foreach ( $strings as $key => $value ) {
      $namespaced["$namespace.$key"] = $value;
    }

    return $namespaced;
  }

  public function i18n( $key ) {

    if ( ! isset( $this->i18n_strings[ $key ] ) ) {
      $group = 'common';
      $group_index = strpos($key, '.');
      if ( -1 !== $group_index ) {
        $group = substr( $key, 0, $group_index );
      }
      $strings = $this->i18n_group( $group );
      foreach ($strings as $string => $value) {
        $this->i18n_strings[ $string ] = $value;
      }
    }

    return isset( $this->i18n_strings[ $key ] ) ? $this->i18n_strings[ $key ] : '';
  }

  /**
   * Plugin entry point.
   * @param  string $file This should be __FILE__ from the main plugin file
   * @return bool true if the instance was generated for the first time
   */
  public static function run( $path, $i18n_path, $url ) {

    if ( ! defined( 'ABSPATH' ) ) {
      die();
    }

    $class = new ReflectionClass( 'Cornerstone_Plugin' );

    if ( ! is_null( $class->getStaticPropertyValue( 'instance', null ) ) ) {
      return false;
    }

    $instance = $class->newInstance( $path, $i18n_path, $url );

    // Setup as a singleton for global access
    if ( $class->hasProperty( 'instance' ) ) {
      $class->setStaticPropertyValue( 'instance', $instance );
    } else {
      // If the child doesn't have an instance property, we'll create a global variable.
      $GLOBALS[ $slug . '_plugin' ] = $instance;
    }

    $instance->superPreinit();

    return true;

  }

  /**
   * Methods to optionally override in child class
   */
  protected function preinitBefore() {}
  protected function preinitAfter() {}
  protected function initBefore() {}
  protected function initAfter() {}
  protected function loggedinBefore() {}
  protected function loggedinAfter() {}
  protected function adminBefore() {}
  protected function adminAfter() {}

}


/**
 * Offers simple dependency injection
 * Automatically creates a reference to the main plugin
 * Having your components extend this class allows you to do things like:
 *
 * $this->plugin->url( 'path/to/file' )
 */
abstract class Cornerstone_Plugin_Component {

  protected $plugin;
  public $dependencies = false;
  protected $path = '';
  protected $url = '';

  public function __construct( $plugin ) {

    $this->plugin = $plugin;

  }

  public function setup() { }
  public function beforeDependencies() { }

  /**
   * Shortcut to plugin path method including component local path additions.
   * @param  $to (optional) Append to the current path
   * @return string
   */
  public function path( $to = '' ) {
    return trailingslashit( $this->plugin->path( $this->path ) ) . $to;
  }

  /**
   * Shortcut to plugin url method including component local path additions.
   * @param  $to (optional) Append to the current url
   * @return string
   */
  public function url( $to = '' ) {
    return trailingslashit( $this->plugin->url( $this->url ) ) . $to;
  }

  /**
   * Returns a component instance via its name
   * @return object Component instance
   */
  public function component( $handle ) {
    return $this->plugin->component($handle);
  }

  /**
   * Passthrough get_template_part
   * This runs through WordPress `load_template` when $load is true
   */
  public function get_template_part( $slug, $name = null, $load = true ) {
    return $this->plugin->get_template_part( $slug, $name, $load );
  }

  /**
   * Find a template so we can include it ourselves.
   * Doesn't run through `load_template` so some globals may need to be declared.
   * This can be used to load markup used in the dashboard.
   */
  public function template( $slug, $name = null, $echo = true ) {

    ob_start();

    $template = $this->plugin->get_template_part( $slug, $name, false );

    if ( $template ) {
      include( $template );
    }

    $contents = ob_get_clean();

    if ( $echo ) {
      echo $contents;
    }

    return $contents;

  }

  /**
   * Get the path to a view so it can be passed to "include", preserving scope.
   */
  public function locate_view( $name ) {
    return $this->plugin->locate_view( $name );
  }

  /**
   * Include a view file, optionally outputting its contents.
   */
  public function view( $name, $echo = true, $data = array(), $extract = false ) {

    ob_start();

    $view = $this->locate_view( $name );

    if ( $extract ) {
      extract( $data );
    }

    if ( $view ) {
      include( $view );
    }

    $contents = ob_get_clean();

    if ( $echo ) {
      echo $contents;
    }

    return $contents;

  }

  public function i18n_group( $group, $namespace = true, $filter = '' ) {
    return $this->plugin->i18n_group( $group, $namespace, $filter );
  }

  public function config_group( $group, $namespace = true, $path = '' ) {
    return $this->plugin->config_group( $group, $namespace, $path );
  }

  public function config_item( $group, $key = null ) {
    return $this->plugin->config( $group, $key );
  }

}


class Cornerstone_Plugin extends Cornerstone_Plugin_Base {

	public static $instance;
	protected $init_priority = -1000;

	/**
	 * Common Component Accessor
	 * @return object reference to Cornerstone_Common instance
	 */
	public function common() {
		return $this->component( 'Common' );
	}

	/**
	 * Shortcut to getting javascript asset URLs.
	 * @param  string asset name. For example: "admin/builder"
	 * @return string URL to asset
	 */
	public function js( $asset ) {
		return $this->versioned_url( "assets/js/$asset", 'js');
	}

	/**
	 * Shortcut to getting css asset URLs.
	 * @param  string asset name. For example: "admin/builder"
	 * @return string URL to asset
	 */
	public function css( $asset ) {
		return $this->versioned_url( "assets/css/$asset", 'css' );
	}

	public function versioned_url( $asset, $ext ) {

    if ( ! defined( 'CS_ASSET_REV' ) ) {
      define( 'CS_ASSET_REV', CS_VERSION );
    }

    if (CS_ASSET_REV) {
      // Return matching asset rev file if it exists
      $rev = CS_ASSET_REV;

      $path = "$asset.$rev.$ext";
      $filename = $this->path( $path );

      if (file_exists($filename)) {
        return array(
          'asset_rev' => true,
          'url' => $this->url($path),
          'version' => defined('CS_APP_BUILD_TOOLS') && CS_APP_BUILD_TOOLS ? time() : null
        );
      }
    }

		// Return a unversioned file if it exists
		$basepath = $this->path($asset);
		$unversioned = "$basepath.$ext";

		if (file_exists($unversioned)) {
			return array(
				'unversioned' => true,
				'url' => $this->url("$asset.$ext"),
				'version' => null
			);
		}

		// Try to detect a versioned file that wasn't declared
		$files = glob("$basepath.*.$ext", GLOB_NOSORT);

		if (count($files) > 0) {

			$urlpath = dirname($asset);
			$filename = basename($files[0]);

			return array(
				'versioned' => true,
				'url' => $this->url("$urlpath/$filename"),
				'version' => null
			);
		}

		// If we can't find anything, return a fallback to the exact requested URL even though it will 404
		return array(
			'not_found' => true,
			'url' => $this->url("$asset.$ext"),
			'version' => null
		);

	}

	/**
	 * Get array of Cornerstone settings with defaults applied
	 * @return array
	 */
	public function settings() {
		return wp_parse_args( get_option( 'cornerstone_settings', array() ), $this->config_group( 'common/default-settings' ) );
	}

	/**
	 * Return plugin instance.
	 * @return object  Singleton instance
	 */
	public static function instance() {
		return ( isset( self::$instance ) ) ? self::$instance : false;
	}

	/**
	 * Run immediately after object instantiation, before anything else is loaded.
	 * @return void
	 */
	public function preinitBefore() {

		// Register class autoloader
    $classes = glob( self::$instance->path( 'includes/classes' ) . '/*', GLOB_ONLYDIR );
    $classic_classes = glob( self::$instance->path( 'includes/classes/classic' ) . '/*', GLOB_ONLYDIR );
    $this->autoload_directories = array_merge( $classes, $classic_classes );
		spl_autoload_register( array( __CLASS__, 'autoloader' ) );

    add_action( 'cornerstone_updated', array( $this, 'update' ) );
	}

	public function update( $prior ) {

		/**
		 * Run if coming from a version prior to Before 1.0.7
		 * if ( version_compare( $prior, '1.0.7', '<' ) ) {
		 * }
		 */

    // if ( ! is_null( $prior ) ) {
    //
    // }

    CS()->component('Cleanup')->clean_generated_styles();
    CS()->component('Caching')->clear_all_caches();

	}

	/**
	 * Cornerstone class autoloader.
	 * @param  string $class_name
	 * @return void
	 */
	public static function autoloader( $class_name ) {

		if ( false === strpos( $class_name, self::$instance->name ) ) {
			return;
		}

		$class = str_replace( self::$instance->name . '_', '', $class_name );
		$file = 'class-' . str_replace( '_', '-', strtolower( $class ) ) . '.php';

		foreach ( self::$instance->autoload_directories as $directory ) {

			$path = $directory . '/' . $file;

			if ( ! file_exists( $path ) ) {
				continue;
			}

			require_once( $path );

		}

  }

}


/**
 * Access Cornerstone without a global variable
 * @return object  main Cornerstone instance.
 */
function CS($component = '') {
	if ($component) {
		return Cornerstone_Plugin::instance()->component( $component );
	}
	return Cornerstone_Plugin::instance();
}
