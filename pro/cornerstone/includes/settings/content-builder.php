<?php

function cs_get_filtered_post_status_choices( $post ) {

  $choices = array();

  $choices[] = array( 'value' => 'publish', 'label' => __( 'Publish', 'cornerstone' ) );

  switch ($post->post_status) {
    case 'private':
      $choices[] = array( 'value' => 'private', 'label' => __( 'Privately Published', 'cornerstone' ) );
      break;
    case 'future':
      $choices[] = array( 'value' => 'future', 'label' => __( 'Scheduled', 'cornerstone' ) );
      break;
    case 'pending':
      $choices[] = array( 'value' => 'pending', 'label' => __( 'Pending Review', 'cornerstone' ) );
      break;
    default:
      $choices[] = array( 'value' => 'draft', 'label' => __( 'Draft', 'cornerstone' ) );
      break;
  }

  return $choices;

}

function cs_get_filtered_post_parent_choices( $post ) {

  $posts  = get_posts( array(
    'post_type' => $post->post_type,
    'exclude' => array( $post->ID),
    'limit' => 10000,
  ) );

  $options = array(
    array( 'label' => __( '(no parent)', 'cornerstone' ), 'value' => '')
  );

  foreach ( $posts as $post) {
    if ($post->post_title) {
      $options[] = array( 'label' => $post->post_title, 'value' => "$post->ID" );
    }
  }

  return $options;

}

function cornerstone_content_builder_settings_controls($post) {

  $post_type_obj = get_post_type_object( $post->post_type );
  $controls = [];

  //
  // General
  //

  $general_controls = array();

  if ( post_type_supports( $post->post_type, 'title' ) || $post->post_type === 'cs_global_block') {
    $general_controls[] = array(
      'key' => 'general_post_title',
      'type' => 'text',
      'label' => __( 'Title', 'cornerstone' ),
    );
  }

  if ( $post->post_type == 'cs_global_block' ) {

    $general_controls[] = array(
      'key' => 'general_post_name',
      'type' => 'text',
      'label' => __( 'Name', 'cornerstone' ),
    );

  }
  if ( $post->post_type !== 'cs_global_block' ) {

    $general_controls[] = array(
      'key' => 'general_post_name',
      'type' => 'text',
      'label' => __( 'Slug', 'cornerstone' ),
    );

    $general_controls[] = array(
      'key' => 'general_post_status',
      'type' => 'select',
      'label' => __( 'Status', 'cornerstone' ),
      'options' => array(
        'choices' => cs_get_filtered_post_status_choices( $post )
      ),
      'condition' => array(
        'user_can:{context}.publish' => true
      )
    );

    // // To furnish this we need an image control that saves the ID instead of URL
    // if (post_type_supports($post->post_type, 'thumbnail')) {

    // }

    if (post_type_supports($post->post_type, 'comments')) {
      $general_controls[] = array(
        'key' => 'general_allow_comments',
        'type' => 'toggle',
        'label' => __( 'Allow Comments', 'cornerstone' ),
      );
    }

    if (post_type_supports($post->post_type, 'excerpt')) {
      $general_controls[] = array(
        'key' => 'general_manual_excerpt',
        'type' => 'textarea',
        'label' => __( 'Manual Excerpt', 'cornerstone' ),
        'options' => array(
          'placeholder' => __( '(Optional) An excerpt will be derived from any paragraphs in your content. You can override this by crafting your own excerpt here, or in the WordPress post editor.', 'cornerstone' )
        )
      );
    }

    if ($post_type_obj->hierarchical) {
      $general_controls[] = array(
        'key' => 'general_post_parent',
        'type' => 'select',
        'label' => sprintf( __( 'Parent %s', 'cornerstone' ), $post_type_obj->labels->singular_name),
        'options' => array(
          'choices' => cs_get_filtered_post_parent_choices( $post )
        )
      );
    }

    if ($post->post_type === 'page') {
      $general_controls[] = array(
        'key' => 'general_page_template',
        'type' => 'select',
        'label' => __( 'Page Template', 'cornerstone' ),
        'options' => array(
          'choices' => cs_get_page_template_options($post->post_type, $post )
        )
      );
    }
  }

  $controls[] = array(
    'type'  => 'group',
    'label' => __('General', 'cornerstone'),
    'controls' => $general_controls
  );


  $controls = apply_filters('cs_builder_settings_controls', $controls, $post );

  if (apply_filters('cs_builder_settings_responsive_text', true, $post)) {
    $controls[] = array(
      'type'  => 'responsive-text',
      'key' => 'responsive_text',
      'label' => __( 'Responsive Text', 'cornerstone' )
    );
  }

  return $controls;
}


