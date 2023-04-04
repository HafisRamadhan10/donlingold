<?php

namespace Themeco\Theme\Util;

class IocContainer {

  protected $container = [];
  protected $registrationHandler;

  public function register($class, $instance) {
    $this->container[$class] = $instance;
  }

  public function setRegistrationHandler($cb) {
    $this->registrationHandler = $cb;
  }

  public function resolve() {

    $args = func_get_args();
    $class = array_shift($args);

    if (isset( $this->container[$class] ) ) return $this->container[$class];

    if (!class_exists($class)) {
      throw new \Exception("Class $class not found");
    }

    $reflector = new \ReflectionClass($class);

    $interfaces = $reflector->getInterfaces();

    $constructor = $reflector->getConstructor();
    $plugin_class = get_class();

    if ( $constructor ) {

      $param_map = function($param) use ($args, $plugin_class ){

        if (!$param->hasType()) {
          return array_shift($args);
        }

        $type = $param->getType();

        if ($type->isBuiltin()) {
          return array_shift($args);
        }

        $className = null;

        if (PHP_VERSION_ID > 71000)  {
          $className = (string) $type;
        } else {
          $className = $type->getName();
        }

        return $className === $plugin_class ? $this : $this->resolve($className);

      };

      $param_map->bindTo($this);
      $parameters = array_map($param_map, $constructor->getParameters());

      $instance = $reflector->newInstanceArgs($parameters);
    } else {
      $instance = $reflector->newInstance();
    }

    $cb = $this->registrationHandler;
    if (is_callable($cb)) {
      $cb($class, $instance, $interfaces,$reflector);
    }

    return $instance;
  }

}