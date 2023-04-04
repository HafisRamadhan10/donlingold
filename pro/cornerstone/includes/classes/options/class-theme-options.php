<?php

class Cornerstone_Theme_Options extends Cornerstone_Plugin_Component {

  protected $defaults = array();
  protected $options = array();

  public function setup() {
    if ( ! current_theme_supports( 'cornerstone-theming' ) ) {
      $this->register_options( $this->plugin->config_group( 'options/defaults' ) );
    }
    $this->register_option( 'cs_safe_layouts', false );
  }

  public function get_values() {

    $values = array();
    $defaults = $this->get_defaults();

    foreach ($defaults as $key => $default) {
      $values[$key] = $this->get_value( $key );
    }

    return $values;

  }

  public function get_config() {
    $global_css_key = apply_filters( 'cs_global_css_option', 'cs_v1_custom_css' );
    $global_js_key = apply_filters( 'cs_global_js_option', 'cs_v1_custom_js' );

    return array(
      'globalCssKey' => $global_css_key,
      'globalJsKey'  => $global_js_key,
      'previewExclusions' => array_merge(
        [ $global_css_key, $global_js_key ],
        apply_filters('cs_theme_option_preview_exclusions',[])
      )
    );
  }

  public function get_controls() {

    $data = [];

    if ( ! current_theme_supports( 'cornerstone-theming' ) ) {
      $data = $this->plugin->config_group( 'options/controls' );
    }

    return apply_filters( 'cs_theme_options_controls', $data );

  }

  public function register_option( $name, $default_value, $options = array() ) {

    if ( isset( $this->defaults[ $name ] ) ) {
      trigger_error( "cornerstone_options_register_option | An option named '$name' has already been registered." );
      return;
    }

    $this->defaults[ $name ] = $default_value;
    $this->options[ $name ] = $options;

  }

  public function register_options( $group, $options = array() ) {

    foreach ( $group as $name => $item ) {
      $this->register_option( $name, $item, $options );
    }
  }

  public function unregister_option( $name ) {

    unset( $this->defaults[ $name ] );
    unset( $this->options[ $name ] );

  }

  public function get_default( $name ) {

    if ( ! isset( $this->defaults[ $name ] ) ) {
      return $this->_not_registered();
    }

    return $this->defaults[ $name ];

  }

  public function get_defaults() {
    return $this->defaults;
  }

  public function get_value( $name ) {

    if ( ! isset( $this->defaults[ $name ] ) ) {
      return $this->_not_registered();
    }

    $store_as = ( isset( $this->options[ $name ]['store_as'] ) && is_string( $this->options[ $name ]['store_as'] ) ) ? $this->options[ $name ]['store_as'] : false;

    if ( 'theme_mod' === $store_as ) {
      return get_theme_mod( $name, $this->get_default( $name ) );
    }

    if ( 'option' === $store_as || ! is_string( $store_as ) ) {
      return get_option( $name, $this->get_default( $name ) );
    }

    $options = get_option( $store_as );

    if ( ! is_array( $options ) || ! isset( $options[ $name ] ) ) {
      return $this->get_default( $name );
    }

    return $options[ $name ];

  }

  public function update_value( $name, $value ) {

    if ( ! isset( $this->defaults[ $name ] ) ) {
      return $this->_not_registered();
    }

    $store_as = ( isset( $this->options[ $name ]['store_as'] ) && is_string( $this->options[ $name ]['store_as'] ) ) ? $this->options[ $name ]['store_as'] : false;

    if ( 'theme_mod' === $store_as ) {
      return set_theme_mod( $name, $value );
    }

    if ( 'option' === $store_as || ! is_string( $store_as ) ) {
      if ( is_bool($value) ) {
        $value = sanitize_key($value); // Convert bool to "1" and ""
      }
      return update_option( $name, $value );
    }

    $options = get_option( $store_as );

    if ( ! is_array( $options ) ) {
      $options = array();
    }

    $options[ $name ] = $value;

    return update_option( $store_as, $options );

  }

  public function is_registered( $name ) {
    return isset( $this->defaults[ $name ] );
  }

  protected function _not_registered() {
    trigger_error( "cornerstone_options_get_default | The option '$name' was never registered." );
    return;
  }


}
