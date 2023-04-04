<?php

class Cornerstone_Element_Registry extends Cornerstone_Plugin_Component {
  protected $settings = array();
  protected $values = array();
  protected $control_partials = array();
  protected $sorter;
  protected $registry_loaded = false;
  protected $partials_loaded = false;

  public function setup() {
    require_once( $this->path( 'includes/elements/values.php' ) );
    $this->sorter = new Cornerstone_Stable_Sort( array( $this, 'prioritize_control' ) );
  }

  public function load_registry() {
    if ( ! $this->registry_loaded ) {
      $this->registry_loaded = true;
      require_once( $this->path( 'includes/elements/registry-setup.php' ) );
      do_action( 'cs_registry_setup' );
    }
  }

  public function load_partials() {
    if ( ! $this->partials_loaded ) {
      $files = $this->plugin->get_registry( 'elements', 'control-partials' );
      $path = $this->path( 'includes/elements/control-partials' );
      foreach ($files as $file) {
        $filename = "$path/$file.php";
        if ( file_exists($filename) ) {
          require_once( $filename );
        }
      }
    }
  }

  public function remember( $key, $value ) {
    $this->maybe_warn();

    if ( isset( $this->settings[ $key ] ) ) {
      return;
    }

    $this->settings[ $key ] = $value;
  }

  public function recall( $key, $args = [] ) {
    $this->maybe_warn();
    $this->load_registry();

    if ( ! isset( $this->settings[ $key ] ) ) {
      return [];
    }

    if ( ! is_array( $this->settings[ $key ] ) ) {
      return $this->settings[ $key ];
    }

    return array_merge( $this->settings[$key], $args );
  }

  public function maybe_warn() {
    $in_builder = did_action('cs_before_late_data') || did_action( 'cornerstone_before_boot_app' );
    if ( ! $in_builder && ! isset($_REQUEST['tco-debug']) ) {
      trigger_error( sprintf( 'cs_remember/cs_recall used outside of builder context | %s line %s', debug_backtrace()[2]['file'], debug_backtrace()[2]['line'] ), E_USER_WARNING );
    }
  }

  public function define_values( $key, $values ) {

    if ( isset( $this->values[ $key ] ) ) {
      return trigger_error( "cs_define_values | $key already defined.", E_USER_WARNING );
    }

    if ( ! is_array( $values )) {
      return trigger_error( 'cs_define_values | values must be an array', E_USER_WARNING );
    }

    $this->values[ $key ] = $values;

  }

  /**
   * Take a set of values and optionally apply a key prefix
   * If you pass a string for the first parameter it will look up
   * values in the registry
   * @param string/array $values
   * @param string $key_prefix
   * @return array
   */
  public function values( $values, $key_prefix = '' ) {

    if ( is_string( $values ) ) {
      $values = isset( $this->values[ $values ] ) ? $this->values[ $values ] : array();
    }

    if ( $key_prefix ) {
      $prefixed = array();
      foreach ( $values as $key => $value ) {
        $prefixed[ $key_prefix . '_' . $key ] = $value;
      }
      return $prefixed;
    }

    return $values;

  }

  public function compose_values( $all_values ) {

    $composed = array();

    foreach( $all_values as $_values ) {
      $values = is_string( $_values ) ? $this->values( $_values ) : $_values;

      foreach ( $values as $key => $value ) {
        if ( ! $value ) {
          unset( $composed[ $key ] );
        } else {
          $composed[ $key ] = $value;
        }
      }
    }

    return $composed;

  }

  public function prioritize_control( $a, $b ) {

    $prioritized_a = isset( $a['priority'] ) ? $a['priority'] : 10;
    $prioritized_b = isset( $b['priority'] ) ? $b['priority'] : 10;

    if ($prioritized_a === $prioritized_b) {
      return 0;
    }

    return ($prioritized_a < $prioritized_b) ? -1 : 1;
  }

  public function compose_partials( $control_sets ) {

    $result = array(
      'controls' => array(),
      'control_nav' => array()
    );

    $groups = array();

    foreach ($control_sets as $control_set) {
      foreach( $result as $key => $value ) {
        if ( isset( $control_set[ $key ] ) ) {
          $result[ $key ] = array_merge( $result[ $key ], $control_set[ $key ] );
          if ($key !== 'control_nav') {
            $result[ $key ] = $this->sorter->sort( $result[ $key ] );
          }
        }
      }
    }

    return $result;

  }


  public function register_control_partial( $name, $function ) {
    if ( isset( $this->control_partials[ $name ] ) ) {
      return;
    }

    if ( ! is_callable( $function ) ) {
      return trigger_error( 'cs_register_control_partial was not passed a function as the second argument.', E_USER_WARNING );
    }

    $this->control_partials[ $name ] = $function;
  }

  public function apply_control_partial( $name, $settings = array() ) {
    $this->load_partials();
    if ( ! isset( $this->control_partials[ $name ] ) ) {
      trigger_error( "attempting to apply non-existent control partial: $name", E_USER_WARNING );
      return array();
    }

    if ( isset( $settings['condition'] ) && ! isset( $settings['conditions'] ) ) {
      $settings['conditions'] = array( $settings['condition'] );
    }

    return call_user_func( $this->control_partials[ $name ], $settings );
  }

}
