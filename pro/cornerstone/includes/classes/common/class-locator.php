  <?php

class Cornerstone_Locator extends Cornerstone_Plugin_Component {

  protected $limit;

  public function setup() {
    $this->limit = apply_filters( 'cs_locator_limit', 50 );
  }

  public function get_limit() {
    return $this->limit;
  }

  public function get_post_types() {

    if (!isset($this->post_types)) {
      $this->post_types = array_merge([
        'page' => get_post_type_object('page'),
        'post' => get_post_type_object('post'),
      ], get_post_types(array(
        'show_ui' => true,
        '_builtin' => false
      ), 'objects'));
    }

    return $this->post_types;
  }

  public function get_post_type_names() {
    return array_map(function($post_type) {
      return $post_type->name;
    }, $this->get_post_types());
  }

  public function get_taxonomies() {

    if (!isset($this->taxonomies)) {
      $this->taxonomies = get_taxonomies( [ 'public' => true ], 'objects' );
    }

    return $this->taxonomies;
  }

  public function get_taxonomies_names() {
    return array_map(function($taxonomy) {
      return $taxonomy->name;
    }, $this->get_taxonomies());
  }


  public function find_posts( $data ) {

    $post_type = isset($data['post_types']) ? $data['post_types'] : $this->get_post_type_names();

    $args = [
      'post_status' => isset($data['post_status']) ? $data['post_status'] : 'any',
      'post_type' => $post_type,
      'posts_per_page' => $this->limit,
      'orderby' => isset($data['orderby']) ? $data['orderby'] : 'title',
      'order' => isset($data['order']) && $data['order'] === 'desc' ? 'DESC' : 'ASC',
      'cs_all_wpml' => true
    ];

    if (isset( $data['find'] ) ) {
      return get_posts( array_merge( $args, [
        'posts_per_page' => 1,
        'post__in' => [ $data['find'] ]
      ] ) );
    }

    $disallowed_ids = cs_get_disallowed_ids();

    if (count($disallowed_ids) > 0) {
      $args['post__not_in'] = $disallowed_ids;
    }

    if (isset($data['search'])) {
      $args['s'] = $data['search'];
    }

    if (isset($data['cursor'])) {
      $args['offset'] = $data['cursor'] * $this->limit;
    }

    return get_posts( $args );
  }

  public function find_terms( $data ) {

    $taxonomy = isset($data['taxonomies']) ? $data['taxonomies'] : $this->get_taxonomies_names();

    if (empty( $taxonomy)) {
      return [];
    }

    $args = [
      'number'   => $this->limit,
      'taxonomy' => $taxonomy,
      'hide_empty' => false
    ];

    if (isset( $data['find'] ) ) {
      return get_terms( array_merge( $args, [
        'number' => 1,
        'include' => [ $data['find'] ]
      ] ) );
    }

    if (isset($data['search'])) {
      $args['search'] = $data['search'];
    }

    if (isset($data['cursor'])) {
      $args['offset'] = $data['cursor'] * $this->limit;
    }

    $result = get_terms($args);

    if (is_wp_error($result)) {
      return [];
    }

    return $result;
  }

  public function find_users( $data ) {

    $args = [
      'number' => $this->limit,
      'fields' => [ 'ID', 'display_name', 'user_login' ]
    ];

    if (isset( $data['find'] ) ) {
      return get_users( array_merge( $args, [
        'number' => 1,
        'include' => [ $data['find'] ]
      ] ) );
    }

    if (isset($data['search'])) {
      $args['search'] = $data['search'];
    }

    if (isset($data['cursor'])) {
      $args['offset'] = $data['cursor'] * $this->limit;
    }

    $result = get_users($args);

    if (is_wp_error($result)) {
      return [];
    }

    return $result;
  }

  public function query( $data ) {

    if (isset($data['query']) ) {
      $args = explode( ':', $data['query']);
      $type = array_shift($args);

      switch ( $type ) {
        case 'user' :
          return $this->query_user( $data, $args );
        case 'posts' :
          return $this->query_posts( $data, $args );
        case 'terms' :
          return $this->query_terms( $data, $args );
        case 'taxonomy-terms' :
          return $this->query_taxonomy_terms( $data, $args );
      }

    }

    return [];

  }

  public function query_user( $data, $args = null ) {
    //  $args[0] === 'all'
    $find_args = $data;
    return array_values( array_map( [$this, 'transform_user'], $this->find_users( $find_args ) ) );
  }

  public function query_posts( $data, $args = null ) {

    $find_args = is_null($args) || $args[0] === 'all' ? $data : array_merge( $data, [
      'post_types' => [ $args[0] ]
    ] );

    return array_values( array_map( [$this, 'transform_post'], $this->find_posts( $find_args ) ) );

  }

  public function query_terms( $data, $args = null ) {

    $find_args = is_null($args) || $args[0] === 'all' ? $data : array_merge( $data, [
      'taxonomies' => [ $args[0] ]
    ] );

    return array_values( array_map( [$this, 'transform_term'], $this->find_terms( $find_args ) ) );
  }

  public function query_taxonomy_terms( $data, $args = null ) {

    $find_args = is_null($args) || $args[0] === 'all' ? $data : array_merge( $data, [
      'taxonomies' => [ $args[0] ]
    ] );

    if (isset($find_args['find'])) {
      list($taxonomy, $term_id) = explode('|',$find_args['find']);
      $find_args['find'] = $term_id;
    }

    return array_values( array_map( [$this, 'transform_taxonomy_term'], $this->find_terms( $find_args ) ) );
  }

