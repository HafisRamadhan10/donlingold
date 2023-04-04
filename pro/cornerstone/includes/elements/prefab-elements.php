<?php

// =============================================================================
// PREFAB-ELEMENTS.PHP
// -----------------------------------------------------------------------------
// It's a bunch of prefab elements, yo.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Local Variables
//   02. Register Groups
//   03. Dynamic Elements (Global)
//   04. Dynamic Elements (Archive)
//       a. Title
//       b. Description
//       c. Link
//   05. Dynamic Elements (Post)
//       a. Text
//       b. Featured Image
//       c. Author
//       d. Meta Line
//       e. Terms
//   06. Dynamic Elements (WooCommerce)
//       a. Add to Cart
//       b. Products
//       c. Cart
//       d. Links
//       e. Tabs
//   07. Dynamic Elements (Posts)
//       a. Tiles
//       b. Minimal
//       c. List
//       d. Magazine
//   08. List Elements
//       a. Looper / Baseline
//       b. Looper / Centered
//       c. Static / Baseline
//       d. Static / Centered
//   09. Navigation Elements
//       a. Modal
//       b. Off Canvas
//   10. Search Elements
//       a. Dropdown
//       b. Modal
//   11. Cart Elements
//       a. Dropdown
//       b. Modal
//       c. Off Canvas
//   12. Mega Menus
//       a. Dropdown
//       b. Modal
//       c. Off Canvas
//   13. Sliders
//       a. Slide Navigation
//       b. Slider (Inline)
//       c. Slider (Stacked)
// =============================================================================

// Local Variables
// =============================================================================

$label_article            = __( 'Article', 'cornerstone' );
$label_aside              = __( 'Aside', 'cornerstone' );
$label_author             = __( 'Author', 'cornerstone' );
$label_comments           = __( 'Comments', 'cornerstone' );
$label_content            = __( 'Content', 'cornerstone' );
$label_count              = __( 'Count', 'cornerstone' );
$label_date               = __( 'Date', 'cornerstone' );
$label_dc_featured_image  = __( 'Featured image for “{{dc:post:title}}”', 'cornerstone' );
$label_divider            = __( 'Divider', 'cornerstone' );
$label_featured_image     = __( 'Featured Image', 'cornerstone' );
$label_featured_headline  = __( 'Featured', 'cornerstone' );
$label_figure             = __( 'Figure', 'cornerstone' );
$label_gravatar           = __( 'Gravatar', 'cornerstone' );
$label_intro              = __( 'Intro', 'cornerstone' );
$label_last_divider       = __( 'Last Divider', 'cornerstone' );
$label_leave_a_comment    = __( 'Leave a Comment', 'cornerstone' );
$label_link               = __( 'Link', 'cornerstone' );
$label_list_base          = __( 'List', 'cornerstone' );
$label_list_item          = __( 'List Item', 'cornerstone' );
$label_main_post          = __( 'Main Post', 'cornerstone' );
$label_mega_menu          = __( 'Mega Menu', 'cornerstone' );
$label_meta_line          = __( 'Meta Line', 'cornerstone' );
$label_more_posts         = __( 'More Posts', 'cornerstone' );
$label_multiple_comments  = __( '2+ Comments', 'cornerstone' );
$label_negative_offset    = __( 'Negative Offset', 'cornerstone' );
$label_no_comments        = __( '0 Comments', 'cornerstone' );
$label_not_last_divider   = __( 'Not Last Divider', 'cornerstone' );
$label_one_comment        = __( '1 Comment', 'cornerstone' );
$label_posts              = __( 'Posts', 'cornerstone' );
$label_published          = __( 'Published', 'cornerstone' );
$label_single_meta        = __( 'Meta', 'cornerstone' );
$label_single_post        = __( 'Post', 'cornerstone' );
$label_single_term        = __( 'Term', 'cornerstone' );
$label_technique_headline = __( 'Technique', 'cornerstone' );
$label_terms              = __( 'Terms', 'cornerstone' );
$label_text               = __( 'Text', 'cornerstone' );
$label_the_author         = __( 'The Author', 'cornerstone' );
$label_the_content        = __( 'The Content', 'cornerstone' );
$label_the_excerpt        = __( 'The Excerpt', 'cornerstone' );
$label_the_title          = __( 'The Title', 'cornerstone' );
$label_title              = __( 'Title', 'cornerstone' );



// Register Groups
// =============================================================================
// Available Scopes:
//   - all
//   - content (Content / Global Blocks)
//   - bars (Headers / Footers)
//   - layout-single
//   - layout-archive
//   - layout-single-wc
//   - layout-archive-wc

cs_register_element_group( 'dynamic', __( 'Dynamic', 'cornerstone' ) );

if ( class_exists( 'WC_API' ) ) {
  cs_register_element_group( 'woocommerce', __( 'WooCommerce', 'cornerstone' ) );
}

if ( class_exists( 'BuddyPress' ) ) {
  cs_register_element_group( 'buddypress', __( 'BuddyPress', 'cornerstone' ) );
}

if ( class_exists( 'bbPress' ) ) {
  cs_register_element_group( 'bbpress', __( 'bbPress', 'cornerstone' ) );
}

cs_register_element_group( 'deprecated', __( 'Deprecated', 'cornerstone' ) );



// Dynamic Elements (Global)
// =============================================================================

cs_register_prefab_element( 'dynamic', 'site-title', [
  'type'   => 'headline',
  'scope'  => [ 'all' ],
  'title'  => __( 'Site Title', 'cornerstone' ),
  'values' => [
    'text_content' => '{{dc:global:site_title}}',
  ]
]);

cs_register_prefab_element( 'dynamic', 'site-tagline', [
  'type'   => 'text',
  'scope'  => [ 'all' ],
  'title'  => __( 'Site Tagline', 'cornerstone' ),
  'values' => [
    'text_content' => '{{dc:global:site_tagline}}',
  ]
]);

cs_register_prefab_element( 'dynamic', 'site-home-link', [
  'type'   => 'button',
  'scope'  => [ 'all' ],
  'title'  => __( 'Site Home Link', 'cornerstone' ),
  'values' => [
    'anchor_text_primary_content' => 'Home',
    'anchor_href'                 => '{{dc:global:home_url}}',
  ]
]);

cs_register_prefab_element( 'dynamic', 'site-admin-link', [
  'type'   => 'button',
  'scope'  => [ 'all' ],
  'title'  => __( 'Site Admin Link', 'cornerstone' ),
  'values' => [
    'anchor_text_primary_content' => 'Admin',
    'anchor_href'                 => '{{dc:global:admin_url}}',
  ]
]);



// Dynamic Elements (Archive)
// =============================================================================

// Title
// -----

cs_register_prefab_element( 'dynamic', 'archive-title', [
  'type'   => 'headline',
  'scope'  => [ 'layout-archive', 'bars' ],
  'title'  => __( 'Archive Title', 'cornerstone' ),
  'values' => [
    'text_content' => '{{dc:archive:title}}',
  ]
]);


// Description
// -----------

cs_register_prefab_element( 'dynamic', 'archive-description', [
  'type'   => 'text',
  'scope'  => [ 'layout-archive', 'bars' ],
  'title'  => __( 'Archive Description', 'cornerstone' ),
  'values' => [
    'text_content' => '{{dc:archive:description}}',
  ]
]);


// Link
// ----

cs_register_prefab_element( 'dynamic', 'archive-link', [
  'type'   => 'button',
  'scope'  => [ 'layout-archive', 'bars' ],
  'title'  => __( 'Archive Link', 'cornerstone' ),
  'values' => [
    'anchor_text_primary_content' => '{{dc:archive:title}}',
    'anchor_href'                 => '{{dc:archive:url}}',
  ]
]);



// Dynamic Elements (Post)
// =============================================================================

// Text
// ----

cs_register_prefab_element( 'dynamic', 'the-title', [
  'type'   => 'headline',
  'scope'  => [ 'all' ],
  'title'  => $label_the_title,
  'values' => [
    'text_base_font_size' => '3.05em',
    'text_line_height'    => '1.2',
    'text_content'        => '{{dc:post:title}}',
  ]
]);

cs_register_prefab_element( 'dynamic', 'the-content', [
  'type'   => 'the-content',
  'scope'  => [ 'layout-single' ],
  'title'  => $label_the_content,
  'values' => []
]);

cs_register_prefab_element( 'dynamic', 'the-excerpt', [
  'type'   => 'text',
  'scope'  => [ 'all' ],
  'title'  => $label_the_excerpt,
  'values' => [
    'text_content' => sprintf( '{{dc:post:excerpt fallback="%s"}}', __( 'No excerpt', 'cornerstone' ) ),
  ]
]);


// Featured Image
// --------------

cs_register_prefab_element( 'dynamic', 'featured-image', [
  'type'   => 'image',
  'scope'  => [ 'all' ],
  'title'  => $label_featured_image,
  'values' => [
    'image_src' => '{{dc:post:featured_image_id}}',
  ]
]);


// Author
// ------

cs_register_prefab_element( 'dynamic', 'author-vertical', [
  'type'   => 'layout-div',
  'scope'  => [ 'all' ],
  'title'  => __( 'Author (Vertical)', 'cornerstone' ),
  'values' => [
    'layout_div_tag'          => 'a',
    'layout_div_href'         => '{{dc:user:url}}',
    'layout_div_max_width'    => '28em',
    'layout_div_flex_wrap'    => false,
    'layout_div_flex_align'   => 'stretch',
    'layout_div_margin'       => '0px auto 0px auto',
    'layout_div_padding'      => '!0em',
    'effects_duration'        => '500ms',
    'effects_timing_function' => 'cubic-bezier(0.680, -0.550, 0.265, 1.550)',
    'effects_provider'        => true,
    'effects_alt'             => true,
    'effects_transform_alt'   => 'translate(0px, -4px)',
    '_type'                   => 'layout-div',
    '_label'                  => $label_author,
    '_modules'                => [
      [
        'layout_div_tag'                   => 'aside',
        'layout_div_bg_color'              => 'rgba(0, 0, 0, 0.06)',
        'layout_div_bg_color_alt'          => 'rgba(0, 0, 0, 0.11)',
        'layout_div_flexbox'               => true,
        'layout_div_flex_wrap'             => false,
        'layout_div_flex_align'            => 'stretch',
        'layout_div_margin'                => '26px 0px 0px 0px',
        'layout_div_padding'               => '0em 1.953em 1.563em 1.953em',
        'layout_div_border_radius'         => '1rem',
        'layout_div_box_shadow_dimensions' => '0em 0em 0em 0em',
        'effects_duration'                 => '500ms',
        '_type'                            => 'layout-div',
        '_label'                           => $label_aside,
        '_modules'                         => [
          [
            'layout_div_tag'                   => 'figure',
            'layout_div_bg_color'              => '#ffffff',
            'layout_div_width'                 => '52px',
            'layout_div_height'                => '52px',
            'layout_div_flex'                  => '0 0 auto',
            'layout_div_overflow_x'            => 'hidden',
            'layout_div_overflow_y'            => 'hidden',
            'layout_div_margin'                => '-26px 0px 1.25em 0px',
            'layout_div_border_width'          => '2px',
            'layout_div_border_color'          => '#ffffff',
            'layout_div_border_color_alt'      => '#ffffff',
            'layout_div_border_radius'         => '0.512em',
            'layout_div_box_shadow_dimensions' => '0em 0.55em 1.15em 0em',
            'layout_div_box_shadow_color'      => 'rgba(0, 0, 0, 0.16)',
            'effects_transform_origin'         => '0% 100%',
            'effects_duration'                 => '500ms',
            'effects_timing_function'          => 'cubic-bezier(0.680, -0.550, 0.265, 1.550)',
            'effects_alt'                      => true,
            'effects_transform_alt'            => 'rotateZ(-7deg)',
            '_type'                            => 'layout-div',
            '_label'                           => $label_figure,
            '_modules'                         => [
              [
                'image_src' => '{{dc:author:gravatar}}',
                '_type'     => 'image',
                '_label'    => $label_gravatar
              ],
            ],
          ],
          [
            'text_font_weight'             => 'inherit:700',
            'text_font_size'               => '1.25em',
            'text_line_height'             => '1.2',
            'text_text_color'              => '#000000',
            'text_content'                 => '{{dc:author:display_name}}',
            'text_tag'                     => 'h6',
            'text_subheadline'             => true,
            'text_subheadline_content'     => '{{dc:author:bio}}',
            'text_subheadline_tag'         => 'p',
            'text_subheadline_spacing'     => '0.409em',
            'text_subheadline_line_height' => '1.6',
            'text_subheadline_text_color'  => 'rgba(0, 0, 0, 0.66)',
            'effects_transform'            => 'translate3d(0, 0, 0)',
            '_type'                        => 'headline'
          ],
        ],
      ],
    ],
  ]
]);

cs_register_prefab_element( 'dynamic', 'author-horizontal', [
  'type'   => 'layout-div',
  'scope'  => [ 'all' ],
  'title'  => __( 'Author (Horizontal)', 'cornerstone' ),
  'values' => [
    'layout_div_tag'          => 'a',
    'layout_div_href'         => '{{dc:user:url}}',
    'layout_div_flex_wrap'    => false,
    'layout_div_flex_align'   => 'stretch',
    'effects_duration'        => '500ms',
    'effects_timing_function' => 'cubic-bezier(0.680, -0.550, 0.265, 1.550)',
    'effects_provider'        => true,
    'effects_alt'             => true,
    'effects_transform_alt'   => 'translate(0px, -4px)',
    '_type'                   => 'layout-div',
    '_label'                  => $label_author,
    '_modules'                => [
      [
        'layout_div_tag'            => 'aside',
        'layout_div_bg_color'       => 'rgba(0, 0, 0, 0.06)',
        'layout_div_bg_color_alt'   => 'rgba(0, 0, 0, 0.11)',
        'layout_div_flexbox'        => true,
        'layout_div_flex_direction' => 'row',
        'layout_div_flex_wrap'      => false,
        'layout_div_margin'         => '0px 0px 0px 26px',
        'layout_div_padding'        => '1.953em 1.953em 1.953em 0em',
        'layout_div_border_radius'  => '1rem',
        'effects_duration'          => '500ms',
        '_type'                     => 'layout-div',
        '_label'                    => $label_aside,
        '_modules'                  => [
          [
            'layout_div_tag'                   => 'figure',
            'layout_div_bg_color'              => '#ffffff',
            'layout_div_width'                 => '52px',
            'layout_div_height'                => '52px',
            'layout_div_flex'                  => '0 0 auto',
            'layout_div_overflow_x'            => 'hidden',
            'layout_div_overflow_y'            => 'hidden',
            'layout_div_margin'                => '0px 1.25em 0px -26px',
            'layout_div_border_width'          => '2px',
            'layout_div_border_color'          => '#ffffff',
            'layout_div_border_color_alt'      => '#ffffff',
            'layout_div_border_radius'         => '0.512em',
            'layout_div_box_shadow_dimensions' => '0em 0.55em 1.15em 0em',
            'layout_div_box_shadow_color'      => 'rgba(0, 0, 0, 0.16)',
            'effects_transform_origin'         => '0% 100%',
            'effects_duration'                 => '500ms',
            'effects_timing_function'          => 'cubic-bezier(0.680, -0.550, 0.265, 1.550)',
            'effects_alt'                      => true,
            'effects_transform_alt'            => 'rotateZ(-7deg)',
            '_type'                            => 'layout-div',
            '_label'                           => $label_figure,
            '_modules'                         => [
              [
                'image_src' => '{{dc:author:gravatar}}',
                '_type'     => 'image',
                '_label'    => $label_gravatar
              ],
            ],
          ],
          [
            'text_font_weight'             => 'inherit:700',
            'text_font_size'               => '1.25em',
            'text_line_height'             => '1.2',
            'text_text_color'              => '#000000',
            'text_content'                 => '{{dc:author:display_name}}',
            'text_tag'                     => 'h6',
            'text_subheadline'             => true,
            'text_subheadline_content'     => '{{dc:author:bio}}',
            'text_subheadline_tag'         => 'p',
            'text_subheadline_spacing'     => '0.409em',
            'text_subheadline_line_height' => '1.6',
            'text_subheadline_text_color'  => 'rgba(0, 0, 0, 0.66)',
            'effects_transform'            => 'translate3d(0, 0, 0)',
            '_type'                        => 'headline'
          ],
        ],
      ],
    ],
  ]
]);


