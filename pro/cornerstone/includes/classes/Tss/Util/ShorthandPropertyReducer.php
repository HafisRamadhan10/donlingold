<?php

namespace Themeco\Cornerstone\Tss\Util;

use Themeco\Cornerstone\Tss\Typed;

class ShorthandPropertyReducer {

  const PROPERTIES = [
    'border'              => 'propBorder',
    'border-block-end'    => 'propBorderBlockEnd',
    'border-block-start'  => 'propBorderBlockStart',
    'border-bottom'       => 'propBorderBottom',
    'border-color'        => 'propBorderColor',
    'border-inline-end'   => 'propBorderInlineEnd',
    'border-inline-start' => 'propBorderInlineStart',
    'border-left'         => 'propBorderLeft',
    'border-radius'       => 'propBorderRadius',
    'border-right'        => 'propBorderRight',
    'border-style'        => 'propBorderStyle',
    'border-top'          => 'propBorderTop',
    'border-width'        => 'propBorderWidth',
    'flex'                => 'propFlex',
    'flex-flow'           => 'propFlexFlow',
    'gap'                 => 'propGap',
    'grid-column'         => 'propGridColumn',
    'grid-row'            => 'propGridRow',
    'margin'              => 'propMargin',
    'outline'             => 'propOutline',
    'overflow'            => 'propOverflow',
    'padding'             => 'propPadding',
    'place-content'       => 'propPlaceContent',
    'place-items'         => 'propPlaceItems',
    'place-self'          => 'propPlaceSelf',
    'scroll-margin'       => 'propScrollMargin',
    'scroll-padding'      => 'propScrollPadding',
  ];

  const ORDER_AMBIGUOUS = [
    'animation',
    'background',
    'border-image',
    'column-rule',
    'columns',
    'font',
    'grid',
    'grid-area',
    'grid-template',
    'list-style',
    'mask',
    'offset',
    'text-emphasis',
    'transition'
  ];

  const NOT_IMPLEMENTED = [
    'text-decoration'
  ];

  const BORDER_STYLES = [
    'none',
    'hidden',
    'dotted',
    'dashed',
    'solid',
    'double',
    'groove',
    'ridge',
    'inset',
    'outset'
  ];

  public function has($key) {
    return isset( self::PROPERTIES[$key] );
  }

  public function reduce($key, $value, $properties = []) {
    $input = is_array( $value ) ? $value : [ $value ];
    if (isset( self::PROPERTIES[$key] )) {
      $result = $this->{self::PROPERTIES[$key]}($input, $properties);
      foreach ($result as $key => $value) {
        if ($value === 'qs') {
          unset($result[$key]);
        }
      }
      return $result;
    }
    $properties[$key] = $input;
    return $properties;
  }

  public function optionalPair($first, $optional, $input, $result) {
    $result[$first] = $input[0];
    $result[$optional] = count($input) === 2 ? $input[1] : $input[0];
    return $result;
  }

  public function p( $side, $before = '', $after = '' ) {
    if ($before) $side = "$before-$side";
    if ($after) $side = "$side-$after";
    return $side;
  }

  public function box( $before, $after, $input, $result ) {

    if (empty($input)) {
      return $result;
    }

    switch (count($input)) {
      case 1:
        $result[$this->p('top', $before, $after)] = $input[0];
        $result[$this->p('right', $before, $after)] = $input[0];
        $result[$this->p('bottom', $before, $after)] = $input[0];
        $result[$this->p('left', $before, $after)] = $input[0];
        break;
      case 2:
        $result[$this->p('top', $before, $after)] = $input[0];
        $result[$this->p('right', $before, $after)] = $input[1];
        $result[$this->p('bottom', $before, $after)] = $input[0];
        $result[$this->p('left', $before, $after)] = $input[1];
        break;
      case 3:
        $result[$this->p('top', $before, $after)] = $input[0];
        $result[$this->p('right', $before, $after)] = $input[1];
        $result[$this->p('bottom', $before, $after)] = $input[2];
        $result[$this->p('left', $before, $after)] = $input[1];
        break;
      default:
        $result[$this->p('top', $before, $after)] = $input[0];
        $result[$this->p('right', $before, $after)] = $input[1];
        $result[$this->p('bottom', $before, $after)] = $input[2];
        $result[$this->p('left', $before, $after)] = $input[3];
        break;
    }
    return $result;
  }

  public function borderGroup( $side, $input, $result ) {
    if (count($input) == 3) {
      $result[$this->p($side, 'border', 'width')] = $input[0];
      $result[$this->p($side, 'border', 'style')] = $input[1];
      $result[$this->p($side, 'border', 'color')] = $input[2];
    } else {
      $result['border-' . $side] = implode( ' ', $input );
    }

    return $result;

  }

  public function propBorder($input, $result) {

    if (count($input) === 3) {
      return $this->borderGroup( 'top', $input, $this->borderGroup( 'right', $input, $this->borderGroup( 'bottom', $input, $this->borderGroup( 'left', $input, $result ) ) ) );
    }

    $result['border'] = implode( ' ', $input );
    return $result;
  }

  public function propBorderBlockEnd($input, $result) {
    return $this->borderGroup('block-end', $input, $result);
  }

  public function propBorderBlockStart($input, $result) {
    return $this->borderGroup('block-start', $input, $result);
  }

  public function propBorderBottom($input, $result) {
    return $this->borderGroup('bottom', $input, $result);
  }

