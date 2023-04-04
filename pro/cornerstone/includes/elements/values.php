<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/VARIANTS.PHP
// -----------------------------------------------------------------------------
// Search for "alt diff" in this file to see alt colors that do not use the
// empty string technique.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Icon
//   02. Image
//   03. Graphic
//   04. Content Area
//   05. Menu
//   06. Particle
//   07. Search
//   08. Separator
//   09. Text
//   10. Anchor
//   11. Rating
//   12. Pagination
//   13. Products
//   14. Omega
//   15. Component: Effects
//   16. Component: BG (Background)
//   17. Component: Dropdown
//   18. Component: Frame
//   19. Component: MEJS
//   20. Component: Modal
//   21. Component: Off Canvas
//   22. Component: Toggle
//   23. Component: Cart
// =============================================================================

// Icon
// =============================================================================

cs_define_values( 'icon', array(
  'icon'                        => cs_value( 'l-hand-pointer', 'markup', true ),
  'icon_font_size'              => cs_value( '1em' ),
  'icon_width'                  => cs_value( 'auto' ),
  'icon_height'                 => cs_value( 'auto' ),
  'icon_color'                  => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'icon_color_alt'              => cs_value( '', 'style:color' ),
  'icon_bg_color'               => cs_value( 'transparent', 'style:color' ),
  'icon_bg_color_alt'           => cs_value( '', 'style:color' ),
  'icon_margin'                 => cs_value( '!0em' ),
  'icon_border_width'           => cs_value( '!0px' ),
  'icon_border_style'           => cs_value( 'solid' ),
  'icon_border_color'           => cs_value( 'transparent', 'style:color' ),
  'icon_border_color_alt'       => cs_value( '', 'style:color' ),
  'icon_border_radius'          => cs_value( '!0px' ),
  'icon_box_shadow_dimensions'  => cs_value( '!0em 0em 0em 0em' ),
  'icon_box_shadow_color'       => cs_value( 'transparent', 'style:color' ),
  'icon_box_shadow_color_alt'   => cs_value( '', 'style:color' ),
  'icon_text_shadow_dimensions' => cs_value( '!0px 0px 0px' ),
  'icon_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  'icon_text_shadow_color_alt'  => cs_value( '', 'style:color' ),
) );



// Image
// =============================================================================

cs_define_values( 'image', array(
  'image_type'                  => cs_value( 'standard', 'markup' ),
  'image_font_size'             => cs_value( '1em' ),
  'image_type'                  => cs_value( 'standard', 'markup' ),
  'image_display'               => cs_value( 'inline-block' ),
  'image_bg_color'              => cs_value( 'transparent', 'style:color' ),
  'image_bg_color_alt'          => cs_value( '', 'style:color' ),

  'image_styled_width'          => cs_value( 'auto' ),
  'image_styled_max_width'      => cs_value( 'none' ),
  'image_styled_height'         => cs_value( 'auto' ),
  'image_styled_max_height'     => cs_value( 'none' ),

  'image_margin'                => cs_value( '!0px' ),
  'image_padding'               => cs_value( '!0px' ),
  'image_border_width'          => cs_value( '!0px' ),
  'image_border_style'          => cs_value( 'solid' ),
  'image_border_color'          => cs_value( 'transparent', 'style:color' ),
  'image_border_color_alt'      => cs_value( '', 'style:color' ),
  'image_outer_border_radius'   => cs_value( '!0em' ),
  'image_inner_border_radius'   => cs_value( '!0em' ),
  'image_box_shadow_dimensions' => cs_value( '!0em 0em 0em 0em' ),
  'image_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  'image_box_shadow_color_alt'  => cs_value( '', 'style:color' ),
) );


cs_define_values( 'image:retina', array(
  'image_retina' => cs_value( true, 'markup', true )
) );


cs_define_values( 'image:dimensions', array(
  'image_width'  => cs_value( '', 'markup', true ),
  'image_height' => cs_value( '', 'markup', true )
) );


cs_define_values( 'image:link', array(
  'image_link'     => cs_value( false, 'markup', true ),
  'image_href'     => cs_value( '', 'markup', true ),
  'image_blank'    => cs_value( false, 'markup', true ),
  'image_nofollow' => cs_value( false, 'markup', true )
) );


cs_define_values( 'image:src', array(
  'image_src' => cs_value( '', 'markup:img', true )
) );


cs_define_values( 'image:alt', array(
  'image_alt' => cs_value( '', 'markup', true )
) );


cs_define_values( 'image:object', array(
  'image_object_fit'      => cs_value( 'fill', 'style', true ),
  'image_object_position' => cs_value( '50% 50%', 'style', true )
) );



// Graphic
// =============================================================================

cs_define_values( 'graphic', array(
  'graphic_has_alt'                     => cs_value( false, 'markup' ),
  'graphic_has_interactions'            => cs_value( false, 'markup' ),
  'graphic_has_sourced_content'         => cs_value( false, 'markup' ),
  'graphic_has_toggle'                  => cs_value( false, 'markup' ),

  'graphic'                             => cs_value( false, 'markup' ),
  'graphic_type'                        => cs_value( 'icon', 'markup', true ),

  'graphic_margin'                      => cs_value( '5px' ),

  'graphic_icon'                        => cs_value( 'l-hand-pointer', 'markup', true ),
  'graphic_icon_font_size'              => cs_value( '1.25em' ),
  'graphic_icon_width'                  => cs_value( 'auto' ),
  'graphic_icon_height'                 => cs_value( 'auto' ),
  'graphic_icon_color'                  => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'graphic_icon_bg_color'               => cs_value( 'transparent', 'style:color' ),
  'graphic_icon_border_width'           => cs_value( '!0px' ),
  'graphic_icon_border_style'           => cs_value( 'solid' ),
  'graphic_icon_border_color'           => cs_value( 'transparent', 'style:color' ),
  'graphic_icon_border_radius'          => cs_value( '!0px' ),
  'graphic_icon_box_shadow_dimensions'  => cs_value( '!0em 0em 0em 0em' ),
  'graphic_icon_box_shadow_color'       => cs_value( 'transparent', 'style:color' ),
  'graphic_icon_text_shadow_dimensions' => cs_value( '!0px 0px 0px' ),
  'graphic_icon_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),

  'graphic_image_src'                   => cs_value( '', 'markup:img', true ),
  'graphic_image_width'                 => cs_value( '', 'markup', true ),
  'graphic_image_height'                => cs_value( '', 'markup', true ),
  'graphic_image_alt'                   => cs_value( '', 'markup', true ),
  'graphic_image_max_width'             => cs_value( 'none' ),
  'graphic_image_retina'                => cs_value( true, 'markup', true ),
) );


cs_define_values( 'graphic:alt', array(
  'graphic_has_alt'                    => cs_value( true, 'markup' ),
  'graphic_icon_alt_enable'            => cs_value( false, 'markup' ),
  'graphic_icon_color_alt'             => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ), // alt diff
  'graphic_icon_bg_color_alt'          => cs_value( '', 'style:color' ),
  'graphic_icon_border_color_alt'      => cs_value( '', 'style:color' ),
  'graphic_icon_box_shadow_color_alt'  => cs_value( '', 'style:color' ),
  'graphic_icon_text_shadow_color_alt' => cs_value( '', 'style:color' ),
  'graphic_image_alt_enable'           => cs_value( false, 'markup' ),
  'graphic_icon_alt'                   => cs_value( 'l-hand-spock', 'markup', true ),
  'graphic_image_src_alt'              => cs_value( '', 'markup:img', true ),
  'graphic_image_alt_alt'              => cs_value( '', 'markup', true ),
) );


cs_define_values( 'graphic:toggle', array(
  'graphic_has_toggle' => cs_value( true, 'markup' )
) );


cs_define_values( 'graphic:interactions', array(
  'graphic_has_interactions' => cs_value( true, 'markup' ),
  'graphic_interaction'      => cs_value( 'none', 'markup' ),
) );


cs_define_values( 'graphic:sourced-content', array(
  'graphic_has_sourced_content' => cs_value( true, 'markup' ),
  'graphic_icon_alt'            => null,
  'graphic_image_src_alt'       => null,
  'graphic_image_alt_alt'       => null,
  'graphic_icon'                => null,
  'graphic_image_src'           => null,
  'graphic_image_width'         => null,
  'graphic_image_height'        => null,
  'graphic_image_alt'           => null
) );



// Content Area
// =============================================================================

cs_define_values( 'content-area', array(
  'content' => cs_value( __( '<span>This content will show up directly in its container.</span>', '__x__' ), 'markup:seo', true ),
) );


cs_define_values( 'content-area-margin', array(
  'content_margin' => cs_value( '!0em' ),
) );


cs_define_values( 'content-area:dynamic', array(
  'content'                   => cs_value( __( '<div style="padding: 25px; line-height: 1.4; text-align: center;">Add any HTML or custom content here.</div>', '__x__' ), 'markup:seo', true ),
  'content_dynamic_rendering' => cs_value( false, 'markup', true )
) );



// Menu
// =============================================================================

cs_define_values( 'menu:base', array(
  'menu'                                      => cs_value( 'sample:default', 'markup', true ),
  'menu_active_links_highlight_current'       => cs_value( true, 'markup' ),
  'menu_active_links_highlight_ancestors'     => cs_value( true, 'markup' ),
  'menu_active_links_show_graphic'            => cs_value( false, 'markup' ),
  'menu_active_links_show_primary_particle'   => cs_value( false, 'markup' ),
  'menu_active_links_show_secondary_particle' => cs_value( false, 'markup' ),
  'menu_custom_atts'                          => cs_value( '', 'markup' )
) );


cs_define_values( 'menu:styles', array(
  'menu_base_font_size' => cs_value( '1em' ),
  'menu_margin'         => cs_value( '!0px' ),
) );