// Meta Line
// ---------

$meta_line_line_height = '1.65';
$meta_line_color_base  = '#000000';
$meta_line_color_int   = 'rgba(0, 0, 0, 0.33)';

cs_register_prefab_element( 'dynamic', 'meta-line', [
  'type'   => 'layout-div',
  'scope'  => [ 'all' ],
  'title'  => $label_meta_line,
  'values' => [
    'layout_div_flexbox'        => true,
    'layout_div_flex_direction' => 'row',
    'layout_div_flex_align'     => 'baseline',
    '_type'                     => 'layout-div',
    '_label'                    => $label_meta_line,
    '_modules'                  => [
      [
        'layout_div_flexbox'        => true,
        'layout_div_flex_direction' => 'row',
        'layout_div_flex_wrap'      => false,
        'layout_div_flex_align'     => 'center',
        '_type'                     => 'layout-div',
        '_label'                    => $label_date,
        '_modules'                  => [
          [
            'text_line_height' => $meta_line_line_height,
            'text_text_color'  => $meta_line_color_base,
            'text_content'     => '{{dc:post:publish_date}}',
            'class'            => '{{thing}}',
            '_type'            => 'text',
            '_label'           => $label_text
          ],
          [
            'text_line_height' => $meta_line_line_height,
            'text_text_color'  => $meta_line_color_int,
            'text_content'     => '&nbsp;/&nbsp;',
            '_type'            => 'text',
            '_label'           => $label_divider
          ],
        ],
      ],
      [
        'layout_div_flexbox'        => true,
        'layout_div_flex_direction' => 'row',
        'layout_div_flex_wrap'      => false,
        'layout_div_flex_align'     => 'center',
        '_type'                     => 'layout-div',
        '_label'                    => $label_author,
        '_modules'                  => [
          [
            'text_line_height' => $meta_line_line_height,
            'text_text_color'  => $meta_line_color_base,
            'text_content'     => '{{dc:author:display_name}}',
            '_type'            => 'text',
            '_label'           => $label_text
          ],
          [
            'text_line_height' => $meta_line_line_height,
            'text_text_color'  => $meta_line_color_int,
            'text_content'     => '&nbsp;/&nbsp;',
            '_type'            => 'text',
            '_label'           => $label_divider
          ],
        ],
      ],
      [
        'layout_div_flexbox'        => true,
        'layout_div_flex_direction' => 'row',
        'layout_div_flex_wrap'      => false,
        'layout_div_flex_align'     => 'center',
        '_type'                     => 'layout-div',
        '_label'                    => $label_comments,
        '_modules'                  => [
          [
            'anchor_bg_color'               => 'transparent',
            'anchor_margin'                 => '!0px',
            'anchor_padding'                => '!0px',
            'anchor_border_radius'          => '!0px',
            'anchor_box_shadow_dimensions'  => '!0em 0em 0em 0em',
            'anchor_box_shadow_color'       => 'transparent',
            'anchor_text_margin'            => '!0px',
            'anchor_primary_line_height'    => $meta_line_line_height,
            'anchor_primary_text_color'     => $meta_line_color_base,
            'anchor_primary_text_color_alt' => 'rgba(0, 0, 0, 0.33)',
            'anchor_text_primary_content'   => $label_leave_a_comment,
            'anchor_href'                   => '{{dc:post:comment_link}}',
            'show_condition'                => [
              [
                'group'     => true,
                'condition' => 'expression:number',
                'value'     => '0',
                'operand'   => '{{dc:post:comment_count}}',
                'operator'  => 'eq'
              ],
            ],
            '_type'  => 'button',
            '_label' => $label_no_comments
          ],
          [
            'anchor_bg_color'               => 'transparent',
            'anchor_margin'                 => '!0px',
            'anchor_padding'                => '!0px',
            'anchor_border_radius'          => '!0px',
            'anchor_box_shadow_dimensions'  => '!0em 0em 0em 0em',
            'anchor_box_shadow_color'       => 'transparent',
            'anchor_text_margin'            => '!0px',
            'anchor_primary_line_height'    => $meta_line_line_height,
            'anchor_primary_text_color'     => $meta_line_color_base,
            'anchor_primary_text_color_alt' => 'rgba(0, 0, 0, 0.33)',
            'anchor_text_primary_content'   => '{{dc:post:comment_count}} Comment',
            'anchor_href'                   => '{{dc:post:comment_link}}',
            'show_condition'                => [
              [
                'group'     => true,
                'condition' => 'expression:number',
                'value'     => '1',
                'operand'   => '{{dc:post:comment_count}}',
                'operator'  => 'eq'
              ],
            ],
            '_type'  => 'button',
            '_label' => $label_one_comment
          ],
          [
            'anchor_bg_color'               => 'transparent',
            'anchor_margin'                 => '!0px',
            'anchor_padding'                => '!0px',
            'anchor_border_radius'          => '!0px',
            'anchor_box_shadow_dimensions'  => '!0em 0em 0em 0em',
            'anchor_box_shadow_color'       => 'transparent',
            'anchor_text_margin'            => '!0px',
            'anchor_primary_line_height'    => $meta_line_line_height,
            'anchor_primary_text_color'     => $meta_line_color_base,
            'anchor_primary_text_color_alt' => 'rgba(0, 0, 0, 0.33)',
            'anchor_text_primary_content'   => '{{dc:post:comment_count}} Comments',
            'anchor_href'                   => '{{dc:post:comment_link}}',
            'show_condition'                => [
              [
                'group'     => true,
                'condition' => 'expression:number',
                'value'     => '1',
                'operand'   => '{{dc:post:comment_count}}',
                'operator'  => 'gt'
              ],
            ],
            '_type'  => 'button',
            '_label' => $label_multiple_comments
          ],
          [
            'text_line_height' => $meta_line_line_height,
            'text_text_color'  => $meta_line_color_int,
            'text_content'     => '&nbsp;/&nbsp;',
            '_type'            => 'text',
            '_label'           => $label_divider
          ],
        ],
      ],
      [
        'layout_div_flexbox'        => true,
        'layout_div_flex_direction' => 'row',
        'layout_div_flex_align'     => 'center',
        'looper_provider'           => true,
        'looper_provider_type'      => 'terms',
        '_type'                     => 'layout-div',
        '_label'                    => $label_terms,
        '_modules'                  => [
          [
            'layout_div_flexbox'        => true,
            'layout_div_flex_direction' => 'row',
            'layout_div_flex_wrap'      => false,
            'layout_div_flex_align'     => 'baseline',
            'looper_consumer'           => true,
            '_type'                     => 'layout-div',
            '_label'                    => $label_single_term,
            '_modules'                  => [
              [
                'anchor_bg_color'               => 'transparent',
                'anchor_margin'                 => '!0px',
                'anchor_padding'                => '!0px',
                'anchor_border_radius'          => '!0px',
                'anchor_box_shadow_dimensions'  => '!0em 0em 0em 0em',
                'anchor_box_shadow_color'       => 'transparent',
                'anchor_text_margin'            => '!0px',
                'anchor_primary_line_height'    => $meta_line_line_height,
                'anchor_primary_text_color'     => $meta_line_color_base,
                'anchor_primary_text_color_alt' => 'rgba(0, 0, 0, 0.33)',
                'anchor_text_primary_content'   => '{{dc:term:name}}',
                'anchor_href'                   => '{{dc:term:url}}',
                '_type'                         => 'button',
                '_label'                        => $label_link
              ],
              [
                'text_line_height' => $meta_line_line_height,
                'text_text_color'  => $meta_line_color_base,
                'text_content'     => ',&nbsp;',
                'show_condition'   => [
                  [
                    'group'     => true,
                    'condition' => 'looper:index',
                    'value'     => 'last',
                    'toggle'    => false
                  ],
                ],
                '_type'  => 'text',
                '_label' => $label_divider
              ],
            ],
          ],
        ],
      ],
    ],
  ]
]);


// Terms
// -----

cs_register_prefab_element( 'dynamic', 'terms-cloud', [
  'type'   => 'layout-row',
  'scope'  => [ 'all' ],
  'title'  => __( 'Terms (Cloud)', 'cornerstone' ),
  'values' => [
    '_type'                     => 'layout-row',
    '_bp_base'                  => '4_4',
    '_label'                    => 'Terms',
    '_m'                        => [
      'e' => 2
    ],
    'layout_row_base_font_size' => '0.8em',
    'layout_row_gap_column'     => '0.64em',
    'layout_row_gap_row'        => '0.8em',
    'layout_row_layout'         => 'auto',
    'layout_row_layout_lg'      => 'auto',
    'layout_row_layout_md'      => 'auto',
    'layout_row_layout_sm'      => 'auto',
    'layout_row_layout_xl'      => 'auto',
    'layout_row_layout_xs'      => 'auto',
    'layout_row_tag'            => 'ul',
    '_modules'                  => [
      [
        '_type'                => 'layout-column',
        '_bp_base'             => '4_4',
        '_label'               => 'List Item',
        '_m'                   => [
          'e' => 2
        ],
        'layout_column_tag'    => 'li',
        'looper_consumer'      => true,
        'looper_provider'      => true,
        'looper_provider_type' => 'taxonomy',
        '_modules'             => [
          [
            '_type'                         => 'button',
            '_bp_base'                      => '4_4',
            '_label'                        => 'Term',
            'anchor_bg_color'               => 'rgba(0, 0, 0, 0.06)',
            'anchor_bg_color_alt'           => 'rgba(0, 0, 0, 0.11)',
            'anchor_border_radius'          => '100em',
            'anchor_box_shadow_color'       => 'transparent',
            'anchor_box_shadow_dimensions'  => '!0em 0em 0em 0em',
            'anchor_flex_align'             => 'baseline',
            'anchor_graphic_icon'           => 'o-hashtag',
            'anchor_graphic_icon_alt'       => 'o-hashtag',
            'anchor_graphic_icon_color'     => 'rgba(0, 0, 0, 0.66)',
            'anchor_graphic_icon_color_alt' => '#000000',
            'anchor_graphic_icon_font_size' => '1em',
            'anchor_graphic_margin'         => '0em 0.209em 0em 0em',
            'anchor_href'                   => '{{dc:term:url}}',
            'anchor_padding'                => '0.8em 1.25em 0.8em 1.25em',
            'anchor_primary_font_weight'    => 'inherit:700',
            'anchor_primary_line_height'    => '1.45',
            'anchor_primary_text_color'     => 'rgba(0, 0, 0, 0.66)',
            'anchor_primary_text_color_alt' => '#000000',
            'anchor_text_margin'            => '!0px',
            'anchor_text_primary_content'   => '{{dc:term:name}} ({{dc:term:count}})',
            'effects_duration'              => '222ms'
          ]
        ]
      ]
    ]
  ]
]);


cs_register_prefab_element( 'dynamic', 'terms-minimal', [
  'type'   => 'layout-row',
  'scope'  => [ 'all' ],
  'title'  => __( 'Terms (Minimal)', 'cornerstone' ),
  'values' => [
    '_type'                 => 'layout-row',
    '_bp_base'              => '4_4',
    '_label'                => 'Terms',
    '_m'                    => [
      'e' => 2
    ],
    'layout_row_gap_column' => '0em',
    'layout_row_gap_row'    => '0.512em',
    'layout_row_layout'     => 'auto',
    'layout_row_layout_lg'  => 'auto',
    'layout_row_layout_md'  => 'auto',
    'layout_row_layout_sm'  => 'auto',
    'layout_row_layout_xl'  => 'auto',
    'layout_row_layout_xs'  => 'auto',
    'layout_row_tag'        => 'ul',
    '_modules'              => [
      [
        '_type'                        => 'layout-column',
        '_bp_base'                     => '4_4',
        '_label'                       => 'List Item',
        '_m'                           => [
          'e' => 2
        ],
        'layout_column_flex_align'     => 'center',
        'layout_column_flex_direction' => 'row',
        'layout_column_flex_wrap'      => false,
        'layout_column_flexbox'        => true,
        'layout_column_tag'            => 'li',
        'looper_consumer'              => true,
        'looper_provider'              => true,
        'looper_provider_type'         => 'taxonomy',
        '_modules'                     => [
          [
            '_type'                         => 'button',
            '_bp_base'                      => '4_4',
            '_label'                        => 'Term',
            'anchor_base_font_size'         => '0.64em',
            'anchor_bg_color'               => 'transparent',
            'anchor_border_radius'          => '!0px',
            'anchor_box_shadow_color'       => 'transparent',
            'anchor_box_shadow_dimensions'  => '!0em 0em 0em 0em',
            'anchor_graphic_icon'           => 'o-hashtag',
            'anchor_graphic_icon_alt'       => 'o-hashtag',
            'anchor_graphic_icon_color'     => '#000000',
            'anchor_graphic_icon_color_alt' => 'rgba(0, 0, 0, 0.66)',
            'anchor_graphic_icon_font_size' => '1em',
            'anchor_graphic_margin'         => '0em 0.262em 0em 0em',
            'anchor_href'                   => '{{dc:term:url}}',
            'anchor_padding'                => '0.409em 0em 0.409em 0em',
            'anchor_primary_font_weight'    => 'inherit:700',
            'anchor_primary_letter_spacing' => '0.135em',
            'anchor_primary_line_height'    => '1.4',
            'anchor_primary_text_color'     => '#000000',
            'anchor_primary_text_color_alt' => 'rgba(0, 0, 0, 0.44)',
            'anchor_primary_text_transform' => 'uppercase',
            'anchor_text_margin'            => '!0px',
            'anchor_text_primary_content'   => '{{dc:term:name}}',
            'effects_duration'              => '222ms'
          ],
          [
            '_type'           => 'text',
            '_bp_base'        => '4_4',
            '_label'          => 'Not Last Divider',
            'show_condition'  => [
              [
                'group'     => true,
                'condition' => 'looper:index',
                'value'     => 'last',
                'toggle'    => false
              ]
            ],
            'text_content'    => '/',
            'text_padding'    => '0em 0.512em 0em 0.512em',
            'text_text_color' => 'rgba(0, 0, 0, 0.33)'
          ],
          [
            '_type'           => 'text',
            '_bp_base'        => '4_4',
            '_label'          => 'Last Divider',
            'effects_opacity' => '0',
            'show_condition'  => [
              [
                'group'     => true,
                'condition' => 'looper:index',
                'value'     => 'last',
                'toggle'    => true
              ]
            ],
            'text_content'    => '/',
            'text_padding'    => '0em 0.512em 0em 0.512em',
            'text_text_color' => 'rgba(0, 0, 0, 0.33)'
          ]
        ]
      ]
    ]
  ]
]);


