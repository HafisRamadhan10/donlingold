<?php

namespace Themeco\Cornerstone\Services;

use Themeco\Cornerstone\Plugin;

class Admin implements Service {

  protected $plugin;

  public function __construct(Plugin $plugin) {
    $this->plugin = $plugin;
  }

  public function setup() {
    // add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    // add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    // add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ] );
  }
}