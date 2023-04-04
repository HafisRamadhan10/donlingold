<?php

// =============================================================================
// VIEWS/THEMING/HEADER.PHP
// -----------------------------------------------------------------------------
// Declares the DOCTYPE for the site, includes the <head>, opens the <body>
// element as well as the .tco-root <div> and .tco-site <div>.
// =============================================================================

?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head><?php wp_head(); ?></head>
<body <?php body_class(); ?>><?php

wp_body_open();
do_action( 'cs_body_begin' );