cs_define_values( 'menu-inline', cs_compose_values(
  'menu:base',
  'menu:styles',
  array(
    'menu_type'               => cs_value( 'inline', 'markup' ),
    'menu_align_self'         => cs_value( 'stretch' ),
    'menu_flex'               => cs_value( '0 0 auto' ),
    'menu_row_flex_direction' => cs_value( 'row' ),
    'menu_row_flex_wrap'      => cs_value( false ),
    'menu_row_flex_justify'   => cs_value( 'space-around' ),
    'menu_row_flex_align'     => cs_value( 'stretch' ),
    'menu_col_flex_direction' => cs_value( 'column' ),
    'menu_col_flex_wrap'      => cs_value( false ),
    'menu_col_flex_justify'   => cs_value( 'space-around' ),
    'menu_col_flex_align'     => cs_value( 'stretch' ),
    'menu_items_flex'         => cs_value( '0 1 auto' ),
  )
) );


cs_define_values( 'menu-collapsed', cs_compose_values(
  'menu:base',
  'menu:styles',
  array(
    'menu_type'                      => cs_value( 'collapsed', 'markup' ),
    'menu_sub_menu_trigger_location' => cs_value( 'anchor', 'markup' ),
  )
) );


cs_define_values( 'menu-modal', cs_compose_values(
  'menu:base',
  'menu:styles',
  array(
    'menu_type'                      => cs_value( 'modal', 'markup' ),
    'menu_sub_menu_trigger_location' => cs_value( 'anchor', 'markup' ),
    'menu_layered_back_label'        => cs_value( __( '← Back', '__x__' ), 'markup' ),
  )
) );


cs_define_values( 'menu-layered', cs_compose_values(
  'menu:base',
  'menu:styles',
  array(
    'menu_type'                      => cs_value( 'layered', 'markup' ),
    'menu_sub_menu_trigger_location' => cs_value( 'anchor', 'markup' ),
    'menu_layered_back_label'        => cs_value( __( '← Back', '__x__' ), 'markup' ),
  )
) );


cs_define_values( 'menu-dropdown', cs_compose_values(
  'menu:base',
  array(
    'menu_type' => cs_value( 'dropdown', 'markup' ),
  )
) );




// Particle
// =============================================================================

cs_define_values( 'particle', array(
  'particle'                  => cs_value( false, 'markup' ),
  'particle_location'         => cs_value( 'b_c', 'markup' ),
  'particle_placement'        => cs_value( 'inside', 'markup' ),
  'particle_scale'            => cs_value( 'scale-y', 'markup' ),
  'particle_delay'            => cs_value( '0ms' ),
  'particle_transform_origin' => cs_value( '100% 100%' ),
  'particle_width'            => cs_value( '100%' ),
  'particle_height'           => cs_value( '3px' ),
  'particle_border_radius'    => cs_value( '0px' ),
  'particle_color'            => cs_value( 'rgba(0, 0, 0, 0.75)', 'style:color' ),
  'particle_style'            => cs_value( '', 'markup' ),
) );



// Search
// =============================================================================

cs_define_values( '_search', array(

  'search_placeholder'                  => cs_value( __( 'Search', '__x__' ), 'markup', true ),
  'search_order_input'                  => cs_value( '2' ),
  'search_order_submit'                 => cs_value( '1' ),
  'search_order_clear'                  => cs_value( '3' ),

  'search_base_font_size'               => cs_value( '1em' ),
  'search_width'                        => cs_value( '100%' ),
  'search_height'                       => cs_value( 'auto' ),
  'search_max_width'                    => cs_value( 'none' ),
  'search_bg_color'                     => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
  'search_bg_color_alt'                 => cs_value( '', 'style:color' ),

  'search_margin'                       => cs_value( '!0em' ),
  'search_border_width'                 => cs_value( '!0px' ),
  'search_border_style'                 => cs_value( 'solid' ),
  'search_border_color'                 => cs_value( 'transparent', 'style:color' ),
  'search_border_color_alt'             => cs_value( '', 'style:color' ),
  'search_border_radius'                => cs_value( '100em' ),
  'search_box_shadow_dimensions'        => cs_value( '0em 0.15em 0.5em 0em' ),
  'search_box_shadow_color'             => cs_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
  'search_box_shadow_color_alt'         => cs_value( '', 'style:color' ),

  'search_input_margin'                 => cs_value( '!0em' ),
  'search_input_font_family'            => cs_value( 'inherit', 'style:font-family' ),
  'search_input_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
  'search_input_font_size'              => cs_value( '1em' ),
  'search_input_letter_spacing'         => cs_value( '0em' ),
  'search_input_line_height'            => cs_value( '1.3' ),
  'search_input_font_style'             => cs_value( 'normal' ),
  'search_input_text_align'             => cs_value( 'none' ),
  'search_input_text_decoration'        => cs_value( 'none' ),
  'search_input_text_transform'         => cs_value( 'none' ),
  'search_input_text_color'             => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
  'search_input_text_color_alt'         => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ), // alt diff

  'search_submit_font_size'             => cs_value( '1em' ),
  'search_submit_stroke_width'          => cs_value( 2, 'markup' ),
  'search_submit_width'                 => cs_value( '1em' ),
  'search_submit_height'                => cs_value( '1em' ),
  'search_submit_color'                 => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'search_submit_color_alt'             => cs_value( '', 'style:color' ),
  'search_submit_bg_color'              => cs_value( 'transparent', 'style:color' ),
  'search_submit_bg_color_alt'          => cs_value( '', 'style:color' ),
  'search_submit_margin'                => cs_value( '0.5em 0.5em 0.5em 0.9em' ),
  'search_submit_border_width'          => cs_value( '!0px' ),
  'search_submit_border_style'          => cs_value( 'solid' ),
  'search_submit_border_color'          => cs_value( 'transparent', 'style:color' ),
  'search_submit_border_color_alt'      => cs_value( '', 'style:color' ),
  'search_submit_border_radius'         => cs_value( '!0px' ),
  'search_submit_box_shadow_dimensions' => cs_value( '!0em 0em 0em 0em' ),
  'search_submit_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  'search_submit_box_shadow_color_alt'  => cs_value( '', 'style:color' ),

  'search_clear_font_size'              => cs_value( '0.9em' ),
  'search_clear_stroke_width'           => cs_value( 3, 'markup' ),
  'search_clear_width'                  => cs_value( '2em' ),
  'search_clear_height'                 => cs_value( '2em' ),
  'search_clear_color'                  => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
  'search_clear_color_alt'              => cs_value( '', 'style:color' ),
  'search_clear_bg_color'               => cs_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
  'search_clear_bg_color_alt'           => cs_value( 'rgba(0, 0, 0, 0.3)', 'style:color' ), // alt diff
  'search_clear_margin'                 => cs_value( '0.5em' ),
  'search_clear_border_width'           => cs_value( '!0px' ),
  'search_clear_border_style'           => cs_value( 'solid' ),
  'search_clear_border_color'           => cs_value( 'transparent', 'style:color' ),
  'search_clear_border_color_alt'       => cs_value( '', 'style:color' ),
  'search_clear_border_radius'          => cs_value( '100em' ),
  'search_clear_box_shadow_dimensions'  => cs_value( '!0em 0em 0em 0em' ),
  'search_clear_box_shadow_color'       => cs_value( 'transparent', 'style:color' ),
  'search_clear_box_shadow_color_alt'   => cs_value( '', 'style:color' ),
  'search_custom_atts'                  => cs_value( '', 'markup' )
) );


cs_define_values( 'search-inline', cs_compose_values(
  '_search',
  array(
    'search_type' => cs_value( 'inline', 'markup' )
  )
) );


cs_define_values( 'search-modal', cs_compose_values(
  '_search',
  array(
    'search_type' => cs_value( 'modal', 'markup' )
  )
) );


cs_define_values( 'search-dropdown', cs_compose_values(
  '_search',
  // override search inline values
  array(
    'search_type'                  => cs_value( 'dropdown', 'markup' ),
    'search_base_font_size'        => cs_value( '1.25em' ),
    'search_border_radius'         => cs_value( '0em' ),
    'search_box_shadow_dimensions' => cs_value( '0em 0em 0em 0em' ),
    'search_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
    'search_box_shadow_color_alt'  => cs_value( '', 'style:color' ),
    'search_submit_margin'         => cs_value( '0.9em 0.65em 0.9em 0.9em' ),
    'search_clear_font_size'       => cs_value( '1em' ),
    'search_clear_width'           => cs_value( '1em' ),
    'search_clear_height'          => cs_value( '1em' ),
    'search_clear_color'           => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'search_clear_color_alt'       => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ), // alt diff
    'search_clear_bg_color'        => cs_value( 'transparent', 'style:color' ),
    'search_clear_bg_color_alt'    => cs_value( '', 'style:color' ),
    'search_clear_stroke_width'    => cs_value( '2', 'markup' ),
    'search_clear_margin'          => cs_value( '0.9em 0.9em 0.9em 0.65em' ),
  )
) );



// Separator
// =============================================================================

cs_define_values( 'separator', array(
  'separator'             => cs_value( false, 'markup' ),
  'separator_type'        => cs_value( 'angle-in', 'markup' ),
  'separator_angle_point' => cs_value( '50', 'markup' ),
  'separator_height'      => cs_value( '50px', 'markup' ),
  'separator_inset'       => cs_value( '0px', 'markup' ),
  'separator_color'       => cs_value( 'rgba(0, 0, 0, 0.75)', 'markup' ),
) );





// Text
// =============================================================================

