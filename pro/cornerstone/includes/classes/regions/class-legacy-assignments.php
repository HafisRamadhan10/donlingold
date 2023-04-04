<?php

class Cornerstone_Legacy_Assignments extends Cornerstone_Plugin_Component {

  public function setup() {
    add_filter( 'cs_locate_footer_assignment', [ $this, 'locate_legacy_footer' ], -9999 );
    add_filter( 'cs_locate_header_assignment', [ $this, 'locate_legacy_header' ], -9999 );
    add_action( 'cs_delete_header', [ $this, 'header_unset_assignment' ] );
    add_action( 'cs_delete_footer', [ $this, 'footer_unset_assignment' ] );
    add_action( 'cs_save_header', [ $this, 'header_unset_assignment' ] );
    add_action( 'cs_save_footer', [ $this, 'footer_unset_assignment' ] );
    add_filter( 'cs_regions_settings', [ $this, 'insert_assignments' ], 10, 3 );
  }

  public function locate_legacy_footer( $id ) {
    return $this->get_legacy_match( 'footer' );
  }

  public function locate_legacy_header( $id ) {
    return $this->get_legacy_match( 'header' );
  }

  public function get_legacy_match( $type ) {

    $assignments = wp_parse_args( json_decode( wp_unslash( get_option( "cornerstone_{$type}_assignments" ) ), true ), $this->assignment_schema() );

    // Start by using the global assignment
    $match = $assignments['global'];

    if ( function_exists( 'is_shop' ) && is_shop() ) {
      $post = get_post( wc_get_page_id( 'shop' ) );
    } else {
      $post = get_post();
    }

    if ( is_front_page() && isset( $assignments['indexes']['front'] ) ) {
      $match = $assignments['indexes']['front'];
    } elseif ( is_home() ) {
      $match = isset( $assignments['indexes']['home'] ) ? $assignments['indexes']['home'] : $assignments['global'];
    } elseif ( is_a( $post, 'WP_POST' ) ) {

      if ( isset( $assignments['post_types'][ $post->post_type ] ) ) {
        $match = $assignments['post_types'][ $post->post_type ];
      }

      $source_post_id = CS()->component('Wpml')->get_source_id_for_post($post->ID, $post->post_type);
      if ( isset( $assignments['posts'][ 'post-' . $source_post_id ] ) ) {
        $match = $assignments['posts'][ 'post-' . $source_post_id ];
      }

    }

    return $match;

  }

  public function insert_assignments( $settings, $type, $entity_id ) {

    if ($entity_id && empty($settings['assignments'])) {
      $converted = $this->convert_assignments( "cornerstone_{$type}_assignments", $entity_id );
      if (!empty($converted['assignments'])) {
        $settings['assignments'] = $converted['assignments'];
      }
      if (!empty($converted['assignment_priority'])) {
        $settings['assignment_priority'] = $converted['assignment_priority'];
      }
    }

    return $settings;
  }

  public function convert_assignments( $option_key, $entity_id ) {

    $data = $this->load_transform( get_option( $option_key ) );
    $assigned = array();
    $priority = null;

    foreach ($data as $key => $value) {
      if ( (int) $value !== (int) $entity_id ) {
        continue;
      }

      if (is_null($priority)) {
        $priority = 20;
      }

      if ( $key === 'global' ) {
        $assigned[] = $this->normalize_new_assignment('site:entire-site');
        continue;
      }

      if ($key === 'indexes::front') {
        $assigned[] = $this->normalize_new_assignment('archive:front-page');
        $assigned[] = $this->normalize_new_assignment('single:front-page');
        $priority = min($priority, 10);
        continue;
      }

      if ($key === 'indexes::home') {
        $assigned[] = $this->normalize_new_assignment('archive:front-page');
        $priority = min($priority, 10);
        continue;
      }

      $parts = explode( '::', $key );


      if ( isset($parts[0]) && $parts[0] === 'post_type' && isset($parts[1])) {


        if (isset($parts[2])) {
          $priority =
          $assigned[] = $this->normalize_new_assignment('single:specific-post-of-type|' . $parts[1], (int) $parts[2]);
          $priority = min($priority, 0);
          continue;
        }

        $assigned[] = $this->normalize_new_assignment('single:post-type', $parts[1] );
        $assigned[] = $this->normalize_new_assignment('archive:post-type', $parts[1] );
        $priority = min($priority, 5);

      }

    }

    return [
      'assignments' => $assigned,
      'assignment_priority' => is_int( $priority ) ? $priority : 0
    ];
  }

