<?php

// =============================================================================
// VIEWS/PARTIALS/PAGINATION.PHP
// -----------------------------------------------------------------------------
// Pagination partial.
// =============================================================================

$classes                  = ( isset( $classes )  ) ? $classes  : [];
$custom_atts              = ( isset( $custom_atts )  ) ? $custom_atts  : null;
$pagination_numbered_hide = isset( $pagination_numbered_hide  ) ? $pagination_numbered_hide : '';

// Prepare Attr Values
// -------------------

$atts = [
  'class' => array_merge( [ 'x-paginate' ], $classes ),
  'role'  => 'navigation',
];

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

if ( isset( $style ) && ! empty( $style ) ) {
  $atts['style'] = $style;
}

$atts = cs_apply_effect( $atts, $_view_data );


// Previous / Next
// ---------------

$prev_output = $pagination_items_prev_text;
$next_output = $pagination_items_next_text;

if ( $pagination_items_prev_next_type === 'icon' ) {
  $prev_output = cs_get_partial_view( 'icon', [ 'icon' => $pagination_items_prev_icon ] ) . '<span class="screen-reader-text">' . $pagination_items_prev_text . '</span>';
  $next_output = cs_get_partial_view( 'icon', [ 'icon' => $pagination_items_next_icon ] ) . '<span class="screen-reader-text">' . $pagination_items_next_text . '</span>';
}

$prev_output_rtl_sanitized = is_rtl() ? $next_output : $prev_output;
$next_output_rtl_sanitized = is_rtl() ? $prev_output : $next_output;


// Args (Base)
// -----------

$args = null;

if ( $pagination_type !== 'post-nav' ) {
  $args = array(
    'type'         => 'plain',
    'aria_current' => 'page',
    'prev_next'    => true,
    'prev_text'    => $prev_output_rtl_sanitized,
    'next_text'    => $next_output_rtl_sanitized,
    'end_size'     => $pagination_numbered_end_size, // either side of '...'
    'mid_size'     => $pagination_numbered_mid_size, // either side of 'current'
    'show_all'     => false,
    'echo'         => false
  );
}


// Args (Products)
// ---------------

if ( $pagination_type === 'product' ) {
  // $base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
  // $format  = isset( $format ) ? $format : '';
  // $current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
  // $total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );

  $base    = esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
  $format  = '';
  $current = wc_get_loop_prop( 'current_page' );
  $total   = wc_get_loop_prop( 'total_pages' );

  $args['base']     = $base;
  $args['format']   = $format;
  $args['add_args'] = false;
  $args['current']  = max( 1, $current );
  $args['total']    = $total;

  $args = apply_filters( 'woocommerce_pagination_args', $args );
}


// Output
// ------
// 01. The "output" (i.e. text or icon set) here is flipped because of how
//     WordPress handles this markup. For example, we consider older (read:
//     "previous" posts) to be what users expect to come "next" when going
//     back in time on an archive, which is why we swap these around.

ob_start();
$hideClass = '';

if ( $pagination_numbered_hide && $pagination_numbered_hide !== 'xl' && $pagination_numbered_hide !== 'none') {
  $activeRanges = CS()->novus()->service('Breakpoints')->activeBreakpointRangeKeys();
  array_pop($activeRanges); // remove XL option
  $index = array_search( $pagination_numbered_hide, $activeRanges);
  if ($index !== false) {
    // var_dump($activeRanges);
    $classes = array_map(function($key){
      return "cs-hide-$key";
    }, array_slice($activeRanges,0,$index + 1));

    if (count($classes) > 0) {
      $hideClass = ' ' . implode(' ', $classes);
    }

  }

}


if ( $pagination_type === 'comment' && ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) ) {
  if ( $pagination_numbered_hide === 'xl' ) {
    previous_comments_link( $prev_output_rtl_sanitized );
    next_comments_link( $next_output_rtl_sanitized );
  } else {
    echo str_replace("class=\"page-numbers\"", "class=\"page-numbers$hideClass\"", paginate_comments_links( $args ));
  }
}

if ( $pagination_type === 'post' || $pagination_type === 'product' ) {
  if ( $pagination_numbered_hide === 'xl' ) {
    echo get_posts_nav_link( array( 'sep' => '', 'prelabel' => $prev_output_rtl_sanitized, 'nxtlabel' => $next_output_rtl_sanitized ) );
  } else {
    echo str_replace("class=\"page-numbers\"", "class=\"page-numbers$hideClass\"", paginate_links( $args ));
  }
}

if ( $pagination_type === 'post-nav' ) {
  $older_post = get_adjacent_post( false, '', true );
  $newer_post = get_adjacent_post( false, '', false );

  if ( gettype( $newer_post ) === 'object' ) {
    echo '<a href="' . get_permalink( $newer_post ) . '" rel="next">' . $prev_output_rtl_sanitized . '</a>'; // 01
  }

  if ( gettype( $older_post ) === 'object' ) {
    echo '<a href="' . get_permalink( $older_post ) . '" rel="prev">' . $next_output_rtl_sanitized . '</a>'; // 01
  }
}

$pagination_content = ob_get_clean();

echo cs_tag( 'nav', $atts, $custom_atts, cs_tag( 'div', [ 'class' => 'x-paginate-inner' ], $pagination_content ) );