cs_define_values( '_text', array(
  'text_width'                  => cs_value( 'auto' ),
  'text_max_width'              => cs_value( 'none' ),
  'text_bg_color'               => cs_value( 'transparent', 'style:color' ),
  'text_bg_color_alt'           => cs_value( '', 'style:color' ),
  'text_margin'                 => cs_value( '!0em' ),
  'text_padding'                => cs_value( '!0em' ),
  'text_border_width'           => cs_value( '!0px' ),
  'text_border_style'           => cs_value( 'solid' ),
  'text_border_color'           => cs_value( 'transparent', 'style:color' ),
  'text_border_color_alt'       => cs_value( '', 'style:color' ),
  'text_border_radius'          => cs_value( '!0px' ),
  'text_box_shadow_dimensions'  => cs_value( '!0em 0em 0em 0em' ),
  'text_box_shadow_color'       => cs_value( 'transparent', 'style:color' ),
  'text_box_shadow_color_alt'   => cs_value( '', 'style:color' ),
  'text_font_family'            => cs_value( 'inherit', 'style:font-family' ),
  'text_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
  'text_font_size'              => cs_value( '1em' ),
  'text_line_height'            => cs_value( '1.4' ),
  'text_letter_spacing'         => cs_value( '0em' ),
  'text_font_style'             => cs_value( 'normal' ),
  'text_text_align'             => cs_value( 'none' ),
  'text_text_decoration'        => cs_value( 'none' ),
  'text_text_transform'         => cs_value( 'none' ),
  'text_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'text_text_color_alt'         => cs_value( '', 'style:color' ),
  'text_text_shadow_dimensions' => cs_value( '!0px 0px 0px' ),
  'text_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  'text_text_shadow_color_alt'  => cs_value( '', 'style:color' ),
) );


cs_define_values( '_text-link', array(
  'text_link'     => cs_value( false, 'markup', true ),
  'text_href'     => cs_value( '', 'markup', true ),
  'text_blank'    => cs_value( false, 'markup', true ),
  'text_nofollow' => cs_value( false, 'markup', true )
) );


cs_define_values( 'text-standard', cs_compose_values(
  '_text',
  array(
    'text_content'                => cs_value( __( 'Input your text here! The text element is intended for longform copy that could potentially include multiple paragraphs.', '__x__' ), 'markup:seo', true ),
    'text_columns_break_inside'   => cs_value( 'auto' ),
    'text_columns'                => cs_value( false ),
    'text_columns_count'          => cs_value( 2 ),
    'text_columns_width'          => cs_value( '250px' ),
    'text_columns_gap'            => cs_value( '30px' ),
    'text_columns_rule_style'     => cs_value( 'solid' ),
    'text_columns_rule_width'     => cs_value( '2px' ),
    'text_columns_rule_color'     => cs_value( 'rgba(0, 0, 0, 0.1)', 'style:color' ),
    'text_columns_rule_color_alt' => cs_value( '', 'style:color' ),
  )
) );


cs_define_values( 'text-headline', cs_compose_values(
  '_text',
  '_text-link',
  array(
    'text_content'                            => cs_value( __( 'Short and Sweet Headlines are Best!', '__x__' ), 'markup:seo', true ),
    'text_base_font_size'                     => cs_value( '1em' ),
    'text_tag'                                => cs_value( 'h1', 'markup', true ),
    'text_overflow'                           => cs_value( false ),
    'text_typing'                             => cs_value( false, 'markup' ),
    'text_typing_prefix'                      => cs_value( 'Short and ', 'markup', true ),
    'text_typing_content'                     => cs_value( "Sweet\nClever\nImpactful", 'markup', true ),
    'text_typing_suffix'                      => cs_value( ' Headlines are Best!', 'markup', true ),
    'text_typing_speed'                       => cs_value( '150ms', 'markup' ),
    'text_typing_back_speed'                  => cs_value( '85ms', 'markup' ),
    'text_typing_delay'                       => cs_value( '0ms', 'markup' ),
    'text_typing_back_delay'                  => cs_value( '1800ms', 'markup' ),
    'text_typing_loop'                        => cs_value( true, 'markup' ),
    'text_typing_cursor'                      => cs_value( true, 'markup' ),
    'text_typing_cursor_content'              => cs_value( '|', 'markup' ),
    'text_typing_color'                       => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'text_typing_color_alt'                   => cs_value( '', 'style:color' ),
    'text_typing_cursor_color'                => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'text_typing_cursor_color_alt'            => cs_value( '', 'style:color' ),
    'text_flex_direction'                     => cs_value( 'row' ),
    'text_flex_wrap'                          => cs_value( false ),
    'text_flex_justify'                       => cs_value( 'center' ),
    'text_flex_align'                         => cs_value( 'center' ),
    'text_content_margin'                     => cs_value( '!0px' ),
    'text_subheadline'                        => cs_value( false, 'markup' ),
    'text_subheadline_content'                => cs_value( __( 'Subheadline space', '__x__' ), 'markup:seo', true ),
    'text_subheadline_tag'                    => cs_value( 'span', 'markup', true ),
    'text_subheadline_spacing'                => cs_value( '0.35em' ),
    'text_subheadline_reverse'                => cs_value( false, 'markup' ),
    'text_subheadline_font_family'            => cs_value( 'inherit', 'style:font-family' ),
    'text_subheadline_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
    'text_subheadline_font_size'              => cs_value( '1em' ),
    'text_subheadline_line_height'            => cs_value( '1.4' ),
    'text_subheadline_letter_spacing'         => cs_value( '0em' ),
    'text_subheadline_font_style'             => cs_value( 'normal' ),
    'text_subheadline_text_align'             => cs_value( 'none' ),
    'text_subheadline_text_decoration'        => cs_value( 'none' ),
    'text_subheadline_text_transform'         => cs_value( 'none' ),
    'text_subheadline_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'text_subheadline_text_color_alt'         => cs_value( '', 'style:color' ),
    'text_subheadline_text_shadow_dimensions' => cs_value( '!0px 0px 0px' ),
    'text_subheadline_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),
    'text_subheadline_text_shadow_color_alt'  => cs_value( '', 'style:color' ),
  ),
  cs_values( 'graphic', 'text' ),
  cs_values( 'graphic:alt', 'text' ),
  cs_values( 'graphic:interactions', 'text' ),
  cs_values( array(
    'graphic_margin'         => cs_value( '0em 0.5em 0em 0em' ),
    'graphic_icon_color_alt' => cs_value( '', 'style:color' ),
  ), 'text' )
) );



// Anchor
// =============================================================================

cs_define_values( '_anchor-base', array(
  'anchor_type'                           => cs_value( 'button', 'markup' ),
  'anchor_has_template'                   => cs_value( true, 'markup' ),
  'anchor_has_link_control'               => cs_value( false, 'markup' ),

  'anchor_base_font_size'                 => cs_value( '1em' ),
  'anchor_width'                          => cs_value( 'auto' ),
  'anchor_height'                         => cs_value( 'auto' ),
  'anchor_min_width'                      => cs_value( '0px' ),
  'anchor_min_height'                     => cs_value( '0px' ),
  'anchor_max_width'                      => cs_value( 'none' ),
  'anchor_max_height'                     => cs_value( 'none' ),
  'anchor_bg_color'                       => cs_value( 'transparent', 'style:color' ),
  'anchor_bg_color_alt'                   => cs_value( '', 'style:color' ),

  'anchor_margin'                         => cs_value( '!0em' ),
  'anchor_padding'                        => cs_value( '0.575em 0.85em 0.575em 0.85em' ),
  'anchor_border_width'                   => cs_value( '!0px' ),
  'anchor_border_style'                   => cs_value( 'solid' ),
  'anchor_border_color'                   => cs_value( 'transparent', 'style:color' ),
  'anchor_border_color_alt'               => cs_value( '', 'style:color' ),
  'anchor_border_radius'                  => cs_value( '!0em' ),

  'anchor_box_shadow_dimensions'          => cs_value( '!0em 0em 0em 0em' ),
  'anchor_box_shadow_color'               => cs_value( 'transparent', 'style:color' ),
  'anchor_box_shadow_color_alt'           => cs_value( '', 'style:color' ),

  'anchor_text'                           => cs_value( true, 'markup' ),
  'anchor_text_margin'                    => cs_value( '5px' ),

  'anchor_primary_font_family'            => cs_value( 'inherit', 'style:font-family' ),
  'anchor_primary_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
  'anchor_primary_font_size'              => cs_value( '1em' ),
  'anchor_primary_letter_spacing'         => cs_value( '0em' ),
  'anchor_primary_line_height'            => cs_value( '1' ),
  'anchor_primary_font_style'             => cs_value( 'normal' ),
  'anchor_primary_text_align'             => cs_value( 'none' ),
  'anchor_primary_text_decoration'        => cs_value( 'none' ),
  'anchor_primary_text_transform'         => cs_value( 'none' ),
  'anchor_primary_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'anchor_primary_text_color_alt'         => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ), // alt diff
  'anchor_primary_text_shadow_dimensions' => cs_value( '!0px 0px 0px' ),
  'anchor_primary_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  'anchor_primary_text_shadow_color_alt'  => cs_value( '', 'style:color' ),
) );


cs_define_values( '_anchor-template', cs_compose_values(
  array(
    'anchor_flex_direction'                   => cs_value( 'row' ),
    'anchor_flex_wrap'                        => cs_value( false ),
    'anchor_flex_justify'                     => cs_value( 'center' ),
    'anchor_flex_align'                       => cs_value( 'center' ),

    'anchor_text_overflow'                    => cs_value( false ),
    'anchor_text_interaction'                 => cs_value( 'none', 'markup' ),

    'anchor_text_reverse'                     => cs_value( false, 'markup' ),
    'anchor_text_spacing'                     => cs_value( '0.35em' ),

    'anchor_text_primary_content'             => cs_value( __( 'Learn More', '__x__' ), 'markup:seo', true ),
    'anchor_text_secondary_content'           => cs_value( '', 'markup:seo', true ),

    'anchor_secondary_font_family'            => cs_value( 'inherit', 'style:font-family' ),
    'anchor_secondary_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
    'anchor_secondary_font_size'              => cs_value( '0.75em' ),
    'anchor_secondary_letter_spacing'         => cs_value( '0em' ),
    'anchor_secondary_line_height'            => cs_value( '1' ),
    'anchor_secondary_font_style'             => cs_value( 'normal' ),
    'anchor_secondary_text_align'             => cs_value( 'none' ),
    'anchor_secondary_text_decoration'        => cs_value( 'none' ),
    'anchor_secondary_text_transform'         => cs_value( 'none' ),
    'anchor_secondary_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'anchor_secondary_text_color_alt'         => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ), // alt diff
    'anchor_secondary_text_shadow_dimensions' => cs_value( '!0px 0px 0px' ),
    'anchor_secondary_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),
    'anchor_secondary_text_shadow_color_alt'  => cs_value( '', 'style:color' ),
  ),
  cs_values( 'particle', 'anchor_primary' ),
  cs_values( 'particle', 'anchor_secondary' ),
  cs_values( 'graphic', 'anchor' ),
  cs_values( 'graphic:alt', 'anchor' ),
  cs_values( 'graphic:interactions', 'anchor' )
) );