  public function transform_user( $user ) {
    return [
      'id' => $user->ID,
      'title' => sprintf(_x('%s (%s)', 'User Display Name (User Login)', '__x__'), $user->display_name, $user->user_login )
    ];
  }

  protected function resolve_post_parent_title( $post ) {
    if ( $post->post_parent ) {
      $parent = get_post( $post->post_parent );
      if ($parent) {
        return $parent->post_title;
      }
    }
    return null;
  }

  protected function resolve_term_parent_name( $term ) {
    if ( $term->parent ) {
      $parent = get_term( $term->parent );
      if ($parent) {
        return $parent->name;
      }
    }
    return null;
  }

  public function get_entity($post) {
    switch ($post->post_type) {
      case 'cs_header':
        return new Cornerstone_Header($post);
      case 'cs_footer':
        return new Cornerstone_Footer($post);
      case 'cs_layout':
        return new Cornerstone_Layout($post);
      default:
        return null;
    }
  }

  public function get_entity_meta( $entity ) {
    $settings = $entity->get_settings();

    return [
      'layoutType' => $settings['layout_type'],
      'assignmentLabel' => $this->get_entity_assignment( $settings )
    ];
  }

  public function get_entity_assignment( $settings ) {


    if (isset($settings['assignments'])) {
      if (1 === count($settings['assignments']) ) {
        return $this->plugin->component('Conditionals')->identify_assignment($settings['assignments'][0]);
      }

      if (1 < count($settings['assignments']) ) {
        return csi18n('app.assign.multiple');
      }

    }
    return csi18n('app.assign.unassigned');
  }

  public function transform_post( $post ) {
    $post_type_obj = get_post_type_object( $post->post_type );


    $data = [

      // Common Fields
      // -------------

      'id'          => $post->ID,
      'title'       => $post->post_title,
      'typeLabel'   => isset( $post_type_obj->labels ) ? $post_type_obj->labels->singular_name : $post->post_type,
      'url'         => get_permalink( $post ),
      'parentTitle' => $this->resolve_post_parent_title( $post ),

      // Post Fields
      // -------------

      'modified'    => date_i18n( get_option( 'date_format' ), strtotime( $post->post_modified ) ),
      'language'    => $this->plugin->component('Wpml')->get_language_data( $post->ID, $post->post_type ),
      'postStatus'  => $post->post_status,
      'postType'    => $post->post_type,
      'postName'    => $post->post_name,
    ];

    $entity = $this->get_entity( $post );

    if (is_a($entity, 'Cornerstone_Regions_Entity')) {
      return array_merge( $data, $this->get_entity_meta( $entity ) );
    }

    return $data;

  }

  public function transform_term( $term ) {

    $taxonomy_obj = get_taxonomy( $term->taxonomy );

    return [

      // Common Fields
      // -------------

      'id'          => $term->term_id,
      'title'       => $term->name,
      'typeLabel'   => $taxonomy_obj->labels->singular_name,
      'url'         => get_term_link( $term ),
      'parentTitle' => $this->resolve_term_parent_name( $term ),

      // Term Fields
      // -------------

      'taxonomy'    => $term->taxonomy,
    ];

  }

  public function transform_taxonomy_term( $term ) {

    $taxonomy_obj = get_taxonomy( $term->taxonomy );

    return [

      // Common Fields
      // -------------

      'id'          => $term->taxonomy . '|' . $term->term_id,
      'title'       => $term->name,
      'typeLabel'   => $taxonomy_obj->labels->singular_name,
      'url'         => get_term_link( $term ),
      'parentTitle' => $this->resolve_term_parent_name( $term ),

      // Term Fields
      // -------------

      'taxonomy'    => $term->taxonomy,
    ];

  }

  public function get_post_type_options() {

    if (!isset( $this->post_type_options ) ) {

      $post_types = $this->get_post_types();

      $this->post_type_options = [];

      foreach ($post_types as $post_type => $post_type_obj) {
        $this->post_type_options[] = ['value' => $post_type, 'label' => $post_type_obj->labels->singular_name];
      }
    }

    return $this->post_type_options;

  }

  public function get_taxonomy_options() {

    if (!isset( $this->taxonomy_options ) ) {

      $this->taxonomy_options = array_map(function($taxonomy) {
        return ['value' => $taxonomy->name, 'label' => $taxonomy->label];
      }, array_values( $this->get_taxonomies() ) );

    }

    return $this->taxonomy_options;

  }

  public function get_orderby_options() {
    return array(
      array( 'value' => 'date',          'label' => __( 'Date', '__x__' )              ),
      array( 'value' => 'modified',      'label' => __( 'Modified Date', '__x__' )     ),
      array( 'value' => 'title',         'label' => __( 'Title', '__x__' )             ),
      array( 'value' => 'name',          'label' => __( 'Slug', '__x__' )              ),
      array( 'value' => 'type',          'label' => __( 'Post Type', '__x__' )         ),
      array( 'value' => 'ID',            'label' => __( 'ID', '__x__' )                ),
      array( 'value' => 'parent',        'label' => __( 'Parent ID', '__x__' )         ),
      array( 'value' => 'rand',          'label' => __( 'Random', '__x__' )            ),
      array( 'value' => 'comment_count', 'label' => __( 'Comment Count', '__x__' )     ),
      array( 'value' => 'menu_order',    'label' => __( 'Page Order (Menu)', '__x__' ) ),
    );
  }

}