  public function normalize_new_assignment( $condition = '', $value = '' ) {
    return [
      'group' => true,
      'condition' => $condition,
      'value' => $value,
    ];
  }

  public function header_unset_assignment( $entity_id ) {
    $this->unset_assignment( 'cornerstone_header_assignments', $entity_id );
  }

  public function footer_unset_assignment( $entity_id ) {
    $this->unset_assignment( 'cornerstone_footer_assignments', $entity_id );
  }

  public function unset_assignment( $option_key, $entity_id ) {

    $data = $this->load_transform( get_option( $option_key ) );

    foreach ($data as $key => $value) {
      if ( (int) $entity_id === (int) $value ) {
        unset($data[$key]);
      }
    }

    update_option( $option_key, $this->save_transform( $data ) );

  }

  public function load_transform( $data ) {

    $data = json_decode( wp_unslash( $data ), true );
    if ( is_null( $data ) ) {
      return new stdClass;
    }

    $uncompacted = array();

    if ( isset( $data['global'] ) ) {
      $uncompacted['global'] = $data['global'];
    }

    if ( isset( $data['indexes'] ) ) {
      foreach ($data['indexes'] as $key => $value) {
        $uncompacted[ 'indexes::' . $key] = $value;
      }
    }

    if ( isset( $data['post_types'] ) ) {
      foreach ($data['post_types'] as $key => $value) {
        $uncompacted[ 'post_type::' . $key] = $value;
      }
    }

    if ( isset( $data['meta'] ) && isset( $data['meta']['post_types'] ) && isset( $data['posts'] ) ) {
      foreach ($data['meta']['post_types'] as $key => $value) {
        foreach ($value as $id) {
          if ( isset( $data['posts'][ 'post-' . $id] ) ) {
            $uncompacted[ 'post_type::' . $key . '::' . $id ] = $data['posts'][ 'post-' . $id];
          }
        }
      }
    }

    ksort( $uncompacted );

    if ( empty($uncompacted)) {
      $uncompacted = new stdClass;
    }

    return $uncompacted;
  }

  public function assignment_schema() {
    return array(
      'global' => null,
      'indexes' => array(),
      'post_types' => array(),
      'posts' => array(),
      'meta' => array(
        'post_types' => array()
      )
    );
  }

  public function save_transform( $data ) {

    if ( ! is_array( $data ) ) {
      $data = array();
    }

    ksort($data);

    $compact = $this->assignment_schema();

    foreach ($data as $key => $value) {

      $address = explode( '::', $key );

      if ( 'global' === $key) {
        $compact['global'] = $value;
      } elseif ( 'indexes' === $address[0] ) {
        $compact['indexes'][ $address[1] ] = $value;
      } elseif ( 'post_type' === $address[0] ) {
        if ( ! isset( $address[2] ) ) {
          $compact['post_types'][ $address[1] ] = $value;
        } else {
          $compact['posts'][ 'post-' . $address[2] ] = $value;
          if ( ! isset( $compact['meta']['post_types'][$address[1]] )) {
            $compact['meta']['post_types'][$address[1]] = array();
          }
          $compact['meta']['post_types'][$address[1]][] = $address[2];
        }

      }

    }

    return wp_slash( json_encode( $compact ) );
  }

}
