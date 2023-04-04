<?php

add_filter( 'cs_resolve_looper_provider', function( $provider, $element ) {

  if ( $element['looper_provider_type'] === 'dc') {
    list( $type, $field, $args ) = CS()->component('Dynamic_Content')->parse_string( $element['looper_provider_dc'] );

    if ( $type === 'acf' && in_array( $field, [ 'post_field', 'term_field', 'user_field', 'option_field' ]) && isset( $args['field'] ) ) {

      $id = Cornerstone_Dynamic_Content_ACF::instance()->normalize_acf_id( $field, $args );
      if ( ! is_null( $id ) ) {
        $field_settings = get_field_object( $args['field'], $id );
        if ( $field_settings && $field_settings['type'] === 'repeater' ) {
          return new Cornerstone_Looper_Provider_ACF_Repeater( $id, $args['field'] );
        }
      }

    }
  }

  return $provider;

}, 10, 2 );


add_action( 'cs_dynamic_content_register', function() {
  Cornerstone_Dynamic_Content_ACF::instance();
});

add_action( 'tco_routes', function() {
  Cornerstone_Dynamic_Content_ACF::instance();
});


class Cornerstone_Dynamic_Content_ACF {

  protected static $instance;

  public function __construct() {
    add_filter( 'cs_dynamic_content_acf', [ $this, 'supply_field' ], 10, 3 );
    add_filter( 'cs_dynamic_content_acf', [ $this, 'supply_field_legacy' ], 10, 3 );
    add_action( 'cs_dynamic_content_setup', [ $this, 'register' ] );
    add_filter( 'cs_dynamic_content_before_expand', [ $this, 'legacy_acf' ] );
    add_filter( 'cs_dynamic_options_acf_post_fields', [ $this, 'populate_post_fields' ], 10, 2 );
    add_filter( 'cs_dynamic_options_acf_term_fields', [ $this, 'populate_term_fields' ], 10, 2 );
    add_filter( 'cs_dynamic_options_acf_user_fields', [ $this, 'populate_user_fields' ], 10, 2 );
    add_filter( 'cs_dynamic_options_acf_option_fields', [ $this, 'populate_option_fields' ], 10, 3 );
    add_filter( 'cs_looper_field', [ $this, 'looper_field' ], 10, 2 );
  }

  public static function instance() {
    if ( ! isset( self::$instance ) ) {
      self::$instance = new Cornerstone_Dynamic_Content_ACF();
    }
    return self::$instance;
  }

  public function register() {
    cornerstone_dynamic_content_register_group(array(
      'name'  => 'acf',
      'label' => csi18n('app.dc.group-title-acf')
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'post_field',
      'group' => 'acf',
      'type'  => 'mixed',
      'label' => 'Post Field',
      'controls' => array( 'acf-post-field', 'post' ),
      'deep' => true
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'term_field',
      'group' => 'acf',
      'type'  => 'mixed',
      'label' => 'Term Field',
      'controls' => array( 'acf-term-field', 'term' ),
      'deep' => true
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'user_field',
      'group' => 'acf',
      'type'  => 'mixed',
      'label' => 'User Field', // NEED TO LOCALIZE
      'controls' => array( 'acf-user-field', 'user' ),
      'deep' => true
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'option_field',
      'group' => 'acf',
      'type'  => 'mixed',
      'label' => 'Option Field', // NEED TO LOCALIZE
      'controls' => array( 'acf-option-field' ),
      'deep' => true
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'post_field_setting',
      'group' => 'acf',
      'type'  => 'mixed',
      'label' => 'Post Field Setting',
      'controls' => array( 'acf-post-field', 'post', 'acf-setting' ),
      'deep' => true
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'term_field_setting',
      'group' => 'acf',
      'type'  => 'mixed',
      'label' => 'Term Field Setting',
      'controls' => array( 'acf-term-field', 'term', 'acf-setting' ),
      'deep' => true
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'user_field_setting',
      'group' => 'acf',
      'type'  => 'mixed',
      'label' => 'User Field Setting', // NEED TO LOCALIZE
      'controls' => array( 'acf-user-field', 'user', 'acf-setting' ),
      'deep' => true
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'option_field_setting',
      'group' => 'acf',
      'type'  => 'mixed',
      'label' => 'Option Field Setting', // NEED TO LOCALIZE
      'controls' => array( 'acf-option-field', 'acf-setting' ),
      'deep' => true
    ));

  }



  public function supply_field( $result, $field, $args = array() ) {

    if ( ! isset( $args['field'] ) ) {
      return $result;
    }

    switch ($field) {
      case 'post_field':
      case 'term_field':
      case 'user_field':
      case 'option_field':
        $id = $this->normalize_acf_id( $field, $args);
        if ( ! is_null( $id ) ) {
          $result = get_field( $args['field'], $id, true );
        }
        break;
      case 'post_field_setting':
      case 'term_field_setting':
      case 'user_field_setting':
      case 'option_field_setting':

        $id = $this->normalize_acf_id( $field, $args);

        if ( ! is_null( $id ) && isset( $args['key'] ) ) {
          $field_settings = get_field_object( $args['field'], $id );

          if ( $field_settings ) {
            $result = cs_get_path( $field_settings, $args['key']);
          }
        }
        break;
      case 'sub_field':
        $result = get_sub_field( $args['field'] );
        break;
    }

    return $result;
  }

