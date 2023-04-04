<?php

class Cornerstone_Dynamic_Content_User extends Cornerstone_Plugin_Component {

  public function setup() {
    add_filter( 'cs_dynamic_content_user', array( $this, 'supply_user_field' ), 10, 3 );
    add_filter( 'cs_dynamic_content_author', array( $this, 'supply_author_field' ), 10, 3 );
    add_action( 'cs_dynamic_content_setup', array( $this, 'register' ) );
    add_filter( 'cs_dynamic_options_usermeta', array( $this, 'populate_usermeta' ), 10, 2 );
  }

  public function register() {

    //
    // User
    //

    cornerstone_dynamic_content_register_group(array(
      'name'  => 'user',
      'label' => csi18n( 'app.dc.group-title-user' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'display_name',
      'group' => 'user',
      'label' => csi18n( 'app.dc.user.display-name' ),
      'controls' => array( 'user' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'email',
      'group' => 'user',
      'label' => csi18n( 'app.dc.user.email-address' ),
      'controls' => array( 'user' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'gravatar',
      'group' => 'user',
      'type'  => 'image',
      'label' => csi18n( 'app.dc.user.gravatar-url' ),
      'controls' => array( 'user' ),
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'registration_date',
      'group' => 'user',
      'label' => csi18n( 'app.dc.user.registration-date' ),
      'controls' => array( 'date-format', 'user' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'registration_time',
      'group' => 'user',
      'label' => csi18n( 'app.dc.user.registration-time' ),
      'controls' => array( 'time-format', 'user' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'url',
      'group' => 'user',
      'label' => csi18n( 'app.dc.user.author-url' ),
      'controls' => array( 'user' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'website',
      'group' => 'user',
      'label' => csi18n( 'app.dc.user.website-url' ),
      'controls' => array( 'user' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'bio',
      'group' => 'user',
      'label' => csi18n( 'app.dc.user.bio' ),
      'controls' => array( 'user' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'meta',
      'group' => 'user',
      'type'  => 'mixed',
      'label' => csi18n( 'app.dc.user.usermeta' ),
      'controls' => array( 'user', 'usermeta' ),
      'deep' => true
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'id',
      'group' => 'user',
      'label' => csi18n('app.dc.id'),
      'controls' => array(
        'user'
      )
    ));

    //
    // Author
    //

    cornerstone_dynamic_content_register_group(array(
      'name'  => 'author',
      'label' => csi18n( 'app.dc.group-title-author' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'display_name',
      'group' => 'author',
      'label' => csi18n( 'app.dc.user.display-name' ),
      'controls' => array( 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'email',
      'group' => 'author',
      'label' => csi18n( 'app.dc.user.email-address' ),
      'controls' => array( 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'gravatar',
      'group' => 'author',
      'type'  => 'image',
      'label' => csi18n( 'app.dc.user.gravatar-url' ),
      'controls' => array( 'post' ),
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'registration_date',
      'group' => 'author',
      'label' => csi18n( 'app.dc.user.registration-date' ),
      'controls' => array( 'date-format', 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'registration_time',
      'group' => 'author',
      'label' => csi18n( 'app.dc.user.registration-time' ),
      'controls' => array( 'time-format', 'post' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'url',
      'group' => 'author',
      'label' => csi18n( 'app.dc.user.author-url' ),
      'controls' => array( 'user' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'website',
      'group' => 'author',
      'label' => csi18n( 'app.dc.user.website-url' ),
      'controls' => array( 'user' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'bio',
      'group' => 'author',
      'label' => csi18n( 'app.dc.user.bio' ),
      'controls' => array( 'user' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'meta',
      'group' => 'author',
      'type'  => 'mixed',
      'label' => csi18n( 'app.dc.user.usermeta' ),
      'controls' => array( 'post', 'usermeta' ),
      'deep' => true
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'id',
      'group' => 'author',
      'label' => csi18n('app.dc.id'),
      'controls' => array(
        'post'
      )
    ));
  }

  public function supply_user_field( $result, $field, $args) {
    return $this->supply_field(
      CS()->component('Dynamic_Content')->get_contextual_user( $args ),
      $result,
      $field,
      $args
    );
  }

  public function supply_author_field( $result, $field, $args) {
    return $this->supply_field(
      CS()->component('Dynamic_Content')->get_contextual_author( $args ),
      $result,
      $field,
      $args
    );
  }

  public function supply_field( $user, $result, $field, $args) {

    if ( ! is_a( $user, 'WP_User' ) ) {
      return $result;
    }

    switch ( $field ) {
      case 'display_name': {
        $result = $user->data->display_name;
        break;
      }
      case 'email': {
        $result = $user->data->user_email;
        break;
      }
      case 'avatar':
      case 'gravatar': {
        $result = get_avatar_url( $user->ID, $args );
        break;
      }
      case 'registration_date': {
        $result = date( isset( $args['format'] ) ? $args['format'] : get_option('date_format'), strtotime( $user->data->user_registered ) );
        break;
      }
      case 'registration_time': {
        $result = date( isset( $args['format'] ) ? $args['format'] : get_option('time_format'), strtotime( $user->data->user_registered ) );
        break;
      }
      case 'url': {
        $result = get_author_posts_url( $user->ID  );
        break;
      }
      case 'website': {
        $result = $user->get( 'user_url' );
        break;
      }
      case 'bio': {
        $result = $user->get( 'description' );
        break;
      }
      case 'meta': {
        if ( isset( $args['key'] ) ) {
          $result = $user->get( $args['key'] );
        }
        break;
      }
      case 'id': {
        $result = "{$user->data->ID}";
        break;
      }
    }

    return $result;

  }

  public function get_usermeta_keys( $user_id ) {
    
    global $wpdb;

    $query = "SELECT DISTINCT $wpdb->usermeta.meta_key FROM $wpdb->usermeta";
    
    if ( $user_id ) {
      $query = $wpdb->prepare( "SELECT DISTINCT $wpdb->usermeta.meta_key, $wpdb->usermeta.meta_value FROM $wpdb->usermeta WHERE user_id = %d", $user_id );
    }
    
    return $wpdb->get_results( $query, ARRAY_N );
  }


  public function populate_usermeta( $options, $args = array() ) {
    
    $results = $this->get_usermeta_keys( isset( $args['context'] ) && isset( $args['context']['user'] ) ? $args['context']['user'] : null );

    foreach ($results as $result) {
      list( $key, $value ) = $result;
      $options[] = array( 'label' => $value ? sprintf( '%s - %s', $key, substr( $value, 0, 55 ) ) : $key, 'value' => $key );
    }

    return $options;

  }

}
