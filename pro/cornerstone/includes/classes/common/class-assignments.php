<?php

class Cornerstone_Assignments extends Cornerstone_Plugin_Component {

  protected $active_header = null;
  protected $active_footer = null;
  protected $active_layout = null;

  public function setup() {
    add_action( 'cs_save_region_entity', [ $this, 'clear_cached_rules' ] );
    add_action( 'cs_delete_region_entity', [ $this, 'clear_cached_rules' ] );
  }

  public function resolve_post_type( $type ) {
    switch ( $type ) {
      case 'header':
        return 'cs_header';
      case 'footer':
        return 'cs_footer';
      case 'layout-single':
      case 'layout-archive':
      case 'layout-single-wc':
      case 'layout-archive-wc':
        return 'cs_layout';
      default:
        return null;
    }
  }

  public function resolve_entity( $type, $post ) {
    switch ( $type ) {
      case 'header':
        return new Cornerstone_Header( $post );
      case 'footer':
        return new Cornerstone_Footer( $post );
      case 'layout-single':
      case 'layout-archive':
      case 'layout-single-wc':
      case 'layout-archive-wc':
        return new Cornerstone_Layout( $post );
      default:
        return null;
    }
  }

  public function valid_layout_type( $type, $layout_type ) {

    if ( 'layout-single' === $type) {
      return $layout_type === 'single';
    }
    if ( 'layout-archive' === $type) {
      return $layout_type === 'archive';
    }
    return true;
  }

  public function get_rules( $type ) {

    $post_type = $this->resolve_post_type( $type );

    if (! $post_type ) {
      return [];
    }

    $posts = $this->plugin->component('Locator')->find_posts( [
      'post_types'   => [$post_type],
      'post_status' => 'tco-data'
    ] );

    $sets = [];

    foreach ($posts as $post ) {

      $entity = $this->resolve_entity($type, $post);
      if ($entity) {
        $settings = $entity->get_settings();

        if (!empty($settings['assignments']) && $this->valid_layout_type( $type, $settings['layout_type'] ) ) {
          $sets[] = [
            'id' => $entity->get_id(),
            'rules' => $settings['assignments'],
            'priority' => (int) $settings['assignment_priority']
          ];
        }
      }

    }

    usort( $sets, [ $this, 'sort_rules' ]);

    return $sets;
  }

  public function sort_rules( $a, $b ) {
    $a_priority = $a['priority'];
    $b_priority = $b['priority'];

    if ($a_priority == $b_priority) {
        return 0;
    }
    return ($a_priority < $b_priority) ? -1 : 1;
  }

  public function get_first_match($rules) {
    $matcher = $this->plugin->component('Condition_Matcher');

    foreach ($rules as $set) {

      if ($matcher->match_rule_set( $set['rules'] ) ) {
        return $set['id'];
      }
    }
    return null;
  }

  public function get_option_key( $type ) {
    return str_replace("-", '_', "cs_assignment_cache_$type");
  }

  public function clear_cached_rules( $type ) {
    delete_option( 'x_cache_google_fonts_request' );
    if ( strpos( $type, 'layout' ) === 0 ) {
      delete_option( $this->get_option_key( 'layout-single' ) );
      delete_option( $this->get_option_key( 'layout-archive' ) );
      delete_option( $this->get_option_key( 'layout-single-wc' ) );
      delete_option( $this->get_option_key( 'layout-archive-wc' ) );
    }
    delete_option( $this->get_option_key( $type ) );
  }

  public function get_cached_rules( $type ) {
    $option_key = $this->get_option_key( $type );
    $rules = get_option($option_key);
    if (false === $rules) {
      $rules = $this->get_rules( $type );
      add_option($option_key, $rules); // add_option enables use of autoload which is desirable here
    }
    return $rules;
  }

  public function get_active_header() {

    try {

      $assignment = $this->get_first_match( $this->get_cached_rules( 'header' ) );

      if (is_null( $assignment ) ) {
        // This filter is useful to provide a fallback for when no conditions match
        $assignment = apply_filters( 'cs_locate_header_assignment', null, null, null ); // params deprecated
      }

      // This filter can be used to force an assignment regardless of what was previously detected
      $assignment = apply_filters( 'cs_match_header_assignment', $assignment, null, null ); // params deprecated

      if ( ! is_null( $assignment ) ) {
        $assignment = (int) $assignment = (int) apply_filters( 'wpml_object_id', $assignment, 'cs_header', true, apply_filters( 'wpml_current_language', null ) );
        $this->active_header = new Cornerstone_Header( $assignment );
        return $this->active_header;
      }

    } catch( Exception $e ) {
      trigger_error('Unable to load assigned header ' . $e->getMessage(), E_USER_WARNING);
    }

    return null;
  }

  public function get_active_footer() {

    try {

      $assignment = $this->get_first_match( $this->get_cached_rules( 'footer' ) );

      if ( is_null( $assignment ) ) {
        // This filter is useful to provide a fallback for when no conditions match
        $assignment = apply_filters( 'cs_locate_footer_assignment', null, null, null ); // params deprecated
      }

      // This filter can be used to force an assignment regardless of what was previously detected
      $assignment = apply_filters( 'cs_match_footer_assignment', $assignment, null, null ); // params deprecated

      if ( ! is_null( $assignment ) ) {
        $assignment = (int) apply_filters( 'wpml_object_id', $assignment, 'cs_footer', true, apply_filters( 'wpml_current_language', null ) );
        $this->active_footer = new Cornerstone_Footer( $assignment );
        return $this->active_footer;
      }

    } catch( Exception $e ) {
      trigger_error('Unable to load assigned footer. ' . $e->getMessage(), E_USER_WARNING);
    }

    return null;
  }

  public function detect_layout_type() {

    if (is_singular() || is_404() ) {
      return 'layout-single';
    }

    return 'layout-archive';

  }

  public function get_active_layout() {

    try {

      $layout_type = apply_filters( 'cs_detect_layout_type', $this->detect_layout_type() );

      $assignment = $this->get_first_match( $this->get_cached_rules( $layout_type ) );

      if (is_null( $assignment ) ) {
        // This filter is useful to provide a fallback for when no conditions match
        $assignment = apply_filters( 'cs_locate_' . $layout_type . '_assignment', null );
      }

      // This filter can be used to force an assignment regardless of what was previously detected
      $assignment = apply_filters( 'cs_match_' . $layout_type . '_assignment', $assignment );

      if ( ! is_null( $assignment ) ) {
        $assignment = (int) $assignment = (int) apply_filters( 'wpml_object_id', $assignment, 'cs_layout', true, apply_filters( 'wpml_current_language', null ) );
        $this->active_layout = new Cornerstone_Layout( $assignment );
        return $this->active_layout;
      }

    } catch( Exception $e ) {
      trigger_error('Unable to load assigned layout. ' . $e->getMessage(), E_USER_WARNING);
    }

    return null;
  }

  public function get_last_active_header() {
    return isset( $this->active_header ) ? $this->active_header : null;
  }

  public function get_last_active_footer() {
    return isset( $this->active_footer ) ? $this->active_footer : null;
  }

  public function get_last_active_layout() {
    return isset( $this->active_layout ) ? $this->active_layout : null;
  }
}
