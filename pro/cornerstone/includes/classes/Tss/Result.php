<?php

namespace Themeco\Cornerstone\Tss;

class Result {
  
  protected $complete = false;
  protected $content;

  public function content() {
    return $this->content;
  }

  public function update($value) {
    $this->content = is_callable($value) ? call_user_func( $value, $this->content ) : $value;
  }

  public function isComplete() {
    return $this->complete;
  }

  public function setComplete( $value = true) {
    $this->complete = $value;
  }

}