cs_define_values( '_anchor', cs_compose_values(
  '_anchor-base',
  '_anchor-template'
) );


cs_define_values( '_anchor-no-template', cs_compose_values(
  '_anchor-base',
  array(
    'anchor_has_template' => cs_value( false, 'markup' ),
  )
) );


cs_define_values( 'anchor:link', array(
  'anchor_has_link_control' => cs_value( true, 'markup' ), // 01
  'anchor_href'             => cs_value( '#', 'markup', true ),
  'anchor_info'             => cs_value( false, 'markup', true ),
  'anchor_blank'            => cs_value( false, 'markup', true ),
  'anchor_nofollow'         => cs_value( false, 'markup', true ),
) );


cs_define_values( 'anchor:share', array(
  'anchor_share_enabled' => cs_value( false, 'markup', true ),
  'anchor_share_type'    => cs_value( CS()->component( 'Social' )->get_default_share_type(), 'markup', true ),
  'anchor_share_title'   => cs_value( '', 'markup', true )
) );


cs_define_values( 'anchor:interactive-content', array(
  'anchor_interactive_content'                        => cs_value( true, 'markup' ),
  'anchor_interactive_content_text_primary_content'   => cs_value( __( 'Discover Now', '__x__' ), 'markup:seo', true ),
  'anchor_interactive_content_text_secondary_content' => cs_value( __( 'We Have Answers', '__x__' ), 'markup:seo', true ),
  'anchor_interactive_content_interaction'            => cs_value( 'x-anchor-content-out-slide-top-in-scale-up', 'markup' ),
  'anchor_interactive_content_graphic_icon'           => cs_value( 'l-lightbulb-on', 'markup', true ),
  'anchor_interactive_content_graphic_icon_alt'       => cs_value( 'l-lightbulb-on', 'markup', true ),
  'anchor_interactive_content_graphic_image_src'      => cs_value( '', 'markup:img', true ),
  'anchor_interactive_content_graphic_image_alt'      => cs_value( '', 'markup', true ),
  'anchor_interactive_content_graphic_image_src_alt'  => cs_value( '', 'markup:img', true ),
  'anchor_interactive_content_graphic_image_alt_alt'  => cs_value( '', 'markup', true ),
) );


// Anchor: Button
// --------------

cs_define_values( 'anchor-button', cs_compose_values(
  '_anchor',
  'anchor:link',
  array(
    'anchor_bg_color'              => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'anchor_bg_color_alt'          => cs_value( '', 'style:color' ),
    'anchor_border_radius'         => cs_value( '0.35em' ),
    'anchor_box_shadow_dimensions' => cs_value( '0em 0.15em 0.65em 0em' ),
    'anchor_box_shadow_color'      => cs_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'anchor_box_shadow_color_alt'  => cs_value( '', 'style:color' )
  )
) );


// Anchor: Menu Item
// -----------------

cs_define_values( 'menu-item', cs_compose_values(
  '_anchor',
  array(
    'anchor_type'                                 => cs_value( 'menu-item', 'markup' ),
    'anchor_text_primary_content'                 => cs_value( 'on', 'markup', true ),
    'anchor_text_secondary_content'               => cs_value( '', 'markup', true ),
    'anchor_duration'                             => cs_value( '300ms' ),
    // 'anchor_delay'                                => cs_value( '0ms' ),
    'anchor_timing_function'                      => cs_value( 'cubic-bezier(0.400, 0.000, 0.200, 1.000)' ),
    'anchor_sub_indicator'                        => cs_value( true, 'markup' ),
    'anchor_sub_indicator_font_size'              => cs_value( '1em' ),
    'anchor_sub_indicator_width'                  => cs_value( 'auto' ),
    'anchor_sub_indicator_height'                 => cs_value( 'auto' ),
    'anchor_sub_indicator_icon'                   => cs_value( 'angle-down', 'markup' ),
    'anchor_sub_indicator_color'                  => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'anchor_sub_indicator_color_alt'              => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ), // alt diff
    'anchor_sub_indicator_margin'                 => cs_value( '5px' ),
    'anchor_sub_indicator_text_shadow_dimensions' => cs_value( '!0px 0px 0px' ),
    'anchor_sub_indicator_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),
    'anchor_sub_indicator_text_shadow_color_alt'  => cs_value( '', 'style:color' ),
  ),
  cs_values( 'graphic:sourced-content', 'anchor' )
) );


// Anchor: Cart Button
// -------------------

cs_define_values( 'cart-button', cs_compose_values(
  cs_values( '_anchor-no-template', 'cart' ),
  cs_values( array(

    'anchor_base_font_size'                 => cs_value( '0.75em' ),
    'anchor_width'                          => cs_value( '47.5%' ),
    'anchor_max_width'                      => cs_value( 'none' ),
    'anchor_height'                         => cs_value( 'auto' ),
    'anchor_max_height'                     => cs_value( 'none' ),
    'anchor_bg_color'                       => cs_value( 'rgb(245, 245, 245)', 'style:color' ), // #f5f5f5
    'anchor_bg_color_alt'                   => cs_value( '', 'style:color' ),

    'anchor_primary_font_family'            => cs_value( 'inherit', 'style:font-family' ),
    'anchor_primary_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
    'anchor_primary_font_size'              => cs_value( '1em' ),
    'anchor_primary_letter_spacing'         => cs_value( '0.15em' ),
    'anchor_primary_line_height'            => cs_value( '1' ),
    'anchor_primary_font_style'             => cs_value( 'normal' ),
    'anchor_primary_text_align'             => cs_value( 'center' ),
    'anchor_primary_text_decoration'        => cs_value( 'none' ),
    'anchor_primary_text_transform'         => cs_value( 'uppercase' ),
    'anchor_primary_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'anchor_primary_text_color_alt'         => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ), // alt diff
    'anchor_primary_text_shadow_dimensions' => cs_value( '!0px 0px 0px' ),
    'anchor_primary_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),
    'anchor_primary_text_shadow_color_alt'  => cs_value( '', 'style:color' ),

    'anchor_margin'                         => cs_value( '!0em' ),
    'anchor_padding'                        => cs_value( '0.75em 1.25em 0.75em 1.25em' ),
    'anchor_border_width'                   => cs_value( '1px' ),
    'anchor_border_style'                   => cs_value( 'solid' ),
    'anchor_border_color'                   => cs_value( 'rgba(0, 0, 0, 0.065)', 'style:color' ),
    'anchor_border_color_alt'               => cs_value( '', 'style:color' ),
    'anchor_border_radius'                  => cs_value( '0.5em' ),

    'anchor_box_shadow_dimensions'          => cs_value( '0em 0.15em 0.5em 0em' ),
    'anchor_box_shadow_color'               => cs_value( 'rgba(0, 0, 0, 0.05)', 'style:color' ),
    'anchor_box_shadow_color_alt'           => cs_value( '', 'style:color' ),
  ), 'cart' )
) );



// Rating
// =============================================================================
// 'rating_empty' => cs_value( true, 'markup' ),

cs_define_values( 'rating', array(
  'rating'                               => cs_value( true, 'markup' ),
  'rating_base_font_size'                => cs_value( '1em' ),
  'rating_value_content'                 => cs_value( 3.5, 'markup', true ),
  'rating_scale_min_content'             => cs_value( 0, 'markup', true ),
  'rating_scale_max_content'             => cs_value( 5, 'markup', true ),
  'rating_width'                         => cs_value( 'auto' ),
  'rating_max_width'                     => cs_value( 'none' ),
  'rating_bg_color'                      => cs_value( 'transparent', 'style:color' ),
  'rating_text'                          => cs_value( false, 'markup' ),
  'rating_schema'                        => cs_value( false, 'markup' ),
  'rating_empty'                         => cs_value( true, 'markup' ),
  'rating_round'                         => cs_value( false, 'markup' ),
  'rating_text_content'                  => cs_value( '{{rating}} / {{max}}', 'markup', true ),

  'rating_schema_item_reviewed_type'     => cs_value( '', 'markup', true ),
  'rating_schema_item_name_content'      => cs_value( '', 'markup', true ),
  'rating_schema_item_telephone_content' => cs_value( '', 'markup', true ),
  'rating_schema_item_address_content'   => cs_value( '', 'markup', true ),
  'rating_schema_item_image_src'         => cs_value( '', 'markup:img', true ),
  'rating_schema_author_content'         => cs_value( '', 'markup', true ),
  'rating_schema_review_body_content'    => cs_value( '', 'markup', true ),

  'rating_graphic_type'                  => cs_value( 'icon', 'markup', true ),
  'rating_graphic_spacing'               => cs_value( '2px' ),
  'rating_graphic_full_icon'             => cs_value( 'star', 'markup', true ),
  'rating_graphic_half_icon'             => cs_value( 'star-half-alt', 'markup', true ),
  'rating_graphic_empty_icon'            => cs_value( 'o-star', 'markup', true ),
  'rating_graphic_icon_color'            => cs_value( 'rgb(243, 156, 18)', 'style:color' ), // #f39c12
  'rating_graphic_full_image_src'        => cs_value( '', 'markup:img', true ),
  'rating_graphic_half_image_src'        => cs_value( '', 'markup:img', true ),
  'rating_graphic_empty_image_src'       => cs_value( '', 'markup:img', true ),
  'rating_graphic_image_max_width'       => cs_value( '32px' ),

  'rating_flex_direction'                => cs_value( 'row' ),
  'rating_flex_wrap'                     => cs_value( false ),
  'rating_flex_justify'                  => cs_value( 'flex-start' ),
  'rating_flex_align'                    => cs_value( 'center' ),

  'rating_margin'                        => cs_value( '!0em' ),
  'rating_border_width'                  => cs_value( '!0px' ),
  'rating_border_style'                  => cs_value( 'solid' ),
  'rating_border_color'                  => cs_value( 'transparent', 'style:color' ),
  'rating_border_radius'                 => cs_value( '!0px' ),
  'rating_padding'                       => cs_value( '!0em' ),
  'rating_box_shadow_dimensions'         => cs_value( '!0em 0em 0em 0em' ),
  'rating_box_shadow_color'              => cs_value( 'transparent', 'style:color' ),

  'rating_text_margin'                   => cs_value( '0em 0em 0em 0.35em' ),
  'rating_font_family'                   => cs_value( 'inherit', 'style:font-family' ),
  'rating_font_weight'                   => cs_value( 'inherit:400', 'style:font-weight' ),
  'rating_font_size'                     => cs_value( '1em' ),
  'rating_letter_spacing'                => cs_value( '0em' ),
  'rating_line_height'                   => cs_value( '1.6' ),
  'rating_font_style'                    => cs_value( 'normal' ),
  'rating_text_align'                    => cs_value( 'none' ),
  'rating_text_decoration'               => cs_value( 'none' ),
  'rating_text_transform'                => cs_value( 'none' ),
  'rating_text_color'                    => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'rating_text_shadow_dimensions'        => cs_value( '!0px 0px 0px' ),
  'rating_text_shadow_color'             => cs_value( 'transparent', 'style:color' ),
  'rating_text_shadow_color_alt'         => cs_value( '', 'style:color' ),
) );



