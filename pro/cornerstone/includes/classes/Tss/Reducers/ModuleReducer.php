<?php

namespace Themeco\Cornerstone\Tss\Reducers;

use Themeco\Cornerstone\Tss\Util\IdEncoder;

class ModuleReducer {

  protected $idEncoder;

  public function __construct(IdEncoder $idEncoder) {
    $this->idEncoder = $idEncoder;
  }

  public function setup( $id ) {
    $this->idEncoder->setup($id, 'm');
  }

  public function id() {
    return $this->idEncoder->nextId();
  }

  public function reduce($input) {

    $reducedProperties = [];

    foreach ($input as $modName => $moduleResult) {
      list($containerId, $moduleName, $declarations) = $moduleResult;

      foreach ($declarations as $qualifier => $declaration) {
        $value = $declaration[0];
        $qualified = "$qualifier::$value";
        if (!isset( $reducedProperties[$qualified])) {
          $reducedProperties[$qualified] = [
            $declaration,
            []
          ];
        }
        $reducedProperties[$qualified][1][$modName] = [$containerId, $moduleName];
      }
    }


    $reducedContainers = [];

    foreach ($reducedProperties as $key => $item) {
      $reducedProperties[$key][] = implode(':', array_keys($item[1]));
    }

    foreach ($reducedProperties as $key => $item) {
      list($declarations, $containers, $qualifier) = $item;

      if (!isset($reducedContainers[$qualifier])) {
        $reducedContainers[$qualifier] = [$containers, []];
      }

      $reducedContainers[$qualifier][1][$key] = $declarations;

    }

    $containerResult = [];
    $combinedDeclarations = [];

    foreach ($reducedContainers as $item) {
      list($containers, $declarations) = $item;


      foreach ($containers as $container) {
        list($containerId, $moduleName) = $container;
        if (!isset( $containerResult[$containerId])) {
          $containerResult[$containerId] = [];
        }

        if (!isset( $containerResult[$containerId][$moduleName])) {
          $containerResult[$containerId][$moduleName] = [];
        }

      }

      if (count($declarations) <= 0) {
        continue;
      }

      $id = $this->id();

      foreach ($containers as $container) {
        list($containerId, $moduleName) = $container;
        $containerResult[$containerId][$moduleName][] = $id;
      }

      foreach ($declarations as $qualifier => $item) {
        $item[2] = str_replace('$m', '.' . $id, $item[2]);
        $combinedDeclarations[] = $item;
      }
    }

    return [$containerResult, $combinedDeclarations];

  }

}