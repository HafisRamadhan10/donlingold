<?php

// =============================================================================
// VIEWS/PARTIALS/TOGGLE.PHP
// -----------------------------------------------------------------------------
// Toggle partial.
// =============================================================================

$classes = ( isset( $classes ) ) ? $classes : [];

// Prepare Attr Data
// -----------------

$toggle_type_group         = preg_replace( '/-\d/', '', $toggle_type );
$toggle_type_deconstructed = explode( '-', $toggle_type );
$toggle_type_number        = end( $toggle_type_deconstructed );


// Prepare Atts
// ------------

$atts = [
  'class'       => array_merge( [ 'x-toggle', 'x-toggle-' . $toggle_type_group ], $classes ),
  'aria-hidden' => "true",
];


// Output
// ------

?>

<span <?php echo cs_atts( $atts ); ?>>

  <?php if ( $toggle_type_group == 'burger' ) : ?>

    <span class="x-toggle-burger-bun-t" data-x-toggle-anim="x-bun-t-<?php echo $toggle_type_number; ?>"></span>
    <span class="x-toggle-burger-patty" data-x-toggle-anim="x-patty-<?php echo $toggle_type_number; ?>"></span>
    <span class="x-toggle-burger-bun-b" data-x-toggle-anim="x-bun-b-<?php echo $toggle_type_number; ?>"></span>

  <?php elseif ( $toggle_type_group == 'grid' ) : ?>

    <span class="x-toggle-grid-center" data-x-toggle-anim="x-grid-<?php echo $toggle_type_number; ?>"></span>

  <?php elseif ( $toggle_type_group == 'more-h' || $toggle_type_group == 'more-v' ) : ?>

    <span class="x-toggle-more-1" data-x-toggle-anim="x-more-1-<?php echo $toggle_type_number; ?>"></span>
    <span class="x-toggle-more-2" data-x-toggle-anim="x-more-2-<?php echo $toggle_type_number; ?>"></span>
    <span class="x-toggle-more-3" data-x-toggle-anim="x-more-3-<?php echo $toggle_type_number; ?>"></span>

  <?php endif; ?>

</span>