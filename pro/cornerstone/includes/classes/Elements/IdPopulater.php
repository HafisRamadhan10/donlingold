<?php

namespace Themeco\Cornerstone\Elements;

class IdPopulater {

  public function populate( $elements ) {
    $counter = 0;
    return array_filter(array_map(function( $element ) use (&$counter) {
      if (!isset($element['_region'])) {
        return null;
      }
      $region = $element['_region'];
      $mapper = function($element) use ($region, &$mapper, &$counter) {
        $element['_id'] = $counter++;
        $element['_region'] = $region;
        if ( isset( $element['_modules'] ) ) {
          $element['_modules'] = array_map($mapper, $element['_modules']);
        }
        return $element;
      };
      return $mapper($element);
    }, $elements));
  }

}