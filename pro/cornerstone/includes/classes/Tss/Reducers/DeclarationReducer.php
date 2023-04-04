<?php

namespace Themeco\Cornerstone\Tss\Reducers;

class DeclarationReducer {

  protected $maxThreshold = -0.02;

  public function reduce($declarations, $baseBreakpoint, $ranges, $selectorPrefix) {


    $_prefix = is_string( $selectorPrefix ) ? trim($selectorPrefix) . ' ' : '';

    $tiers = [];

    $priorities = [];

    foreach($declarations as $declaration) {
      list($value, $property, $selector, $minMax) = $declaration;
      $_selector = $_prefix . $selector;
      list($priority, $mq) = $this->resolveMediaQuery( $minMax, $baseBreakpoint, $ranges );
      if ( !isset( $tiers[$mq] ) ) {
        $priorities[$mq] = $priority;
        $tiers[$mq] = [];
      }
      if ( !isset( $tiers[$mq][$_selector] ) ) {
        $tiers[$mq][$_selector] = [];
      }
      $tiers[$mq][$_selector][$property] = $value;
    }

    $buffer = '';

    // SORT keys of $tiers based on priority
    uksort($tiers, function($a, $b) use ($priorities){
      if ($priorities[$a] == $priorities[$b]) {
        return 0;
      }
      return ($priorities[$a] < $priorities[$b]) ? -1: 1;
    });

    foreach( $tiers as $q => $styles) {

      $rules = '';

      foreach ($styles as $selector => $props) {
        $style = '';
        foreach ($props as $prop => $value) {
          if (! is_null($value) && $value !== '') {
            $style .= "$prop:$value;";
          }
        }
        if($style) {
          $rules .= $selector . '{' . $style . '}';
        }

      }

      if ($q === 'root') {
        $buffer .= $rules;
      } else {
        $buffer .= $q . '{' . $rules . '}';
      }

    }

    // echo '<pre>';
    // var_dump($buffer);
    // echo '</pre>';
    return $buffer;

  }

  public function distanceFromBase($base, $number) {
    if ($number > $base) return $number - $base;
    if ($number < $base) return $base - $number;
    return 0;
  }

  // Return a media query and priority based on its distance from the base
  public function resolveMediaQuery( $minMax, $baseBreakpoint, $ranges ) {

    list($min, $max) = $minMax;

    if ( is_null( $min ) && is_null( $max ) ) {
      return [-1, 'root'];
    }

    if ( is_null( $min ) ) {
      $maxw = $this->floatToStr( $ranges[$max] + $this->maxThreshold );
      return [$this->distanceFromBase( $baseBreakpoint, $max ), "@media screen and (max-width: {$maxw}px)"];
    }

    if ( is_null( $max ) ) {
      $minw = $this->floatToStr( $ranges[$min] );
      return [$this->distanceFromBase( $baseBreakpoint, $min ), "@media screen and (min-width: {$minw}px)"];
    }

    $maxw = $minw = $this->floatToStr( $ranges[$max] + $this->maxThreshold );
    $minw = $minw = $this->floatToStr( $ranges[$min] );
    $direction = $min < $baseBreakpoint ? -1 : 1;
    return [$this->distanceFromBase( $baseBreakpoint, $min ) + 0.5 * $direction,"@media screen and (min-width: {$minw}px) and (max-width: {$maxw}px)"];

  }

  // prevent other locale number formats from effecting CSS output
  function floatToStr( $float ) {
    $locale = localeconv();
    $string = strval( $float );
    $string = str_replace( $locale['decimal_point'], '.', $string );
    return $string;
  }
}