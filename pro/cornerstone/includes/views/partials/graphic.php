<?php

// =============================================================================
// VIEWS/PARTIALS/GRAPHIC.PHP
// -----------------------------------------------------------------------------
// Graphic partial.
// =============================================================================

$classes = ( isset( $classes ) ) ? $classes : [];



// Clean $graphic_interaction Value
// --------------------------------

if ( $graphic_has_interactions === true ) {
  $graphic_interaction = str_replace( 'anchor-', '', $graphic_interaction );
}



// Prepare Atts
// ------------

$atts = [
  'class'       => array_merge( [ 'x-graphic'], $classes ),
  'aria-hidden' => "true",
];



// Output
// ------

$output = [];

switch ( $graphic_type ) {


  // Type: Icon
  // ----------
  // 01. Graphic interaction is a class-based transition if primary and
  //     secondary icons are both present.
  // 02. Always active state is passed through to determine if state changes
  //     should be executed when interacted with.
  // 03. Graphic interaction is an animation if only the primary icon is
  //     present.

  case 'icon' :

    $this_has_alt         = $graphic_has_alt === true && $graphic_icon_alt_enable === true;
    $this_has_interaction = $graphic_has_interactions === true && $graphic_interaction !== 'none';
    $interaction_class    = ( $this_has_alt && $this_has_interaction ) ? $graphic_interaction : ''; // 01
    $always_active_class  = ( isset( $graphic_is_active ) && $graphic_is_active === true ) ? 'x-always-active' : ''; // 02


    // Icon Args: Base
    // ---------------

    $icon_base = [
      'icon' => $graphic_icon,
      'classes' => [ 'x-graphic-child', 'x-graphic-icon', 'x-graphic-primary', $interaction_class, $always_active_class ],
    ];

    if ( ! $this_has_alt && $this_has_interaction ) {
      $icon_base['atts'] = [ 'data-x-single-anim' => $graphic_interaction ]; // 03
    }


    // Output
    // ------

    $content[] = cs_get_partial_view( 'icon', $icon_base );

    if ( $this_has_alt ) {

      $content[] = cs_get_partial_view( 'icon', [
        'icon' => $graphic_icon_alt,
        'classes' => [ 'x-graphic-child', 'x-graphic-icon', 'x-graphic-secondary', $interaction_class, $always_active_class ]
      ]);
    }

    break;


  // Type: Image
  // -----------
  // 01. Graphic interaction is a class-based transition if primary and
  //     secondary icons are both present.
  // 02. Always active state is passed through to determine if state changes
  //     should be executed when interacted with.
  // 03. Graphic interaction is an animation if only the primary icon is
  //     present.

  case 'image' :

    $this_has_alt         = $graphic_has_alt === true && $graphic_image_alt_enable === true;
    $this_has_interaction = $graphic_has_interactions === true && $graphic_interaction !== 'none';
    $interaction_class    = ( $this_has_alt && $this_has_interaction ) ? $graphic_interaction : ''; // 01
    $always_active_class  = ( isset( $graphic_is_active ) && $graphic_is_active === true ) ? 'x-always-active' : ''; // 02


    // Image Args: Base
    // ----------------

    $image_base = [
      'classes' => [ 'x-graphic-child', 'x-graphic-image', 'x-graphic-primary', $interaction_class, $always_active_class ],
    ];

    if ( ! $this_has_alt && $this_has_interaction ) {
      $image_base['atts'] = [ 'data-x-single-anim' => $graphic_interaction ]; // 03
    }

    // Image Output
    // ------------

    $image_data = cs_extract( $_view_data, [ 'graphic_image' => 'image' ] );

    $content[] = cs_get_partial_view( 'image', array_merge( $image_data, $image_base ) );

    if ( $this_has_alt ) {

      $image_data['image_src'] = $image_data['image_src_alt'];
      $image_data['image_alt'] = $image_data['image_alt_alt'];

      $content[] = cs_get_partial_view( 'image', array_merge( $image_data, [
        'classes' => [ 'x-graphic-child', 'x-graphic-image', 'x-graphic-secondary', $interaction_class, $always_active_class ]
      ]));
    }

    break;


  // Type: Toggle
  // ------------

  case 'toggle' :


    // Toggle Output
    // -------------

    $content[] = cs_get_partial_view( 'toggle', array_merge(
      cs_extract( $_view_data, [ 'toggle' => '' ] ),
      [ 'classes' => ['x-graphic-child', 'x-graphic-toggle' ] ]
    ));

    break;

}

echo cs_tag('span', $atts, $content );
