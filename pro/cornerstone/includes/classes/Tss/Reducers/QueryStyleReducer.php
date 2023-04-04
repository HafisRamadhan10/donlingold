<?php

namespace Themeco\Cornerstone\Tss\Reducers;

class QueryStyleReducer {

  protected $qualified = [];
  protected $grouped = [];

  // End result should be the original inputs combined with qualifiers for which breakpoints they will reside in
  public function reduce($baseBreakpoint, $baseData, $queryData) {
    $this->count = count($queryData);
    $this->baseBreakpoint = $baseBreakpoint;
    $this->baseData = $baseData;
    $this->queryData = $queryData;
    $this->group();
    $this->qualify();
    return $this->qualified;
  }

  public function group() {

    foreach ($this->baseData as $key => $value) {
      if (!isset($this->grouped[$key])) {
        $this->grouped[$key] = [];
        for ($i=0; $i < $this->count; $i++) {
          $this->grouped[$key][] = null;
        }
      }
      $this->grouped[$key][$this->baseBreakpoint] = $value;
    }


    foreach( $this->queryData as $index => $data) {
      foreach( $data as $key => $value) {
        if (!isset($this->grouped[$key])) {
          $this->grouped[$key] = [];
          for ($i=0; $i < $this->count; $i++) {
            $this->grouped[$key][] = null;
          }
        }
        $this->grouped[$key][$index] = $value;
      }
    }

  }

  public function qualify() {

    foreach ($this->grouped as $key => $values) {

      // Add the base values to our qualified rules with null min / max
      $baseValue = null;
      if (isset($values[$this->baseBreakpoint]) && ! empty( $values[$this->baseBreakpoint])) {
        $baseValue = $values[$this->baseBreakpoint];
        $baseValue[] = [null, null];
        $this->qualified[$key] = $baseValue;
      }

      if ($this->baseBreakpoint < $this->count - 1) {
        $changes = [];

        // Identify at which breakpoints the value changes (in both directions)
        $currentValue = is_null( $baseValue ) ? null : $baseValue;
        $previousValue = is_null( $baseValue ) ? null : $baseValue;

        for ($i=$this->baseBreakpoint + 1; $i < $this->count; $i++) {

          $valueAtIndex = $values[$i];
          $valueAtPrevIndex = $values[$i - 1];
          $currentValue = $values[$i] === null && ! is_null( $currentValue ) ? $currentValue : $values[$i];
          $previousValue = $values[$i - 1] === null ? $previousValue : $values[$i - 1];

          if ( is_null( $previousValue) || $currentValue[0] !== $previousValue[0] ) {
            if ( !is_null( $currentValue ) ) {
              $changes[] = [$i, $currentValue];
            }
          }
        }


        if (count($changes) > 0) {

          // Work inwards setting the min/max values
          $pre_qualifed = [];
          list($min, $value) = array_pop($changes);
          $value[] = [$min, null]; // final breakpoint has an outer bound of infinity
          $pre_qualifed[] = [$this->makeQualifier($min, null) . $key, $value];

          $max = $min;
          while(count($changes) > 0) {
            list($min, $value) = array_pop($changes);
            $value[] = [$min, $max];
            $pre_qualifed[] = [$this->makeQualifier($min, $max) . $key, $value];
            $max = $min;
          }

          // Work outwards to set final qualifed rules so they output in the correct order
          while (count($pre_qualifed) > 0) {
            list($qualifier, $rule) = array_pop($pre_qualifed);
            $this->qualified[$qualifier] = $rule;
          }
        }

      }

      if ($this->baseBreakpoint > 0) {

        $changes = [];

        $currentValue = is_null( $baseValue ) ? null : $baseValue;
        $previousValue = is_null( $baseValue ) ? null : $baseValue;

        for ($i=$this->baseBreakpoint - 1; $i >= 0; $i--) {
          $previousValue = $values[$i + 1] === null && ! is_null( $currentValue ) ? $previousValue : $values[$i + 1];
          $currentValue = $values[$i] === null ? $currentValue : $values[$i];

          if ( is_null( $previousValue) || $currentValue[0] !== $previousValue[0] ) {
            if ( !is_null( $currentValue ) ) {
              $changes[] = [$i + 1, $currentValue];
            }
          }

        }


        if (count($changes) > 0) {

          // Work inwards setting the min/max values
          $pre_qualifed = [];
          list($max, $value) = array_pop($changes);
          $value[] = [null, $max]; // final breakpoint has an outer bound of infinity
          $pre_qualifed[] = [$this->makeQualifier(null, $max) . $key, $value];

          $min = $max;
          while(count($changes) > 0) {
            list($max, $value) = array_pop($changes);
            $value[] = [$min, $max];
            $pre_qualifed[] = [$this->makeQualifier($min, $max) . $key, $value];
            $min = $max;
          }

          // Work outwards to set final qualifed rules so they output in the correct order
          while (count($pre_qualifed) > 0) {
            list($qualifier, $rule) = array_pop($pre_qualifed);
            $this->qualified[$qualifier] = $rule;
          }
        }

      }

    }

  }

  public function makeQualifier( $min, $max ) {
    if ( is_null( $min ) && is_null( $max ) ) {
      return '';
    }

    if ( is_null( $min ) ) {
      return "$max-::";
    }

    if ( is_null( $max ) ) {
      return "$min+::";
    }

    return "$min-$max::";

  }

}