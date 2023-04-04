<?php

namespace Themeco\Cornerstone\Tss\Util;

class IdEncoder {
  protected $base = 0;
  protected $prefix = '';
  protected $nextId = 0;

  public function setup( $base, $prefix = '' ) {
    $this->base = $base;
    $this->prefix = $prefix;
  }

  function encodeIds( $ids = [], $prefix = 'm') {
    $encoded = array_map(function($id) {
      return is_int($id) ? base_convert($id,10,36) : $id;
    }, $ids);
    return $this->prefix  . implode('-', $encoded);
  }

  public function nextId() {
    return $this->encodeIds([$this->base, $this->nextId++ ]);
  }
}