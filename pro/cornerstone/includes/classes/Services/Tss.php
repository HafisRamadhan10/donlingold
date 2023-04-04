<?php

namespace Themeco\Cornerstone\Services;

use Themeco\Cornerstone\Util\ErrorHandler;
use Themeco\Cornerstone\Util\PostMetaCache;
use Themeco\Cornerstone\Tss\Environment;
use Themeco\Cornerstone\Plugin;

class Tss implements Service {

  protected $plugin;
  protected $env;
  protected $entityStyleCache;
  protected $containerStore = [];
  protected $registered = [];

  public function __construct(Plugin $plugin, Styling $styling, Breakpoints $breakpoints, Environment $env, PostMetaCache $entityStyleCache, ErrorHandler $errorHandler) {
    $this->plugin = $plugin;
    $this->env = $env;
    $this->breakpoints = $breakpoints;
    $this->stylingService = $styling;
    $this->entityStyleCache = $entityStyleCache;
    $this->errorHandler = $errorHandler;
  }

  public function setElementManager($manager) {
    $this->elementManager = $manager;
  }

  public function init() {

    $this->entityStyleCache->setup('_cs_generated_tss', function(){
      return apply_filters('cs_disable_style_cache', false );
    });

    list($base, $ranges) = $this->breakpoints->breakpointConfig();
    $this->env()->configureBreakpoints($base, $ranges);
    $this->env()->configure( 'selectorPrefix', $this->getSelectorPrefix() );
    $this->import('elements-base');

  }

  public function env() {
    return $this->env;
  }

  public function read($name) {
    ob_start();
    include $this->plugin->path . "/assets/tss/$name.php";
    return ob_get_clean();
  }

  public function import($dep) {
    $this->errorHandler->start();
    $this->env()->import($dep, $this->read($dep));
    $this->errorHandler->stop();
    $this->errorHandler->flush();
  }

  public function registerEntity( $id, $stylePriority, $elementData ) {

    if ( isset( $this->registered[$id] ) ) {
      return;
    }

    $this->registered[$id] = true;

    $entityStyles = $this->entityStyleCache->resolve( $id, function() use ($id, $elementData){
      list( $elements, $types ) = $elementData;

      $element_css = [];
      // For each element type being used, register it's configuration into a container
      foreach ($types as $type) {
        $this->registerElementType( $type );
      }

      // Create a runtime scoped to the entity ID
      $runtime = $this->env()->runtime($id);

      // Process all the elements using their registered container
      $process = function($element) use (&$process, &$element_css, $runtime) {

        $def = $this->elementManager->get_element( $element['_type'] );
        $preprocessed = $def->preprocess_tss( $element );

        if ( isset( $preprocessed['css'] ) && $preprocessed['css'] ) {
          $element_css[] = str_replace('$el', '.' . $preprocessed['style_id'], $preprocessed['css']);
          unset( $preprocessed['css'] );
        }

        $runtime->process( "el:" . $element['_id'], "el:" . $element['_type'], $preprocessed );

        if (isset($element['_modules'])) {
          array_map($process, $element['_modules']);
        }
      };

      array_map($process, $elements);

      // Finalize the output so it can be stored in the cache
      $container = $runtime->finalize();

      return array_merge( $container, [
        'element_css' => implode(' ', $element_css)
      ]);

    });

    // Make the output available to other systems
    $this->containerStore['c:' .$id] = $entityStyles['containers'];

    $this->stylingService->addStyles( $id . '-generated', $entityStyles['tss'], $stylePriority );
    $this->stylingService->addStyles( $id . '-element-css', $entityStyles['element_css'], $stylePriority + 1 );

  }

  public function registerElementType( $type ) {
    $this->registerType( "el:$type", $this->elementManager->get_element( $type )->get_tss_config());
  }

