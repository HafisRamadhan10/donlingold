<?php

class Cornerstone_Pro_Setup extends Cornerstone_Plugin_Component {

  public function setup() {
    $this->elementsService = CS()->novus()->service('Elements');

    add_action( 'init', array( $this, 'register_post_types' ) );
    add_action( 'cs_register_elements', array( $this, 'register_elements' ), 5 );

    add_action( 'template_redirect', array( $this, 'setup_views' ), 100 );
    add_action( 'cs_late_template_redirect', array( $this, 'setup_region_elements' ) );
    add_filter( 'template_include', array( $this, 'resolve_layout_template'), 97 ); // before under construction extension

  }

  public function register_post_types() {

    register_post_type( 'cs_header', array(
      'public'          => false,
      'capability_type' => 'page',
      'supports'        => false,
      'labels'          => array(
        'name'          => csi18n( "common.headers.entities" ),
        'singular_name' => csi18n( "common.headers.entity" ),
      )
    ) );

    register_post_type( 'cs_footer', array(
      'public'          => false,
      'capability_type' => 'page',
      'supports'        => false,
      'labels'          => array(
        'name'          => csi18n( "common.footers.entities" ),
        'singular_name' => csi18n( "common.footers.entity" ),
      )
    ) );

    register_post_type( 'cs_layout', array(
      'public'          => false,
      'capability_type' => 'page',
      'supports'        => false,
      'labels'          => array(
        'name'          => csi18n( "common.layouts.entities" ),
        'singular_name' => csi18n( "common.layouts.entity" ),
      )
    ) );

  }

  public function register_elements() {
    $path = $this->plugin->path('includes/elements/definitions-pro');
    require_once( $path . '/bar.php' );
    require_once( $path . '/container.php' );
    require_once( $path . '/layout-grid.php' );
    require_once( $path . '/layout-cell.php' );
  }


  public function setup_views() {

    $this->setup_layouts();

    // cs_output_header/cs_output_footer are false when
    // - we are previewing a Global Block
    // - the current Layout has the header/footer disabled
    // - the current legacy page template contains "No Header/Footer"

    if ( apply_filters( 'cs_output_header', true ) ) {
      do_action( 'cs_connect_masthead' );
    }

    if ( apply_filters( 'cs_output_footer', true ) ) {
      do_action( 'cs_connect_colophon' );
    }

  }

  public function setup_bar_spaces( $regions ) {

    add_action('wp_body_open', function() use ($regions) {
      // Hook in left and right bar spaces which are output earlier than their bars.
      $bar_space_actions = array(
        'left'  => 'x_before_site_begin',
        'right' => 'x_before_site_begin',
      );

      foreach ( $regions as $region ) {
        foreach ( $region['_modules'] as $element ) {
          if ($element['_type'] === 'bar') {
            if ( isset( $bar_space_actions[ $element['_region']] ) ) {
              if ( 'fixed' === cs_identity_bar_position( $element )) {
                $data = CS()->novus()->service('Tss')->applyTssToElement( $element );
                cs_defer_view( $bar_space_actions[ $element['_region'] ], 'elements-pro/bar-space', $data );
              }
            }
          }
        }
      }
    });

  }

  public function setup_region_elements() {
    $this->setup_header();
    $this->setup_footer();
  }

  public function setup_layouts() {
    $layout = apply_filters( 'cs_output_layout', true ) ? $this->plugin->component( 'Assignments' )->get_active_layout() : null;

    if ( ! is_null( $layout ) ) {

      do_action('cs_will_output_layout', $layout );

      $front_end = $this->plugin->component( 'Element_Front_End' );

      $layout_id = $layout->get_id();
      $layout_settings = $layout->get_settings();
      $layout_elements = $this->elementsService->loadEntity( $layout );

      if (!$layout_settings['header_enabled']) {
        add_filter('cs_output_header', '__return_false' );
      }

      if (!$layout_settings['footer_enabled']) {
        add_filter('cs_output_footer', '__return_false' );
      }

      if ($layout_settings['layout_type']) {

        $this->elementsService->registerEntityStyles( $layout );
        if (!did_action('cs_before_preview_frame_layout')) {
          $this->elementsService->renderer()->deferRenderRegions( $layout_elements[0], [ 'layout' => 'cs_layout' ] );
        }

        if ( strpos( $layout_settings['layout_type'], 'single' ) === 0 ) {
          $this->layout_template = $this->plugin->path('includes/views/theming/layout-single.php');
        }

        if ( strpos( $layout_settings['layout_type'], 'archive' ) === 0 ) {
          $this->layout_template = $this->plugin->path('includes/views/theming/layout-archive.php');
        }

        if ( isset( $layout_settings['customJS'] ) && $layout_settings['customJS'] ) {
          cornerstone_enqueue_custom_script( 'x-layout-custom-scripts', $layout_settings['customJS'] );
        }

        CS()->novus()->service('Styling')->addStyles( $layout_id . '-custom', isset( $layout_settings['customCSS'] ) ? $layout_settings['customCSS'] : '', 70 );

      }

    }

  }

  public function resolve_layout_template( $template ) {
    return isset($this->layout_template) ? $this->layout_template : $template;
  }

  public function setup_footer() {

    $footer = apply_filters( 'cs_output_footer', true ) ? $this->plugin->component( 'Assignments' )->get_active_footer() : null;

    if ( is_null( $footer ) ) {
      return;
    }

    do_action('cs_will_output_footer', $footer);

    $front_end = $this->plugin->component( 'Element_Front_End' );
    $footer_id = $footer->get_id();
    $footer_settings = $footer->get_settings();
    $footer_elements = $this->elementsService->loadEntity( $footer );
    $this->elementsService->registerEntityStyles( $footer );
    if (!did_action('cs_before_preview_frame_footer')) {
      $this->elementsService->renderer()->deferRenderRegions( $footer_elements[0], [ 'footer' => 'cs_colophon' ]);
    }

    if ( isset( $footer_settings['customJS'] ) && $footer_settings['customJS'] ) {
      cornerstone_enqueue_custom_script( 'x-footer-custom-scripts', $footer_settings['customJS'] );
    }

    CS()->novus()->service('Styling')->addStyles( $footer_id . '-custom', isset( $footer_settings['customCSS'] ) ? $footer_settings['customCSS'] : '', 90 );

  }

  public function setup_header() {

    $header = apply_filters( 'cs_output_header', true ) ? $this->plugin->component( 'Assignments' )->get_active_header() : null;

    if ( is_null( $header ) ) {
      return;
    }

    do_action( 'cs_will_output_header', $header );

    $front_end = $this->plugin->component( 'Element_Front_End' );
    $header_id = $header->get_id();
    $header_settings = $header->get_settings();
    $header_elements = $this->elementsService->loadEntity( $header );
    $this->elementsService->registerEntityStyles( $header );

    if (!did_action('cs_before_preview_frame_header')) {
      $this->setup_bar_spaces( $header_elements[0] );
      $this->elementsService->renderer()->deferRenderRegions( $header_elements[0], [
        'top' => 'cs_masthead',
        'left' => 'cs_masthead',
        'bottom' => 'cs_masthead',
        'right' => 'cs_masthead',
      ]);
    }

    if ( isset( $header_settings['customJS'] ) && $header_settings['customJS'] ) {
      cornerstone_enqueue_custom_script( 'x-header-custom-scripts', $header_settings['customJS'] );
    }

    CS()->novus()->service('Styling')->addStyles( $header_id . '-custom', isset( $header_settings['customCSS'] ) ? $header_settings['customCSS'] : '', 80 );


  }



}
