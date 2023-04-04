<?php

namespace Themeco\Cornerstone\Tss;

use Themeco\Cornerstone\Parsy\Token;

class ContainerConfig {

  protected $modules = [];
  protected $deps = [];

  public function setup($input ) {

    if (is_array( $input ) ) {
      if (isset($input['modules'])) {
        $this->modules = array_map( [$this, 'normalizeModule'], $input['modules'] );
      }
      if (isset($input['require'])) {
        if ( is_string( $input['require'] ) ) {
          $this->deps = [ $input['require'] ];
        } else if ( is_array( $input['require'])) {
          $this->deps = $input['require'];
        }
      }
    }
  }

  public function deps() {
    return $this->deps;
  }

  public function normalizeModule($module) {
    if ( is_string( $module ) ) {
      return $this->normalizeModule( [$module, []] );
    }

    list($name, $config) = $module;
    $base = [
      'module'     => $name,
      'name'       => null,
      'args'       => [],
      'nested'     => false,
      'remap'      => null,
      'conditions' => []
    ];

    $normalized = array_merge($base, $config);
    $normalized['class-key'] = is_null($normalized['name']) ? $name : $normalized['name'];
    return $normalized;
  }

  public function normalizeModuleArgs($env, $module) {
    $normalized = [];

    foreach ($module['args'] as $key => $value) {
      $normalized[] = $env->parseModuleArg( $key, $value );
    }
    $module['args'] = $normalized;
    return $module;
  }

  public function modules() {
    return $this->modules;
  }

  public function modulesForEnv($env) {
    return array_map( function( $module) use ($env) {
      return $this->normalizeModuleArgs( $env, $module );
    }, $this->modules );
  }
}