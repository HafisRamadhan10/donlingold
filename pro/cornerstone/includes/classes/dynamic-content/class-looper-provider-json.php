<?php

class Cornerstone_Looper_Provider_Json extends Cornerstone_Looper_Provider_Array {

  public function get_array_items( $element ) {
    
    // If the JSON is immediately valid, dynamic content will not be run until the fields are accessed 
    $items = json_decode( $element['looper_provider_json'], true );
    
    // If the JSON isn't valid, run the string through dynamic content to see if the user is supplying a field that returns valid JSON.
    // If we get valid JSON, the fields will still be parsed when fields are accessed
    if ( is_null( $items ) ) {
      
      $decoded = json_decode( cs_dynamic_content( $element['looper_provider_json'] ), true );
      
      if ( is_null( $decoded ) ) {
        return new WP_Error('cs-loopers', 'Unable to decode JSON');
      }

      return $decoded;

    }

    return $items;
  }

}
