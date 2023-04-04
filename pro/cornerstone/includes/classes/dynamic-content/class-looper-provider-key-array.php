<?php

// This class is for the "Array" type in the Looper Provider list
// It uses the key in looper_provider_key_array to access an array inside the current looper

class Cornerstone_Looper_Provider_Key_Array extends Cornerstone_Looper_Provider_Generic_Array {

  public function get_array_items( $element ) {

    if ( isset($element['looper_provider_key_array'])) {
      $data = $this->manager->get_current_data();
      if (!$element['looper_provider_key_array'] && is_array( $data )) {
        return $data;
      }
      $lookup = cs_get_path( $data, $element['looper_provider_key_array']);
      return is_null( $lookup ) ? [] : $lookup;
    }

    return [];

  }

}
