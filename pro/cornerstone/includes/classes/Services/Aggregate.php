<?php

namespace Themeco\Cornerstone\Services;

use Themeco\Cornerstone\Plugin;

class Aggregate implements Service {

  public function __call($name, $args) {
    return $this->{$name};
  }
}