cs_register_prefab_element( 'dynamic', 'terms-column', [
  'type'   => 'layout-row',
  'scope'  => [ 'all' ],
  'title'  => __( 'Terms (Column)', 'cornerstone' ),
  'values' => [
    '_type'                 => 'layout-row',
    '_bp_base'              => '4_4',
    '_label'                => 'Terms',
    '_m'                    => [
      'e' => 2
    ],
    'layout_row_gap_column' => '1.563em',
    'layout_row_gap_row'    => '0em',
    'layout_row_tag'        => 'ul',
    '_modules'              => [
      [
        '_type'                   => 'layout-column',
        '_bp_base'                => '4_4',
        '_label'                  => 'List Item',
        '_m'                      => [
          'e' => 2
        ],
        'layout_column_flex_wrap' => false,
        'layout_column_flexbox'   => true,
        'layout_column_tag'       => 'li',
        'looper_consumer'         => true,
        'looper_provider'         => true,
        'looper_provider_type'    => 'taxonomy',
        '_modules'                => [
          [
            '_type'                     => 'layout-div',
            '_bp_base'                  => '4_4',
            '_label'                    => $label_single_term,
            '_m'                        => [
              'e' => 1
            ],
            'effects_provider'          => true,
            'layout_div_flex_align'     => 'center',
            'layout_div_flex_direction' => 'row',
            'layout_div_flex_justify'   => 'space-between',
            'layout_div_flex_wrap'      => false,
            'layout_div_flexbox'        => true,
            'layout_div_height'         => '3.5em',
            'layout_div_href'           => '{{dc:term:url}}',
            'layout_div_tag'            => 'a',
            'layout_div_width'          => '100%',
            '_modules'                  => [
              [
                '_type'                       => 'headline',
                '_bp_base'                    => '4_4',
                '_label'                      => 'Title',
                'effects_duration'            => '22ms',
                'text_content'                => '{{dc:term:name}}',
                'text_font_weight'            => 'inherit:700',
                'text_graphic_icon'           => 'o-hashtag',
                'text_graphic_icon_alt'       => 'o-hashtag',
                'text_graphic_icon_color'     => 'rgba(0, 0, 0, 0.44)',
                'text_graphic_icon_font_size' => '1em',
                'text_graphic_margin'         => '0em 0.327em 0em 0em',
                'text_line_height'            => '1.65',
                'text_overflow'               => true,
                'text_tag'                    => 'span',
                'text_text_color'             => '#000000',
                'text_text_color_alt'         => 'rgba(0, 0, 0, 0.44)'
              ],
              [
                '_type'                     => 'layout-div',
                '_bp_base'                  => '4_4',
                '_label'                    => 'Figure',
                '_m'                        => [
                  'e' => 1
                ],
                'layout_div_base_font_size' => '10px',
                'layout_div_bg_color'       => 'rgba(0, 0, 0, 0.06)',
                'layout_div_border_radius'  => '3px',
                'layout_div_flex'           => '0 0 auto',
                'layout_div_flex_align'     => 'center',
                'layout_div_flex_justify'   => 'center',
                'layout_div_flexbox'        => true,
                'layout_div_height'         => '2em',
                'layout_div_margin'         => '0em 0em 0em 1em',
                'layout_div_min_width'      => '2em',
                'layout_div_padding'        => '0em 0.5em 0em 0.5em',
                'layout_div_tag'            => 'figure',
                '_modules'                  => [
                  [
                    '_type'            => 'text',
                    '_bp_base'         => '4_4',
                    '_label'           => 'Count',
                    'effects_duration' => '0ms',
                    'text_content'     => '{{dc:term:count}}',
                    'text_font_weight' => 'inherit:700',
                    'text_line_height' => '1',
                    'text_text_color'  => '#000000'
                  ]
                ]
              ]
            ]
          ],
          [
            '_type'          => 'line',
            '_bp_base'       => '4_4',
            'line_color'     => 'rgba(0, 0, 0, 0.16)',
            'line_size'      => '1px',
            'line_style'     => 'dotted',
            'show_condition' => [
              [
                'group'     => true,
                'condition' => 'looper:index',
                'value'     => 'last',
                'toggle'    => false
              ]
            ]
          ]
        ]
      ]
    ]
  ]
]);



// Dynamic Elements (WooCommerce)
// =============================================================================

// Add to Cart
// -----------

if ( class_exists( 'WC_API' ) ) :

cs_register_prefab_element( 'woocommerce', 'add-to-cart-button', [
  'type'   => 'button',
  'scope'  => [ 'all' ],
  'title'  => __( 'Add to Cart Button', 'cornerstone' ),
  'values' => [
    'anchor_text_primary_content' => 'Add to Cart',
    'anchor_href'                 => '?add-to-cart={{dc:woocommerce:product_id}}',
    'class'                       => 'add_to_cart_button ajax_add_to_cart',
    'custom_atts'                 => '{"data-quantity":"1","data-product_id":"{{dc:woocommerce:product_id}}","data-product_sku":"{{dc:woocommerce:product_sku}}","aria-label":"Add “{{dc:woocommerce:product_title}}” to your cart","rel":"nofollow"}'
  ]
]);

// cs_register_prefab_element( 'woocommerce', 'add-to-cart-with-quantity', [
//   'type'   => 'button',
//   'scope'  => [ 'all' ],
//   'title'  => __( 'Add to Cart Button', 'cornerstone' ),
//   'values' => [

//   )
// ]);


// Products
// --------

cs_register_prefab_element( 'woocommerce', 'shop-title', [
  'type'   => 'headline',
  'scope'  => [ 'all' ],
  'title'  => __( 'Shop Title', 'cornerstone' ),
  'values' => [
    'text_base_font_size' => '3.05em',
    'text_line_height'    => '1.2',
    'text_content'        => '{{dc:woocommerce:page_title}}',
  ]
]);

cs_register_prefab_element( 'woocommerce', 'product-title', [
  'type'   => 'headline',
  'scope'  => [ 'all' ],
  'title'  => __( 'Product Title', 'cornerstone' ),
  'values' => [
    'text_base_font_size' => '3.05em',
    'text_line_height'    => '1.2',
    'text_content'        => '{{dc:woocommerce:product_title}}',
  ]
]);

cs_register_prefab_element( 'woocommerce', 'product-long-description', [
  'type'   => 'the-content',
  'scope'  => [ 'all' ],
  'title'  => __( 'Product Long Description', 'cornerstone' ),
  'values' => []
]);

cs_register_prefab_element( 'woocommerce', 'product-short-description', [
  'type'   => 'text',
  'scope'  => [ 'all' ],
  'title'  => __( 'Product Short Description', 'cornerstone' ),
  'values' => [
    'text_content' => '{{dc:woocommerce:product_short_description}}',
  ]
]);

cs_register_prefab_element( 'woocommerce', 'product-additional-information', [
  'type'   => 'content-area',
  'scope'  => [ 'all' ],
  'title'  => __( 'Product Additional Information', 'cornerstone' ),
  'values' => [
    'content' => '{{dc:woocommerce:product_additional_information}}',
  ]
]);

cs_register_prefab_element( 'woocommerce', 'product-reviews', [
  'type'   => 'content-area',
  'scope'  => [ 'all' ],
  'title'  => __( 'Product Reviews', 'cornerstone' ),
  'values' => [
    'content' => '{{dc:woocommerce:product_reviews}}',
  ]
]);

cs_register_prefab_element( 'woocommerce', 'product-image', [
  'type'   => 'image',
  'scope'  => [ 'all' ],
  'title'  => __( 'Product Image', 'cornerstone' ),
  'values' => [
    'image_src' => '{{dc:woocommerce:product_image}}',
  ]
]);

cs_register_prefab_element( 'woocommerce', 'product-price', [
  'type'   => 'headline',
  'scope'  => [ 'all' ],
  'title'  => __( 'Product Price', 'cornerstone' ),
  'values' => [
    'text_tag'     => 'span',
    'text_content' => '{{dc:woocommerce:product_price}}',
  ]
]);


cs_register_prefab_element( 'woocommerce', 'product-rating', [
  'type'   => 'rating',
  'scope'  => [ 'all' ],
  'title'  => __( 'Product Rating', 'cornerstone' ),
  'values' => [
    'rating_value_content' => '{{dc:woocommerce:product_average_rating}}',
  ]
]);


// Cart
// ----

cs_register_prefab_element( 'woocommerce', 'cart-total', [
  'type'   => 'headline',
  'scope'  => [ 'all' ],
  'title'  => __( 'Cart Total', 'cornerstone' ),
  'values' => [
    'text_tag'     => 'span',
    'text_content' => '{{dc:woocommerce:cart_total}}',
  ]
]);

cs_register_prefab_element( 'woocommerce', 'cart-items', [
  'type'   => 'headline',
  'scope'  => [ 'all' ],
  'title'  => __( 'Cart Items', 'cornerstone' ),
  'values' => [
    'text_tag'     => 'span',
    'text_content' => '{{dc:woocommerce:cart_items}}',
  ]
]);


// Links
// -----

cs_register_prefab_element( 'woocommerce', 'shop-link', [
  'type'   => 'button',
  'scope'  => [ 'all' ],
  'title'  => __( 'Shop Link', 'cornerstone' ),
  'values' => [
    'anchor_text_primary_content' => __( 'Shop', 'cornerstone' ),
    'anchor_href'                 => '{{dc:woocommerce:shop_url}}',
  ]
]);

cs_register_prefab_element( 'woocommerce', 'cart-link', [
  'type'   => 'button',
  'scope'  => [ 'all' ],
  'title'  => __( 'Cart Link', 'cornerstone' ),
  'values' => [
    'anchor_text_primary_content' => __( 'Cart', 'cornerstone' ),
    'anchor_href'                 => '{{dc:woocommerce:cart_url}}',
  ]
]);

cs_register_prefab_element( 'woocommerce', 'checkout-link', [
  'type'   => 'button',
  'scope'  => [ 'all' ],
  'title'  => __( 'Checkout Link', 'cornerstone' ),
  'values' => [
    'anchor_text_primary_content' => __( 'Checkout', 'cornerstone' ),
    'anchor_href'                 => '{{dc:woocommerce:checkout_url}}',
  ]
]);

cs_register_prefab_element( 'woocommerce', 'account-link', [
  'type'   => 'button',
  'scope'  => [ 'all' ],
  'title'  => __( 'Account Link', 'cornerstone' ),
  'values' => [
    'anchor_text_primary_content' => __( 'Account', 'cornerstone' ),
    'anchor_href'                 => '{{dc:woocommerce:account_url}}',
  ]
]);

cs_register_prefab_element( 'woocommerce', 'terms-link', [
  'type'   => 'button',
  'scope'  => [ 'all' ],
  'title'  => __( 'Terms Link', 'cornerstone' ),
  'values' => [
    'anchor_text_primary_content' => __( 'Terms', 'cornerstone' ),
    'anchor_href'                 => '{{dc:woocommerce:terms_url}}',
  ]
]);


// Tabs
// ----

cs_register_prefab_element( 'woocommerce', 'product-tabs', [
  'type'   => 'tabs',
  'scope'  => [ 'all' ],
  'title'  => __( 'Product Tabs', 'cornerstone' ),
  'values' => [
    '_modules' => [
      [
        '_type'             => 'tab',
        'tab_label_content' => __( 'Description', 'cornerstone' ),
        'tab_content'       => '{{dc:woocommerce:product_description fallback="No Description"}}',
      ],
      [
        '_type'             => 'tab',
        'tab_label_content' => __( 'Additional Information', 'cornerstone' ),
        'tab_content'       => '{{dc:woocommerce:product_additional_information fallback="No Additional Information"}}',
      ],
      [
        '_type'             => 'tab',
        'tab_label_content' => __( 'Reviews ({{dc:woocommerce:product_review_count}})', 'cornerstone' ),
        'tab_content'       => '{{dc:woocommerce:product_reviews fallback="No Reviews"}}',
      ],
    ],
  ]
]);

endif;



// Dynamic Elements (Posts)
// =============================================================================

// Tiles
// -----

cs_register_prefab_element( 'dynamic', 'posts-tiles', [
  'type'   => 'layout-row',
  'scope'  => [ 'all' ],
  'title'  => __( 'Posts (Tiles)', 'cornerstone' ),
  'values' => [
    '_type'                       => 'layout-row',
    '_bp_base'                    => '4_4',
    '_label'                      => 'Posts',
    '_m'                          => [
      'e' => 2
    ],
    'layout_row_base_font_size'   => '1rem',
    'layout_row_flex_justify'     => 'center',
    'layout_row_gap_column'       => '1em',
    'layout_row_gap_row'          => '1em',
    'layout_row_grow'             => true,
    'layout_row_layout'           => '28em',
    'layout_row_layout_lg'        => '28em',
    'layout_row_layout_md'        => '28em',
    'layout_row_layout_sm'        => '28em',
    'layout_row_layout_xl'        => '28em',
    'layout_row_layout_xs'        => '28em',
    'looper_provider'             => true,
    'looper_provider_query_count' => '3',
    '_modules'                    => [
      [
        '_type'                                             => 'layout-column',
        '_bp_base'                                          => '4_4',
        '_label'                                            => 'Post',
        '_m'                                                => [
          'e' => 2
        ],
        'effects_provider'                                  => true,
        'layout_column_border_radius'                       => '2px',
        'layout_column_box_shadow_color'                    => 'rgba(0, 0, 0, 0.22)',
        'layout_column_box_shadow_dimensions'               => '0em 0.65em 1.5em 0em',
        'layout_column_height'                              => '44vh',
        'layout_column_href'                                => '{{dc:post:permalink}}',
        'layout_column_max_height'                          => '400px',
        'layout_column_min_height'                          => '320px',
        'layout_column_overflow'                            => 'hidden',
        'layout_column_padding'                             => '!0em',
        'layout_column_primary_particle'                    => true,
        'layout_column_primary_particle_color'              => '#ffba00',
        'layout_column_primary_particle_location'           => 't_r',
        'layout_column_primary_particle_scale'              => 'scale-x',
        'layout_column_primary_particle_transform_origin'   => '100% 0%',
        'layout_column_primary_particle_width'              => '16px',
        'layout_column_secondary_particle'                  => true,
        'layout_column_secondary_particle_color'            => '#ffba00',
        'layout_column_secondary_particle_delay'            => '150ms',
        'layout_column_secondary_particle_height'           => '16px',
        'layout_column_secondary_particle_location'         => 't_r',
        'layout_column_secondary_particle_transform_origin' => '100% 0%',
        'layout_column_secondary_particle_width'            => '3px',
        'layout_column_tag'                                 => 'a',
        'looper_consumer'                                   => true,
        '_modules'                                          => [
          [
            '_type'                   => 'layout-div',
            '_bp_base'                => '4_4',
            '_label'                  => 'Article',
            '_m'                      => [
              'e' => 1
            ],
            'effects_duration'        => '650ms',
            'layout_div_bg_color'     => 'rgba(0, 0, 0, 0.66)',
            'layout_div_bg_color_alt' => 'rgba(0, 0, 0, 0.33)',
            'layout_div_flexbox'      => true,
            'layout_div_height'       => '100%',
            'layout_div_padding'      => '2.441em',
            'layout_div_position'     => 'static',
            'layout_div_tag'          => 'article',
            'layout_div_width'        => '100%',
            '_modules'                => [
              [
                '_type'               => 'text',
                '_bp_base'            => '4_4',
                '_label'              => 'Published',
                'effects_duration'    => '650ms',
                'text_content'        => '{{dc:post:publish_date format=\'M / Y\'}}',
                'text_font_size'      => '0.8em',
                'text_letter_spacing' => '0.15em',
                'text_line_height'    => '1',
                'text_text_color'     => 'rgba(255, 255, 255, 0.55)',
                'text_text_color_alt' => '#ffffff',
                'text_text_transform' => 'uppercase'
              ],
              [
                '_type'               => 'headline',
                '_bp_base'            => '4_4',
                '_label'              => 'The Title',
                'text_base_font_size' => '1.563em',
                'text_content'        => '{{dc:post:title}}',
                'text_flex_align'     => 'flex-start',
                'text_flex_direction' => 'column',
                'text_flex_justify'   => 'flex-start',
                'text_line_height'    => '1.25',
                'text_margin'         => 'auto 0em 0em 0em',
                'text_max_width'      => '21em',
                'text_tag'            => 'h2',
                'text_text_color'     => '#ffffff'
              ],
              [
                '_type'                 => 'layout-div',
                '_bp_base'              => '4_4',
                '_label'                => 'Figure',
                '_m'                    => [
                  'e' => 1
                ],
                'effects_alt'           => true,
                'effects_duration'      => '650ms',
                'effects_transform'     => 'translate3d(0, 0, 0)',
                'effects_transform_alt' => 'translate3d(0, 0, 0) scale(1.05)',
                'layout_div_bottom'     => '0px',
                'layout_div_left'       => '0px',
                'layout_div_position'   => 'absolute',
                'layout_div_right'      => '0px',
                'layout_div_tag'        => 'figure',
                'layout_div_top'        => '0px',
                'layout_div_z_index'    => '-1',
                'show_condition'        => [
                  [
                    'group'     => true,
                    'condition' => 'current-post:featured-image',
                    'value'     => ''
                  ]
                ],
                '_modules'              => [
                  [
                    '_type'               => 'image',
                    '_bp_base'            => '4_4',
                    '_label'              => 'Featured Image',
                    'image_alt'           => 'Featured image for “{{dc:post:title}}”',
                    'image_display'       => 'block',
                    'image_object_fit'    => 'cover',
                    'image_src'           => '{{dc:post:featured_image_id}}',
                    'image_styled_height' => '100%',
                    'image_styled_width'  => '100%'
                  ]
                ]
              ]
            ]
          ]
        ]
      ]
    ]
  ]
]);


