<?php

namespace Themeco\Cornerstone\Elements;

class BreakpointData {

  public function setElement( $element, $defaultValues = [] ) {
    $this->element = $element;
    $this->defaultValues = $defaultValues;
    $base = explode('_', $this->element['_bp_base']);
    $this->base = $base[0];
    $this->size = $base[1];
    $this->bpKey = $this->makeBpKey($this->base, $this->size);
    $this->queryValues = isset($element[$this->bpKey]) ? $element[$this->bpKey] : null;
    return $this;
  }

  public function makeBpKey($base, $size) {
    return '_bp_data' . $base . '_' . $size;
  }

  public function convertTo( $newBase, $newSize ) {

    if ( is_array( $this->queryValues ) ) {

      $keys = array_keys($this->queryValues);

      foreach ( $keys as $key ) {
        $this->convertKeyTo( $key, (int) $newBase, (int) $newSize );
      }

      unset($this->element[$this->bpKey]);

    }

    $this->element['_bp_base'] = $newBase . '_' . $newSize;
    return $this->element;

  }

  public function convertKeyTo( $key, $newBase, $newSize) {
    $newBreakpointKey = $this->makeBpKey( $newBase, $newSize);

    if ( !isset( $this->element[$newBreakpointKey] ) ) {
      $this->element[$newBreakpointKey] = [];
    }

    // Take the current inheriting values and get a fully populated array
		$expanded = $this->expandValues($key);

    // Adapt the values to the size of the new bp configuration
		$newQueryValues = $this->adaptNewSize( $expanded, $newBase, $newSize );

    // streamline the array removing values that would be inherited
    list ($newBaseValue, $newBreakPointValues) = $this->streamline($newQueryValues, $newBase, $newSize );
    $this->element[$key] = $newBaseValue;
    if (isset($this->defaultValues[$key]) && $this->element[$key] === $this->defaultValues[$key][0]) {
      unset($this->element[$key]);
    }
    $this->element[$newBreakpointKey][$key] = $newBreakPointValues;
  }

  public function makeNullArray($size) {
    $items = [];
    for ( $i = 0; $i <= $size; $i++) {
      $items[] = null;
    }
    return $items;
  }

  // return an array the size of the current base config with all the values fully expanded
  public function expandValues($key) {
    $base = isset( $this->element[$key] ) ? $this->element[$key] : $this->defaultValues[$key][0];
    $queryValues = $this->queryValues[$key];

    $expanded = $this->makeNullArray($this->size);

    $prev = $base;
    for ( $i = $this->base; $i <= $this->size; $i++) {
      if ( ! is_null( $queryValues[$i] ) ) {
        $prev = $queryValues[$i];
      }
      $expanded[$i] = $prev;
    }

    $prev = $base;
    for ( $i = $this->base; $i >= 0; $i--) {
      if ( ! is_null( $queryValues[$i] ) ) {
        $prev = $queryValues[$i];
      }
      $expanded[$i] = $prev;
    }

    return $expanded;
  }

  public function adaptNewSize( $values, $newBase, $newSize ) {

    // the last value will always be our desktop value

    $desktopValue = $values[count($values) - 1];

    $newValues = [];

    for ($i=0; $i <= $newSize; $i++) {
      if (!empty($values)) {
        $newValues[] = array_shift($values); // copy the previous values into the new array
      } else {
        $newValues[] = $desktopValue; // fill remaining spots with desktop value
      }
    }

    $newValues[count($newValues) - 1] = $desktopValue; // overwrite the final value with the desktop value

    return $newValues;
  }

  // Take an expanded list and streamline it to a set of inheriting  values
  public function streamline( $expanded, $toBase, $newSize ) {

    $streamlined = $this->makeNullArray($newSize);

    $prev = $expanded[$toBase];
    for ( $i = $toBase + 1; $i <= $newSize; $i++) {
      if ($prev !== $expanded[$i]) {
        $streamlined[$i] = $expanded[$i];
        $prev = $expanded[$i];
      }
    }

    $prev = $expanded[$toBase];
    for ( $i = $toBase - 1; $i >= 0; $i--) {
      if ($prev !== $expanded[$i]) {
        $streamlined[$i] = $expanded[$i];
        $prev = $expanded[$i];
      }
    }

    return [$expanded[$toBase], $streamlined ];
  }



}