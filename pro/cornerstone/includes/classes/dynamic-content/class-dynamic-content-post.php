<?php

class Cornerstone_Dynamic_Content_Post extends Cornerstone_Plugin_Component {

  public function setup() {
    add_filter( 'cs_dynamic_content_post', array( $this, 'supply_field' ), 10, 3 );
    add_action( 'cs_dynamic_content_setup', array( $this, 'register' ) );
    add_filter( 'cs_dynamic_options_postmeta', array( $this, 'populate_postmeta' ), 10, 2 );
  }

  public function register() {

    cornerstone_dynamic_content_register_group(array(
      'name'  => 'post',
      'label' => csi18n('app.dc.group-title-post')
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'title',
      'group' => 'post',
      'label' => csi18n('app.dc.title'),
      'controls' => array( 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'excerpt',
      'group' => 'post',
      'label' => 'Excerpt',
      'controls' => array( 'post', array(
        'key'     => 'length',
        'type'    => 'text',
        'label'   => csi18n('app.dc.length'),
        'options' => array( 'placeholder' => 'e.g. 25' )
      ) )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'featured_image_id',
      'group' => 'post',
      'type'  => 'image',
      'label' => 'Featured Image',
      'controls' => array( 'post' ),
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'featured_image',
      'group' => 'post',
      'type'  => 'image',
      'label' => 'Featured Image URL',
      'controls' => array( 'post' ),
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'publish_date',
      'group' => 'post',
      'label' => 'Publish Date',
      'controls' => array( 'date-format', 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'publish_time',
      'group' => 'post',
      'label' => 'Publish Time',
      'controls' => array( 'time-format', 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'modified_date',
      'group' => 'post',
      'label' => 'Modified Date',
      'controls' => array( 'date-format', 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'modified_time',
      'group' => 'post',
      'label' => 'Modified Time',
      'controls' => array( 'time-format', 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'comment_count',
      'group' => 'post',
      'label' => 'Comment Count',
      'controls' => array( 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'comment_link',
      'group' => 'post',
      'label' => 'Comment Link',
      'controls' => array( 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'permalink',
      'group' => 'post',
      'label' => 'Permalink',
      'controls' => array( 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'post_type',
      'group' => 'post',
      'label' => 'Post Type Name',
      'controls' => array( 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'post_type_plural',
      'group' => 'post',
      'label' => 'Post Type Name Plural',
      'controls' => array( 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'post_type_url',
      'group' => 'post',
      'label' => 'Post Type URL',
      'controls' => array( 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'meta',
      'group' => 'post',
      'type'  => 'mixed',
      'label' => 'Meta (Custom Field)',
      'controls' => array( 'post', 'postmeta' ),
      'deep' => true
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'classes',
      'group' => 'post',
      'label' => 'Classes'
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'id_attribute',
      'group' => 'post',
      'label' => 'ID (Attribute)'
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'id',
      'group' => 'post',
      'label' => 'ID (Numeric)'
    ));

  }

  public function supply_field( $result, $field, $args = array() ) {

    $current_post = CS()->component('Dynamic_Content')->get_contextual_post( $args );

    if (!$current_post) {
      return $result;
    }

    global $post;

    $different_post = $post->ID !== $current_post->ID;
    $original_post = $post;

    if ( $different_post ) {  
      $post = $current_post;
      setup_postdata( $post );
    }
    
    switch ($field) {
      case 'the_content':
        ob_start();
        the_content();
        $result = ob_get_clean();
        break;
      case 'title':
        $result = get_the_title( $post );
        break;
      case 'excerpt':
        $excerpt_length_handler = function() use ( $args ) { return $args['length']; };
        add_filter( 'excerpt_more', '__return_empty_string', 1000 );

        $has_wpautop = has_filter( 'the_excerpt', 'wpautop' );

        if ( $has_wpautop ) {
          remove_filter( 'the_excerpt', 'wpautop' );
        }

        if (isset( $args['length'] ) ) {
          add_filter( 'excerpt_length', $excerpt_length_handler, 1000 );
        }

        ob_start();
        the_excerpt();
        $result = ob_get_clean();

        if ( $has_wpautop ) {
          add_filter( 'the_excerpt', 'wpautop' );
        }

        remove_filter( 'excerpt_more', '__return_empty_string', 1000 );
        if ( isset( $args['length'] ) ) {
          remove_filter( 'excerpt_length', $excerpt_length_handler, 1000 );
          $result = $result ? wp_trim_words( $result, $args['length'], '' ) : '';
        }
        break;
      case 'featured_image':
        $source = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'full' );
        $result = $source && isset($source[0]) ? $source[0] : '';
        break;
      case 'featured_image_id':
        $id = get_post_thumbnail_id( $post );
        $size = isset( $args['size'] ) ? $args['size'] : 'full';
        $result = $id ? "$id:$size" : '';
        break;
      case 'publish_date':
        $result = get_the_date( isset( $args['format'] ) ? $args['format'] : get_option('date_format'), $post->ID );
        break;
      case 'publish_time':
        $result = get_the_time( isset( $args['format'] ) ? $args['format'] : get_option('time_format  '), $post->ID );
        break;
      case 'modified_date':
        $result = get_the_modified_date( isset( $args['format'] ) ? $args['format'] : get_option('date_format'), $post->ID );
        break;
      case 'modified_time':
        $result = get_the_modified_time( isset( $args['format'] ) ? $args['format'] : get_option('time_format'), $post->ID );
        break;
      case 'comment_count':
        $result = (string) get_comments_number( $post->ID );
        break;
      case 'comment_link':
        $result = (string) get_comments_link( $post->ID );
        break;
      case 'permalink':
        $result = get_permalink( $post );
        break;
      case 'post_type':
      case 'post_type_plural':

        $post_type_obj = get_post_type_object($post->post_type);

        if ($post_type_obj) {
          if ($field === 'post_type') {
            $result = $post_type_obj->labels->singular_name;
          }

          if ($field === 'post_type_plural') {
            $result = $post_type_obj->labels->name;
          }
        }

        break;
      case 'post_type_url':
        $result = get_post_type_archive_link( $post->post_type );
        break;
      case 'meta':
      case 'custom_field':
        if ( isset( $args['key'] ) ) {
          $key = $args['key'];
          $result = get_post_meta( $post->ID, $args['key'], true );
          $result = apply_filters( 'cs_format_dynamic_content_post_meta', $result, $key );
        }
        break;
      case 'id':
        $result = "$post->ID";
        break;
      case 'id_attribute':
        $result = "post-$post->ID";
        break;
      case 'classes':
        $result = esc_attr( join( ' ', get_post_class('', $post->ID ) ) );
        break;
    }

    if ( $different_post ) {  
      $post = $original_post;
      setup_postdata( $post );
    }

    return $result;
  }

  public function get_postmeta_keys( $post_id ) {
    
    global $wpdb;

    $query = "SELECT DISTINCT $wpdb->postmeta.meta_key FROM $wpdb->postmeta";
    
    if ( $post_id ) {
      $query = $wpdb->prepare( "SELECT DISTINCT $wpdb->postmeta.meta_key, $wpdb->postmeta.meta_value FROM $wpdb->postmeta WHERE post_id = %d", $post_id );
    }
    
    return $wpdb->get_results( $query, ARRAY_N );
  }


  public function populate_postmeta( $options, $args = array() ) {
    
    $results = $this->get_postmeta_keys( isset( $args['context'] ) && isset( $args['context']['post'] ) ? $args['context']['post'] : null );

    foreach ($results as $result) {
      list( $key, $value ) = $result;
      $options[] = array( 'label' => $value ? sprintf( '%s - %s', $key, substr( $value, 0, 55 ) ) : $key, 'value' => $key );
    }

    return $options;

  }

}