// Minimal
// -------

cs_register_prefab_element( 'dynamic', 'posts-minimal', [
  'type'   => 'layout-row',
  'scope'  => [ 'all' ],
  'title'  => __( 'Posts (Minimal)', 'cornerstone' ),
  'values' => [
    '_type'                       => 'layout-row',
    '_bp_base'                    => '4_4',
    '_label'                      => 'Posts',
    '_m'                          => [
      'e' => 2
    ],
    'layout_row_base_font_size'   => '1rem',
    'layout_row_flex_justify'     => 'center',
    'layout_row_gap_column'       => '1em',
    'layout_row_gap_row'          => '1em',
    'layout_row_layout'           => '22em',
    'layout_row_layout_lg'        => '22em',
    'layout_row_layout_md'        => '22em',
    'layout_row_layout_sm'        => '22em',
    'layout_row_layout_xl'        => '22em',
    'layout_row_layout_xs'        => '22em',
    'looper_provider'             => true,
    'looper_provider_query_count' => '6',
    '_modules'                    => [
      [
        '_type'                               => 'layout-column',
        '_bp_base'                            => '4_4',
        '_label'                              => 'Post',
        '_m'                                  => [
          'e' => 2
        ],
        'effects_alt'                         => true,
        'effects_duration'                    => '400ms',
        'effects_provider'                    => true,
        'effects_timing_function'             => 'cubic-bezier(0.680, -0.550, 0.265, 1.550)',
        'effects_transform_alt'               => 'translate(0em, -0.5em)',
        'layout_column_border_radius'         => '6px',
        'layout_column_box_shadow_color_alt'  => 'rgba(0, 0, 0, 0.16)',
        'layout_column_box_shadow_dimensions' => '0em 0.65em 1.35em 0em',
        'layout_column_flex_align'            => 'stretch',
        'layout_column_flexbox'               => true,
        'layout_column_href'                  => '{{dc:post:permalink}}',
        'layout_column_overflow'              => 'hidden',
        'layout_column_padding'               => '1em',
        'layout_column_tag'                   => 'a',
        'looper_consumer'                     => true,
        '_modules'                            => [
          [
            '_type'                    => 'layout-div',
            '_bp_base'                 => '4_4',
            '_label'                   => 'Figure',
            '_m'                       => [
              'e' => 1
            ],
            'layout_div_bg_color'      => '#d5d5d5',
            'layout_div_border_radius' => '3px',
            'layout_div_flex'          => '0 0 auto',
            'layout_div_height'        => '44vh',
            'layout_div_margin'        => '0em 0em 1em 0em',
            'layout_div_max_height'    => '240px',
            'layout_div_min_height'    => '210px',
            'layout_div_overflow_x'    => 'hidden',
            'layout_div_overflow_y'    => 'hidden',
            'layout_div_tag'           => 'figure',
            'show_condition'           => [
              [
                'group'     => true,
                'condition' => 'current-post:featured-image',
                'value'     => '',
                'toggle'    => true
              ]
            ],
            '_modules'                 => [
              [
                '_type'                     => 'image',
                '_bp_base'                  => '4_4',
                '_label'                    => 'Featured Image',
                'image_alt'                 => 'Featured image for “{{dc:post:title}}”',
                'image_display'             => 'block',
                'image_inner_border_radius' => '!0px',
                'image_margin'              => '!0em',
                'image_object_fit'          => 'cover',
                'image_outer_border_radius' => '!0px',
                'image_src'                 => '{{dc:post:featured_image_id}}',
                'image_styled_height'       => '100%',
                'image_styled_width'        => '100%'
              ]
            ]
          ],
          [
            '_type'              => 'layout-div',
            '_bp_base'           => '4_4',
            '_label'             => 'Article',
            '_m'                 => [
              'e' => 1
            ],
            'layout_div_flex'    => '1 1 auto',
            'layout_div_flexbox' => true,
            'layout_div_padding' => '0em',
            'layout_div_tag'     => 'article',
            '_modules'           => [
              [
                '_type'                   => 'headline',
                '_bp_base'                => '4_4',
                '_label'                  => 'The Title',
                'effects_duration'        => '400ms',
                'effects_timing_function' => 'cubic-bezier(0.770, 0.000, 0.175, 1.000)',
                'text_content'            => '{{dc:post:title}}',
                'text_font_weight'        => 'inherit:700',
                'text_line_height'        => '1.5',
                'text_margin'             => '0em 0em 0.512em 0em',
                'text_max_width'          => '21em',
                'text_tag'                => 'h2',
                'text_text_color_alt'     => '#f45c00'
              ],
              [
                '_type'            => 'text',
                '_bp_base'         => '4_4',
                '_label'           => 'The Excerpt',
                'text_content'     => '{{dc:post:excerpt length=\'20\' fallback=\'No excerpt\'}}&hellip;',
                'text_line_height' => '1.6',
                'text_margin'      => '0em 0em auto 0em',
                'text_text_color'  => 'rgba(0, 0, 0, 0.55)'
              ],
              [
                '_type'                        => 'headline',
                '_bp_base'                     => '4_4',
                '_label'                       => 'The Author',
                'effects_duration'             => '400ms',
                'effects_timing_function'      => 'cubic-bezier(0.770, 0.000, 0.175, 1.000)',
                'text_content'                 => '{{dc:author:display_name}}',
                'text_font_size'               => '0.64em',
                'text_font_weight'             => 'inherit:700',
                'text_graphic'                 => true,
                'text_graphic_icon'            => 'o-user-circle',
                'text_graphic_icon_alt'        => 'user-circle',
                'text_graphic_icon_alt_enable' => true,
                'text_graphic_icon_color'      => '#000000',
                'text_graphic_icon_font_size'  => '1em',
                'text_graphic_icon_height'     => '1em',
                'text_graphic_icon_width'      => '1em',
                'text_graphic_interaction'     => 'x-anchor-flip-y',
                'text_graphic_margin'          => '0em 0.409em 0em 0em',
                'text_letter_spacing'          => '0.065em',
                'text_line_height'             => '1',
                'text_margin'                  => '1.563em 0em 0em 0em',
                'text_overflow'                => true,
                'text_text_color'              => '#000000',
                'text_text_transform'          => 'uppercase'
              ]
            ]
          ]
        ]
      ]
    ]
  ]
]);


// List
// ----

cs_register_prefab_element( 'dynamic', 'posts-list', [
  'type'   => 'layout-row',
  'scope'  => [ 'all' ],
  'title'  => __( 'Posts (List)', 'cornerstone' ),
  'values' => [
    '_type'                       => 'layout-row',
    '_bp_base'                    => '4_4',
    '_label'                      => 'Posts',
    '_m'                          => [
      'e' => 2
    ],
    'layout_row_base_font_size'   => '1rem',
    'layout_row_gap_column'       => '1em',
    'layout_row_gap_row'          => '1em',
    'looper_provider'             => true,
    'looper_provider_query_count' => '5',
    '_modules'                    => [
      [
        '_type'                        => 'layout-column',
        '_bp_base'                     => '4_4',
        '_label'                       => 'Post',
        '_m'                           => [
          'e' => 2
        ],
        'effects_provider'             => true,
        'layout_column_flex_align'     => 'center',
        'layout_column_flex_direction' => 'row',
        'layout_column_flex_wrap'      => false,
        'layout_column_flexbox'        => true,
        'layout_column_href'           => '{{dc:post:permalink}}',
        'layout_column_tag'            => 'a',
        'looper_consumer'              => true,
        '_modules'                     => [
          [
            '_type'                            => 'layout-div',
            '_bp_base'                         => '4_4',
            '_label'                           => 'Figure',
            '_m'                               => [
              'e' => 1
            ],
            'layout_div_bg_color'              => '#4c3be9',
            'layout_div_border_radius'         => '4px',
            'layout_div_box_shadow_color'      => 'rgba(0, 0, 0, 0.11)',
            'layout_div_box_shadow_dimensions' => '0em 0.15em 0.65em 0em',
            'layout_div_flex'                  => '0 0 auto',
            'layout_div_flex_align'            => 'center',
            'layout_div_flex_justify'          => 'center',
            'layout_div_flexbox'               => true,
            'layout_div_height'                => '4em',
            'layout_div_margin'                => '0em 1em 0em 0em',
            'layout_div_overflow_x'            => 'hidden',
            'layout_div_overflow_y'            => 'hidden',
            'layout_div_tag'                   => 'figure',
            'layout_div_width'                 => '4em',
            '_modules'                         => [
              [
                '_type'               => 'image',
                '_bp_base'            => '4_4',
                '_label'              => 'Featured Image',
                'image_alt'           => 'Featured image for “{{dc:post:title}}”',
                'image_display'       => 'block',
                'image_object_fit'    => 'cover',
                'image_src'           => '{{dc:post:featured_image_id}}',
                'image_styled_height' => '100%',
                'image_styled_width'  => '100%',
                'show_condition'      => [
                  [
                    'group'     => true,
                    'condition' => 'current-post:featured-image',
                    'value'     => ''
                  ]
                ]
              ],
              [
                '_type'          => 'icon',
                '_bp_base'       => '4_4',
                'icon'           => 'o-arrow-right',
                'icon_color'     => '#ffffff',
                'icon_height'    => '1em',
                'icon_width'     => '1em',
                'show_condition' => [
                  [
                    'group'     => true,
                    'condition' => 'current-post:featured-image',
                    'value'     => '',
                    'toggle'    => false
                  ]
                ]
              ]
            ]
          ],
          [
            '_type'                => 'layout-div',
            '_bp_base'             => '4_4',
            '_label'               => 'Article',
            '_m'                   => [
              'e' => 1
            ],
            'layout_div_flex'      => '1 1 12em',
            'layout_div_min_width' => '1px',
            'layout_div_tag'       => 'article',
            '_modules'             => [
              [
                '_type'                           => 'headline',
                '_bp_base'                        => '4_4',
                '_label'                          => 'The Title',
                'effects_duration'                => '0ms',
                'text_content'                    => '{{dc:post:title}}',
                'text_font_weight'                => 'inherit:700',
                'text_subheadline'                => true,
                'text_subheadline_content'        => '{{dc:post:publish_date format=\'M. d, Y\'}}',
                'text_subheadline_font_size'      => '0.64em',
                'text_subheadline_font_weight'    => 'inherit:700',
                'text_subheadline_letter_spacing' => '0.125em',
                'text_subheadline_line_height'    => '1.6',
                'text_subheadline_reverse'        => true,
                'text_subheadline_spacing'        => '0.512em',
                'text_subheadline_text_color'     => 'rgba(0, 0, 0, 0.55)',
                'text_subheadline_text_transform' => 'uppercase',
                'text_tag'                        => 'h2',
                'text_text_color'                 => '#000000',
                'text_text_color_alt'             => '#4c3be9'
              ]
            ]
          ]
        ]
      ]
    ]
  ]
]);


// Magazine
// --------

