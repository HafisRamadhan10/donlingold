<?php

namespace Themeco\Cornerstone\Tss\Operations;

use Themeco\Cornerstone\Tss\Traits\StackAccessor;

class Operation {
  
  use StackAccessor;

  protected $content;

  public function setup($content) {
    $this->content = $content;
  }

}