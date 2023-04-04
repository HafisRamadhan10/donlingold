<?php

namespace Themeco\Cornerstone\Services;

use Themeco\Cornerstone\Plugin;

class Breakpoints implements Service {

  protected $ranges;
  public function breakpointConfig() {
    $ranges = $this->breakpointRanges();
    return [
      $this->breakpointBase(),
      array_merge([0], $ranges), // px range values
      count($ranges)
    ];
  }

  public function breakpointBase() {
    return (int) apply_filters( 'cs_breakpoint_base', 0 );
  }

  public function breakpointRanges() {
    if ( ! isset( $this->ranges ) ) {
      $this->ranges = array_map('intval', apply_filters( 'cs_breakpoint_ranges', array_slice( $this->defaultRanges(), 0, 2) ));
    }
    return $this->ranges;
  }

  public function activeBreakpointRanges() {
    $ranges = $this->breakpointRanges();
    return $this->rangeInfo()[count($ranges) - 1];
  }

  public function activeBreakpointRangeKeys() {
    return array_map( function( $item ) {
      return $item['tag'];
    }, $this->activeBreakpointRanges());
  }

  public function defaultRanges() {
    return [ 480, 767, 979, 1200 ];
  }

  public function rangeInfo() {
    $sizes = $this->defaultRanges();
    return [
      [
        [ 'label' => 'Small', 'tag' => 'xs', 'default' => null ],
        [ 'label' => 'Large', 'tag' => 'xl', 'default' => $sizes[0]  ],
      ],
      [
        [ 'label' => 'Small',  'tag' => 'xs', 'default' => null ],
        [ 'label' => 'Medium', 'tag' => 'md', 'default' => $sizes[0]  ],
        [ 'label' => 'Large',  'tag' => 'xl', 'default' => $sizes[2]  ],
      ],
      [
        [ 'label' => 'Extra Small', 'tag' => 'xs', 'default' => null ],
        [ 'label' => 'Small',       'tag' => 'sm', 'default' => $sizes[0] ],
        [ 'label' => 'Medium',      'tag' => 'md', 'default' => $sizes[2] ],
        [ 'label' => 'Large',       'tag' => 'xl', 'default' => $sizes[3] ],
      ],
      [
        [ 'label' => 'Extra Small', 'tag' => 'xs', 'default' => null ],
        [ 'label' => 'Small',       'tag' => 'sm', 'default' => $sizes[0] ],
        [ 'label' => 'Medium',      'tag' => 'md', 'default' => $sizes[1] ],
        [ 'label' => 'Large',       'tag' => 'lg', 'default' => $sizes[2] ],
        [ 'label' => 'Extra Large', 'tag' => 'xl', 'default' => $sizes[3] ],
      ]
    ];
  }

  public function appData() {
    return [
      'config' => $this->breakpointConfig(),
      'controlRanges' => array_merge([0], $this->defaultRanges() ),
      'rangeInfo' => $this->rangeInfo()
    ];
  }

}