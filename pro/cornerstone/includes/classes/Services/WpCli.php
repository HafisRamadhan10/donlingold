<?php

namespace Themeco\Cornerstone\Services;

use Themeco\Cornerstone\WpCli\Commands;

class WpCli implements Service {

  public function setup() {

    if ( class_exists( 'WP_CLI' ) ) {
      \WP_CLI::add_command( 'cs', Commands::class );
    }
  }

}
