<?php

// =============================================================================
// VIEWS/PARTIALS/MODAL.PHP
// -----------------------------------------------------------------------------
// Modal partial.
// =============================================================================

$classes              = ( isset( $classes )              ) ? $classes                              : [];
$modal_custom_atts    = ( isset( $modal_custom_atts )    ) ? $modal_custom_atts                    : null;
$modal_content_atts   = ( isset( $modal_content_atts )   ) ? $modal_content_atts                   : [];
$modal_close_location = ( isset( $modal_close_location ) ) ? explode( '-', $modal_close_location ) : explode( '-', 'top-right' );


// Prepare Attr Values
// -------------------

$id_slug             = ( isset( $id ) && ! empty( $id ) ) ? $id . '-modal' : $toggleable_id . '-modal';
$classes_modal       = [ 'x-modal' ];
$classes_modal_close = [ 'x-modal-close', 'x-modal-close-' . $modal_close_location[0], 'x-modal-close-' . $modal_close_location[1] ];


// Prepare Atts
// ------------

$atts = [
  'id'                => $id_slug,
  'class'             => array_merge( $classes_modal, $classes ),
  'role'              => 'dialog',
  'tabindex'          => '-1',
  'data-x-toggleable' => $toggleable_id,
  'data-x-scrollbar'  => '{"suppressScrollX":true}',
  'aria-hidden'       => 'true',
  'aria-label'        => __( 'Modal', 'cornerstone' ),
];

if ( isset( $style ) && ! empty( $style ) ) {
  $atts['style'] = $style;
}

if ( $modal_body_scroll === 'disable' ) {
  $atts['data-x-disable-body-scroll'] = true;
}

$atts_modal_close = [
  'class'               => $classes_modal_close,
  'data-x-toggle-close' => true,
  'aria-label'          => __( 'Close Modal Content', 'cornerstone' ),
];

$atts_modal_content = array_merge( [
  'class'      => 'x-modal-content',
  'role'       => 'document',
  'aria-label' => __( 'Modal Content', 'cornerstone' ),
], $modal_content_atts );


// Output
// ------

$close_svg = '<svg viewBox="0 0 16 16"><g><path d="M14.7,1.3c-0.4-0.4-1-0.4-1.4,0L8,6.6L2.7,1.3c-0.4-0.4-1-0.4-1.4,0s-0.4,1,0,1.4L6.6,8l-5.3,5.3 c-0.4,0.4-0.4,1,0,1.4C1.5,14.9,1.7,15,2,15s0.5-0.1,0.7-0.3L8,9.4l5.3,5.3c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3 c0.4-0.4,0.4-1,0-1.4L9.4,8l5.3-5.3C15.1,2.3,15.1,1.7,14.7,1.3z"></path></g></svg>';

echo cs_tag('div', $atts, $modal_custom_atts, [
  cs_tag( 'span', ['class' => 'x-modal-bg'], ''),
  cs_tag( 'button', $atts_modal_close, cs_tag('span', $close_svg ) ),
  cs_tag( 'div', $atts_modal_content, $modal_content)
]);
