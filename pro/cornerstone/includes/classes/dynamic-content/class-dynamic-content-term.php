<?php

class Cornerstone_Dynamic_Content_Term extends Cornerstone_Plugin_Component {

  public function setup() {
    add_filter('cs_dynamic_content_term', array( $this, 'supply_field' ), 10, 3 );
    add_filter('cs_dynamic_content_archive', array( $this, 'supply_field' ), 10, 3 );
    add_action('cs_dynamic_content_setup', array( $this, 'register' ) );
  }

  public function register() {

    //
    // Term
    //

    cornerstone_dynamic_content_register_group(array(
      'name'  => 'term',
      'label' => csi18n('app.dc.group-title-term')
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'name',
      'group' => 'term',
      'label' => csi18n('app.dc.name'),
      'controls' => array( 'term' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'slug',
      'group' => 'term',
      'label' => csi18n('app.dc.slug'),
      'controls' => array( 'term' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'description',
      'group' => 'term',
      'label' => csi18n('app.dc.description'),
      'controls' => array( 'term' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'url',
      'group' => 'term',
      'label' => csi18n('app.dc.url'),
      'controls' => array( 'term' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'count',
      'group' => 'term',
      'label' => csi18n('app.dc.count'),
      'controls' => array( 'term' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'meta',
      'group' => 'term',
      'type'  => 'mixed',
      'label' => csi18n('app.dc.meta'),
      'controls' => array(
        'term',
        array(
          'key' => 'key',
          'type' => 'text',
          'label' => csi18n('app.dc.key'),
          'options' => array( 'placeholder' => csi18n('app.dc.meta-key') )
        )
      ),
      'deep' => true
    ));


    //
    // Archive
    //

    cornerstone_dynamic_content_register_group(array(
      'name'  => 'archive',
      'label' => csi18n('app.dc.group-title-archive')
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'name',
      'group' => 'archive',
      'label' => csi18n('app.dc.name'),
      'controls' => array( 'term' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'slug',
      'group' => 'archive',
      'label' => csi18n('app.dc.slug'),
      'controls' => array( 'term' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'description',
      'group' => 'archive',
      'label' => csi18n('app.dc.description'),
      'controls' => array( 'term' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'url',
      'group' => 'archive',
      'label' => csi18n('app.dc.url'),
      'controls' => array( 'term' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'count',
      'group' => 'archive',
      'label' => csi18n('app.dc.count'),
      'controls' => array( 'term' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'meta',
      'group' => 'archive',
      'type'  => 'mixed',
      'label' => csi18n('app.dc.meta'),
      'controls' => array(
        'term',
        array(
          'key' => 'key',
          'type' => 'text',
          'label' => csi18n('app.dc.key'),
          'options' => array( 'placeholder' => csi18n('app.dc.meta-key') )
        )
      ),
      'deep' => true
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'id',
      'group' => 'archive',
      'label' => csi18n('app.dc.id'),
      'controls' => array( 'term' )
    ));

  }

  public function supply_field( $result, $field, $args = array() ) {

    $term = CS()->component('Dynamic_Content')->get_contextual_term( $args );

    if ( ! is_a( $term, 'WP_Term') ) {
      return $result;
    }

    switch ( $field ) {
      case 'title':  // deprecated
      case 'name': {
        $result = $term->name;
        break;
      }
      case 'slug': {
        $result = $term->slug;
        break;
      }
      case 'description': {
        $result = $term->description;
        break;
      }
      case 'count': {
        $result = $term->count;
        break;
      }
      case 'url': {
        $result = get_term_link( $term );
        break;
      }
      case 'meta': {
        if ( isset( $args['key'] ) ) {
          $result = get_term_meta( $term->term_id, $args['key'], true );
        }
        break;
      }
      case 'id': {
        $result = "$term->term_id";
        break;
      }
    }

    return $result;
  }
}
