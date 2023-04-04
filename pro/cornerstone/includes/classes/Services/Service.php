<?php

namespace Themeco\Cornerstone\Services;

/**
 * Classes that implement this interface will be stored as singletons
 * in the resolver.
 */

interface Service {

}

/**
 * Services can be registered in boot.php
 * - Service constructors should not perform initialization code
 * - When a setup function is present, it will run when the service is instantiated
 * - When an init function is present, it will be attached to the WordPress init action or run immediately if that already happened
 *
 * The keys are services and the values are WordPress hooks
 * where the service's setup function should be called. Value could also be the following
 * strings which run immediately, but under certain conditions
 *   'preinit' Runs immediately
 *   'debug' Runs is WP_DEBUG is enabled
 *   'is_admin' Runs if is_admin() is true, but not wp_doing_ajax()
 *   'is_ajax' Runs if both is_admin() and wp_doing_ajax() are true
 */