cs_register_prefab_element( 'dynamic', 'posts-magazine', [
  'type'   => 'layout-row',
  'scope'  => [ 'all' ],
  'title'  => __( 'Posts (Magazine)', 'cornerstone' ),
  'values' => [
    '_type'                       => 'layout-row',
    '_bp_base'                    => '4_4',
    '_label'                      => 'Posts',
    '_m'                          => [
      'e' => 2
    ],
    'layout_row_base_font_size'   => '1rem',
    'layout_row_flex_justify'     => 'center',
    'layout_row_gap_column'       => '3em',
    'layout_row_gap_row'          => '3em',
    'layout_row_grow'             => true,
    'layout_row_layout'           => '38rem 20rem',
    'layout_row_layout_lg'        => '38rem 20rem',
    'layout_row_layout_md'        => '38rem 20rem',
    'layout_row_layout_sm'        => '38rem 20rem',
    'layout_row_layout_xl'        => '38rem 20rem',
    'layout_row_layout_xs'        => '38rem 20rem',
    'looper_provider'             => true,
    'looper_provider_query_count' => '5',
    '_modules'                    => [
      [
        '_type'                               => 'layout-column',
        '_bp_base'                            => '4_4',
        '_label'                              => 'Main Post',
        '_m'                                  => [
          'e' => 2
        ],
        'effects_alt'                         => true,
        'effects_duration'                    => '500ms',
        'effects_provider'                    => true,
        'effects_transform_alt'               => 'translate3d(0, -10px, 0)',
        'layout_column_border_color_alt'      => 'transparent',
        'layout_column_border_radius'         => '2px',
        'layout_column_box_shadow_color_alt'  => 'rgba(0, 0, 0, 0.16)',
        'layout_column_box_shadow_dimensions' => '10px 10px 0px 0px',
        'layout_column_href'                  => '{{dc:post:permalink}}',
        'layout_column_min_height'            => '58vmin',
        'layout_column_overflow'              => 'hidden',
        'layout_column_tag'                   => 'a',
        'looper_consumer'                     => true,
        'looper_consumer_repeat'              => '1',
        '_modules'                            => [
          [
            '_type'                       => 'layout-div',
            '_bp_base'                    => '4_4',
            '_label'                      => 'Article',
            '_m'                          => [
              'e' => 1
            ],
            'effects_duration'            => '500ms',
            'layout_div_bg_color'         => 'rgba(18, 18, 18, 0.77)',
            'layout_div_bg_color_alt'     => 'rgba(18, 18, 18, 0.55)',
            'layout_div_border_color_alt' => 'transparent',
            'layout_div_flexbox'          => true,
            'layout_div_height'           => '100%',
            'layout_div_padding'          => 'calc(1rem + 5%)',
            'layout_div_position'         => 'static',
            'layout_div_width'            => '100%',
            '_modules'                    => [
              [
                '_type'                     => 'layout-div',
                '_bp_base'                  => '4_4',
                '_label'                    => 'Meta',
                '_m'                        => [
                  'e' => 1
                ],
                'layout_div_flex_align'     => 'baseline',
                'layout_div_flex_direction' => 'row',
                'layout_div_flex_wrap'      => false,
                'layout_div_flexbox'        => true,
                'layout_div_margin'         => '0em 0em 1.563em 0em',
                '_modules'                  => [
                  [
                    '_type'               => 'text',
                    '_bp_base'            => '4_4',
                    '_label'              => 'Date',
                    'effects_duration'    => '500ms',
                    'text_content'        => '{{dc:post:publish_date}}',
                    'text_font_size'      => '0.64em',
                    'text_letter_spacing' => '0.125em',
                    'text_line_height'    => '1',
                    'text_text_color'     => 'rgba(255, 255, 255, 0.55)',
                    'text_text_color_alt' => '#ffffff',
                    'text_text_transform' => 'uppercase'
                  ]
                ]
              ],
              [
                '_type'               => 'headline',
                '_bp_base'            => '4_4',
                '_label'              => 'The Title',
                'text_base_font_size' => '1.563em',
                'text_content'        => '{{dc:post:title}}',
                'text_font_style'     => 'italic',
                'text_line_height'    => '1.35',
                'text_margin'         => 'auto 0em 0em 0em',
                'text_max_width'      => '18em',
                'text_tag'            => 'h2',
                'text_text_color'     => '#ffffff'
              ],
              [
                '_type'                 => 'layout-div',
                '_bp_base'              => '4_4',
                '_label'                => 'Figure',
                '_m'                    => [
                  'e' => 1
                ],
                'effects_alt'           => true,
                'effects_duration'      => '1000ms',
                'effects_transform_alt' => 'scale(1.05)',
                'layout_div_bottom'     => '0px',
                'layout_div_left'       => '0px',
                'layout_div_position'   => 'absolute',
                'layout_div_right'      => '0px',
                'layout_div_tag'        => 'figure',
                'layout_div_top'        => '0px',
                'layout_div_z_index'    => '-1',
                'show_condition'        => [
                  [
                    'group'     => true,
                    'condition' => 'current-post:featured-image',
                    'value'     => ''
                  ]
                ],
                '_modules'              => [
                  [
                    '_type'               => 'image',
                    '_bp_base'            => '4_4',
                    '_label'              => 'Featured Image',
                    'image_alt'           => 'Featured image for “{{dc:post:title}}”',
                    'image_display'       => 'block',
                    'image_object_fit'    => 'cover',
                    'image_src'           => '{{dc:post:featured_image_id}}',
                    'image_styled_height' => '100%',
                    'image_styled_width'  => '100%'
                  ]
                ]
              ]
            ]
          ]
        ]
      ],
      [
        '_type'                      => 'layout-column',
        '_bp_base'                   => '4_4',
        '_label'                     => 'More Posts',
        '_m'                         => [
          'e' => 2
        ],
        'layout_column_flex_align'   => 'stretch',
        'layout_column_flex_justify' => 'space-between',
        'layout_column_flex_wrap'    => false,
        'layout_column_flexbox'      => true,
        '_modules'                   => [
          [
            '_type'                     => 'layout-div',
            '_bp_base'                  => '4_4',
            '_label'                    => 'Intro',
            '_m'                        => [
              'e' => 1
            ],
            'layout_div_border_color'   => 'transparent transparent #dddddd transparent',
            'layout_div_border_style'   => 'solid solid dotted solid',
            'layout_div_border_width'   => '0px 0px 1px 0px',
            'layout_div_flex_align'     => 'baseline',
            'layout_div_flex_direction' => 'row',
            'layout_div_flex_justify'   => 'space-between',
            'layout_div_flex_wrap'      => false,
            'layout_div_flexbox'        => true,
            'layout_div_padding'        => '0em 0em 0.64em 0em',
            '_modules'                  => [
              [
                '_type'               => 'headline',
                '_bp_base'            => '4_4',
                'text_base_font_size' => '1.953em',
                'text_content'        => 'Latest',
                'text_font_weight'    => 'inherit:700',
                'text_line_height'    => '1',
                'text_tag'            => 'h2',
                'text_text_color'     => '#121212'
              ],
              [
                '_type'                         => 'button',
                '_bp_base'                      => '4_4',
                'anchor_base_font_size'         => '0.64em',
                'anchor_bg_color'               => 'transparent',
                'anchor_border_radius'          => '!0em',
                'anchor_box_shadow_color'       => 'transparent',
                'anchor_box_shadow_dimensions'  => '!0em 0em 0em 0em',
                'anchor_flex_direction'         => 'row-reverse',
                'anchor_graphic'                => true,
                'anchor_graphic_icon'           => 'o-arrow-right',
                'anchor_graphic_icon_color'     => 'rgba(18, 18, 18, 0.55)',
                'anchor_graphic_icon_color_alt' => '#121212',
                'anchor_graphic_icon_font_size' => '1em',
                'anchor_graphic_icon_height'    => '1em',
                'anchor_graphic_margin'         => '0em 0em 0em 0.512em',
                'anchor_href'                   => '{{dc:global:blog_url}}',
                'anchor_padding'                => '!0em',
                'anchor_primary_letter_spacing' => '0.125em',
                'anchor_primary_text_color'     => 'rgba(18, 18, 18, 0.55)',
                'anchor_primary_text_color_alt' => '#121212',
                'anchor_primary_text_transform' => 'uppercase',
                'anchor_text_margin'            => '!0px',
                'anchor_text_primary_content'   => 'See All',
                'effects_duration'              => '0ms'
              ]
            ]
          ],
          [
            '_type'                     => 'layout-div',
            '_bp_base'                  => '4_4',
            '_label'                    => 'Post',
            '_m'                        => [
              'e' => 1
            ],
            'effects_provider'          => true,
            'layout_div_flex_direction' => 'row',
            'layout_div_flex_justify'   => 'space-between',
            'layout_div_flex_wrap'      => false,
            'layout_div_flexbox'        => true,
            'layout_div_href'           => '{{dc:post:permalink}}',
            'layout_div_margin'         => '2.441em 0em 0em 0em',
            'layout_div_tag'            => 'a',
            'layout_div_width'          => '100%',
            'looper_consumer'           => true,
            '_modules'                  => [
              [
                '_type'                           => 'headline',
                '_bp_base'                        => '4_4',
                '_label'                          => 'The Title',
                'effects_duration'                => '0ms',
                'text_border_radius'              => '!2px',
                'text_content'                    => '{{dc:post:title}}',
                'text_font_size'                  => '1.25em',
                'text_font_style'                 => 'italic',
                'text_line_height'                => '1.35',
                'text_padding'                    => '!1em',
                'text_subheadline'                => true,
                'text_subheadline_content'        => '{{dc:post:publish_date}}',
                'text_subheadline_font_size'      => '0.64em',
                'text_subheadline_letter_spacing' => '0.125em',
                'text_subheadline_line_height'    => '1',
                'text_subheadline_reverse'        => true,
                'text_subheadline_spacing'        => '0.64em',
                'text_subheadline_text_color'     => 'rgba(18, 18, 18, 0.55)',
                'text_subheadline_text_transform' => 'uppercase',
                'text_tag'                        => 'h3',
                'text_text_color'                 => '#121212',
                'text_text_color_alt'             => '#4353ff'
              ],
              [
                '_type'                            => 'layout-div',
                '_bp_base'                         => '4_4',
                '_label'                           => 'Figure',
                '_m'                               => [
                  'e' => 1
                ],
                'layout_div_bg_color'              => '#000000',
                'layout_div_border_radius'         => '2px',
                'layout_div_box_shadow_color'      => 'rgba(18, 18, 18, 0.16)',
                'layout_div_box_shadow_dimensions' => '5px 5px 0px 0px',
                'layout_div_flex'                  => '0 0 auto',
                'layout_div_flex_align'            => 'center',
                'layout_div_flex_justify'          => 'center',
                'layout_div_flex_wrap'             => false,
                'layout_div_flexbox'               => true,
                'layout_div_height'                => '3.5em',
                'layout_div_margin'                => '0em 5px 5px 1.953em',
                'layout_div_overflow_x'            => 'hidden',
                'layout_div_overflow_y'            => 'hidden',
                'layout_div_tag'                   => 'figure',
                'layout_div_width'                 => '3.5em',
                '_modules'                         => [
                  [
                    '_type'               => 'image',
                    '_bp_base'            => '4_4',
                    'image_alt'           => 'Featured image for “{{dc:post:title}}”',
                    'image_display'       => 'block',
                    'image_object_fit'    => 'cover',
                    'image_src'           => '{{dc:post:featured_image_id}}',
                    'image_styled_height' => '100%',
                    'image_styled_width'  => '100%',
                    'show_condition'      => [
                      [
                        'group'     => true,
                        'condition' => 'current-post:featured-image',
                        'value'     => ''
                      ]
                    ]
                  ],
                  [
                    '_type'          => 'icon',
                    '_bp_base'       => '4_4',
                    'icon'           => 'o-arrow-right',
                    'icon_color'     => '#ffffff',
                    'icon_height'    => '1em',
                    'icon_width'     => '1em',
                    'show_condition' => [
                      [
                        'group'     => true,
                        'condition' => 'current-post:featured-image',
                        'value'     => '',
                        'toggle'    => false
                      ]
                    ]
                  ]
                ]
              ]
            ]
          ]
        ]
      ]
    ]
  ]
]);



// List Elements
// =============================================================================

$looper_list_json  = "[\n  {\n    \"text\" : \"This is an list, which is currently powered by a JSON Looper Provider.\"\n  },\n  {\n    \"text\" : \"To adjust its content, locate the &ldquo;List Item&rdquo; Element in the outline and go to its &ldquo;Customize&rdquo; controls.\"\n  },\n  {\n    \"text\" : \"Then, locate the &ldquo;Looper Provider&rdquo; control group and click on the &ldquo;Edit&rdquo; button for the &ldquo;Content&rdquo; control.\"\n  },\n  {\n    \"text\" : \"Inside the code editor, you can edit or add new items to the list as you need them.\"\n  },\n  {\n    \"text\" : \"The benefit of using a Looper Provider like this is the uniform styling that gets applied to all children.\"\n  },\n  {\n    \"text\" : \"If you'd prefer to go manual or style each item differently, simply turn off the Looper Provider / Consumer and go for it!\"\n  }\n]";


// Looper / Baseline
// -----------------

cs_register_prefab_element( 'dynamic', 'looper-list-baseline', [
  'type'   => 'layout-row',
  'scope'  => [ 'all' ],
  'title'  => __( 'Looper List (Baseline)', 'cornerstone' ),
  'values' => [
    '_type'                 => 'layout-row',
    '_bp_base'              => '4_4',
    '_label'                => 'List',
    '_m'                    => [
      'e' => 2
    ],
    'layout_row_gap_column' => '2.441em',
    'layout_row_gap_row'    => '0.8em',
    'layout_row_margin'     => '0px auto 0px auto',
    'layout_row_tag'        => 'ol',
    '_modules'              => [
      [
        '_type'                        => 'layout-column',
        '_bp_base'                     => '4_4',
        '_label'                       => 'List Item',
        '_m'                           => [
          'e' => 2
        ],
        'layout_column_flex_align'     => 'baseline',
        'layout_column_flex_direction' => 'row',
        'layout_column_flexbox'        => true,
        'layout_column_tag'            => 'li',
        'looper_consumer'              => true,
        'looper_provider'              => true,
        'looper_provider_json'         => $looper_list_json,
        'looper_provider_type'         => 'json',
        '_modules'                     => [
          [
            '_type'                     => 'layout-div',
            '_bp_base'                  => '4_4',
            '_label'                    => 'Figure',
            '_m'                        => [
              'e' => 1
            ],
            'layout_div_flex_align'     => 'baseline',
            'layout_div_flex_direction' => 'row',
            'layout_div_flex_justify'   => 'center',
            'layout_div_flexbox'        => true,
            'layout_div_margin'         => '0em 0.8em 0em 0em',
            'layout_div_tag'            => 'figure',
            'layout_div_width'          => '1em',
            '_modules'                  => [
              [
                '_type'            => 'text',
                '_bp_base'         => '4_4',
                'text_content'     => '{{dc:looper:index}}.',
                'text_font_weight' => 'inherit:700',
                'text_line_height' => '1.65',
                'text_text_align'  => 'center',
                'text_text_color'  => '#f40b7f'
              ]
            ]
          ],
          [
            '_type'                   => 'layout-div',
            '_bp_base'                => '4_4',
            '_label'                  => 'Content',
            '_m'                      => [
              'e' => 1
            ],
            'effects_duration_scroll' => '650ms',
            'effects_offset_bottom'   => '15%',
            'effects_scroll'          => true,
            'effects_transform_exit'  => 'translate(0px, 0.5em)',
            'layout_div_flex'         => '1 1 16em',
            '_modules'                => [
              [
                '_type'            => 'text',
                '_bp_base'         => '4_4',
                'text_content'     => '{{dc:looper:field key=\'text\'}}',
                'text_line_height' => '1.65',
                'text_text_color'  => '#000000'
              ]
            ]
          ]
        ]
      ]
    ]
  ]
]);


// Looper / Centered
// -----------------

cs_register_prefab_element( 'dynamic', 'looper-list-centered', [
  'type'   => 'layout-row',
  'scope'  => [ 'all' ],
  'title'  => __( 'Looper List (Centered)', 'cornerstone' ),
  'values' => [
    '_type'                 => 'layout-row',
    '_bp_base'              => '4_4',
    '_label'                => 'List',
    '_m'                    => [
      'e' => 2
    ],
    'layout_row_flex_align' => 'flex-start',
    'layout_row_gap_column' => '2.441em',
    'layout_row_gap_row'    => '1em',
    'layout_row_margin'     => '0px auto 0px auto',
    'layout_row_tag'        => 'ol',
    '_modules'              => [
      [
        '_type'                        => 'layout-column',
        '_bp_base'                     => '4_4',
        '_label'                       => 'List Item',
        '_m'                           => [
          'e' => 2
        ],
        'layout_column_flex_align'     => 'center',
        'layout_column_flex_direction' => 'row',
        'layout_column_flexbox'        => true,
        'layout_column_tag'            => 'li',
        'looper_consumer'              => true,
        'looper_provider'              => true,
        'looper_provider_json'         => $looper_list_json,
        'looper_provider_type'         => 'json',
        '_modules'                     => [
          [
            '_type'                            => 'layout-div',
            '_bp_base'                         => '4_4',
            '_label'                           => 'Figure',
            '_m'                               => [
              'e' => 1
            ],
            'layout_div_bg_color'              => '#f40b7f',
            'layout_div_border_radius'         => '0.64em',
            'layout_div_box_shadow_color'      => 'rgba(46, 17, 31, 0.11)',
            'layout_div_box_shadow_dimensions' => '0em 0.15em 0.35em 0em',
            'layout_div_flex_align'            => 'center',
            'layout_div_flex_direction'        => 'row',
            'layout_div_flex_justify'          => 'center',
            'layout_div_flexbox'               => true,
            'layout_div_height'                => '2em',
            'layout_div_margin'                => '0.409em 1em 0.409em 0em',
            'layout_div_tag'                   => 'figure',
            'layout_div_width'                 => '2em',
            '_modules'                         => [
              [
                '_type'                       => 'text',
                '_bp_base'                    => '4_4',
                'text_content'                => '{{dc:looper:index}}',
                'text_font_weight'            => 'inherit:700',
                'text_line_height'            => '1',
                'text_text_color'             => '#ffffff',
                'text_text_shadow_color'      => 'rgba(46, 17, 31, 0.22)',
                'text_text_shadow_dimensions' => '0px 1px 2px'
              ]
            ]
          ],
          [
            '_type'                   => 'layout-div',
            '_bp_base'                => '4_4',
            '_label'                  => 'Content',
            '_m'                      => [
              'e' => 1
            ],
            'effects_duration_scroll' => '650ms',
            'effects_offset_bottom'   => '15%',
            'effects_scroll'          => true,
            'effects_transform_exit'  => 'translate(0px, 0.5em)',
            'layout_div_flex'         => '1 1 15em',
            '_modules'                => [
              [
                '_type'            => 'text',
                '_bp_base'         => '4_4',
                'text_content'     => '{{dc:looper:field key=\'text\'}}',
                'text_line_height' => '1.65',
                'text_text_color'  => '#000000'
              ]
            ]
          ]
        ]
      ]
    ]
  ]
]);


// Static / Baseline
// -----------------


