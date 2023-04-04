<?php

// =============================================================================
// VIEWS/PARTIALS/FRAME.PHP
// -----------------------------------------------------------------------------
// Frame partial.
// =============================================================================


$atts        = ( isset( $atts )        ) ? $atts        : array();
$custom_atts = ( isset( $custom_atts ) ) ? $custom_atts : null;

// Prepare Attr Values
// -------------------

$frame_classes = [ 'x-frame' ];

if ( isset( $frame_content_type ) && ! empty( $frame_content_type ) ) {
  $frame_classes[] = 'x-frame-' . $frame_content_type;
}

// Output
// ------

echo cs_tag('div', [ 'class' => $frame_classes ], $atts, $custom_atts, cs_tag( 'div', ['class' => 'x-frame-inner'], $frame_content) );