// Below are some comments of old setting code from prior to the Pro 4 update
// If these are added back, it should go in framework/functions/plugins/cornerstone.php

// //
// // X Settings
// //

// if (in_array($post->post_type, array( 'post', 'page', 'x-portfolio'))) {

//   $x_settings = [];

//   $controls[] = array(
//     'type'  => 'group',
//     'label' => __( 'Meta Settings', 'cornerstone' ),
//     'controls' => $x_settings
//   );
// }


// //
// // Sliders
// //

// if ( class_exists( 'RevSlider' ) || class_exists( 'LS_Sliders' ) ) {


//   $slider_above_controls = [];
//   $slider_below_controls = [];

//   $controls[] = array(
//     'type'  => 'group',
//     'label' => __( 'Slider Settings: Above Masthead', 'cornerstone' ),
//     'controls' => $slider_above_controls
//   );

//   $controls[] = array(
//     'type'  => 'group',
//     'label' => __( 'Slider Settings: Above Masthead', 'cornerstone' ),
//     'controls' => $slider_below_controls
//   );

// }

// class CS_Settings_X_Settings extends Cornerstone_Legacy_Setting_Section {

//   public function data() {
//     return array(
//       'name'        => 'x-settings',
//       'title'       => __( 'Meta Settings', 'cornerstone' ),
//       'priority' => '20'
//     );
//   }

//   public function controls() {

//     global $post;

//     if ( $post->post_type == 'post') {
//       $this->postControls();
//     } elseif ( $post->post_type == 'page') {
//       $this->pageControls();
//     } elseif ( $post->post_type == 'x-portfolio') {
//       $this->portfolioControls();
//     }

//   }

//   public function postControls() {

//     global $post;

//     $this->addControl(
//       'body_css_class',
//       'text',
//       __( 'Body CSS Class(es)', 'cornerstone' ),
//       '',
//       get_post_meta( $post->ID, '_x_entry_body_css_class', true ),
//       array(
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//     $this->addControl(
//       'fullwidth_post_layout',
//       'toggle',
//       __( 'Fullwidth Post Layout', 'cornerstone' ),
//       '',
//       ( get_post_meta( $post->ID, '_x_post_layout', true ) == 'on' ),
//       array(
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//     $this->addControl(
//       'alternate_index_title',
//       'text',
//       __( 'Alternate Index Title', 'cornerstone' ),
//       '',
//       get_post_meta( $post->ID, '_x_entry_alternate_index_title', true ),
//       array(
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//     $this->addControl(
//       'bg_image_full',
//       'text',
//       __( 'Background Image(s)', 'cornerstone' ),
//       '',
//       get_post_meta( $post->ID, '_x_entry_bg_image_full', true ),
//       array(
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//     $meta = get_post_meta( $post->ID, '_x_entry_bg_image_full_fade', true );
//     $default = ( $meta == '' ) ? '750' : $meta;

//     $this->addControl(
//       'bg_image_full_fade',
//       'text',
//       __( 'Background Image(s) Fade', 'cornerstone' ),
//       '',
//       $default,
//       array(
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//     $meta = get_post_meta( $post->ID, '_x_entry_bg_image_full_duration', true );
//     $default = ( $meta == '' ) ? '7500' : $meta;

//     $this->addControl(
//       'bg_image_full_duration',
//       'text',
//       __( 'Background Images Duration', 'cornerstone' ),
//       '',
//       $default,
//       array(
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//   }

//   public function pageControls() {

//     global $post;

//     $this->addControl(
//       'body_css_class',
//       'text',
//       __( 'Body CSS Class(es)', 'cornerstone' ),
//       '',
//       get_post_meta( $post->ID, '_x_entry_body_css_class', true ),
//       array(
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//     $this->addControl(
//       'alternate_index_title',
//       'text',
//       __( 'Alternate Index Title', 'cornerstone' ),
//       '',
//       get_post_meta( $post->ID, '_x_entry_alternate_index_title', true ),
//       array(
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//     $this->addControl(
//       'disable_page_title',
//       'toggle',
//       __( 'Disable Page Title', 'cornerstone' ),
//       '',
//       ( get_post_meta( $post->ID, '_x_entry_disable_page_title', true ) == 'on' ),
//       array(
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//     $meta = get_post_meta( $post->ID, '_x_page_one_page_navigation', true );

//     $deactivated_label = __( 'Deactivated', 'cornerstone' );
//     $default = ( $meta == '' ) ? $deactivated_label : $meta;

//     $menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
//     $choices = array();
//     $choices[] = array( 'value' => 'Deactivated', 'label' => $deactivated_label );