cs_register_prefab_element( 'dynamic', 'static-list-baseline', [
  'type'   => 'layout-row',
  'scope'  => [ 'all' ],
  'title'  => __( 'Static List (Baseline)', 'cornerstone' ),
  'values' => [
    '_type'                 => 'layout-row',
    '_bp_base'              => '4_4',
    '_label'                => 'List',
    '_m'                    => [
      'e' => 2
    ],
    'layout_row_gap_column' => '2.441em',
    'layout_row_gap_row'    => '0.8em',
    'layout_row_margin'     => '0px auto 0px auto',
    'layout_row_tag'        => 'ul',
    '_modules'              => [
      [
        '_type'                        => 'layout-column',
        '_bp_base'                     => '4_4',
        '_label'                       => 'List Item',
        '_m'                           => [
          'e' => 2
        ],
        'layout_column_flex_align'     => 'baseline',
        'layout_column_flex_direction' => 'row',
        'layout_column_flexbox'        => true,
        'layout_column_tag'            => 'li',
        'looper_provider_type'         => 'json',
        '_modules'                     => [
          [
            '_type'             => 'layout-div',
            '_bp_base'          => '4_4',
            '_label'            => 'Figure',
            '_m'                => [
              'e' => 1
            ],
            'layout_div_margin' => '0em 0.8em 0em 0em',
            'layout_div_tag'    => 'figure',
            '_modules'          => [
              [
                '_type'      => 'icon',
                '_bp_base'   => '4_4',
                'icon'       => 'o-check',
                'icon_color' => '#1b9d56',
                'icon_width' => '1em'
              ]
            ]
          ],
          [
            '_type'                   => 'layout-div',
            '_bp_base'                => '4_4',
            '_label'                  => 'Content',
            '_m'                      => [
              'e' => 1
            ],
            'effects_duration_scroll' => '650ms',
            'effects_offset_bottom'   => '15%',
            'effects_scroll'          => true,
            'effects_transform_exit'  => 'translate(0px, 0.5em)',
            'layout_div_flex'         => '1 1 16em',
            '_modules'                => [
              [
                '_type'            => 'text',
                '_bp_base'         => '4_4',
                'text_content'     => 'This is a list, which styles each &ldquo;List Item&rdquo; individually (unlike utilizing a Looper as with some of our other list Elements).',
                'text_line_height' => '1.65',
                'text_text_color'  => '#000000'
              ]
            ]
          ]
        ]
      ],
      [
        '_type'                        => 'layout-column',
        '_bp_base'                     => '4_4',
        '_label'                       => 'List Item',
        '_m'                           => [
          'e' => 2
        ],
        'layout_column_flex_align'     => 'baseline',
        'layout_column_flex_direction' => 'row',
        'layout_column_flexbox'        => true,
        'layout_column_tag'            => 'li',
        'looper_provider_type'         => 'json',
        '_modules'                     => [
          [
            '_type'             => 'layout-div',
            '_bp_base'          => '4_4',
            '_label'            => 'Figure',
            '_m'                => [
              'e' => 1
            ],
            'layout_div_margin' => '0em 0.8em 0em 0em',
            'layout_div_tag'    => 'figure',
            '_modules'          => [
              [
                '_type'      => 'icon',
                '_bp_base'   => '4_4',
                'icon'       => 'o-check',
                'icon_color' => '#1b9d56',
                'icon_width' => '1em'
              ]
            ]
          ],
          [
            '_type'                   => 'layout-div',
            '_bp_base'                => '4_4',
            '_label'                  => 'Content',
            '_m'                      => [
              'e' => 1
            ],
            'effects_duration_scroll' => '650ms',
            'effects_offset_bottom'   => '15%',
            'effects_scroll'          => true,
            'effects_transform_exit'  => 'translate(0px, 0.5em)',
            'layout_div_flex'         => '1 1 16em',
            '_modules'                => [
              [
                '_type'            => 'text',
                '_bp_base'         => '4_4',
                'text_content'     => 'While this approach is more straightforward than using a Looper, there is a little more work you\'ll need to do to keep things uniform between your &ldquo;List Items.&rdquo;',
                'text_line_height' => '1.65',
                'text_text_color'  => '#000000'
              ]
            ]
          ]
        ]
      ],
      [
        '_type'                        => 'layout-column',
        '_bp_base'                     => '4_4',
        '_label'                       => 'List Item',
        '_m'                           => [
          'e' => 2
        ],
        'layout_column_flex_align'     => 'baseline',
        'layout_column_flex_direction' => 'row',
        'layout_column_flexbox'        => true,
        'layout_column_tag'            => 'li',
        'looper_provider_type'         => 'json',
        '_modules'                     => [
          [
            '_type'             => 'layout-div',
            '_bp_base'          => '4_4',
            '_label'            => 'Figure',
            '_m'                => [
              'e' => 1
            ],
            'layout_div_margin' => '0em 0.8em 0em 0em',
            'layout_div_tag'    => 'figure',
            '_modules'          => [
              [
                '_type'      => 'icon',
                '_bp_base'   => '4_4',
                'icon'       => 'o-check',
                'icon_color' => '#1b9d56',
                'icon_width' => '1em'
              ]
            ]
          ],
          [
            '_type'                   => 'layout-div',
            '_bp_base'                => '4_4',
            '_label'                  => 'Content',
            '_m'                      => [
              'e' => 1
            ],
            'effects_duration_scroll' => '650ms',
            'effects_offset_bottom'   => '15%',
            'effects_scroll'          => true,
            'effects_transform_exit'  => 'translate(0px, 0.5em)',
            'layout_div_flex'         => '1 1 16em',
            '_modules'                => [
              [
                '_type'            => 'text',
                '_bp_base'         => '4_4',
                'text_content'     => 'For example, if you change the line height for the text in one &ldquo;List Item,&rdquo; you will want to make sure that you set the same line height for all other &ldquo;List Items&rdquo; so that they match.',
                'text_line_height' => '1.65',
                'text_text_color'  => '#000000'
              ]
            ]
          ]
        ]
      ],
      [
        '_type'                        => 'layout-column',
        '_bp_base'                     => '4_4',
        '_label'                       => 'List Item',
        '_m'                           => [
          'e' => 2
        ],
        'layout_column_flex_align'     => 'baseline',
        'layout_column_flex_direction' => 'row',
        'layout_column_flexbox'        => true,
        'layout_column_tag'            => 'li',
        'looper_provider_type'         => 'json',
        '_modules'                     => [
          [
            '_type'             => 'layout-div',
            '_bp_base'          => '4_4',
            '_label'            => 'Figure',
            '_m'                => [
              'e' => 1
            ],
            'layout_div_margin' => '0em 0.8em 0em 0em',
            'layout_div_tag'    => 'figure',
            '_modules'          => [
              [
                '_type'      => 'icon',
                '_bp_base'   => '4_4',
                'icon'       => 'o-check',
                'icon_color' => '#1b9d56',
                'icon_width' => '1em'
              ]
            ]
          ],
          [
            '_type'                   => 'layout-div',
            '_bp_base'                => '4_4',
            '_label'                  => 'Content',
            '_m'                      => [
              'e' => 1
            ],
            'effects_duration_scroll' => '650ms',
            'effects_offset_bottom'   => '15%',
            'effects_scroll'          => true,
            'effects_transform_exit'  => 'translate(0px, 0.5em)',
            'layout_div_flex'         => '1 1 16em',
            '_modules'                => [
              [
                '_type'            => 'text',
                '_bp_base'         => '4_4',
                'text_content'     => 'However, you can also use this to your advantage to change individual &ldquo;List Items&rdquo; more easily if you want to.',
                'text_line_height' => '1.65',
                'text_text_color'  => '#000000'
              ]
            ]
          ]
        ]
      ]
    ]
  ]
]);


// Static / Centered
// -----------------


cs_register_prefab_element( 'dynamic', 'static-list-centered', [
  'type'   => 'layout-row',
  'scope'  => [ 'all' ],
  'title'  => __( 'Static List (Centered)', 'cornerstone' ),
  'values' => [
    '_type'                 => 'layout-row',
    '_bp_base'              => '4_4',
    '_label'                => 'List',
    '_m'                    => [
      'e' => 2
    ],
    'layout_row_flex_align' => 'flex-start',
    'layout_row_gap_column' => '2.441em',
    'layout_row_gap_row'    => '1em',
    'layout_row_margin'     => '0px auto 0px auto',
    'layout_row_tag'        => 'ul',
    '_modules'              => [
      [
        '_type'                        => 'layout-column',
        '_bp_base'                     => '4_4',
        '_label'                       => 'List Item',
        '_m'                           => [
          'e' => 2
        ],
        'layout_column_flex_align'     => 'center',
        'layout_column_flex_direction' => 'row',
        'layout_column_flexbox'        => true,
        'layout_column_tag'            => 'li',
        'looper_provider_type'         => 'json',
        '_modules'                     => [
          [
            '_type'                            => 'layout-div',
            '_bp_base'                         => '4_4',
            '_label'                           => 'Figure',
            '_m'                               => [
              'e' => 1
            ],
            'layout_div_bg_color'              => '#1b9d56',
            'layout_div_border_radius'         => '0.64em',
            'layout_div_box_shadow_color'      => 'rgba(23, 44, 33, 0.11)',
            'layout_div_box_shadow_dimensions' => '0em 0.15em 0.35em 0em',
            'layout_div_flex_align'            => 'center',
            'layout_div_flex_justify'          => 'center',
            'layout_div_flexbox'               => true,
            'layout_div_height'                => '2em',
            'layout_div_margin'                => '0.409em 1em 0.409em 0em',
            'layout_div_tag'                   => 'figure',
            'layout_div_width'                 => '2em',
            '_modules'                         => [
              [
                '_type'                       => 'icon',
                '_bp_base'                    => '4_4',
                'icon'                        => 'o-check',
                'icon_color'                  => '#ffffff',
                'icon_height'                 => '1em',
                'icon_text_shadow_color'      => 'rgba(23, 44, 33, 0.22)',
                'icon_text_shadow_dimensions' => '0px 1px 2px'
              ]
            ]
          ],
          [
            '_type'                   => 'layout-div',
            '_bp_base'                => '4_4',
            '_label'                  => 'Content',
            '_m'                      => [
              'e' => 1
            ],
            'effects_duration_scroll' => '650ms',
            'effects_offset_bottom'   => '15%',
            'effects_scroll'          => true,
            'effects_transform_exit'  => 'translate(0px, 0.5em)',
            'layout_div_flex'         => '1 1 15em',
            '_modules'                => [
              [
                '_type'            => 'text',
                '_bp_base'         => '4_4',
                'text_content'     => 'This is a list, which styles each &ldquo;List Item&rdquo; individually (unlike utilizing a Looper as with some of our other list Elements).',
                'text_line_height' => '1.65',
                'text_text_color'  => '#000000'
              ]
            ]
          ]
        ]
      ],
      [
        '_type'                        => 'layout-column',
        '_bp_base'                     => '4_4',
        '_label'                       => 'List Item',
        '_m'                           => [
          'e' => 2
        ],
        'layout_column_flex_align'     => 'center',
        'layout_column_flex_direction' => 'row',
        'layout_column_flexbox'        => true,
        'layout_column_tag'            => 'li',
        'looper_provider_type'         => 'json',
        '_modules'                     => [
          [
            '_type'                            => 'layout-div',
            '_bp_base'                         => '4_4',
            '_label'                           => 'Figure',
            '_m'                               => [
              'e' => 1
            ],
            'layout_div_bg_color'              => '#1b9d56',
            'layout_div_border_radius'         => '0.64em',
            'layout_div_box_shadow_color'      => 'rgba(23, 44, 33, 0.11)',
            'layout_div_box_shadow_dimensions' => '0em 0.15em 0.35em 0em',
            'layout_div_flex_align'            => 'center',
            'layout_div_flex_justify'          => 'center',
            'layout_div_flexbox'               => true,
            'layout_div_height'                => '2em',
            'layout_div_margin'                => '0.409em 1em 0.409em 0em',
            'layout_div_tag'                   => 'figure',
            'layout_div_width'                 => '2em',
            '_modules'                         => [
              [
                '_type'                       => 'icon',
                '_bp_base'                    => '4_4',
                'icon'                        => 'o-check',
                'icon_color'                  => '#ffffff',
                'icon_height'                 => '1em',
                'icon_text_shadow_color'      => 'rgba(23, 44, 33, 0.22)',
                'icon_text_shadow_dimensions' => '0px 1px 2px'
              ]
            ]
          ],
          [
            '_type'                   => 'layout-div',
            '_bp_base'                => '4_4',
            '_label'                  => 'Content',
            '_m'                      => [
              'e' => 1
            ],
            'effects_duration_scroll' => '650ms',
            'effects_offset_bottom'   => '15%',
            'effects_scroll'          => true,
            'effects_transform_exit'  => 'translate(0px, 0.5em)',
            'layout_div_flex'         => '1 1 15em',
            '_modules'                => [
              [
                '_type'            => 'text',
                '_bp_base'         => '4_4',
                'text_content'     => 'While this approach is more straightforward than using a Looper, there is a little more work you\'ll need to do to keep things uniform between your &ldquo;List Items.&rdquo;',
                'text_line_height' => '1.65',
                'text_text_color'  => '#000000'
              ]
            ]
          ]
        ]
      ],
      [
        '_type'                        => 'layout-column',
        '_bp_base'                     => '4_4',
        '_label'                       => 'List Item',
        '_m'                           => [
          'e' => 2
        ],
        'layout_column_flex_align'     => 'center',
        'layout_column_flex_direction' => 'row',
        'layout_column_flexbox'        => true,
        'layout_column_tag'            => 'li',
        'looper_provider_type'         => 'json',
        '_modules'                     => [
          [
            '_type'                            => 'layout-div',
            '_bp_base'                         => '4_4',
            '_label'                           => 'Figure',
            '_m'                               => [
              'e' => 1
            ],
            'layout_div_bg_color'              => '#1b9d56',
            'layout_div_border_radius'         => '0.64em',
            'layout_div_box_shadow_color'      => 'rgba(23, 44, 33, 0.11)',
            'layout_div_box_shadow_dimensions' => '0em 0.15em 0.35em 0em',
            'layout_div_flex_align'            => 'center',
            'layout_div_flex_justify'          => 'center',
            'layout_div_flexbox'               => true,
            'layout_div_height'                => '2em',
            'layout_div_margin'                => '0.409em 1em 0.409em 0em',
            'layout_div_tag'                   => 'figure',
            'layout_div_width'                 => '2em',
            '_modules'                         => [
              [
                '_type'                       => 'icon',
                '_bp_base'                    => '4_4',
                'icon'                        => 'o-check',
                'icon_color'                  => '#ffffff',
                'icon_height'                 => '1em',
                'icon_text_shadow_color'      => 'rgba(23, 44, 33, 0.22)',
                'icon_text_shadow_dimensions' => '0px 1px 2px'
              ]
            ]
          ],
          [
            '_type'                   => 'layout-div',
            '_bp_base'                => '4_4',
            '_label'                  => 'Content',
            '_m'                      => [
              'e' => 1
            ],
            'effects_duration_scroll' => '650ms',
            'effects_offset_bottom'   => '15%',
            'effects_scroll'          => true,
            'effects_transform_exit'  => 'translate(0px, 0.5em)',
            'layout_div_flex'         => '1 1 15em',
            '_modules'                => [
              [
                '_type'            => 'text',
                '_bp_base'         => '4_4',
                'text_content'     => 'For example, if you change the line height for the text in one &ldquo;List Item,&rdquo; you will want to make sure that you set the same line height for all other &ldquo;List Items&rdquo; so that they match.',
                'text_line_height' => '1.65',
                'text_text_color'  => '#000000'
              ]
            ]
          ]
        ]
      ],
      [
        '_type'                        => 'layout-column',
        '_bp_base'                     => '4_4',
        '_label'                       => 'List Item',
        '_m'                           => [
          'e' => 2
        ],
        'layout_column_flex_align'     => 'center',
        'layout_column_flex_direction' => 'row',
        'layout_column_flexbox'        => true,
        'layout_column_tag'            => 'li',
        'looper_provider_type'         => 'json',
        '_modules'                     => [
          [
            '_type'                            => 'layout-div',
            '_bp_base'                         => '4_4',
            '_label'                           => 'Figure',
            '_m'                               => [
              'e' => 1
            ],
            'layout_div_bg_color'              => '#1b9d56',
            'layout_div_border_radius'         => '0.64em',
            'layout_div_box_shadow_color'      => 'rgba(23, 44, 33, 0.11)',
            'layout_div_box_shadow_dimensions' => '0em 0.15em 0.35em 0em',
            'layout_div_flex_align'            => 'center',
            'layout_div_flex_justify'          => 'center',
            'layout_div_flexbox'               => true,
            'layout_div_height'                => '2em',
            'layout_div_margin'                => '0.409em 1em 0.409em 0em',
            'layout_div_tag'                   => 'figure',
            'layout_div_width'                 => '2em',
            '_modules'                         => [
              [
                '_type'                       => 'icon',
                '_bp_base'                    => '4_4',
                'icon'                        => 'o-check',
                'icon_color'                  => '#ffffff',
                'icon_height'                 => '1em',
                'icon_text_shadow_color'      => 'rgba(23, 44, 33, 0.22)',
                'icon_text_shadow_dimensions' => '0px 1px 2px'
              ]
            ]
          ],
          [
            '_type'                   => 'layout-div',
            '_bp_base'                => '4_4',
            '_label'                  => 'Content',
            '_m'                      => [
              'e' => 1
            ],
            'effects_duration_scroll' => '650ms',
            'effects_offset_bottom'   => '15%',
            'effects_scroll'          => true,
            'effects_transform_exit'  => 'translate(0px, 0.5em)',
            'layout_div_flex'         => '1 1 15em',
            '_modules'                => [
              [
                '_type'            => 'text',
                '_bp_base'         => '4_4',
                'text_content'     => 'However, you can also use this to your advantage to change individual &ldquo;List Items&rdquo; more easily if you want to.',
                'text_line_height' => '1.65',
                'text_text_color'  => '#000000'
              ]
            ]
          ]
        ]
      ]
    ]
  ]
]);



