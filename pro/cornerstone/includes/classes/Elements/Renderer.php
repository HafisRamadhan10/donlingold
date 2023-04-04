<?php

namespace Themeco\Cornerstone\Elements;

use Themeco\Cornerstone\Plugin;

class Renderer {

  public function setElementManager($manager) {
    $this->elementManager = $manager;
  }

  public function setElementDecorator($decorator) {
    $this->elementDecorator = $decorator;
  }

  public function start() {
    $this->childrenSetup( [$this, 'renderElements'] );
    return $this;
  }

  public function renderRegion( $elements, $echo = true ) {
    ob_start();
    $this->renderElements( $elements );
    $result = cs_expand_content( ob_get_clean() );
    if ( $echo ) {
      echo $result;
    }
    return $result;
  }

  public function deferRenderRegions( $regions, $hooks = []) {
    foreach( $regions as $region ) {
      if ( isset( $hooks[ $region['_region'] ] ) ) {
        cs_action_defer( $hooks[ $region['_region'] ], [$this, 'renderRegion'], [ $region['_modules'] ], 10, true );
      }
    }
  }


  function inLinkSetup( $parent ) {

    if ( empty( $parent ) || ! isset( $parent['_type'] ) || apply_filters( 'cs_in_link', false ) ) {
      return false;
    }

    $in_link = cs_get_element( $parent['_type'] )->will_render_link( $parent );

    if ($in_link) {
      add_filter( 'cs_in_link', '__return_true' );
    }

    return $in_link;

  }

  function inLinkTeardown( $is_setup ) {
    if ( $is_setup ) {
      remove_filter( 'cs_in_link', '__return_true' );
    }
  }

  public function renderElement( $element ) {
    return $this->elementManager->get_element( $element['_type'] )->render( $element );
  }

  public function renderElements($elements, $parent = null) {

    $in_link = $this->inLinkSetup( $parent );

    if ( is_array( $elements ) && count( $elements ) > 0 ) {
      foreach ( $elements as $element ) {
        echo $this->renderElement( $element );
      }
    } else {
      if ($parent) {
        $parent_definition = $this->elementManager->get_element($parent['_type']);
        if (isset($parent_definition->def['options']['fallback_content'] ) ) {
          echo $parent_definition->def['options']['fallback_content'];
        }
      }
    }

    $this->inLinkTeardown( $in_link );

  }

  public function childrenSetup( $callback ) {
    add_action('x_render_children', $callback, 10, 2 );

    $definitions = $this->elementManager->get_all_elements();
    foreach ($definitions  as $name => $definition) {
      $hook = $definition->get_children_hook();
      if ($hook) {
        add_action( $hook, $callback, 10, 2 );
      }
    }
  }

  public function childrenTeardown( $callback ) {
    remove_action('x_render_children', $callback, 10, 2 );
    $definitions = $this->elementManager->get_all_elements();
    foreach ($definitions as $name => $definition) {
      $hook = $definition->get_children_hook();
      if ($hook) {
        remove_action( $hook, $callback );
      }
    }
  }

  public function childrenOverrideStart( $callback ) {
    $this->childrenTeardown( [$this, 'renderElements'] );
    $this->childrenSetup( $callback );
  }

  public function childrenOverrideStop( $callback ) {
    $this->childrenTeardown( $callback );
    $this->childrenSetup( [$this, 'renderElements'] );
  }

}