//     if ( ! is_wp_error( $menus ) ) {
//       foreach ( $menus as $menu ) {
//         $choices[] = array( 'value' => $menu->name, 'label' => $menu->name );
//       }
//     }

//     $this->addControl(
//       'one_page_navigation',
//       'select',
//       __( 'One Page Navigation', 'cornerstone' ),
//       '',
//       $default,
//       array(
//         'choices' => $choices,
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//     $this->addControl(
//       'bg_image_full',
//       'text',
//       __( 'Background Image(s)', 'cornerstone' ),
//       '',
//       get_post_meta( $post->ID, '_x_entry_bg_image_full', true ),
//       array(
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//     $meta = get_post_meta( $post->ID, '_x_entry_bg_image_full_fade', true );
//     $default = ( $meta == '' ) ? '750' : $meta;

//     $this->addControl(
//       'bg_image_full_fade',
//       'text',
//       __( 'Background Image(s) Fade', 'cornerstone' ),
//       '',
//       $default,
//       array(
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//     $meta = get_post_meta( $post->ID, '_x_entry_bg_image_full_duration', true );
//     $default = ( $meta == '' ) ? '7500' : $meta;

//     $this->addControl(
//       'bg_image_full_duration',
//       'text',
//       __( 'Background Images Duration', 'cornerstone' ),
//       '',
//       $default,
//       array(
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//   }

//   public function portfolioControls() {

//     global $post;

//     $this->addControl(
//       'body_css_class',
//       'text',
//       __( 'Body CSS Class(es)', 'cornerstone' ),
//       '',
//       get_post_meta( $post->ID, '_x_entry_body_css_class', true ),
//       array(
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//     $this->addControl(
//       'alternate_index_title',
//       'text',
//       __( 'Alternate Index Title', 'cornerstone' ),
//       '',
//       get_post_meta( $post->ID, '_x_entry_alternate_index_title', true ),
//       array(
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//     $pages = get_pages( array(
//       'meta_key'    => '_wp_page_template',
//       'meta_value'  => 'template-layout-portfolio.php',
//       'sort_order'  => 'ASC',
//       'sort_column' => 'ID'
//     ) );

//     if ( ! empty($pages) ) {

//       $current = get_post_meta( $post->ID, '_x_portfolio_parent', true );

//       ob_start();
//       echo '<select name="portfolio_parent" >';
//       echo '<option value="Default">Default</option>';
//       foreach ( $pages as $page ) {
//         echo '<option value="' . $page->ID . '"';
//         if ( $current == $page->ID ) {
//           echo ' selected="selected"';
//         }
//         echo'>' . $page->post_title . '</option>';
//       }
//       echo '</select>';

//       $markup = ob_get_clean();
//       $this->addControl(
//         'portfolio_parent',
//         'wpselect',
//         __('Portfolio Parent', 'cornerstone' ),
//         '',
//         "{$current}",
//         array(
//           'markup' => $markup,
//           'trigger' => 'settings-theme-changed'
//         )
//       );
//     }

//     $this->addControl(
//       'media_type',
//       'select',
//       __( 'Media Type', 'cornerstone' ),
//       '',
//       get_post_meta( $post->ID, '_x_portfolio_media', true ),
//       array(
//         'choices' => array(
//           array( 'value' => 'Image',   'label' => __( 'Image', 'cornerstone' ) ),
//           array( 'value' => 'Gallery', 'label' => __( 'Gallery', 'cornerstone' ) ),
//           array( 'value' => 'Video',   'label' => __( 'Video', 'cornerstone' ) ),
//         ),
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//     $current_video_aspect_ratio = get_post_meta( $post->ID, '_x_portfolio_aspect_ratio', true );
//     $this->addControl(
//       'video_aspect_ratio',
//       'select',
//       __( 'Video Aspect Ratio', 'cornerstone' ),
//       '',
//       ($current_video_aspect_ratio == '' ) ? '16:9' : $current_video_aspect_ratio,
//       array(
//         'choices' => array(
//           array( 'value' => '16:9',   'label' => '16:9' ),
//           array( 'value' => '5:3', 'label' => '5:3' ),
//           array( 'value' => '5:4',   'label' => '5:4' ),
//           array( 'value' => '4:3',   'label' => '4:3' ),
//           array( 'value' => '3:2',   'label' => '3:2' ),
//         ),
//         'condition' => array(
//           'media_type' => 'Video',
//         ),
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//     $this->addControl(
//       'm4v_file_url',
//       'text',
//       __( 'M4V File URL', 'cornerstone' ),
//       '',
//       get_post_meta( $post->ID, '_x_portfolio_m4v', true ),
//       array(
//         'condition' => array(
//           'media_type' => 'Video',
//         ),
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//     $this->addControl(
//       'ogv_file_url',
//       'text',
//       __( 'OGV File URL', 'cornerstone' ),
//       '',
//       get_post_meta( $post->ID, '_x_portfolio_ogv', true ),
//       array(
//         'condition' => array(
//           'media_type' => 'Video',
//         ),
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//     if (current_user_can( 'unfiltered_html' ) ) {

