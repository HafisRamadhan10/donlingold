<?php

class Cornerstone_Save_Controller extends Cornerstone_Plugin_Component {

  protected $handlers = array();
  protected $builder_handlers = array();

  public function setup() {
    $routing = $this->plugin->component( 'Routing' );
    $routing->add_route('post', 'save', [$this, 'save']);
  }

  public function add_handler( $name, $callback ) {
    $this->handlers[$name] = $callback;
  }

  public function add_builder_handler( $name, $callback ) {
    $this->builder_handlers[$name] = $callback;
  }

  public function save($params) {

    if (!isset($params['requests'])) {
      throw new Error('Nothing requested');
    }

    $results = array();
    $errors = array();
    $context = isset($params['context']) ? $params['context'] : array();

    foreach ($params['requests'] as $key => $request_params) {
      try {
        $args = array_merge( $context, $request_params );
        if ($key === 'builder' && is_callable($this->builder_handlers[$request_params['type']]) ) {
          $results[$key] = call_user_func_array($this->builder_handlers[$request_params['type']], array( $args ) );
        } elseif (is_callable($this->handlers[$key])) {
          $results[$key] = call_user_func_array($this->handlers[$key], array( $args ) );
        } else {
          throw new Exception('No handler registered ' . json_encode($params));
        }
      } catch (Exception $e) {
        $results[$key] = array( 'error' => $e->getMessage() );
      }
    }
    
    
    return $results;

  }

}