// Pagination
// =============================================================================

cs_define_values( '_pagination-numbered', array(
  'pagination_numbered_hide'     => cs_value( 'md', 'markup' ),
  'pagination_numbered_end_size' => cs_value( 1, 'markup' ),
  'pagination_numbered_mid_size' => cs_value( 2, 'markup' ),
) );

cs_define_values( '_pagination-base', array(
  'pagination_base_font_size'                 => cs_value( '1em' ),
  'pagination_width'                          => cs_value( 'auto' ),
  'pagination_max_width'                      => cs_value( 'none' ),
  'pagination_bg_color'                       => cs_value( 'transparent', 'style:color' ),

  'pagination_flex_justify'                   => cs_value( 'flex-start' ),
  'pagination_reverse'                        => cs_value( false ),

  'pagination_margin'                         => cs_value( '!0em' ),
  'pagination_padding'                        => cs_value( '!0em' ),
  'pagination_border_width'                   => cs_value( '!0px' ),
  'pagination_border_style'                   => cs_value( 'solid' ),
  'pagination_border_color'                   => cs_value( 'transparent', 'style:color' ),
  'pagination_border_radius'                  => cs_value( '!0px' ),
  'pagination_box_shadow_dimensions'          => cs_value( '!0em 0em 0em 0em' ),
  'pagination_box_shadow_color'               => cs_value( 'transparent', 'style:color' ),

  'pagination_items_prev_next_type'           => cs_value( 'icon', 'markup' ),
  'pagination_items_prev_text'                => cs_value( 'Prev', 'markup' ),
  'pagination_items_next_text'                => cs_value( 'Next', 'markup' ),
  'pagination_items_prev_icon'                => cs_value( 'o-arrow-left', 'markup' ),
  'pagination_items_next_icon'                => cs_value( 'o-arrow-right', 'markup' ),
  'pagination_items_min_width'                => cs_value( '3em' ),
  'pagination_items_min_height'               => cs_value( '3em' ),
  'pagination_items_gap'                      => cs_value( '6px' ),
  'pagination_items_grow'                     => cs_value( false ),
  'pagination_items_bg_color'                 => cs_value( 'rgba(0, 0, 0, 0.075)', 'style:color' ),
  'pagination_items_bg_color_alt'             => cs_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ), // alt diff
  'pagination_items_padding'                  => cs_value( '0.8em 1em 0.8em 1em' ),
  'pagination_items_border_width'             => cs_value( '!0px' ),
  'pagination_items_border_style'             => cs_value( 'solid' ),
  'pagination_items_border_color'             => cs_value( 'transparent', 'style:color' ),
  'pagination_items_border_color_alt'         => cs_value( '', 'style:color' ),
  'pagination_items_border_radius'            => cs_value( '100em' ),
  'pagination_items_box_shadow_dimensions'    => cs_value( '0px 0px 0px 2px' ),
  'pagination_items_box_shadow_color'         => cs_value( 'transparent', 'style:color' ),
  'pagination_items_box_shadow_color_alt'     => cs_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ), // alt diff
  'pagination_items_font_family'              => cs_value( 'inherit', 'style:font-family' ),
  'pagination_items_font_weight'              => cs_value( 'inherit:400', 'style:font-weight' ),
  'pagination_items_font_size'                => cs_value( '1em' ),
  'pagination_items_font_style'               => cs_value( 'normal' ),
  'pagination_items_text_color'               => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'pagination_items_text_color_alt'           => cs_value( '', 'style:color' ),

  'pagination_current_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'pagination_current_border_color'           => cs_value( 'transparent', 'style:color' ),
  'pagination_current_box_shadow_color'       => cs_value( 'transparent', 'style:color' ),
  'pagination_current_bg_color'               => cs_value( 'rgba(0, 0, 0, 0.3)', 'style:color' ),

  'pagination_dots'                           => cs_value( false ),
  'pagination_dots_text_color'                => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'pagination_dots_border_color'              => cs_value( 'transparent', 'style:color' ),
  'pagination_dots_box_shadow_color'          => cs_value( 'transparent', 'style:color' ),
  'pagination_dots_bg_color'                  => cs_value( 'transparent', 'style:color' ),

  'pagination_prev_next'                      => cs_value( false ),
  'pagination_prev_next_text_color'           => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
  'pagination_prev_next_text_color_alt'       => cs_value( '', 'style:color' ),
  'pagination_prev_next_border_color'         => cs_value( 'transparent', 'style:color' ),
  'pagination_prev_next_border_color_alt'     => cs_value( '', 'style:color' ),
  'pagination_prev_next_box_shadow_color'     => cs_value( 'transparent', 'style:color' ),
  'pagination_prev_next_box_shadow_color_alt' => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ), // alt diff
  'pagination_prev_next_bg_color'             => cs_value( 'rgba(0, 0, 0, 0.85)', 'style:color' ),
  'pagination_prev_next_bg_color_alt'         => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ), // alt diff
) );

cs_define_values( 'pagination:comment', cs_compose_values(
  array(
    'pagination_type' => cs_value( 'comment', 'markup' ),
  ),
  '_pagination-numbered',
  '_pagination-base'
) );

cs_define_values( 'pagination:post', cs_compose_values(
  array(
    'pagination_type' => cs_value( 'post', 'markup' ),
  ),
  '_pagination-numbered',
  '_pagination-base'
) );

cs_define_values( 'pagination:product', cs_compose_values(
  array(
    'pagination_type' => cs_value( 'product', 'markup' ),
  ),
  '_pagination-numbered',
  '_pagination-base'
) );

cs_define_values( 'pagination:post-nav', cs_compose_values(
  array(
    'pagination_type' => cs_value( 'post-nav', 'markup' ),
  ),
  '_pagination-base'
) );



// Products
// =============================================================================

cs_define_values( 'products', array(
  'products_count'   => cs_value( 2, 'markup' ),
  'products_columns' => cs_value( 2, 'markup' ),
  'products_orderby' => cs_value( 'rand', 'markup' ),
  'products_order'   => cs_value( 'desc', 'markup' ),
  'products_margin'  => cs_value( '!0em' ),
) );



// Omega
// =============================================================================
// 01. Element CSS.
// 02. Hide by breakpoint. The core decorator will automatically update the
//     class value for you.
// 03. Inline style attribute.

cs_define_values( 'omega', array(
  'id'             => cs_value( '', 'markup' ),
  'class'          => cs_value( '', 'markup' ),
  'css'            => cs_value( '', 'markup' ), // 01
  'hide_bp'        => cs_value( '', 'markup' ), // 02
  'show_condition' => cs_value( '', 'markup' )
) );

cs_define_values( 'omega:style', array(
  'style' => cs_value( '', 'markup' ) // 03
) );

cs_define_values( 'omega:toggle-hash', array(
  'toggle_hash' => cs_value( '', 'markup' )
) );

cs_define_values( 'omega:custom-atts', array(
  'custom_atts' => cs_value( '', 'markup' )
) );

