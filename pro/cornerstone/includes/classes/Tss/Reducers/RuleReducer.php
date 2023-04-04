<?php

namespace Themeco\Cornerstone\Tss\Reducers;

class RuleReducer {

  // this class should accept an input of nested properties, style rules and @ rules.
  // it should boil down to a single list of qualified properties

  public function reduce( $input ) {


    $reduced = $this->reduceRule([
      [],
      $input
    ], [ '$m' ]);

    return $this->qualify($reduced);
  }

  public function reduceRule( $input, $parentSelectors = [] ) {
    list($selectors, $content) = $input;

    $normalizedContent = is_null( $content ) ? [] : $content;
    $mergedSelectors = $this->mergeSelectors( $parentSelectors, $selectors );

    $reduced = [
      [$mergedSelectors, isset( $normalizedContent['properties']) ? $normalizedContent['properties']: []]
    ];

    if (isset( $normalizedContent['styleRules'])) {
      foreach ($normalizedContent['styleRules'] as $styleRule) {
        $reduced = array_merge( $reduced, $this->reduceRule( $styleRule, $mergedSelectors));
      }
    }

    return $reduced;

  }

  public function mergeSelectors( $parent, $child ) {
    $combined = [];

    if (empty($parent)) {
      return $child;
    }

    if (empty($child)) {
      return $parent;
    }

    foreach ($parent as $p) {
      foreach ($child as $c) {
        $combined[] = $this->combineSelectors($p, $c);
      }
    }

    return array_unique( $combined );
  }

  public function combineSelectors($parent, $child) {
    if (strpos($child, '&') !== false) {
      return str_replace( '&', $parent, $child);
    }
    return "$parent $child";
  }


  public function qualify($input) {
    $qualified = [];

    foreach($input as $ruleSet) {
      list ($selectors, $properties) = $ruleSet;

      sort($selectors);
      $qualifiedSelector = implode(',', $selectors);
      foreach($properties as $property => $value) {
        if (! is_null($property) && $property !== '') {
          $qualifiedKey = "$property::$qualifiedSelector";
          $qualified[$qualifiedKey] = [$value, $property, $qualifiedSelector];
        }

      }
    }

    return $qualified;
  }
}
