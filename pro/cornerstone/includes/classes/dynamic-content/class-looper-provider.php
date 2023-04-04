<?php

abstract class Cornerstone_Looper_Provider {

  protected $current_data = array();
  protected $index = 0;
  protected $disposed = false;
  protected $manager = null;
  protected $current_consumer = false;
  protected $error = null;

  public function setup( $element ) {}

  public function begin() {}

  public function pause() {}

  public function resume() {}

  public function end() {}

  abstract public function advance();

  abstract public function rewind();

  abstract public function get_context();

  abstract public function get_index();

  abstract public function get_size();

  final public function dispose() {
    if ( ! $this->disposed ) {
      $this->end();
    }
  }

  final protected function set_error( $error ) {
    $this->error = $error;
  }

  final public function get_error() {
    return $this->error;
  }

  final public function consume() {
    $result = $this->advance();
    $this->current_data = $result ? $result : array();
    $complete = empty($result);
    if ( $complete ) {
      $this->dispose();
      return false;
    }
    return true;
  }

  final public function set_current_consumer( $current_consumer ) {
    $this->current_consumer = $current_consumer;
  }

  final public function current_consumer() {
    return $this->current_consumer;
  }

  final public function get_current_data() {
    return $this->current_data;
  }

  final public function set_manager( $manager ) {
    $this->manager = $manager;
  }

  static public function looper_factory( $type ) {
    switch ( $type ) {
      case 'query-recent':
        return new Cornerstone_Looper_Provider_User_Query( [ 'is_recent' => true ] );
      case 'query-builder':
        return new Cornerstone_Looper_Provider_User_Query( [ 'is_builder' => true ] );
      case 'query-string':
        return new Cornerstone_Looper_Provider_User_Query( [ 'is_string' => true ] );
      case 'taxonomy':
        return new Cornerstone_Looper_Provider_Taxonomy();
      case 'page-children':
        return new Cornerstone_Looper_Provider_Page_Children();
      case 'terms':
        return new Cornerstone_Looper_Provider_Terms();
      case 'json':
        return new Cornerstone_Looper_Provider_Json();
      case 'string':
        return new Cornerstone_Looper_Provider_String();
      case 'custom':
        return new Cornerstone_Looper_Provider_Custom();
      case 'key-array':
        return new Cornerstone_Looper_Provider_Key_Array();
      case 'dc':
        return new Cornerstone_Looper_Provider_Dynamic_Content();
      default:
       return null;
    }
  }

  static public function create( $element, $manager ) {

    /**
     * Can be used to supply an instance of an external class that extends Cornerstone_Looper_Provider
     add_filter('cs_resolve_looper_provider', function($value, $element) {
        return new My_Custom_Looper( $element );
      }, 10, 2 );
     */

    $provider = apply_filters( 'cs_resolve_looper_provider', null, $element );

    if ( is_null( $provider ) ) {
      $provider = self::looper_factory( $element['looper_provider_type'] );
    }

    if ( is_a( $provider, 'Cornerstone_Looper_Provider' ) ) {
      $provider->set_manager( $manager );
      $provider->setup( $element );
      return $provider;
    }

    throw new Exception('Unable to determine source type');
  }

}
