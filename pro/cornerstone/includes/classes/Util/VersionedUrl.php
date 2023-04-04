<?php

namespace Themeco\Cornerstone\Util;

class VersionedUrl {

  public function get( $asset, $ext ) {
    return CS()->versioned_url( $asset, $ext );
  }

}