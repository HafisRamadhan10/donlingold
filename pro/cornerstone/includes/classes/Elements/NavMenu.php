<?php

namespace Themeco\Cornerstone\Elements;

class NavMenu extends \Walker_Nav_Menu {

  public $x_menu_data;
  public $x_menu_type;
  public $x_menu_item_count;

  public function __construct( $x_menu_data = array() ) {
    $this->x_menu_data       = $x_menu_data;
    $this->x_menu_type       = ( isset( $x_menu_data['menu_type'] ) ) ? $x_menu_data['menu_type'] : 'inline';
    $this->x_menu_item_count = 0;
  }

  public function x_get_unique_id( $count = NULL, $id = NULL, $delim = NULL ) {

    $id    = ( ! empty( $id )    ) ? $id    : $this->x_menu_data['unique_id'];
    $delim = ( ! empty( $delim ) ) ? $delim : '-';
    $count = ( ! empty( $count ) ) ? $count : $this->x_menu_item_count;

    return $id . $delim . $count;
  }


  // start_lvl()
  // -----------

  public function start_lvl( &$output, $depth = 0, $args = array() ) {

    $ul_atts = array(
      'class' => 'sub-menu'
    );


    // Inline and Dropdown
    // -------------------

    if ( in_array( $this->x_menu_type, array( 'inline', 'dropdown' ), true ) ) {

      $ul_atts['data-x-depth'] = $depth;
      $ul_atts['class']       .= ' x-dropdown';
      $ul_atts['data-x-stem']  = NULL;


      // Notes: "data-x-stem-menu-top" Attribute
      // ----------------------------------
      // "r" to reverse direction
      // "h" to begin flowing horizontally

      if ( $depth === 0 && $this->x_menu_type === 'inline' ) {

        $ul_atts['data-x-stem-menu-top'] = NULL;

        if ( isset( $this->x_menu_data['_region'] ) ) {

          if ( $this->x_menu_data['_region'] === 'left' ) {
            $ul_atts['data-x-stem-menu-top'] = 'h';
          }

          if ( $this->x_menu_data['_region'] === 'right' ) {
            $ul_atts['data-x-stem-menu-top'] = 'rh';
          }

        }

      }

    }


    // Collapsed
    // ---------

    if ( $this->x_menu_type === 'collapsed' ) {

      $ul_atts['id']                     = 'x-menu-collapsed-list-' . $this->x_get_unique_id();
      $ul_atts['class']                 .= ' x-collapsed';
      $ul_atts['aria-hidden']            = 'true';
      $ul_atts['aria-labelledby']        = 'x-menu-collapsed-anchor-' . $this->x_get_unique_id();
      $ul_atts['data-x-toggleable']      = $this->x_get_unique_id();
      $ul_atts['data-x-toggle-collapse'] = true;

    }


    // Layered
    // -------

    if ( $this->x_menu_type === 'modal' || $this->x_menu_type === 'layered' ) {

      $ul_atts['id']                    = 'x-menu-layered-list-' . $this->x_get_unique_id();
      $ul_atts['aria-hidden']           = 'true';
      $ul_atts['aria-labelledby']       = 'x-menu-layered-anchor-' . $this->x_get_unique_id();
      $ul_atts['data-x-toggleable']     = $this->x_get_unique_id();
      $ul_atts['data-x-toggle-layered'] = true;

    }


    // Increment `x_menu_item_count`
    // -----------------------------
    // 01. Always increment `x_menu_item_count` to be utilized as an internal
    //     counter when needed.

    $output .= '<ul ' . cs_atts( $ul_atts ) . '>';

    if ( $this->x_menu_type === 'modal' || $this->x_menu_type === 'layered' ) {

      $layered_back_atts = array(
        'class'             => array_merge( ['x-anchor', 'x-anchor-layered-back'], $this->x_menu_data['anchor_classes'] ),
        'aria-label'        => __( 'Go Back One Level', '__x__' ),
        'data-x-toggle'     => 'layered',
        'data-x-toggleable' => $this->x_get_unique_id(),
      );

      $output .= '<li>'
                . '<a ' . cs_atts( $layered_back_atts ) . '>'
                  . '<span class="x-anchor-appearance">'
                    . '<span class="x-anchor-content">'
                      . '<span class="x-anchor-text">'
                        . '<span class="x-anchor-text-primary">' . $this->x_menu_data['menu_layered_back_label'] . '</span>'
                      . '</span>'
                    . '</span>'
                  . '</span>'
                . '</a>'
              . '</li>';

    }

    $this->x_menu_item_count++; // 01

  }


  // start_el()
  // ----------
  // Section outputting $attributes was removed in favor of merging $atts
  // into our own cs_atts() function.
  //
  // 01. Utilize cs_atts() to include <li> attributes.