  public function processPreviewElement( $element ) {
    $runtime = $this->env()->runtime($element['_id']);
    $container_type = "el:" . $element['_type'];
    $container_key = "el:" . $element['_id'];
    $runtime->process( "el:" . $element['_id'], "el:" . $element['_type'], $element );
    $result = $runtime->finalize();
    $this->containerStore['c:' . $element['_id'] ] = $result['containers'];
    return $result['tss'];
  }

  public function registerType( $type, $config ) {

    $deps = $config->deps();
    foreach( $deps as $dep) {
      if (is_string($dep)) {
        $this->import($dep);
      }
    }

    $this->env()->registerType( $type, $config);
  }

  public function getContainer($entityId, $itemId) {

    if ( ! isset( $this->containerStore['c:' .$entityId] ) ) {
      return [];
    }

    $entity = $this->containerStore['c:' .$entityId];
    return isset( $entity["el:" . $itemId] ) ?  $entity["el:" . $itemId] : [];
  }

  public function getSelectorPrefix() {
    $prefixes = apply_filters('cs_tss_selector_prefixes', ['#cs-content', '#cs-footer']);
    if (count($prefixes) > 0) {
      return sprintf(":is(%s) ", implode(', ', $prefixes ) );
    }
    return '';
  }

  public function previewConfig() {
    return [
      'prefixes' => $this->getSelectorPrefix(),
    ];
  }

  public function applyTssToElement( $element ) {

    // When previewing, each element gets a dedicated container. Otherwise use the current entityId
    $parent_managing_child = apply_filters( 'cs_is_element_parent_render', false );
    $is_element_preview = apply_filters( 'cs_is_element_preview', false); // a real element is being rendered
    $is_looper_virtual = apply_filters( 'cs_render_looper_is_virtual', false ) && apply_filters( 'cs_is_preview_render', false ); // we are in a preview request but it is a virtual looper item
    $rendering_global_block = apply_filters( '_cs_rendering_global_block', false );
    $use_preview_container = ! $rendering_global_block && $is_element_preview || $is_looper_virtual || $parent_managing_child;

    if ( $parent_managing_child && $rendering_global_block ) { // fixes GB shortcode not previewing in tabs
      $use_preview_container = false;
    }

    return $this->applyElementContainer( $element, $this->getContainer( $use_preview_container? $element['_id'] : $element['_p'], $element['_id'] ) );
  }

  public function applyElementContainer( $element, $container ) {

    $element['_tss'] = [];
    $element['_tss_style'] = '';

    $modules = $this->elementManager->get_element( $element['_type'] )->get_tss_config()->modules();

    $element['classes'][] = $element['style_id'];


    if (! empty($container) && ! empty( $modules ) ) {

      foreach( $container as $key => $value) {
        if ($key === 'dynamic-content') {
          $element['_tss_style'] = $this->applyDynamicContentStyle( $value );
        } else {
          $element['_tss'][$key] = implode(' ', $value);
        }

      }

      foreach( $modules as $module) {
        if ( isset( $container[$module['class-key']] ) ) {
          if ( ! isset( $element['_tss'][$module['class-key']] ) ) {
            $element['_tss'][$module['class-key']] = '';
          }
          if (!$module['nested']) {
            $element['classes'][] = implode(' ', $container[$module['class-key']]);
          }
        }
      }

    }


    if ( ! isset($element['style']) ) {
      $element['style'] = '';
    }


    $element['style'] = $element['_tss_style'] . $element['style'];

    if ( isset($element['class']) && $element['class'] && ! in_array( $element['class'], $element['classes'] ) ) {
      $element['classes'][] = $element['class'];
    }

    return $element;

  }

  public function applyDynamicContentStyle( $items ) {
    $styles = [];

    foreach ($items as $id => $dc) {
      $styles[] = '--tco-' . $id . ':' . cs_dynamic_content( $dc );
    }
    $styles_str = implode(';', $styles);
    return $styles_str ? $styles_str . ';' : '';
  }

}
