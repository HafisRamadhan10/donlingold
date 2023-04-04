<?php

class Cornerstone_Looper_Provider_Terms extends Cornerstone_Looper_Provider_Array {

  public function get_array_items( $element ) {
    return get_the_terms( get_the_ID(), $element['looper_provider_terms_tax']);
  }

}
