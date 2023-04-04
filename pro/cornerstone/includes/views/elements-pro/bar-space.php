<?php

// =============================================================================
// VIEWS/ELEMENTS-PRO/BAR-SPACE.PHP
// -----------------------------------------------------------------------------
// Bar space element.
// =============================================================================

// Prepare Classes
// ---------------

$_classes = [ $style_id, $_tss['bar'], 'x-bar-space', 'x-bar-space-' . $_region, $_region === 'left' || $_region === 'right' ? 'x-bar-space-v' : 'x-bar-space-h' ];

if ( isset( $class ) ) {
  $_classes[] = $class;
}

// Prepare Atts
// ------------

$atts = [ 'class' => $_classes ];

if ( $_region === 'top' ) {
  $atts['style'] = 'display: none;';
}


// Output
// ------

echo cs_tag( 'div', $atts, null );