cs_define_values( 'omega:looper-provider', array(
  'looper_provider'                      => cs_value( false, 'markup' ),
  'looper_provider_type'                 => cs_value( 'query-recent', 'markup' ),

  // Recent Posts, Query Builder, Query String
  'looper_provider_query_string'         => cs_value( '', 'markup' ),
  'looper_provider_query_mode'           => cs_value( 'types', 'markup' ),
  'looper_provider_query_post_types'     => cs_value( ['post'], 'markup' ),
  'looper_provider_query_post_in'        => cs_value( true, 'markup' ),
  'looper_provider_query_post_ids'       => cs_value( '', 'markup' ),

  'looper_provider_query_term_and'       => cs_value( false, 'markup' ),
  'looper_provider_query_term_in'        => cs_value( true, 'markup' ),
  'looper_provider_query_term_ids'       => cs_value( '', 'markup' ),

  'looper_provider_query_author_in'      => cs_value( true, 'markup' ),
  'looper_provider_query_author_ids'     => cs_value( '', 'markup' ),

  'looper_provider_query_before'         => cs_value( '', 'markup' ),
  'looper_provider_query_after'          => cs_value( '', 'markup' ),
  'looper_provider_query_count'          => cs_value( '', 'markup' ),
  'looper_provider_query_order'          => cs_value( 'DESC', 'markup' ),
  'looper_provider_query_orderby'        => cs_value( 'date', 'markup' ),
  'looper_provider_query_offset'         => cs_value( '', 'markup' ),
  'looper_provider_query_include_sticky' => cs_value( false, 'markup' ),

  // Taxonomy
  'looper_provider_tax'                  => cs_value( 'category', 'markup' ),
  'looper_provider_tax_hide_empty'       => cs_value( false, 'markup' ),

  // Current Post Terms
  'looper_provider_terms_tax'            => cs_value( 'category', 'markup' ),

  // Custom / JSON
  'looper_provider_custom'               => cs_value( '', 'markup' ),
  'looper_provider_json'                 => cs_value( '', 'markup' ),
  'looper_provider_key_array'            => cs_value( '', 'markup' ),
  'looper_provider_dc'                   => cs_value( '', 'markup' ),

  'looper_provider_string_content'       => cs_value( '', 'markup' ),
  'looper_provider_string_delim'         => cs_value( '', 'markup' ),


  // Array Generics
  'looper_provider_array_offset'         => cs_value( '', 'markup' ),


) );

cs_define_values( 'omega:looper-consumer', array(
  'looper_consumer'              => cs_value( false, 'markup' ),
  'looper_consumer_repeat'       => cs_value( '-1', 'markup' ), // -1 for all
  'looper_consumer_rewind'       => cs_value( false, 'markup' ),
) );



// Component: Effects
// =============================================================================

cs_define_values( 'effects', [

  //
  // Base
  //

  'effects_opacity'             => cs_value( '1' ),
  'effects_filter'              => cs_value( '' ),
  'effects_transform'           => cs_value( '' ),
  'effects_transform_origin'    => cs_value( '50% 50%' ),
  'effects_backface_visibility' => cs_value( 'visible' ),
  // 'effects_perspective'         => cs_value( '0px' ),
  // 'effects_perspective_origin'  => cs_value( 'center' ),
  'effects_duration'            => cs_value( '300ms', 'markup' ),
  // 'effects_delay'               => cs_value( '0ms', 'markup' ),
  'effects_mix_blend_mode'      => cs_value( 'normal' ),
  'effects_backdrop_filter'     => cs_value( '' ),
  'effects_timing_function'     => cs_value( 'cubic-bezier(0.400, 0.000, 0.200, 1.000)', 'markup' ),


  //
  // Alt
  //

  'effects_alt'                           => cs_value( false, 'markup' ),

  'effects_type_alt'                      => cs_value( 'transform', 'markup' ),
  'effects_opacity_alt'                   => cs_value( '1' ),
  'effects_filter_alt'                    => cs_value( '' ),
  'effects_animation_alt'                 => cs_value( 'tada', 'markup' ),
  'effects_transform_alt'                 => cs_value( '' ),

  'effects_duration_animation_alt'        => cs_value( '1000ms', 'markup' ),
  // 'effects_delay_animation_alt'           => cs_value( '0ms', 'markup' ),
  'effects_timing_function_animation_alt' => cs_value( 'cubic-bezier(0.400, 0.000, 0.200, 1.000)', 'markup' ),


  //
  // Scroll
  //

  'effects_scroll'                 => cs_value( false, 'markup' ),
  'effects_type_scroll'            => cs_value( 'transform', 'markup' ),

  'effects_opacity_enter'          => cs_value( '1' ),
  'effects_filter_enter'           => cs_value( '' ),
  'effects_animation_enter'        => cs_value( 'rollIn', 'markup' ),
  'effects_transform_enter'        => cs_value( 'translate(0px, 0px)' ),

  'effects_opacity_exit'           => cs_value( '0' ),
  'effects_filter_exit'            => cs_value( '' ),
  'effects_animation_exit'         => cs_value( 'rollOut', 'markup' ),
  'effects_transform_exit'         => cs_value( 'translate(0px, 1rem)' ),

  'effects_offset_top'             => cs_value( '10%', 'markup' ),
  'effects_offset_bottom'          => cs_value( '10%', 'markup' ),

  'effects_behavior_scroll'        => cs_value( 'fire-once', 'markup' ), // in-n-out, reset, fire-once
  'effects_pointer_events_scroll'  => cs_value( 'none', 'markup' ),

  'effects_duration_scroll'        => cs_value( '1000ms', 'markup' ),
  'effects_delay_scroll'           => cs_value( '0ms', 'markup' ),
  'effects_timing_function_scroll' => cs_value( 'cubic-bezier(0.400, 0.000, 0.200, 1.000)', 'markup' ),

  //
  // Provider
  //

  'effects_provider'         => cs_value( false, 'markup' ),
  'effects_provider_targets' => cs_value( 'colors particles effects', 'markup' ),

]);

cs_register_component( 'effects', [
  'value_prefix' => 'effects',
  'values'       => cs_compose_values( 'effects' )
] );



// Component: BG (Background)
// =============================================================================

cs_define_values( 'bg', [
  'bg_lower_type'                => cs_value( 'none', 'markup' ),
  'bg_lower_color'               => cs_value( 'rgba(255, 255, 255, 0.5)', 'markup' ),
  'bg_lower_image'               => cs_value( '', 'markup:img', true ),
  'bg_lower_image_repeat'        => cs_value( 'no-repeat', 'markup', true ),
  'bg_lower_image_size'          => cs_value( 'cover', 'markup', true ),
  'bg_lower_image_position'      => cs_value( 'center', 'markup', true ),
  'bg_lower_img_src'             => cs_value( '', 'markup:img', true ),
  'bg_lower_img_alt'             => cs_value( '', 'markup', true ),
  'bg_lower_img_object_fit'      => cs_value( 'cover', 'markup', true ),
  'bg_lower_img_object_position' => cs_value( 'center', 'markup', true ),
  'bg_lower_video'               => cs_value( '', 'markup', true ),
  'bg_lower_video_poster'        => cs_value( '', 'markup', true ),
  'bg_lower_video_loop'          => cs_value( true, 'markup' ),
  'bg_lower_custom_content'      => cs_value( '', 'markup', true ),
  'bg_lower_custom_aria_hidden'  => cs_value( true, 'markup', true ),

  'bg_lower_parallax'            => cs_value( false, 'markup' ),
  'bg_lower_parallax_size'       => cs_value( '150%', 'markup' ),
  'bg_lower_parallax_direction'  => cs_value( 'v', 'markup' ),
  'bg_lower_parallax_reverse'    => cs_value( false, 'markup' ),

  'bg_upper_type'                => cs_value( 'none', 'markup' ),
  'bg_upper_color'               => cs_value( 'rgba(255, 255, 255, 0.5)', 'markup' ),
  'bg_upper_image'               => cs_value( '', 'markup:img', true ),
  'bg_upper_image_repeat'        => cs_value( 'no-repeat', 'markup', true ),
  'bg_upper_image_size'          => cs_value( 'cover', 'markup', true ),
  'bg_upper_image_position'      => cs_value( 'center', 'markup', true ),
  'bg_upper_img_src'             => cs_value( '', 'markup:img', true ),
  'bg_upper_img_alt'             => cs_value( '', 'markup', true ),
  'bg_upper_img_object_fit'      => cs_value( 'cover', 'markup', true ),
  'bg_upper_img_object_position' => cs_value( 'center', 'markup', true ),
  'bg_upper_video'               => cs_value( '', 'markup', true ),
  'bg_upper_video_poster'        => cs_value( '', 'markup', true ),
  'bg_upper_video_loop'          => cs_value( true, 'markup' ),
  'bg_upper_custom_content'      => cs_value( '', 'markup', true ),
  'bg_upper_custom_aria_hidden'  => cs_value( true, 'markup', true ),

  'bg_upper_parallax'            => cs_value( false, 'markup' ),
  'bg_upper_parallax_size'       => cs_value( '150%', 'markup' ),
  'bg_upper_parallax_direction'  => cs_value( 'v', 'markup' ),
  'bg_upper_parallax_reverse'    => cs_value( false, 'markup' ),

  'bg_border_radius'             => cs_value( '!inherit', 'markup' ),
]);

cs_register_component( 'bg', [
  'value_prefix' => 'bg',
  'values'       => cs_compose_values( 'bg' ),
] );



// Component: Dropdown
// =============================================================================

cs_define_values( 'dropdown', array(
  'dropdown_base_font_size'        => cs_value( '16px' ),
  'dropdown_width'                 => cs_value( '14em' ),
  'dropdown_min_width'             => cs_value( '0px' ),
  'dropdown_max_width'             => cs_value( 'none' ),
  'dropdown_height'                => cs_value( 'auto' ),
  'dropdown_min_height'            => cs_value( '0px' ),
  'dropdown_max_height'            => cs_value( 'none' ),
  'dropdown_toggle_trigger'        => cs_value( 'click', 'markup' ),
  'dropdown_text_align'            => cs_value( 'none' ),
  'dropdown_overflow'              => cs_value( 'visible' ),
  'dropdown_duration'              => cs_value( '500ms' ),
  'dropdown_timing_function'       => cs_value( 'cubic-bezier(0.400, 0.000, 0.200, 1.000)' ),
  'dropdown_bg_color'              => cs_value( 'rgb(255, 255, 255)', 'style:color' ),
  'dropdown_bg_advanced'           => cs_value( false, 'markup' ),

  'dropdown_flexbox'               => cs_value( false ),
  'dropdown_flex_direction'        => cs_value( 'column' ),
  'dropdown_flex_wrap'             => cs_value( false ),
  'dropdown_flex_justify'          => cs_value( 'flex-start' ),
  'dropdown_flex_align'            => cs_value( 'flex-start' ),
  'dropdown_margin'                => cs_value( '!0em' ),
  'dropdown_padding'               => cs_value( '!0em' ),
  'dropdown_border_width'          => cs_value( '!0px' ),
  'dropdown_border_style'          => cs_value( 'solid' ),
  'dropdown_border_color'          => cs_value( 'transparent', 'style:color' ),
  'dropdown_border_radius'         => cs_value( '!0px' ),
  'dropdown_box_shadow_dimensions' => cs_value( '0em 0.15em 2em 0em' ),
  'dropdown_box_shadow_color'      => cs_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),

  'dropdown_custom_atts'           => cs_value( '', 'markup' )
) );