// Navigation Elements
// =============================================================================

// Modal
// -----

cs_register_prefab_element( 'standard', 'nav-modal-prefab', [
  'type'   => 'layout-modal',
  'icon'   => 'nav-modal',
  'scope'  => [ 'all' ],
  'title'  => __( 'Navigation Modal', 'cornerstone' ),
  'values' => [
    '_type'                               => 'layout-modal',
    'modal_bg_color'                      => 'rgba(0, 0, 0, 0.88)',
    'modal_body_scroll'                   => 'disable',
    'modal_content_bg_color'              => 'transparent',
    'modal_content_box_shadow_color'      => 'transparent',
    'modal_content_box_shadow_dimensions' => '!0em 0em 0em 0em',
    'modal_content_max_width'             => 'none',
    'modal_content_padding'               => '!0em',
    '_modules'                            => [
      [
        '_type'                          => 'nav-layered',
        '_m'                             => [ 'e' => 1 ],
        'anchor_base_font_size'          => 'calc(16px + 3vmin)',
        'anchor_duration'                => '222ms',
        'anchor_flex_align'              => 'baseline',
        'anchor_margin'                  => '0em auto 0em auto',
        'anchor_max_width'               => '18em',
        'anchor_padding'                 => '0.8em 1em 0.8em 1em',
        'anchor_primary_text_color'      => 'rgba(255, 255, 255, 0.66)',
        'anchor_primary_text_color_alt'  => 'rgb(255, 255, 255)',
        'anchor_sub_indicator_color'     => 'rgba(255, 255, 255, 0.66)',
        'anchor_sub_indicator_color_alt' => 'rgb(255, 255, 255)',
        'anchor_sub_indicator_icon'      => 'caret-right',
        'anchor_sub_indicator_margin'    => '0em -1.409em 0em 0.409em',
        'anchor_sub_indicator_width'     => '1em',
        'anchor_text_margin'             => '!0em',
        'menu_layered_back_label'        => 'Back'
      ]
    ]
  ]
]);


// Off Canvas
// ----------

cs_register_prefab_element( 'standard', 'nav-off-canvas-prefab', [
  'type'   => 'layout-off-canvas',
  'icon'   => 'nav-modal',
  'scope'  => [ 'all' ],
  'title'  => __( 'Navigation Off Canvas', 'cornerstone' ),
  'values' => [
    '_type'                  => 'layout-off-canvas',
    'off_canvas_body_scroll' => 'disable',
    '_modules'               => [
      [
        '_type'                              => 'nav-collapsed',
        '_m'                                 => [ 'e' => 1 ],
        'anchor_bg_color'                    => 'rgba(0, 0, 0, 0.07)',
        'anchor_bg_color_alt'                => 'rgba(0, 0, 0, 0.16)',
        'anchor_border_radius'               => '4px',
        'anchor_margin'                      => '2px 0px 2px 0px',
        'anchor_padding'                     => '1em 1.25em 1em 1.25em',
        'anchor_primary_text_color_alt'      => '',
        'anchor_sub_indicator_color'         => 'rgba(0, 0, 0, 0.5)',
        'anchor_sub_indicator_color_alt'     => 'rgb(0, 0, 0)',
        'anchor_sub_indicator_icon'          => 'o-angle-down',
        'sub_anchor_padding'                 => '0.75em 1.25em 0.75em 1.25em',
        'sub_anchor_primary_text_color'      => 'rgba(0, 0, 0, 0.5)',
        'sub_anchor_primary_text_color_alt'  => 'rgb(0, 0, 0)',
        'sub_anchor_sub_indicator_color'     => 'rgba(0, 0, 0, 0.5)',
        'sub_anchor_sub_indicator_color_alt' => 'rgb(0, 0, 0)',
        'sub_anchor_sub_indicator_icon'      => 'o-angle-down',
      ],
    ],
  ]
]);



// Search Elements
// =============================================================================

// Dropdown
// --------

cs_register_prefab_element( 'standard', 'search-dropdown-prefab', [
  'type'   => 'layout-dropdown',
  'icon'   => 'shared-search',
  'scope'  => [ 'all' ],
  'title'  => __( 'Search Dropdown', 'cornerstone' ),
  'values' => [
    '_type'                                 => 'layout-dropdown',
    'dropdown_base_font_size'               => '20px',
    'dropdown_border_radius'                => '4px',
    'toggle_anchor_graphic_icon'            => 'o-search',
    'toggle_anchor_graphic_icon_alt'        => 'o-ellipsis-h',
    'toggle_anchor_graphic_icon_alt_enable' => true,
    'toggle_anchor_graphic_icon_font_size'  => '1em',
    'toggle_anchor_graphic_icon_width'      => '1em',
    'toggle_anchor_graphic_interaction'     => 'x-anchor-flip-x',
    'toggle_anchor_graphic_type'            => 'icon',
    '_modules'                              => [
      [
        '_type'                        => 'search-inline',
        'search_bg_color'              => 'transparent',
        'search_border_radius'         => '!0em',
        'search_box_shadow_color'      => 'transparent',
        'search_box_shadow_dimensions' => '!0em 0em 0em 0em',
        'search_clear_bg_color'        => 'transparent',
        'search_clear_bg_color_alt'    => '',
        'search_clear_border_radius'   => '!0px',
        'search_clear_color'           => 'rgba(0, 0, 0, 0.5)',
        'search_clear_color_alt'       => 'rgb(0, 0, 0)',
        'search_clear_font_size'       => '1em',
        'search_clear_height'          => '1em',
        'search_clear_margin'          => '1em 1em 1em 0.64em',
        'search_clear_stroke_width'    => 2,
        'search_clear_width'           => '1em',
        'search_submit_margin'         => '1em 0.64em 1em 1em'
      ]
    ]
  ]
]);


// Modal
// -----

cs_register_prefab_element( 'standard', 'search-modal-prefab', [
  'type'   => 'layout-modal',
  'icon'   => 'search-modal',
  'scope'  => [ 'all' ],
  'title'  => __( 'Search Modal', 'cornerstone' ),
  'values' => [
    '_type'                                => 'layout-modal',
    'modal_bg_color'                       => 'rgba(0, 0, 0, 0.88)',
    'modal_body_scroll'                    => 'disable',
    'modal_content_bg_color'               => 'transparent',
    'modal_content_box_shadow_color'       => 'transparent',
    'modal_content_box_shadow_dimensions'  => '!0em 0em 0em 0em',
    'modal_content_max_width'              => 'none',
    'modal_content_padding'                => '!0em',
    'toggle_anchor_graphic_icon'           => 'o-search',
    'toggle_anchor_graphic_icon_font_size' => '1em',
    'toggle_anchor_graphic_type'           => 'icon',
    '_modules'                             => [
      [
        '_type'                      => 'search-inline',
        'search_base_font_size'      => 'calc(10px + 4vmin)',
        'search_bg_color'            => 'rgb(255, 255, 255)',
        'search_clear_bg_color'      => 'transparent',
        'search_clear_bg_color_alt'  => '',
        'search_clear_border_radius' => '!0px',
        'search_clear_color'         => 'rgba(0, 0, 0, 0.5)',
        'search_clear_color_alt'     => 'rgb(0, 0, 0)',
        'search_clear_font_size'     => '1em',
        'search_clear_height'        => '1em',
        'search_clear_margin'        => '1em 1em 1em 0.64em',
        'search_clear_stroke_width'  => 2,
        'search_clear_width'         => '1em',
        'search_margin'              => '0em auto 0em auto',
        'search_max_width'           => '21em',
        'search_submit_margin'       => '1em 0.64em 1em 1em'
      ]
    ]
  ]
]);



// Cart Elements
// =============================================================================

$cart_toggle_graphic_key       = 'o-shopping-basket';
$cart_toggle_graphic_font_size = '1em';
$cart_toggle_graphic_type      = 'icon';
$cart_contents                 = [
  [
    '_type'               => 'headline',
    'text_base_font_size' => '1.563em',
    'text_content'        => __( 'Your Items', 'cornerstone' ),
    'text_line_height'    => '1',
    'text_margin'         => '0em 0em 0.512em 0em',
    'text_tag'            => 'h2'
  ],
  [
    '_type' => 'tp-wc-cart'
  ]
];


// Dropdown
// --------

cs_register_prefab_element( 'woocommerce', 'cart-dropdown-prefab', [
  'type'   => 'layout-dropdown',
  'scope'  => [ 'all' ],
  'title'  => __( 'Cart Dropdown', 'cornerstone' ),
  'values' => [
    '_type'                                => 'layout-dropdown',
    'dropdown_border_radius'               => '2px',
    'dropdown_padding'                     => '1.563em',
    'dropdown_width'                       => '320px',
    'toggle_anchor_graphic_icon'           => $cart_toggle_graphic_key,
    'toggle_anchor_graphic_icon_alt'       => $cart_toggle_graphic_key,
    'toggle_anchor_graphic_icon_font_size' => $cart_toggle_graphic_font_size,
    'toggle_anchor_graphic_type'           => $cart_toggle_graphic_type,
    '_modules'                             => $cart_contents
  ]
]);


// Modal
// -----

cs_register_prefab_element( 'woocommerce', 'cart-modal-prefab', [
  'type'   => 'layout-modal',
  'scope'  => [ 'all' ],
  'title'  => __( 'Cart Modal', 'cornerstone' ),
  'values' => [
    '_type'                                => 'layout-modal',
    'modal_content_border_radius'          => '2px',
    'toggle_anchor_graphic_icon'           => $cart_toggle_graphic_key,
    'toggle_anchor_graphic_icon_alt'       => $cart_toggle_graphic_key,
    'toggle_anchor_graphic_icon_font_size' => $cart_toggle_graphic_font_size,
    'toggle_anchor_graphic_type'           => $cart_toggle_graphic_type,
    '_modules'                             => $cart_contents
  ]
]);


// Off Canvas
// ----------

cs_register_prefab_element( 'woocommerce', 'cart-off-canvas-prefab', [
  'type'   => 'layout-off-canvas',
  'scope'  => [ 'all' ],
  'title'  => __( 'Cart Off Canvas', 'cornerstone' ),
  'values' => [
    '_type'                                => 'layout-off-canvas',
    'toggle_anchor_graphic_icon'           => $cart_toggle_graphic_key,
    'toggle_anchor_graphic_icon_alt'       => $cart_toggle_graphic_key,
    'toggle_anchor_graphic_icon_font_size' => $cart_toggle_graphic_font_size,
    'toggle_anchor_graphic_type'           => $cart_toggle_graphic_type,
    '_modules'                             => $cart_contents
  ]
]);



// Mega Menus
// =============================================================================

function x_mega_menu_headline( $text ) {
  return [
    '_type'               => 'headline',
    'text_content'        => $text,
    'text_font_size'      => '0.8em',
    'text_letter_spacing' => '0.185em',
    'text_line_height'    => '1',
    'text_margin'         => '0em 0em 0.8em 0em',
    'text_tag'            => 'h6',
    'text_text_color'     => 'rgba(0, 0, 0, 0.33)',
    'text_text_transform' => 'uppercase'
  ];
}

function x_mega_menu_button( $primary_text, $secondary_text, $graphic_icon, $graphic_bg_color ) {
  return [
    '_type'                                      => 'button',
    'anchor_bg_color'                            => 'transparent',
    'anchor_bg_color_alt'                        => 'rgba(0, 0, 0, 0.09)',
    'anchor_border_radius'                       => '1.563em',
    'anchor_box_shadow_color'                    => 'transparent',
    'anchor_box_shadow_dimensions'               => '!0em 0em 0em 0em',
    'anchor_flex_justify'                        => 'flex-start',
    'anchor_graphic'                             => true,
    'anchor_graphic_icon'                        => $graphic_icon,
    'anchor_graphic_icon_alt'                    => $graphic_icon,
    'anchor_graphic_icon_bg_color'               => $graphic_bg_color,
    'anchor_graphic_icon_border_radius'          => '0.64em',
    'anchor_graphic_icon_color'                  => 'rgb(255, 255, 255)',
    'anchor_graphic_icon_color_alt'              => '',
    'anchor_graphic_icon_font_size'              => '2em',
    'anchor_graphic_icon_height'                 => '2em',
    'anchor_graphic_icon_text_shadow_color'      => 'rgba(0, 0, 0, 0.27)',
    'anchor_graphic_icon_text_shadow_dimensions' => '0em 0.15em 0.35em',
    'anchor_graphic_icon_width'                  => '2em',
    'anchor_graphic_margin'                      => '0em 0.8em 0em 0em',
    'anchor_padding'                             => '0.5em 1.25em 0.5em 0.5em',
    'anchor_primary_font_size'                   => '1.563em',
    'anchor_primary_font_weight'                 => 'inherit:700',
    'anchor_primary_line_height'                 => '1.1',
    'anchor_primary_text_color'                  => 'rgb(0, 0, 0)',
    'anchor_primary_text_color_alt'              => '',
    'anchor_secondary_font_size'                 => '0.8em',
    'anchor_secondary_line_height'               => '1.3',
    'anchor_secondary_text_color'                => 'rgba(0, 0, 0, 0.66)',
    'anchor_secondary_text_color_alt'            => '',
    'anchor_text_margin'                         => '!0px',
    'anchor_text_overflow'                       => true,
    'anchor_text_primary_content'                => $primary_text,
    'anchor_text_secondary_content'              => $secondary_text,
    'anchor_text_spacing'                        => '0.409em',
    'anchor_width'                               => '100%',
    'effects_duration'                           => '0ms'
  ];
}

