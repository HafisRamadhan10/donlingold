<?php

class Cornerstone_Formatting_Controller extends Cornerstone_Plugin_Component {

  public function setup() {
    $routing = $this->plugin->component( 'Routing' );
    $routing->add_route('get', 'formatting', [$this, 'format']);

    add_filter( 'cs_remote_format_query-builder-posts', [ $this, 'query_builder_posts'], 10, 2);
    add_filter( 'cs_remote_format_query-builder-terms', [ $this, 'query_builder_terms'], 10, 2);
    add_filter( 'cs_remote_format_query-builder-authors', [ $this, 'query_builder_authors'], 10, 2);
  }

  public function format($data) {

    if ( ! isset( $data['type'] ) ) {
      throw new Exception( 'No type provided' );
    }

    return apply_filters('cs_remote_format_' . $data['type'], $data['type'], isset($data['args']) ? $data['args'] : array() );

  }

  public function query_builder_posts( $result, $args ) {
    list( $types, $in, $ids) = $args;

    $type_names = [];

    foreach( $types as $type ) {
      $post_type_obj = get_post_type_object( $type );
      $type_names[$type] = $post_type_obj->labels->singular_name;
    }

    $formatted_types = implode( ', ', array_values( $type_names ) );

    if ( is_array( $ids ) && count($ids) > 0) {

      $posts = get_posts( [
        'post__in' => array_map(function($id) {
          return (int) $id;
        }, $ids )
      ]);

      $names = [];

      foreach ($posts as $post) {
        $names[] = $post->post_title;
      }

      if (empty($names)) {
        return $formatted_types;
      }

      $content = implode(', ', $names );
      return $in ? sprintf( '%s / %s', $formatted_types, $content ) : sprintf( '%s / NOT: %s', $formatted_types, $content );
    }

    return $formatted_types;
  }

  public function query_builder_terms( $result, $args ) {
    list($in, $ids) = $args;

    $term_ids = array_map(function($id) {
      $split = explode('|', $id);
      return (int) array_pop($split);
    }, $ids );


    $terms = get_terms( [
      'include' => $term_ids
    ]);

    $names = [];

    if ( ! is_wp_error( $terms ) ) {
      foreach ($terms as $term) {
        $names[] = $term->name;
      }
    }

    if (empty($names)) {
      return csi18n('app.edit');
    }

    $content = implode(', ', $names );
    return $in === 'true' ? $content : sprintf( 'NOT: %s', $content );

  }

  public function query_builder_authors( $result, $args ) {
    list($in, $ids) = $args;

    $users = get_users( [
      'include' => $ids
    ]);

    $names = [];

    foreach ($users as $user) {
      $names[] = $user->user_login;
    }

    if (empty($names)) {
      return csi18n('app.edit');
    }

    $content = implode(', ', $names );
    return $in === 'true' ? $content : sprintf( 'NOT: %s', $content );

  }


}
