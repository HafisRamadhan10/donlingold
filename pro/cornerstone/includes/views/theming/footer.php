<?php

// =============================================================================
// VIEWS/THEMING/FOOTER.PHP
// -----------------------------------------------------------------------------
// Includes the wp_footer() hook and closes out the .x-site <div>, .x-root
// <div>, <body> and <html> tags.
// =============================================================================

do_action( 'cs_body_end' );
wp_footer();
echo "</body></html>";