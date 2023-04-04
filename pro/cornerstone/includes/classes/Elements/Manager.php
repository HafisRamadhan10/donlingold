<?php

namespace Themeco\Cornerstone\Elements;

class Manager {

  protected $proxy;

  public function register() {
    $this->proxy = CS()->component('Element_Manager');
    $this->proxy->init();
  }

  public function __call($name, $args) {
    return call_user_func_array( [$this->proxy, $name], $args);
  }

}