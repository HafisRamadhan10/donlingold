<?php

class Cornerstone_Looper_Provider_String extends Cornerstone_Looper_Provider_Array {

  public function get_array_items( $element ) {
    $content = cs_dynamic_content( $element['looper_provider_string_content'] );
    if ( $element['looper_provider_string_delim'] ) {
      return explode( $element['looper_provider_string_delim'], $content );
    } else {
      return str_split( $content );
    }
  }

}