//       $this->addControl(
//         'embedded_video_code',
//         'textarea',
//         __( 'Embedded Video Code', 'cornerstone' ),
//         '',
//         get_post_meta( $post->ID, '_x_portfolio_embed', true ),
//         array(
//           'condition' => array(
//             'media_type' => 'Video',
//           ),
//           'trigger' => 'settings-theme-changed'
//         )
//       );
//     }

//     $this->addControl(
//       'featured_content',
//       'select',
//       __( 'Featured Content', 'cornerstone' ),
//       '',
//       get_post_meta( $post->ID, '_x_portfolio_index_media', true ),
//       array(
//         'choices' => array(
//           array( 'value' => 'Thumbnail', 'label' => __( 'Thumbnail', 'cornerstone' ) ),
//           array( 'value' => 'Media',     'label' => __( 'Media', 'cornerstone' ) ),
//         ),
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//     $this->addControl(
//       'project_link',
//       'text',
//       __( 'Project Link', 'cornerstone' ),
//       '',
//       get_post_meta( $post->ID, '_x_portfolio_project_link', true ),
//       array(
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//     $this->addControl(
//       'bg_image_full',
//       'text',
//       __( 'Background Image(s)', 'cornerstone' ),
//       '',
//       get_post_meta( $post->ID, '_x_entry_bg_image_full', true ),
//       array(
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//     $meta = get_post_meta( $post->ID, '_x_entry_bg_image_full_fade', true );
//     $default = ( $meta == '' ) ? '750' : $meta;

//     $this->addControl(
//       'bg_image_full_fade',
//       'text',
//       __( 'Background Image(s) Fade', 'cornerstone' ),
//       '',
//       $default,
//       array(
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//     $meta = get_post_meta( $post->ID, '_x_entry_bg_image_full_duration', true );
//     $default = ( $meta == '' ) ? '7500' : $meta;

//     $this->addControl(
//       'bg_image_full_duration',
//       'text',
//       __( 'Background Images Duration', 'cornerstone' ),
//       '',
//       $default,
//       array(
//         'trigger' => 'settings-theme-changed'
//       )
//     );

//   }

//   public function handler( $post, $atts ) {

//   	extract( $atts );

//   	$classes = explode(' ', $body_css_class );
//   	array_map('sanitize_html_class', $classes);
//   	$body_css_class = implode(' ', $classes );

//   	update_post_meta( $post->ID, '_x_entry_body_css_class', $body_css_class );
//   	update_post_meta( $post->ID, '_x_entry_alternate_index_title', sanitize_text_field( $alternate_index_title ) );
//   	update_post_meta( $post->ID, '_x_entry_bg_image_full', $bg_image_full );
//     update_post_meta( $post->ID, '_x_entry_bg_image_full_fade', $bg_image_full_fade );
//     update_post_meta( $post->ID, '_x_entry_bg_image_full_duration', $bg_image_full_duration );

//     if ( $post->post_type == 'post') {

// 	    update_post_meta( $post->ID, '_x_post_layout', ( $fullwidth_post_layout == 'true' ) ? 'on' : '' );

//     } elseif ( $post->post_type == 'page') {

// 	    update_post_meta( $post->ID, '_x_entry_disable_page_title', ( $disable_page_title == 'true' ) ? 'on' : '' );
// 	    update_post_meta( $post->ID, '_x_page_one_page_navigation', $one_page_navigation );

//     } elseif ( $post->post_type == 'x-portfolio') {

// 	    update_post_meta( $post->ID, '_x_portfolio_parent', $portfolio_parent );
// 	    update_post_meta( $post->ID, '_x_portfolio_media', $media_type );
// 	    update_post_meta( $post->ID, '_x_portfolio_aspect_ratio', $video_aspect_ratio );
// 	    update_post_meta( $post->ID, '_x_portfolio_m4v', $m4v_file_url );
// 	    update_post_meta( $post->ID, '_x_portfolio_ogv', $ogv_file_url );
// 	    update_post_meta( $post->ID, '_x_portfolio_embed', $embedded_video_code );
// 	    update_post_meta( $post->ID, '_x_portfolio_index_media', $featured_content );
// 	    update_post_meta( $post->ID, '_x_portfolio_project_link', $project_link );

//     }

//   }

// }
