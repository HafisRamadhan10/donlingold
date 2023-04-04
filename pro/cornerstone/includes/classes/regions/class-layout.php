<?php

class Cornerstone_Layout extends Cornerstone_Regions_Entity {
  protected $post_type = 'cs_layout';
  protected $type = 'layout';
  protected $entity = 'common.layouts.entity';

  public function default_settings() {
    return array (
      'customCSS' => '',
      'customJS' => '',
      'assignments' => [],
      'layout_type' => '',
      'assignment_priority' => 0,
      'header_enabled' => true,
      'footer_enabled' => true,
    );
  }

  public function get_general_controls() {
    return [
      [
        'key' => 'header_enabled',
        'type' => 'toggle',
        'label' => __( 'Header', 'cornerstone' ),
      ], [
        'key' => 'footer_enabled',
        'type' => 'toggle',
        'label' => __( 'Footer', 'cornerstone' ),
      ]
    ];
  }

  public function get_default_preview_url( $settings ) {

    $front_page = CS()->component('Conditionals')->maybe_get_front_page($settings['layout_type']);

    if ( $front_page ) {
      return get_permalink( $front_page );
    }

    if ( $settings['layout_type'] === 'single' ) {
      $posts = get_posts( ['numberposts' => 1 ] );
      if (!empty($posts[0])) {
        return get_permalink( $posts[0]->ID );
      }
    }

    return home_url();
  }


  public function get_library_scope( $settings ) {
    return $this->get_sub_type( $settings );
  }

  public function get_sub_type( $settings ) {
    return 'layout-' . $settings['layout_type'];
  }

}