  // Get a normalized ACF resource ID https://www.advancedcustomfields.com/resources/get_field/
  public function normalize_acf_id( $type, $args = []) {

    $dc = CS()->component('Dynamic_Content');
    switch ( $type ) {
      case 'post':
      case 'post_field':
      case 'post_field_setting':
        global $post;
        $requested_post = $dc->get_contextual_post( $args );
        return !$requested_post || $post->ID === $requested_post->ID ? false : $requested_post->ID;
      case 'term':
      case 'term_field':
      case 'term_field_setting':
        $term = $dc->get_contextual_term( $args );
        return is_a( $term, 'WP_Term' ) ? $term->taxonomy . '_' . $term->term_id : null;
      case 'user':
      case 'user_field':
      case 'user_field_setting':
        $user = $dc->get_contextual_user( $args );
        return is_a( $user, 'WP_User' )  ? 'user_' . $user->ID : null;
      case 'option':
      case 'option_field':
      case 'option_field_setting':
        return 'option';
    }
    return null;
  }

  // legacy directives. Runs through acf_shortcode which converts arrays to strings
  public function supply_field_legacy( $result, $field, $args = array() ) {

    if ( ! isset( $args['field'] ) ) {
      return $result;
    }

    switch ($field) {
      case 'field':
        $post = CS()->component('Dynamic_Content')->get_contextual_post( $args );
        $result = acf_shortcode( [ 'field' => $args['field'], 'post_id' => $post->ID ] );
        break;
      case 'option':
        $result = acf_shortcode( [ 'field' => $args['field'], 'post_id' => 'option' ] );
        break;
    }

    return $result;
  }



  public function get_normalized_field_options( $type, $id, $data_type ) {
    $options = [];
    $args = [];

    if ( $id ) {
      $args[$type] = $id;
    }

    $acf_id = $this->normalize_acf_id( $type, $args, false );
    $fields = get_fields($this->normalize_acf_id( $type, $args, false ) );

    if ( is_array( $fields ) ) {

      foreach ($fields as $key => $value) {
        $setting = get_field_object( $key, $acf_id );

        $format = isset( $setting['return_format'] ) ? $setting['return_format'] : 'string';
        $scalar = ( is_scalar( $value ) || $format === 'id' ) && ! in_array( $format, [ 'object', 'array']);

        if ( $data_type === 'scalar' && $scalar ) {
          $options[] = array( 'label' => sprintf("%s - %s", $setting['label'], $value), 'value' => $key );
        }

        if ( $data_type === 'array' && ! $scalar ) {
          $options[] = array( 'label' => sprintf("%s (%s)", $setting['label'], acf_get_field_type_prop( $setting['type'], 'label' )), 'value' => $key );
        }

      }
    }

    return $options;

  }

  public function populate_post_fields( $options, $args = array() ) {

    if ( isset( $args['context'] ) && isset( $args['context']['post'] ) && $args['context']['post'] ) {
      $options = array_merge( $options, $this->get_normalized_field_options( 'post', $args['context']['post'], isset( $args['context']['type'] ) ? $args['context']['type'] : 'scalar') );
    }

    return $options;

  }


  public function populate_term_fields( $options, $args = array() ) {

    if ( isset( $args['context'] ) && isset( $args['context']['term'] ) && $args['context']['term'] ) {

      $options = array_merge( $options, $this->get_normalized_field_options( 'term', $args['context']['term'], isset( $args['context']['type'] ) ? $args['context']['type'] : 'scalar') );
    }
    return $options;
  }

  public function populate_user_fields( $options, $args = array() ) {
    if ( isset( $args['context'] ) && isset( $args['context']['user'] ) && $args['context']['user'] ) {
      $options = array_merge( $options, $this->get_normalized_field_options( 'user', $args['context']['user'], isset( $args['context']['type'] ) ? $args['context']['type'] : 'scalar') );
    }
    return $options;
  }

  public function populate_option_fields( $options, $args = array() ) {

    return array_merge( $options, $this->get_normalized_field_options( 'option', null, isset( $args['context']['type'] ) ? $args['context']['type'] : 'scalar') );

  }

  /**
   * Earlier versions of Cornersone allowed for this ACF syntax: {{acf:field_name}}
   * This function continues to support it for older content even though {{dc:acf:field}} is the new syntax.
   */
  public function legacy_acf( $content ) {
    return function_exists( 'acf_shortcode' ) && is_string( $content )
      ? preg_replace_callback( '/{{[aA][cC][fF]:([A-Za-z0-9_-]*?)}}/', array( $this, 'legacy_acf_expand_callback' ), $content )
      : $content;
  }

  public function legacy_acf_expand_callback( $matches ) {
    return acf_shortcode( array('field' => $matches[1]) );
  }

  public function looper_field( $result, $args ) {
    if ( is_a( CS()->component('Looper_Manager')->get_provider(), 'Cornerstone_Looper_Provider_ACF_Repeater' ) ) {
      $result = get_sub_field( $args['key'] );
    }
    return $result;
  }
}


class Cornerstone_Looper_Provider_ACF_Repeater extends Cornerstone_Looper_Provider {

  protected $acf_id; // https://www.advancedcustomfields.com/resources/get_field/

  public function __construct( $acf_id, $selector ) {
    $this->acf_id = $acf_id;
    $this->selector = $selector;
  }

  public function advance() {
    if ( have_rows( $this->selector, $this->acf_id ) ) {
      return the_row();
    }
    return false;
  }

  public function rewind() {
    acf_update_loop('active', 'i', -1);
  }

  public function get_context() {
    return acf_get_loop('active', 'value');
  }

  public function get_index() {
    return acf_get_loop('active', 'i');
  }

  public function get_size() {
    return count( acf_get_loop('active', 'value') );
  }

}