cs_register_component( 'dropdown', [
  'value_prefix' => 'dropdown',
  'values'       => cs_compose_values( 'dropdown' )
] );


// Component: Frame
// =============================================================================

cs_define_values( 'frame', array(
  'frame_content_sizing'              => cs_value( 'aspect-ratio', 'markup' ),
  'frame_base_font_size'              => cs_value( '16px' ),
  'frame_width'                       => cs_value( '100%' ),
  'frame_max_width'                   => cs_value( 'none' ),
  'frame_content_aspect_ratio_width'  => cs_value( '16' ),
  'frame_content_aspect_ratio_height' => cs_value( '9' ),
  'frame_content_height'              => cs_value( '350px' ),
  'frame_bg_color'                    => cs_value( 'rgb(255, 255, 255)', 'style:color' ),
  'frame_margin'                      => cs_value( '!0em' ),
  'frame_padding'                     => cs_value( '!0em' ),
  'frame_border_width'                => cs_value( '!0px' ),
  'frame_border_style'                => cs_value( 'solid' ),
  'frame_border_color'                => cs_value( 'transparent', 'style:color' ),
  'frame_border_radius'               => cs_value( '!0px' ),
  'frame_box_shadow_dimensions'       => cs_value( '!0em 0em 0em 0em' ),
  'frame_box_shadow_color'            => cs_value( 'transparent', 'style:color' ),
) );

cs_register_component( 'frame', [
  'value_prefix' => 'frame',
  'values'       => cs_compose_values( 'frame' )
] );


// Component: MEJS
// =============================================================================

cs_define_values( 'mejs', array(
  'mejs_preload'                                  => cs_value( 'metadata', 'markup' ),
  'mejs_advanced_controls'                        => cs_value( false, 'markup' ),
  'mejs_autoplay'                                 => cs_value( false, 'markup' ),
  'mejs_loop'                                     => cs_value( false, 'markup' ),
  'mejs_controls_button_color'                    => cs_value( 'rgba(255, 255, 255, 0.5)', 'style:color' ),
  'mejs_controls_button_color_alt'                => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ), // alt diff
  'mejs_controls_time_total_bg_color'             => cs_value( 'rgba(255, 255, 255, 0.25)', 'style:color' ),
  'mejs_controls_time_loaded_bg_color'            => cs_value( 'rgba(255, 255, 255, 0.25)', 'style:color' ),
  'mejs_controls_time_current_bg_color'           => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
  'mejs_controls_color'                           => cs_value( 'rgba(255, 255, 255, 0.5)', 'style:color' ),
  'mejs_controls_bg_color'                        => cs_value( 'rgba(0, 0, 0, 0.8)', 'style:color' ),
  'mejs_controls_padding'                         => cs_value( '!0px' ),
  'mejs_controls_border_width'                    => cs_value( '!0px' ),
  'mejs_controls_border_style'                    => cs_value( 'solid' ),
  'mejs_controls_border_color'                    => cs_value( 'transparent' ),
  'mejs_controls_border_radius'                   => cs_value( '3px' ),
  'mejs_controls_box_shadow_dimensions'           => cs_value( '!0em 0em 0em 0em' ),
  'mejs_controls_box_shadow_color'                => cs_value( 'transparent' ),
  'mejs_controls_time_rail_border_radius'         => cs_value( '2px' ),
  'mejs_controls_time_rail_box_shadow_dimensions' => cs_value( '!0em 0em 0em 0em' ),
  'mejs_controls_time_rail_box_shadow_color'      => cs_value( 'transparent' ),
  'mejs_controls_margin'                          => cs_value( 'auto 15px 15px 15px' ),
  'mejs_source_files'                             => cs_value( '', 'markup', true ),
  'mejs_poster'                                   => cs_value( '', 'markup', true ),
  'mejs_hide_controls'                            => cs_value( false, 'markup' ),
  'mejs_muted'                                    => cs_value( false, 'markup' ),
) );

cs_register_component( 'mejs', [
  'value_prefix' => 'mejs',
  'values'       => cs_compose_values( 'mejs' )
] );



// Component: Modal
// =============================================================================

cs_define_values( 'modal', array(
  'modal_base_font_size'                => cs_value( '16px' ),
  'modal_content_width'                 => cs_value( '100%' ),
  'modal_content_min_width'             => cs_value( '0px' ),
  'modal_content_max_width'             => cs_value( '28em' ),
  'modal_content_height'                => cs_value( 'auto' ),
  'modal_content_min_height'            => cs_value( '0px' ),
  'modal_content_max_height'            => cs_value( 'none' ),
  'modal_content_text_align'            => cs_value( 'none' ),
  'modal_duration'                      => cs_value( '500ms' ),
  'modal_timing_function'               => cs_value( 'cubic-bezier(0.400, 0.000, 0.200, 1.000)' ),
  'modal_body_scroll'                   => cs_value( 'allow', 'markup' ),
  'modal_content_overflow'              => cs_value( 'visible' ),
  'modal_content_bg_color'              => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
  'modal_content_bg_advanced'           => cs_value( false, 'markup' ),

  'modal_bg_color'                      => cs_value( 'rgba(0, 0, 0, 0.75)', 'style:color' ),
  'modal_close_font_size'               => cs_value( '1em' ),
  'modal_close_dimensions'              => cs_value( '2' ),
  'modal_close_location'                => cs_value( 'top-right', 'markup' ),
  'modal_close_color'                   => cs_value( 'rgba(255, 255, 255, 0.5)', 'style:color' ),
  'modal_close_color_alt'               => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ), // alt diff

  'modal_content_flexbox'               => cs_value( false ),
  'modal_content_flex_direction'        => cs_value( 'column' ),
  'modal_content_flex_wrap'             => cs_value( false ),
  'modal_content_flex_justify'          => cs_value( 'flex-start' ),
  'modal_content_flex_align'            => cs_value( 'flex-start' ),
  'modal_content_padding'               => cs_value( '2em' ),
  'modal_content_border_width'          => cs_value( '!0px' ),
  'modal_content_border_style'          => cs_value( 'solid' ),
  'modal_content_border_color'          => cs_value( 'transparent', 'style:color' ),
  'modal_content_border_radius'         => cs_value( '!0px' ),
  'modal_content_box_shadow_dimensions' => cs_value( '0em 0.15em 2em 0em' ),
  'modal_content_box_shadow_color'      => cs_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),

  'modal_custom_atts'                   => cs_value( '', 'markup' )
) );

cs_register_component( 'modal', [
  'value_prefix' => 'modal',
  'values'       => cs_compose_values( 'modal' )
] );



// Component: Off Canvas
// =============================================================================

cs_define_values( 'off-canvas', array(
  'off_canvas_base_font_size'                => cs_value( '16px' ),
  'off_canvas_content_width'                 => cs_value( '100%' ),
  'off_canvas_content_min_width'             => cs_value( '0px' ),
  'off_canvas_content_max_width'             => cs_value( '24em' ),
  'off_canvas_content_text_align'            => cs_value( 'none' ),
  'off_canvas_duration'                      => cs_value( '500ms' ),
  'off_canvas_timing_function'               => cs_value( 'cubic-bezier(0.400, 0.000, 0.200, 1.000)' ),
  'off_canvas_body_scroll'                   => cs_value( 'allow', 'markup' ),
  'off_canvas_location'                      => cs_value( 'right', 'markup' ),
  'off_canvas_content_overflow'              => cs_value( 'visible' ),
  'off_canvas_content_bg_color'              => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
  'off_canvas_content_bg_advanced'           => cs_value( false, 'markup' ),

  'off_canvas_bg_color'                      => cs_value( 'rgba(0, 0, 0, 0.75)', 'style:color' ),
  'off_canvas_close_font_size'               => cs_value( '1em' ),
  'off_canvas_close_dimensions'              => cs_value( '2' ),
  'off_canvas_close_offset'                  => cs_value( true ),
  'off_canvas_close_color'                   => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
  'off_canvas_close_color_alt'               => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ), // alt diff

  'off_canvas_content_flexbox'               => cs_value( false ),
  'off_canvas_content_flex_direction'        => cs_value( 'column' ),
  'off_canvas_content_flex_wrap'             => cs_value( false ),
  'off_canvas_content_flex_justify'          => cs_value( 'flex-start' ),
  'off_canvas_content_flex_align'            => cs_value( 'flex-start' ),
  'off_canvas_content_border_width'          => cs_value( '!0px' ),
  'off_canvas_content_border_style'          => cs_value( 'solid' ),
  'off_canvas_content_border_color'          => cs_value( 'transparent', 'style:color' ),
  'off_canvas_content_border_radius'         => cs_value( '!0px' ),
  'off_canvas_content_box_shadow_dimensions' => cs_value( '0em 0em 2em 0em' ),
  'off_canvas_content_box_shadow_color'      => cs_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),

  'off_canvas_custom_atts'                   => cs_value( '', 'markup' )
) );

cs_register_component( 'off-canvas', [
  'value_prefix' => 'off_canvas',
  'values'       => cs_compose_values( 'off-canvas' )
] );



// Component: Toggle
// =============================================================================

