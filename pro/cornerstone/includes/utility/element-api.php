<?php

/**
 * Element Registration
 */

function cs_register_element( $type, $options ) {
  CS()->novus()->service('Elements')->manager()->register_element( $type, $options );
}

function cs_unregister_element( $name ) {
	CS()->novus()->service('Elements')->manager()->unregister_element( $name );
}

function cs_register_element_group( $name, $title ) {
  CS()->component( 'Element_Library' )->register_group( $name, $title);
}

function cs_register_prefab_element( $group, $name, $options ) {
  CS()->component( 'Element_Library' )->register_prefab_element( $group, $name, $options );
}

function cs_unregister_prefab_element( $group, $name ) {
	CS()->component( 'Element_Library' )->unregister_prefab_element( $group, $name );
}

function cs_register_component( $type, $options = [] ) {
  CS()->novus()->service('Elements')->manager()->register_component( $type, $options );
}

function cs_get_element( $name ) {
  return CS()->novus()->service('Elements')->manager()->get_element( $name );
}

/**
 * Controls
 */

function cs_control( $type, $key_prefix = '', $control = array() ) {
  return CS()->component( 'Element_Controls' )->control( $type, $key_prefix, $control );
}

/**
 * Settings
 */

function cs_remember( $key, $value ) {
  return CS()->component( 'Element_Registry' )->remember( $key, $value );
}

function cs_recall( $key, $args = [] ) {
  return CS()->component( 'Element_Registry' )->recall( $key, $args );
}

/**
 * Values
 */

function cs_value( $default = null, $designation = 'style', $protected = false ) {

  return [ $default, $designation, $protected ];

  // $value = array( 'default' => $default, 'designation' => $designation );

  // if ( $protected ) {
  //   $value['protected'] = true;
  // }

  // return $value;

}

function cs_values( $values, $key_prefix = '' ) {
  return CS()->component( 'Element_Registry' )->values( $values, $key_prefix );
}

function cs_define_values( $key, $values ) {
  return CS()->component( 'Element_Registry' )->define_values( $key, $values );
}

function cs_compose_values() {
  return CS()->component( 'Element_Registry' )->compose_values( func_get_args() );
}

// ARIA
// =============================================================================

function cs_make_aria_atts( $key_prefix, $aria, $id, $unique_id ) {

  $atts = array();
  $key_prefix  = ( ! empty( $key_prefix ) ) ? $key_prefix . '_' : '';

  if ( isset( $aria['controls'] ) ) {

    $the_id   = ( ! empty( $id ) ) ? $id : $unique_id;
    $the_type = '-' . $aria['controls'];

    $atts[$key_prefix . 'aria_controls'] = $the_id . $the_type;

  }

  if ( isset( $aria['expanded'] ) ) {
    $atts[$key_prefix . 'aria_expanded'] = $aria['expanded'];
  }

  if ( isset( $aria['selected'] ) ) {
    $atts[$key_prefix . 'aria_selected'] = $aria['selected'];
  }

  if ( isset( $aria['haspopup'] ) ) {
    $atts[$key_prefix . 'aria_haspopup'] = $aria['haspopup'];
  }

  if ( isset( $aria['label'] ) ) {
    $atts[$key_prefix . 'aria_label'] = $aria['label'];
  }

  if ( isset( $aria['labelledby'] ) ) {
    $atts[$key_prefix . 'aria_labelledby'] = $aria['labelledby'];
  }

  if ( isset( $aria['hidden'] ) ) {
    $atts[$key_prefix . 'aria_hidden'] = $aria['hidden'];
  }

  if ( isset( $aria['orientation'] ) ) {
    $atts[$key_prefix . 'aria_orientation'] = $aria['orientation'];
  }

  return $atts;

}


function cs_compose_controls() {
  return CS()->component( 'Element_Registry' )->compose_partials( func_get_args() );
}

function cs_register_control_partial( $name, $function ) {
  return CS()->component( 'Element_Registry' )->register_control_partial( $name, $function );
}


function cs_partial_controls( $name, $settings = array() ) {
  return CS()->component( 'Element_Registry' )->apply_control_partial( $name, $settings );
}




// Partial Data
// =============================================================================

function cs_without( $data, $keys ) {
  return array_diff_key( $data, array_flip( $keys ) );
}

function cs_extract( $data, $find = array(), $deprecated = true ) {

  // Notes
  // -----
  // 01. $find - (a) Returns $data with a beginning that matches
  //     the $key and (b) that $data is cleaned to reflect the $value as
  //     the new beginning so it can be passed on to the partial template.

  $extracted = array();

  foreach ( $find as $begins_with => $update_to ) {

    foreach ( $data as $key => $value ) {
      if ( 0 === strpos( $key, $begins_with )  ) { // 01

        if ( ! empty( $update_to ) ) {
          $key = $update_to . substr( $key, strlen( $begins_with ) );
        }

        $extracted[$key] = $value;

      }
    }
  }

  return $extracted;

}