  public function propBorderColor($input, $result) {
    return $this->box( 'border', 'color', $input, $result );
    return $result;
  }

  public function propBorderInlineEnd($input, $result) {
    return $this->borderGroup('inline-end', $input, $result);
  }

  public function propBorderInlineStart($input, $result) {
    return $this->borderGroup('inline-start', $input, $result);
  }

  public function propBorderLeft($input, $result) {
    return $this->borderGroup('left', $input, $result);
  }

  public function borderRadiusSplit($input, $combined) {
    if ( count($input) === 1 ) {
      $combined['border-top-left-radius'][]     = $input[0];
      $combined['border-top-right-radius'][]    = $input[0];
      $combined['border-bottom-right-radius'][] = $input[0];
      $combined['border-bottom-left-radius'][]  = $input[0];
    } else if ( count($input) === 2 ) {
      $combined['border-top-left-radius'][]     = $input[0];
      $combined['border-top-right-radius'][]    = $input[1];
      $combined['border-bottom-right-radius'][] = $input[0];
      $combined['border-bottom-left-radius'][]  = $input[1];
    } else if ( count($input) === 3 ) {
      $combined['border-top-left-radius'][]     = $input[0];
      $combined['border-top-right-radius'][]    = $input[1];
      $combined['border-bottom-right-radius'][] = $input[2];
      $combined['border-bottom-left-radius'][]  = $input[1];
    } else if ( count($input) === 4 ){
      $combined['border-top-left-radius'][]     = $input[0];
      $combined['border-top-right-radius'][]    = $input[1];
      $combined['border-bottom-right-radius'][] = $input[2];
      $combined['border-bottom-left-radius'][]  = $input[3];
    }
    return $combined;
  }
  public function propBorderRadius($input, $result) {

    if ( empty( $input ) ) {
      return $result;
    }

    $combined = [
      'border-top-left-radius' => [],
      'border-top-right-radius' => [],
      'border-bottom-right-radius' => [],
      'border-bottom-left-radius' => [],
    ];

    if ( $input[0] === 'split') {
      $combined = $this->borderRadiusSplit( $input[2], $this->borderRadiusSplit( $input[1], $combined));
    } else {
      $combined = $this->borderRadiusSplit( $input, $combined );
    }

    foreach ($combined as $key => $value) {
      $result[$key] = implode(' ', $value);
    }

    return $result;
  }

  public function propBorderRight($input, $result) {
    return $this->borderGroup('right', $input, $result);
  }

  public function propBorderStyle($input, $result) {
    return $this->box( 'border', 'style', $input, $result );
  }

  public function propBorderTop($input, $result) {
    return $this->borderGroup('top', $input, $result);
  }

  public function propBorderWidth($input, $result) {
    return $this->box( 'border', 'width', $input, $result );
  }

  public function propFlex($input, $result) {
    if (count($input) == 3) {
      $result['flex-grow']   = $input[0];
      $result['flex-shrink'] = $input[1];
      $result['flex-basis']  = $input[2];
    } else {
      $result['flex'] = implode( ' ', $input );
    }

    return $result;
  }

  public function propFlexFlow($input, $result) {
    if (count($input) == 2) {
      $result['flex-direction'] = $input[0];
      $result['flex-wrap']      = $input[1];
    } else {
      $result['flex-flow'] = implode( ' ', $input );
    }

    return $result;
  }

  public function propGap($input, $result) {
    return $this->optionalPair('row-gap', 'column-gap', $input, $result );
  }

  public function propGridColumn($input, $result) {

    if ( $input[0] === 'split') {
      $result['grid-column-start'] = implode( ' ', $input[1]);
      $result['grid-column-end'] = implode( ' ', $input[2]);
    } else {
      $result['grid-column-start'] = implode( ' ', $input);
      $result['grid-column-end'] = 'auto';
    }

    return $result;
  }

  public function propGridRow($input, $result) {
    if ( $input[0] === 'split') {
      $result['grid-row-start'] = implode( ' ', $input[1]);
      $result['grid-row-end'] = implode( ' ', $input[2]);
    } else {
      $result['grid-row-start'] = implode( ' ', $input);
      $result['grid-row-end'] = 'auto';
    }
    return $result;
  }

  public function propMargin($input, $result) {
    return $this->box( 'margin', '', $input, $result );
  }

  public function propOutline($input, $result) {
    if (count($input) == 3) {
      $result['outline-width'] = $input[0];
      $result['outline-style'] = $input[1];
      $result['outline-color'] = $input[2];
    } else {
      $result['outline'] = implode( ' ', $input );
    }

    return $result;
  }

  public function propOverflow($input, $result) {
    return $this->optionalPair('overflow-x', 'overflow-y', $input, $result );
  }

  public function propPadding($input, $result) {
    return $this->box( 'padding', '', $input, $result );
  }

  public function propPlaceContent($input, $result) {
    return $this->optionalPair('align-content', 'justify-content', $input, $result );
  }

  public function propPlaceItems($input, $result) {
    return $this->optionalPair('align-items', 'justify-items', $input, $result );
  }

  public function propPlaceSelf($input, $result) {
    return $this->optionalPair('align-self', 'justify-self', $input, $result );
  }

  public function propScrollMargin($input, $result) {
    return $this->box( 'scroll-margin', '', $input, $result );
  }

  public function propScrollPadding($input, $result) {
    return $this->box( 'scroll-padding', '', $input, $result );
  }

}