cs_define_values( 'toggle', cs_compose_values(
  array(
    'toggle_type'           => cs_value( 'burger-1', 'markup' ),
    'toggle_burger_size'    => cs_value( '2px' ),
    'toggle_burger_spacing' => cs_value( '3em' ),
    'toggle_burger_width'   => cs_value( '10em' ),
    'toggle_grid_size'      => cs_value( '4px' ),
    'toggle_grid_spacing'   => cs_value( '1.5em' ),
    'toggle_more_size'      => cs_value( '4px' ),
    'toggle_more_spacing'   => cs_value( '2em' ),
    'toggle_color'          => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'toggle_color_alt'      => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ), // alt diff
  ),
  cs_values( '_anchor', 'toggle' ),
  cs_values( array(
    'anchor_type'                   => cs_value( 'toggle', 'markup' ),
    'anchor_width'                  => cs_value( '3em' ),
    'anchor_height'                 => cs_value( '3em' ),
    'anchor_bg_color'               => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'anchor_bg_color_alt'           => cs_value( '', 'style:color' ),
    'anchor_padding'                => cs_value( '!0em' ),
    'anchor_border_radius'          => cs_value( '100em' ),
    'anchor_box_shadow_dimensions'  => cs_value( '0em 0.15em 0.65em 0em' ),
    'anchor_box_shadow_color'       => cs_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'anchor_box_shadow_color_alt'   => cs_value( '', 'style:color' ),
    'anchor_text'                   => cs_value( false, 'markup' ),
    'anchor_graphic'                => cs_value( true, 'markup' ),
    'anchor_graphic_has_toggle'     => cs_value( true, 'markup' ),
    'anchor_graphic_type'           => cs_value( 'toggle', 'markup' ),
    'anchor_text_primary_content'   => cs_value( '', 'markup:seo', true ),
    'anchor_text_secondary_content' => cs_value( '', 'markup:seo', true ),
    'anchor_custom_atts'            => cs_value( '', 'markup' )
  ), 'toggle' )
) );

cs_register_component( 'toggle', [
  'value_prefix' => 'toggle',
  'values'       => cs_compose_values( 'toggle' )
] );



// Component: Cart
// =============================================================================

cs_define_values( 'cart', array(
  'cart_width'                           => cs_value( 'auto' ),
  'cart_max_width'                       => cs_value( 'none' ),
  'cart_order_items'                     => cs_value( '1' ),
  'cart_order_total'                     => cs_value( '2' ),
  'cart_order_buttons'                   => cs_value( '3' ),
  'cart_bg'                              => cs_value( 'transparent', 'style:color' ),

  'cart_margin'                          => cs_value( '!0px' ),
  'cart_padding'                         => cs_value( '!0px' ),
  'cart_border_width'                    => cs_value( '!0px' ),
  'cart_border_style'                    => cs_value( 'solid' ),
  'cart_border_color'                    => cs_value( 'transparent', 'style:color' ),
  'cart_border_radius'                   => cs_value( '!0px' ),
  'cart_box_shadow_dimensions'           => cs_value( '!0em 0em 0em 0em' ),
  'cart_box_shadow_color'                => cs_value( 'transparent', 'style:color' ),

  'cart_items_display_remove'            => cs_value( true ),
  'cart_items_content_spacing'           => cs_value( '15px' ),
  'cart_items_bg'                        => cs_value( 'transparent', 'style:color' ),
  'cart_items_bg_alt'                    => cs_value( '', 'style:color' ),
  'cart_items_margin'                    => cs_value( '!0px' ),
  'cart_items_padding'                   => cs_value( '15px 0px 15px 0px' ),
  'cart_items_border_width'              => cs_value( '1px 0px 0px 0px' ),
  'cart_items_border_style'              => cs_value( 'solid' ),
  'cart_items_border_color'              => cs_value( 'rgba(0, 0, 0, 0.065) transparent transparent transparent', 'style:color' ),
  'cart_items_border_color_alt'          => cs_value( '', 'style:color' ),
  'cart_items_border_radius'             => cs_value( '!0px' ),
  'cart_items_box_shadow_dimensions'     => cs_value( '!0em 0em 0em 0em' ),
  'cart_items_box_shadow_color'          => cs_value( 'transparent', 'style:color' ),
  'cart_items_box_shadow_color_alt'      => cs_value( '', 'style:color' ),

  'cart_thumbs_width'                    => cs_value( '70px' ),
  'cart_thumbs_border_radius'            => cs_value( '5px' ),
  'cart_thumbs_box_shadow_dimensions'    => cs_value( '0em 0.15em 1em 0em' ),
  'cart_thumbs_box_shadow_color'         => cs_value( 'rgba(0, 0, 0, 0.05)', 'style:color' ),

  'cart_links_font_family'               => cs_value( 'inherit', 'style:font-family' ),
  'cart_links_font_weight'               => cs_value( 'inherit:400', 'style:font-weight' ),
  'cart_links_font_size'                 => cs_value( '1em' ),
  'cart_links_letter_spacing'            => cs_value( '0em' ),
  'cart_links_line_height'               => cs_value( '1.4' ),
  'cart_links_font_style'                => cs_value( 'normal' ),
  'cart_links_text_align'                => cs_value( 'none' ),
  'cart_links_text_decoration'           => cs_value( 'none' ),
  'cart_links_text_transform'            => cs_value( 'none' ),
  'cart_links_text_color'                => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'cart_links_text_color_alt'            => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ), // alt diff
  'cart_links_text_shadow_dimensions'    => cs_value( '!0px 0px 0px' ),
  'cart_links_text_shadow_color'         => cs_value( 'transparent', 'style:color' ),
  'cart_links_text_shadow_color_alt'     => cs_value( '', 'style:color' ),

  'cart_quantity_font_family'            => cs_value( 'inherit', 'style:font-family' ),
  'cart_quantity_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
  'cart_quantity_font_size'              => cs_value( '0.85em' ),
  'cart_quantity_letter_spacing'         => cs_value( '0em' ),
  'cart_quantity_line_height'            => cs_value( '1.9' ),
  'cart_quantity_font_style'             => cs_value( 'normal' ),
  'cart_quantity_text_align'             => cs_value( 'none' ),
  'cart_quantity_text_decoration'        => cs_value( 'none' ),
  'cart_quantity_text_transform'         => cs_value( 'none' ),
  'cart_quantity_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'cart_quantity_text_shadow_dimensions' => cs_value( '!0px 0px 0px' ),
  'cart_quantity_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),

  'cart_total_bg'                        => cs_value( 'transparent', 'style:color' ),
  'cart_total_font_family'               => cs_value( 'inherit', 'style:font-family' ),
  'cart_total_font_weight'               => cs_value( 'inherit:400', 'style:font-weight' ),
  'cart_total_font_size'                 => cs_value( '1em' ),
  'cart_total_letter_spacing'            => cs_value( '0em' ),
  'cart_total_line_height'               => cs_value( '1' ),
  'cart_total_font_style'                => cs_value( 'normal' ),
  'cart_total_text_align'                => cs_value( 'center' ),
  'cart_total_text_decoration'           => cs_value( 'none' ),
  'cart_total_text_transform'            => cs_value( 'none' ),
  'cart_total_text_color'                => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'cart_total_text_shadow_dimensions'    => cs_value( '!0px 0px 0px' ),
  'cart_total_text_shadow_color'         => cs_value( 'transparent', 'style:color' ),
  'cart_total_margin'                    => cs_value( '!0px' ),
  'cart_total_padding'                   => cs_value( '10px 0px 10px 0px' ),
  'cart_total_border_width'              => cs_value( '1px 0px 1px 0px' ),
  'cart_total_border_style'              => cs_value( 'solid' ),
  'cart_total_border_color'              => cs_value( 'rgba(0, 0, 0, 0.065) transparent rgba(0, 0, 0, 0.065) transparent', 'style:color' ),
  'cart_total_border_radius'             => cs_value( '!0px' ),
  'cart_total_box_shadow_dimensions'     => cs_value( '!0em 0em 0em 0em' ),
  'cart_total_box_shadow_color'          => cs_value( 'transparent', 'style:color' ),

  'cart_buttons_justify_content'         => cs_value( 'space-between' ),
  'cart_buttons_bg'                      => cs_value( 'transparent', 'style:color' ),
  'cart_buttons_margin'                  => cs_value( '15px 0px 0px 0px' ),
  'cart_buttons_padding'                 => cs_value( '!0px' ),
  'cart_buttons_border_width'            => cs_value( '!0px' ),
  'cart_buttons_border_style'            => cs_value( 'solid' ),
  'cart_buttons_border_color'            => cs_value( 'transparent', 'style:color' ),
  'cart_buttons_border_radius'           => cs_value( '!0px' ),
  'cart_buttons_box_shadow_dimensions'   => cs_value( '!0em 0em 0em 0em' ),
  'cart_buttons_box_shadow_color'        => cs_value( 'transparent', 'style:color' )
) );

cs_define_values( 'cart-nested', array(
  'cart_title'                           => cs_value( __( 'Your Items', '__x__' ), 'markup', true ),

  'cart_title_font_family'               => cs_value( 'inherit', 'style:font-family' ),
  'cart_title_font_weight'               => cs_value( 'inherit:400', 'style:font-weight' ),
  'cart_title_font_size'                 => cs_value( '2em' ),
  'cart_title_letter_spacing'            => cs_value( '-0.035em' ),
  'cart_title_line_height'               => cs_value( '1.1' ),
  'cart_title_font_style'                => cs_value( 'normal' ),
  'cart_title_text_align'                => cs_value( 'none' ),
  'cart_title_text_decoration'           => cs_value( 'none' ),
  'cart_title_text_transform'            => cs_value( 'none' ),
  'cart_title_text_color'                => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'cart_title_text_shadow_dimensions'    => cs_value( '!0px 0px 0px' ),
  'cart_title_text_shadow_color'         => cs_value( 'transparent', 'style:color' ),
  'cart_title_margin'                    => cs_value( '0px 0px 15px 0px' ),

  'cart_custom_atts'                     => cs_value( '', 'markup' )
) );

cs_register_component( 'cart', [
  'value_prefix' => 'cart',
  'values'       => cs_compose_values( 'cart' )
] );
