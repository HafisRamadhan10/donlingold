<?php

namespace Themeco\Cornerstone\Elements;

use Themeco\Cornerstone\Util\MapCache;

class Decorator extends MapCache {

  protected $types = [];
  protected $current_id;
  protected $tss;

  public function setElementManager($manager) {
    $this->elementManager = $manager;
  }

  public function decorate( $entity_id, $elements ) {
    $this->types = [];
    return [$this->decorateElements( $entity_id, $elements ), $this->types];
  }

  public function decoratePreviewElement($element, $parent = null ) {

    if ( isset( $element['id'] ) ) {
      $element['id'] = $this->formatPreviewProp('id', $element['id']);
    }

    if ( isset( $element['class'] ) ) {
      $element['class'] = $this->formatPreviewProp('class', $element['class']);
    }



    if ( isset( $element['toggle_hash'] ) ) {
      $element['toggle_hash'] = $this->formatPreviewProp('toggle_hash', $element['toggle_hash']);
    }

    // END

    return $element;
  }

  public function decorateElements( $entity_id, $elements, $parent = null, $offscreen = '', $depth = 0 ) {

    $decorated = [];
    if ( !$offscreen && is_array( $parent ) ) {
      $definition = $this->elementManager->get_element( $parent['_type'] );
      if ( $definition->has_offscreen_dropzone() ) {
        $offscreen = $parent['_type'];
      }
    }

    foreach ($elements as $index => $undecorated) {

      try {
        $element = $this->decorateElement($entity_id, $undecorated, $parent);

        if ( !in_array( $element['_type'], $this->types ) ) {
          $this->types[] = $element['_type'];
        }

        $depth_increase = $element['_type'] === 'root' ? 0 : 1;

        $element['_depth'] = $depth;
        $element['_order'] = $index;
        $element['_offscreen'] = $offscreen;

        if ( isset( $element['_modules'] ) && is_array($element['_modules'] ) ) {
          $element['_modules'] = $this->decorateElements( $entity_id, $element['_modules'], $element, $offscreen, $depth + $depth_increase );
        } else {
          $element['_modules'] = [];
        }

        $decorated[] = $element;
      } catch (\Exception $e) {
        trigger_error( $e->getMessage(), E_USER_WARNING);
      }

    }

    return $decorated;
  }

  public function decorateElement( $entity_id, $element, $parent = null ) {

    if ( ! isset( $element['_type'] ) ) {
      throw new \Exception('Can not decorate element without _type: ' . $entity_id);
    }

    if ( $element['_type'] !== 'root' && ! isset( $element['_region'] ) ) {
      throw new \Exception('Can not decorate element without _region: ' . $entity_id . '| ' . $element['_type']);
    }


    if ( ! isset( $element['_modules'] ) ) {
      $element['_modules'] = [];
    }

    if ( ! isset( $element['classes'] ) ) {
      $element['classes'] = [];
    }

    $definition = $this->elementManager->get_element( $element['_type'] );
    $element = $definition->apply_defaults( $element );

    $element['_p'] = $entity_id;
    $unique_id = $entity_id . '-' . $element['_id'];
    $element['style_id'] = 'e' . $unique_id;
    $element['unique_id'] = 'e' . $unique_id;

    if ( isset($element['legacy_region_detect']) ) {
      $element['legacy_tbf_detect'] = $element['legacy_region_detect'] && ( $element['_region'] === 'top' || $element['_region'] === 'bottom' || $element['_region'] === 'footer' );
    }

    if ( ! empty( $element['hide_bp'] ) ) {
      $hide_bps = explode( ' ', trim($element['hide_bp']) );
      foreach ( $hide_bps as $bp ) {
        if ( $bp == 'none' ) {
          continue;
        }
        $element['class'] .= ' x-hide-' . $bp;
      }
    }

    // Allow shadow elements to get parent keys (e.g. V2 Accordion)
    if ( ! is_null( $parent ) && $definition->shadow_parent() ) {

      $element['p_style_id'] = $parent['style_id'];
      $element['p_unique_id'] = $parent['unique_id'];

      foreach ($parent as $key => $value) {
        if ( ! isset( $element[$key] ) ) {
          $element[$key] = $value;
        }
      }

      $element['_parent_data'] = $parent;
    }

    return $element;

  }

  // This functions allows preview values to update instantly via React props
  // while waiting for the server's next response

  public function formatPreviewProp( $key, $value ) {
    // should check for DC and shortcodes and return the value in those cases
    return "{%%{data.$key}%%}";
  }

  public function usePreviewProp() {
    return apply_filters( 'cs_is_preview', false ) && ! apply_filters( 'cs_render_looper_is_virtual', false );
  }

  public function previewProp( $key, $value ) {
    return $this->usePreviewProp() ? $this->formatPreviewProp( $key, $value ) : $value;
  }

  public function previewProps( $keys, $data ) {
    if ( $this->usePreviewProp() ) {
      foreach ($keys as $key) {
        $data[$key] = $this->formatPreviewProp($key, $data[$key]);
      }
    }
    return $data;
  }

}