  public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $classes[] = 'menu-item-' . $item->ID;
    $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );
    $li_classes = apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth );
    $li_atts = array( 'class' => join( ' ', $li_classes ) );
    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
    if ( $id ) { $li_atts['id'] = $id; }
    $output .= '<li ' . cs_atts( $li_atts ) . '>'; // 01
    $atts = array();
    $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
    $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
    $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
    $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
    $title = apply_filters( 'the_title', $item->title, $item->ID );
    $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );


    // Get Item Meta
    // -------------

    if ( isset( $item->meta ) ) {
      $x_item_meta = array();
      foreach ( $item->meta as $key => $value ) {
        $x_item_meta['menu-item-' . $key] = array( $value );
      }
    } else {
      $x_item_meta = get_post_meta( $item->ID, '', true );
    }


    // Assign Item Meta
    // ----------------

    $x_anchor_graphic_icon              = ( isset( $x_item_meta['menu-item-anchor_graphic_icon'] )              ) ? $x_item_meta['menu-item-anchor_graphic_icon'][0]              : '';
    $x_anchor_graphic_icon_alt          = ( isset( $x_item_meta['menu-item-anchor_graphic_icon_alt'] )          ) ? $x_item_meta['menu-item-anchor_graphic_icon_alt'][0]          : '';
    $x_anchor_graphic_image_src         = ( isset( $x_item_meta['menu-item-anchor_graphic_image_src'] )         ) ? $x_item_meta['menu-item-anchor_graphic_image_src'][0]         : '';
    $x_anchor_graphic_image_src_alt     = ( isset( $x_item_meta['menu-item-anchor_graphic_image_src_alt'] )     ) ? $x_item_meta['menu-item-anchor_graphic_image_src_alt'][0]     : '';
    $x_anchor_graphic_image_alt         = ( isset( $x_item_meta['menu-item-anchor_graphic_image_alt'] )         ) ? $x_item_meta['menu-item-anchor_graphic_image_alt'][0]         : '';
    $x_anchor_graphic_image_alt_alt     = ( isset( $x_item_meta['menu-item-anchor_graphic_image_alt_alt'] )     ) ? $x_item_meta['menu-item-anchor_graphic_image_alt_alt'][0]     : '';
    $x_anchor_graphic_image_width       = ( isset( $x_item_meta['menu-item-anchor_graphic_image_width'] )       ) ? $x_item_meta['menu-item-anchor_graphic_image_width'][0]       : '';
    $x_anchor_graphic_image_height      = ( isset( $x_item_meta['menu-item-anchor_graphic_image_height'] )      ) ? $x_item_meta['menu-item-anchor_graphic_image_height'][0]      : '';
    $x_anchor_graphic_menu_item_display = ( isset( $x_item_meta['menu-item-anchor_graphic_menu_item_display'] ) ) ? $x_item_meta['menu-item-anchor_graphic_menu_item_display'][0] : '';

    $x_menu_meta_data = array(
      'anchor_text_primary_content'      => $title,
      'anchor_text_secondary_content'    => $item->description,
      'anchor_graphic_icon'              => $x_anchor_graphic_icon,
      'anchor_graphic_icon_alt'          => $x_anchor_graphic_icon_alt,
      'anchor_graphic_image_src'         => $x_anchor_graphic_image_src,
      'anchor_graphic_image_src_alt'     => $x_anchor_graphic_image_src_alt,
      'anchor_graphic_image_alt'         => $x_anchor_graphic_image_alt,
      'anchor_graphic_image_alt_alt'     => $x_anchor_graphic_image_alt_alt,
      'anchor_graphic_image_width'       => $x_anchor_graphic_image_width,
      'anchor_graphic_image_height'      => $x_anchor_graphic_image_height,
      'anchor_graphic_menu_item_display' => $x_anchor_graphic_menu_item_display,
      'atts'                             => array_filter( $atts ),
      'classes'                          => []
    );


    // Collapsed
    // ---------
    // 01. Allows the collapsed nav's sub menus to be triggered either by
    //     clicking on the anchor as a whole (which does not allow navigation
    //     to that link but affords a larger click area), or the sub indicator,
    //     (which allows navigation to the main link but has a smaller click
    //     area that users must target).

    if ( $this->x_menu_type === 'collapsed' && in_array( 'menu-item-has-children', $item->classes ) ) {

      $x_menu_meta_data['atts']['id']                       = 'x-menu-collapsed-anchor-' . $this->x_get_unique_id();
      $x_menu_meta_data['anchor_aria_label']                = __( 'Toggle Collapsed Sub Menu', '__x__' );
      $x_menu_meta_data['anchor_aria_haspopup']             = 'true';
      $x_menu_meta_data['anchor_aria_expanded']             = 'false';
      $x_menu_meta_data['anchor_aria_controls']             = 'x-menu-collapsed-list-' . $this->x_get_unique_id();
      $x_menu_meta_data['atts']['data-x-toggle']            = 'collapse';
      $x_menu_meta_data['atts']['data-x-toggleable']        = $this->x_get_unique_id();
      $x_menu_meta_data['anchor_sub_menu_trigger_location'] = $this->x_menu_data['menu_sub_menu_trigger_location']; // 01

    }


    // Layered
    // -------
    // 01. Allows the layered nav's sub menus to be triggered either by
    //     clicking on the anchor as a whole (which does not allow navigation
    //     to that link but affords a larger click area), or the sub indicator,
    //     (which allows navigation to the main link but has a smaller click
    //     area that users must target).

    if ( ( $this->x_menu_type === 'modal' || $this->x_menu_type === 'layered' ) && in_array( 'menu-item-has-children', $item->classes ) ) {

      $x_menu_meta_data['atts']['id']                       = 'x-menu-layered-anchor-' . $this->x_get_unique_id();
      $x_menu_meta_data['anchor_aria_label']                = __( 'Toggle Layered Sub Menu', '__x__' );
      $x_menu_meta_data['anchor_aria_haspopup']             = 'true';
      $x_menu_meta_data['anchor_aria_expanded']             = 'false';
      $x_menu_meta_data['anchor_aria_controls']             = 'x-menu-layered-list-' . $this->x_get_unique_id();
      $x_menu_meta_data['atts']['data-x-toggle']            = 'layered';
      $x_menu_meta_data['atts']['data-x-toggleable']        = $this->x_get_unique_id();
      $x_menu_meta_data['anchor_sub_menu_trigger_location'] = $this->x_menu_data['menu_sub_menu_trigger_location']; // 01

    }


    // Setup "Active" Links
    // --------------------
    // 01. Current menu item highlighting.
    // 02. Ancestor menu item highlighting.
    // 03. Pass on graphic and particle status for active links.

    if ( array_keys( $classes, 'current-menu-item' ) ) { // 01
      if ( $this->x_menu_data['menu_active_links_highlight_current'] === true ) {
        $x_menu_meta_data['anchor_is_active'] = true;
        $x_menu_meta_data['classes'][]        = 'x-always-active';
      }
    }

    if ( array_keys( $classes, 'current-menu-ancestor' ) || array_keys( $classes, 'current_page_parent' ) ) { // 02
      if ( $this->x_menu_data['menu_active_links_highlight_ancestors'] === true ) {
        $x_menu_meta_data['anchor_is_active'] = true;
        $x_menu_meta_data['classes'][]        = 'x-always-active';
      }
    }

    $x_menu_meta_data['anchor_graphic_always_active']            = $this->x_menu_data['menu_active_links_show_graphic']; // 03
    $x_menu_meta_data['anchor_primary_particle_always_active']   = $this->x_menu_data['menu_active_links_show_primary_particle']; // 03
    $x_menu_meta_data['anchor_secondary_particle_always_active'] = $this->x_menu_data['menu_active_links_show_secondary_particle']; // 03


    // Get Sub Link Options
    // --------------------

    $x_has_unique_sub_styles = in_array( $this->x_menu_type, array( 'inline', 'collapsed' ), true ) && $depth !== 0;
    $key_prefix              = ( $x_has_unique_sub_styles ) ? 'sub_' : '';


    // Menu Item Text Output
    // ---------------------
    // 01. Merge meta from the WP menu system into our main data to complete
    //     the whole picture.

    if ( $this->x_menu_data[$key_prefix . 'anchor_text_primary_content'] !== 'on' ) {
      $x_menu_meta_data['anchor_text_primary_content'] = '';
    }

    if ( $this->x_menu_data[$key_prefix . 'anchor_text_secondary_content'] !== 'on' ) {
      $x_menu_meta_data['anchor_text_secondary_content'] = '';
    }

    $x_anchor_data = array_merge( $this->x_menu_data, $x_menu_meta_data ); // 01

    unset( $x_anchor_data['sub_anchor_text_primary_content'] );
    unset( $x_anchor_data['sub_anchor_text_secondary_content'] );


    // Merge Sub Link Options
    // ----------------------
    // 01. Sub anchors with unique styling need to have their keys cleaned as
    //     well as ensuring $x_menu_meta_data still persists.

    if ( $x_has_unique_sub_styles ) {

      $top_level = array_intersect_key( $x_anchor_data, array_flip( array_keys( $x_menu_meta_data ) ) );

      $x_anchor_data = array_merge( $top_level, cs_extract( $x_anchor_data, [ 'sub_anchor' => 'anchor' ] ) ); // 01

    }


    // Item Output
    // -----------


    $item_output  = isset( $args->before ) ? $args->before : '';

    $item_output .= cs_get_partial_view( 'anchor', $x_anchor_data );

    if ( isset( $args->after ) ) {
      $item_output .= $args->after;
    }


    // Final Output
    // ------------

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

  }


  // end_el()
  // --------

  public function end_el( &$output, $object, $depth = 0, $args = array() ) {
    $output .= '</li>';
  }


  // end_lvl()
  // --------

  public function end_lvl( &$output, $depth = 0, $args = array() ) {
    $output .= '</ul>';
  }

}
