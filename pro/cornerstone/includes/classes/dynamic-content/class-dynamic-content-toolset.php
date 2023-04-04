<?php

class Cornerstone_Dynamic_Content_Toolset extends Cornerstone_Plugin_Component {

  public function setup() {
    add_filter( 'cs_dynamic_content_toolset', array( $this, 'supply_field' ), 10, 3 );
    add_action( 'cs_dynamic_content_setup', array( $this, 'register' ) );
    add_filter( 'cs_dynamic_options_toolset', array( $this, 'populate_fields' ), 10, 2 );
  }

  public function register() {
    cornerstone_dynamic_content_register_group(array(
      'name'  => 'toolset',
      'label' => csi18n('app.dc.group-title-toolset')
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'field',
      'group' => 'toolset',
      'type'  => 'mixed',
      'label' => csi18n('app.dc.field'),
      'controls' => array( 'post', 'toolset-field' ),
      'deep' => true
    ));

  }

  public function supply_field( $result, $field, $args = array() ) {

    $post = CS()->component('Dynamic_Content')->get_contextual_post( $args );

    if (!$post) {
      return $result;
    }

    if ( 'field' === $field && isset($args['field']) ) {
      if ( function_exists('wpcf_shortcode') ) {
        $result = wpcf_shortcode( array_merge( $args, array(
          'id' => $post->ID,
          'raw' => true
        ) ) );
      } else if ( function_exists('types_render_postmeta') ) {
        $result = types_render_postmeta( $args['field'], array_merge( $args, array(
          'post_id' => $post->ID,
          'output' => 'raw'
        ) ) );
      }

    }

    return $result;
  }

  public function populate_fields( $options, $args = array() ) {

    if ( defined('WPCF_EMBEDDED_ABSPATH') &&
      isset( $args['context'] ) &&
      isset( $args['context']['post'] ) &&
      $args['context']['post']
    ) {

      if( !function_exists( 'wpcf_admin_post_get_post_groups_fields') ) {
        include_once( WPCF_EMBEDDED_ABSPATH . '/includes/fields-post.php' );
      }

      $groups = wpcf_admin_post_get_post_groups_fields(get_post($args['context']['post']));

      if ( is_array( $groups ) ) {
        foreach ($groups as $group) {
          if ( ! isset( $group['name'] ) ) {
            continue;
          }
          foreach ($group['fields'] as $value => $field ) {
            if ( isset( $field['name'] ) ) {
              $label = implode(' - ', array( $group['name'], $field['name']));
              $options[] = array( 'label' => $label, 'value' => $value );
            }
          }
        }
      }

    }

    return $options;

  }

}