function x_mega_menu_navigation_inline() {
  return [
    '_type'                         => 'nav-inline',
    'anchor_bg_color_alt'           => 'rgb(255, 255, 255)',
    'anchor_border_radius'          => '0.409em',
    'anchor_duration'               => '0ms',
    'anchor_flex_justify'           => 'flex-start',
    'anchor_padding'                => '0.5em 0.64em 0.5em 0.64em',
    'anchor_primary_line_height'    => '1.2',
    'anchor_primary_text_color'     => 'rgb(0, 0, 0)',
    'anchor_primary_text_color_alt' => '',
    'anchor_sub_indicator'          => false,
    'anchor_sub_indicator_margin'   => '0px',
    'anchor_text_margin'            => '!0px auto 0px 0px',
    'anchor_text_overflow'          => true,
    'menu'                          => "[\n  {\n    \"title\" : \"Alekhine\"\n  },\n  {\n    \"title\" : \"Caro-Kann\"\n  },\n  {\n    \"title\" : \"French\"\n  },\n  {\n    \"title\" : \"Nimzowitsch\"\n  },\n  {\n    \"title\" : \"Scandinavian\"\n  },\n  {\n    \"title\" : \"Petrov\"\n  },\n  {\n    \"title\" : \"Tarrasch\"\n  },\n  {\n    \"title\" : \"Two Knights\"\n  }\n]",
    'menu_row_flex_direction'       => 'row',
    'menu_row_flex_wrap'            => true,
    'menu_row_flex_justify'         => 'flex-start',
    'menu_row_flex_align'           => 'stretch',
    'menu_col_flex_direction'       => 'row',
    'menu_col_flex_wrap'            => true,
    'menu_col_flex_justify'         => 'flex-start',
    'menu_col_flex_align'           => 'stretch',
    'menu_items_flex'               => '1 1 8em',
    'menu_margin'                   => '0em -0.64em 0em -0.64em',
    'menu_row_flex_justify'         => 'flex-start',
    'menu_row_flex_wrap'            => true
  ];
}


// Shared Content
// --------------

$mega_menu_featured_div = [
  '_type'                 => 'layout-div',
  'layout_div_flex'       => '0 0 auto',
  'layout_div_flex_align' => 'stretch',
  'layout_div_flex_wrap'  => false,
  'layout_div_flexbox'    => true,
  'layout_div_padding'    => '2.25em 2.25em 1.75em 2.25em',
  '_modules'              => [
    x_mega_menu_headline( $label_featured_headline ),
    [
      '_type'             => 'layout-div',
      '_label'            => $label_negative_offset,
      'layout_div_margin' => '0em -0.5em 0em -0.5em',
      '_modules'          => [
        x_mega_menu_button( __( 'Rooks', 'cornerstone' ), __( 'Unsung heroes of the game', 'cornerstone' ), 'chess-rook', 'rgb(255, 76, 89)' ), // #ff4c59
        x_mega_menu_button( __( 'Bishops', 'cornerstone' ), __( 'Simply cannot walk straight', 'cornerstone' ), 'chess-bishop', 'rgb(56, 98, 234)' ), // #3862ea
      ]
    ]
  ]
];

$mega_menu_technique_div = [
  '_type'                 => 'layout-div',
  'layout_div_bg_color'   => 'rgba(0, 0, 0, 0.09)',
  'layout_div_flex'       => '1 0 auto',
  'layout_div_flex_align' => 'stretch',
  'layout_div_flex_wrap'  => false,
  'layout_div_flexbox'    => true,
  'layout_div_padding'    => '2.25em 2.25em 1.75em 2.25em',
  '_modules'              => [
    x_mega_menu_headline( $label_technique_headline ),
    x_mega_menu_navigation_inline()
  ]
];


// Dropdown
// --------

cs_register_prefab_element( 'standard', 'mega-menu-dropdown-prefab', [
  'type'   => 'layout-dropdown',
  'scope'  => [ 'all' ],
  'title'  => __( 'Mega Menu Dropdown', 'cornerstone' ),
  'values' => [
    '_type'                          => 'layout-dropdown',
    'dropdown_border_radius'         => '0.5em',
    'dropdown_box_shadow_dimensions' => '0em 1.25em 2em 0em',
    'dropdown_flex_align'            => 'stretch',
    'dropdown_flexbox'               => true,
    'dropdown_max_width'             => '24em',
    'dropdown_min_width'             => '18em',
    'dropdown_overflow'              => 'hidden',
    'dropdown_width'                 => '66vw',
    '_label'                         => $label_mega_menu,
    '_modules'                       => [ $mega_menu_featured_div, $mega_menu_technique_div ]
  ]
]);


// Modal
// -----

cs_register_prefab_element( 'standard', 'mega-menu-modal-prefab', [
  'type'   => 'layout-modal',
  'scope'  => [ 'all' ],
  'title'  => __( 'Mega Menu Modal', 'cornerstone' ),
  'values' => [
    '_type'                               => 'layout-modal',
    'modal_body_scroll'                   => 'disable',
    'modal_close_dimensions'              => '1.5',
    'modal_content_border_radius'         => '0.5em',
    'modal_content_box_shadow_dimensions' => '0em 1.25em 2em 0em',
    'modal_content_flex_align'            => 'stretch',
    'modal_content_flexbox'               => true,
    'modal_content_max_width'             => '26em',
    'modal_content_overflow'              => 'hidden',
    'modal_content_padding'               => '0em',
    '_label'                              => $label_mega_menu,
    '_modules'                            => [ $mega_menu_featured_div, $mega_menu_technique_div ]
  ]
]);


// Off Canvas
// ----------

cs_register_prefab_element( 'standard', 'mega-menu-off-canvas-prefab', [
  'type'   => 'layout-off-canvas',
  'scope'  => [ 'all' ],
  'title'  => __( 'Mega Menu Off Canvas', 'cornerstone' ),
  'values' => [
    '_type'                         => 'layout-off-canvas',
    'off_canvas_body_scroll'        => 'disable',
    'off_canvas_close_offset'       => false,
    'off_canvas_content_flex_align' => 'stretch',
    'off_canvas_content_flexbox'    => true,
    '_label'                        => $label_mega_menu,
    '_modules'                      => [ $mega_menu_featured_div, $mega_menu_technique_div ]
  ]
]);



// Sliders
// =============================================================================

function x_full_slider_prefab_navigation() {
  return [
    '_type'                     => 'layout-div',
    '_bp_base'                  => '4_4',
    '_bp_data4_4'               => [
      'layout_div_padding' => [
        null,
        null,
        'qs 0.5em qs 0.5em',
        null,
        null
      ]
    ],
    '_label'                    => 'Slide Navigation',
    '_m'                        => [
      'e' => 1
    ],
    'effects_transform'         => 'translate(0px, -50%)',
    'layout_div_flex_align'     => 'center',
    'layout_div_flex_direction' => 'row',
    'layout_div_flex_justify'   => 'space-between',
    'layout_div_flexbox'        => true,
    'layout_div_left'           => '0',
    'layout_div_padding'        => '0em 1em 0em 1em',
    'layout_div_pointer_events' => 'none-self',
    'layout_div_position'       => 'absolute',
    'layout_div_right'          => '0',
    'layout_div_top'            => '50%',
    '_modules'                  => [
      [
        '_type'                    => 'layout-div',
        '_bp_base'                 => '4_4',
        '_label'                   => 'Prev',
        '_m'                       => [
          'e' => 1
        ],
        'custom_atts'              => '{"data-x-slide-prev":""}',
        'effects_provider'         => true,
        'layout_div_bg_color'      => '#000000',
        'layout_div_border_radius' => '100em',
        'layout_div_flex_align'    => 'center',
        'layout_div_flex_justify'  => 'center',
        'layout_div_flexbox'       => true,
        'layout_div_height'        => '3em',
        'layout_div_href'          => '#prev',
        'layout_div_tag'           => 'a',
        'layout_div_width'         => '3em',
        '_modules'                 => [
          [
            '_type'          => 'icon',
            '_bp_base'       => '4_4',
            'icon'           => 'o-arrow-left',
            'icon_color'     => 'rgba(255, 255, 255, 0.55)',
            'icon_color_alt' => '#ffffff',
            'icon_margin'    => '!0em 0em 0em 0em'
          ]
        ]
      ],
      [
        '_type'                    => 'layout-div',
        '_bp_base'                 => '4_4',
        '_label'                   => 'Next',
        '_m'                       => [
          'e' => 1
        ],
        'custom_atts'              => '{"data-x-slide-next":""}',
        'effects_provider'         => true,
        'layout_div_bg_color'      => '#000000',
        'layout_div_border_radius' => '100em',
        'layout_div_flex_align'    => 'center',
        'layout_div_flex_justify'  => 'center',
        'layout_div_flexbox'       => true,
        'layout_div_height'        => '3em',
        'layout_div_href'          => '#next',
        'layout_div_tag'           => 'a',
        'layout_div_width'         => '3em',
        '_modules'                 => [
          [
            '_type'          => 'icon',
            '_bp_base'       => '4_4',
            'icon'           => 'o-arrow-right',
            'icon_color'     => 'rgba(255, 255, 255, 0.55)',
            'icon_color_alt' => '#ffffff',
            'icon_margin'    => '!0em 0em 0em 0em'
          ]
        ]
      ]
    ]
  ];
}


function x_full_slider_prefab_pagination() {
  return [
    '_type'                   => 'slide-pagination',
    '_bp_base'                => '4_4',
    '_label'                  => 'Pagination',
    'slide_pagination_margin' => '2em 0em 0em 0em'
  ];
}


function x_full_slider_prefab_slide( $count = 1, $type = "Inline" ) {

  $text = "";

  if ( $type === "Inline" ) {
    $text = "This is <strong>Slide " . $count . "</strong> of the Inline Slider. Slides go left or right, and you can add any Element to the Slide Container. Navigation and pagination are optional.";
  }

  if ( $type === "Stacked" ) {
    $text = "This is <strong>Slide " . $count . "</strong> of the Inline Slider. Slides cross-fade or use Effects to transition from one Slide to the next, and you can add any Element to the Slide Container. Navigation and pagination are optional.";
  }

  return [
    '_type'                      => 'layout-slide',
    '_bp_base'                   => '4_4',
    'layout_slide_bg_color'      => 'rgba(0, 0, 0, 0.06)',
    'layout_slide_border_radius' => '1em',
    'layout_slide_padding'       => '3em',
    '_modules'                   => [
      [ '_type' => 'text', '_bp_base' => '4_4', 'text_content' => $text ]
    ]
  ];
}


// Slide Navigation
// ----------------

cs_register_prefab_element( 'standard', 'slide-navigation', [
  'type'   => 'layout-div',
  'icon'   => 'slide-navigation',
  'scope'  => [ 'all' ],
  'title'  => __( 'Slide Navigation', 'cornerstone' ),
  'values' => [
    '_type'                     => 'layout-div',
    '_bp_base'                  => '4_4',
    '_label'                    => 'Slide Navigation',
    '_m'                        => [
      'e' => 1
    ],
    'layout_div_flex_align'     => 'stretch',
    'layout_div_flex_direction' => 'row',
    'layout_div_flex_justify'   => 'center',
    'layout_div_flexbox'        => true,
    'layout_div_height'         => '2em',
    'layout_div_width'          => '6em',
    '_modules'                  => [
      [
        '_type'                    => 'layout-div',
        '_bp_base'                 => '4_4',
        '_label'                   => 'Prev',
        '_m'                       => [
          'e' => 1
        ],
        'custom_atts'              => '{"data-x-slide-prev":""}',
        'layout_div_bg_color'      => 'rgba(0, 0, 0, 0.16)',
        'layout_div_bg_color_alt'  => 'rgba(0, 0, 0, 0.11)',
        'layout_div_border_radius' => '4px',
        'layout_div_flex'          => '1 0 0%',
        'layout_div_flex_align'    => 'center',
        'layout_div_flex_justify'  => 'center',
        'layout_div_flexbox'       => true,
        'layout_div_href'          => '#prev',
        'layout_div_tag'           => 'a',
        '_modules'                 => [
          [
            '_type'    => 'icon',
            '_bp_base' => '4_4',
            'icon'     => 'o-long-arrow-left'
          ]
        ]
      ],
      [
        '_type'                    => 'layout-div',
        '_bp_base'                 => '4_4',
        '_label'                   => 'Next',
        '_m'                       => [
          'e' => 1
        ],
        'custom_atts'              => '{"data-x-slide-next":""}',
        'layout_div_bg_color'      => 'rgba(0, 0, 0, 0.16)',
        'layout_div_bg_color_alt'  => 'rgba(0, 0, 0, 0.11)',
        'layout_div_border_radius' => '4px',
        'layout_div_flex'          => '1 0 0%',
        'layout_div_flex_align'    => 'center',
        'layout_div_flex_justify'  => 'center',
        'layout_div_flexbox'       => true,
        'layout_div_href'          => '#next',
        'layout_div_margin'        => '0px 0px 0px 3px',
        'layout_div_tag'           => 'a',
        '_modules'                 => [
          [
            '_type'    => 'icon',
            '_bp_base' => '4_4',
            'icon'     => 'o-long-arrow-right'
          ]
        ]
      ]
    ]
  ]
]);


// Slider (Inline)
// ---------------

cs_register_prefab_element( 'standard', 'slider-inline', [
  'type'   => 'layout-div',
  'icon'   => 'slider-inline',
  'scope'  => [ 'all' ],
  'title'  => __( 'Slider (Inline)', 'cornerstone' ),
  'values' => [
    '_type'    => 'layout-div',
    '_bp_base' => '4_4',
    '_label'   => 'Slider (Inline)',
    '_m'       => [
      'e' => 1
    ],
    '_modules' => [
      [
        '_type'    => 'layout-div',
        '_bp_base' => '4_4',
        '_label'   => 'Content Wrapper',
        '_m'       => [
          'e' => 1
        ],
        '_modules' => [
          [
            '_type'                                           => 'layout-slide-container',
            '_bp_base'                                        => '4_4',
            '_bp_data4_4'                                     => [
              'layout_slide_container_inline_page_count' => [
                '1',
                null,
                '2',
                null,
                null
              ]
            ],
            '_label'                                          => 'Slide Container',
            'layout_slide_container_content_global_container' => true,
            'layout_slide_container_inline_page_count'        => '3',
            '_modules'                                        => [
              x_full_slider_prefab_slide( 1, 'Inline' ),
              x_full_slider_prefab_slide( 2, 'Inline' ),
              x_full_slider_prefab_slide( 3, 'Inline' ),
              x_full_slider_prefab_slide( 4, 'Inline' ),
              x_full_slider_prefab_slide( 5, 'Inline' ),
              x_full_slider_prefab_slide( 6, 'Inline' ),
            ]
          ],
          x_full_slider_prefab_navigation(),
        ]
      ],
      x_full_slider_prefab_pagination(),
    ]
  ]
]);


// Slider (Stacked)
// ----------------

cs_register_prefab_element( 'standard', 'slider-stacked', [
  'type'   => 'layout-div',
  'icon'   => 'slider-stacked',
  'scope'  => [ 'all' ],
  'title'  => __( 'Slider (Stacked)', 'cornerstone' ),
  'values' => [
    '_type'    => 'layout-div',
    '_bp_base' => '4_4',
    '_label'   => 'Slider (Stacked)',
    '_m'       => [
      'e' => 1
    ],
    '_modules' => [
      [
        '_type'    => 'layout-div',
        '_bp_base' => '4_4',
        '_label'   => 'Content Wrapper',
        '_m'       => [
          'e' => 1
        ],
        '_modules' => [
          [
            '_type'                                           => 'layout-slide-container',
            '_bp_base'                                        => '4_4',
            '_label'                                          => 'Slide Container',
            'layout_slide_container_content_global_container' => true,
            'layout_slide_container_layout_type'              => 'stacked',
            '_modules'                                        => [
              x_full_slider_prefab_slide( 1, 'Stacked' ),
              x_full_slider_prefab_slide( 2, 'Stacked' ),
              x_full_slider_prefab_slide( 3, 'Stacked' ),
            ]
          ],
          x_full_slider_prefab_navigation(),
        ]
      ],
      x_full_slider_prefab_pagination(),
    ]
  ]
]);
