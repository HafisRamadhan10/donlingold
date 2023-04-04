<?php

namespace Themeco\Cornerstone\Util;

class Factory {

  protected static $instance;

  public function __construct() {
    $this->container = new IocContainer;
  }

  public static function create($className) {
    if (!isset(self::$instance)) {
      self::$instance = new self;
    }
    return self::$instance->container->resolve($className);
  }

}