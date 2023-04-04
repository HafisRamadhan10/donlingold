<?php

class Cornerstone_Color_Manager extends Cornerstone_Plugin_Component {

  public $queue = array();
  protected $stored_color_items;
  protected $color_items;
  protected $font_config;

  public function setup() {
    add_filter( 'cs_css_post_process_color', array( $this, 'css_post_process_color') );
    add_filter( 'cs_css_post_process_tss-color', array( $this, 'css_post_process_tss_color') );
  }

  public function default_color_items() {
    return apply_filters( 'cornerstone_option_model_defaults_cornerstone_color_items', array(
      array(
        'title'   => csi18n( 'app.colors.brand-primary' ),
        'value'   => 'transparent',
        '_id'     => md5('brand-primary' . microtime()),
      ),
      array(
        'title'   => csi18n( 'app.colors.brand-secondary' ),
        'value'   => 'transparent',
        '_id'     => md5('brand-secondary' . microtime()),
      ),
      array(
        'title'   => csi18n( 'app.colors.link' ),
        'value'   => 'transparent',
        '_id'     => md5('link' . microtime()),
      ),
      array(
        'title'   => csi18n( 'app.colors.link-interaction' ),
        'value'   => 'transparent',
        '_id'     => md5('link-interaction' . microtime()),
      )
    ));
  }

  public function get_stored_color_items() {
    if ( ! $this->stored_color_items ) {
      $this->stored_color_items = $this->load_colors();
    }

    return $this->stored_color_items;
  }

  public function get_color_items() {

    if ( ! $this->color_items ) {
      $this->color_items = array_merge( $this->get_stored_color_items(), $this->get_extended() );
    }

    return $this->color_items;

  }

  public function get_extended() {
    return apply_filters('cs_colors_extend', array() );
  }

  public function get_app_data() {
    return array(
      'items' => $this->get_stored_color_items()
    );
  }

  protected function load_colors() {
    $stored = get_option( 'cornerstone_color_items' );
    if ($stored === false ) {
      $stored = wp_slash( cs_json_encode( $this->default_color_items() ) );
      update_option( 'cornerstone_color_items', $stored );
    }

    return apply_filters( 'cs_color_items', ( is_null( $stored ) ) ? array() : json_decode( wp_unslash( $stored ), true ) );

  }

  public function locate_color( $_id ) {
    $this->get_color_items();
    foreach ($this->color_items as $color) {
      if ( isset( $color['_id'] ) && $_id === $color['_id'] ) {
        return $color;
      }
    }
    return array(
      'color' => 'transparent'
    );
  }

  public function css_post_process_color( $value ) {

    if ( false !== strpos( $value, 'global-color:' ) ) {

      while (preg_match( '/global-color:([\w\d-]+)/', $value, $matches ) ) {
        $color = $this->locate_color( $matches[1] );
        // var_dump($matches[1]);
        $value = str_replace($matches[0], isset( $color['value'] ) ? $color['value'] : 'transparent', $value );
      }

    }

    return $value;
  }

  public function css_post_process_tss_color( $value ) {

    $color = $this->locate_color( $value );
    if ($color && isset( $color['value'] )) {
      return $color['value'];
    }

    return 'transparent';
  }

}
