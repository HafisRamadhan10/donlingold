<?php

namespace Themeco\Cornerstone;
use Themeco\Cornerstone\Util\IocContainer;

class Plugin {

  protected static $instance;
  protected $path;
  protected $url;

  protected $container;
  protected $services_container = [];
  protected $services = [];
  protected $registry = [];

  /**
   * Create the plugin and assign basic configuration properties
   */
  public function __construct( $path, $url ) {
    $this->path = untrailingslashit( $path );
    $this->url = untrailingslashit( $url );
    $this->setupContainer();
  }

  public function setupContainer() {
    $this->container = new IocContainer;
    $this->container->register(__CLASS__, $this);
    $this->container->setRegistrationHandler(function($class, $instance, $interfaces, $reflector) {
      if ( isset( $interfaces[ __NAMESPACE__ . '\Services\Service'])) {
        $this->container->register($class, $instance);
        if ( $reflector->hasMethod('setup') ) {
          $instance->setup();
        }

        if ( $reflector->hasMethod('init') ) {
          if (did_action('init')) {
            $instance->init();
          } else {
            add_action('init', [$instance, 'init']);
          }
        }
      }
    });
  }

  public function initialize( $services = [], $registry = [] ) {

    $this->registry = $registry;

    // Organize services by their hooks
    $this->services = [];
    foreach ($services as $class => $groups ) {
      if (!is_array($groups)) $groups = [$groups];
      foreach ($groups as $group ) {
        if (!isset($this->services[$group])) $this->services[$group] = [];
        $this->services[$group][] = $class;
      }
    }

    // Load services registered to run immediately
    if ( isset( $this->services['debug'] ) && defined('WP_DEBUG') && WP_DEBUG ) {
      $this->setup_services( 'debug' );
    }

    if ( isset( $this->services['preinit'] ) ) $this->setup_services( 'preinit' );
    if ( isset( $this->services['is_admin']) && is_admin() && ! wp_doing_ajax() ) $this->setup_services( 'is_admin' );
    if ( isset( $this->services['is_ajax'] ) && is_admin() && wp_doing_ajax() ) $this->setup_services( 'is_ajax' );

    // Load services by their registered hooks
    foreach ($this->services as $name => $group) {
      if (in_array( $name, [ 'debug', 'preinit', 'is_admin', 'is_ajax'] ) ) continue;
      add_action( $name, $this->make_setup_services( $name ) );
    }

    add_action( 'init', function() {
      load_plugin_textdomain( 'cornerstone', false, $this->path . '/lang' );
    } );

  }

  /**
   * Create a function we can use to defer setting up
   * a group of services on a WordPress action
   */
  public function make_setup_services($group) {
    $setup = function() use ($group) {
      $this->setup_services( $group );
    };
    $setup->bindTo($this);
    return $setup;
  }

  /**
   * Resolve and setup all services registered to a group
   */
  public function setup_services($group) {
    if ( isset($this->services[$group]) ) {
      foreach ($this->services[$group] as $name) {
        $this->resolve( $name );
      }
    }
  }

  /**
   * Simple ioc container and dependency injection.
   * Services (that implement the Service interface) will be
   * registered as singletons
   */
  public function resolve($class) {
    return $this->container->resolve($class);
  }

  public function service( $name ) {
    return $this->resolve( __NAMESPACE__ . "\Services\\$name" );
  }

  /**
   * Plugin getter function allowing quick access to read only properties
   * and anything placed into $registry when the plugin was initialized
   */
  public function __get($name) {
    switch ($name) {
      case 'path':
      case 'url':
        return $this->{$name};
      default:
        return isset($this->registry[$name]) ? $this->registry[$name] : null;
    }
  }

  /**
   * Allow properties to be retrieved statically as well
   */
  public static function __callStatic($name, $arguments) {
    switch ($name) {
      case 'path':
      case 'url':
        return self::$instance->{$name};
      default:
        return isset(self::$instance->registry[$name]) ? self::$instance->registry[$name] : null;
    }
  }

  /**
   * Singleton Instantiation
   */
  public static function instance() {
    return self::$instance;
  }

  public static function instantiate( $path, $url ) {
    self::$instance = new self( $path, $url );
    spl_autoload_register([__CLASS__, 'autoloader']);
  }

  public static function autoloader($class) {
    $prefix = 'Themeco\\Cornerstone\\';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $filename = self::$instance->path . '/includes/classes/' . str_replace('\\', '/', substr($class, $len)) . '.php';
    if (file_exists($filename)) require_once $filename;
  }

}
