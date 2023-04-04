<?php

class Cornerstone_Preview_Rendering extends Cornerstone_Plugin_Component {

  protected $elements = [];
  protected $portals = [];
  protected $tss = [];
  protected $inline_styling_handles = [];
  protected $is_element_preview = false;
  protected $is_element_parent_render = false;
  protected $the_content_stack = [];
  protected $target = [];

  public function render( $data, $is_initial = false ) {

    if ( ! isset( $data['rootElement'] ) ) {
      throw new Exception('render elements not specified');
    }

    if ( ! isset( $data['config'] ) || ! isset( $data['config']['regions'] ) || ! isset( $data['config']['entityId'] ) ) {
      throw new Exception('invalid config not specified');
    }

    if (is_singular() && have_posts()) {
      the_post();
    }

    if (isset( $data['config']['type']) && strpos($data['config']['type'], 'layout-archive') === 0 ){
      do_action('cs_preview_archive_setup');
    }

    $enqueue_extractor = $this->plugin->component( 'Enqueue_Extractor' );
    if (!$is_initial) {
      $enqueue_extractor->start();
    }

    $this->elementService = CS()->novus()->service('Elements');
    $this->tssService = CS()->novus()->service('Tss');
    $this->resume_preview(); // calls $this->setup_preview_containers();

    add_filter( 'cs_element_update_build_shortcode_content', array( $this, 'expand_dc_in_preview' ) );

    add_action( 'cs_preview_the_content_begin', array( $this, 'pause_preview' ) );
    add_action( 'cs_preview_the_content_end',   array( $this, 'resume_preview' ) );

    add_action( 'cs_styling_add_styles', array( $this, 'track_inline_styling_handles' ) );

    add_filter('cs_is_element_preview', [ $this, 'is_element_preview'] );
    add_filter('cs_is_element_parent_render', [ $this, 'is_element_parent_render'] );
    add_filter('cs_render_element_data', [$this, 'render_repeat']);

    add_filter( 'cs_defer_view', [ $this, 'capture_views'], 99999, 2);

    add_filter( 'cs_is_preview_render', '__return_true' );

    do_action( 'cs_element_rendering' );

    $flags = array_merge(
      [
        'elementConditions'  => 'allow',
        'forceScrollEffects' => 'none'
      ],
      isset( $data['flags'] ) ? $data['flags'] : []
    );

    if ( $flags['elementConditions'] === 'ignore' ) {
      add_filter( 'cs_preview_disable_element_conditions', '__return_true' );
    }

    if ( $flags['forceScrollEffects'] !== 'none' ) {
      add_filter( 'cs_preview_force_scroll_effects', function($force = '') use ($flags) {
        return $flags['forceScrollEffects'];
      } );
    }

    list($decorated, $types) = $this->elementService->decorator()->decorate(
      $data['config']['entityId'],
      [ $data['rootElement'] ]
    );

    foreach ($types as $type) {
      $this->tssService->registerElementType( $type );
    }

    $this->render_tss( $decorated[0] );
    $this->render_element( $decorated[0] );

    if (!$is_initial) {
      $enqueue_extractor->extract();
    }

    $result = array_merge(
      $this->finalize_elements( $flags ),
      $is_initial ? [] : [
        'scripts'  => $enqueue_extractor->get_scripts(),
        'styles'   => $enqueue_extractor->get_styles()
      ]
    );

    add_filter( 'cs_is_preview_render', '__return_false' );

    return $result;
  }

  public function finalize_elements( $flags ) {

    $elements = [];
    $markup = [];

    foreach ($this->elements as $id => $element) {

      $hidden = false;

      list( $type, $content, $inline_css, $context_ids ) = $element;

      $tss_shim = isset($this->tss[$id]) ? $this->tss[$id] : '';

      if ($content === '%%HIDDEN%%') {
        $content = '';
        $hidden = true;
      }

      if ( isset($this->portals[$id]) ) {
        $content .= $this->portals[$id];
      }

      $hash = md5($type . $content . json_encode( $flags ));
      $elements[$id] = [$type, $hash, $inline_css, $hidden, $context_ids, $tss_shim]; // remote.js
      $markup[$hash] = $content;

    }

    return [
      'elements' => $elements,
      'markup'   => $markup
    ];
  }

  public function render_tss( $data ) {
    $this->tss[$data['_id']] = $this->tssService->processPreviewElement( $data );

    foreach( $data['_modules'] as $element ) {
      $this->render_tss( $element );
    }
  }

  public function render_element( $data, $parent = null ) {

    $definition = $this->elementService->manager()->get_element( $data['_type'] );

    if ( in_array( $data['_type'], ['region', 'root'] ) ) {
      foreach( $data['_modules'] as $element ) {
        $this->render_element( $element, $data );
      }
      return;
    }

    $response = '';
    $this->inline_styling_handles = [];
    array_push($this->target, $data['_id']);

    $should_render_children = $definition->render_children();

    if ( $should_render_children ) {
      $this->is_element_parent_render = true;
      $this->teardown_preview_containers();
    }

    $response = cs_expand_content(
      $this->elementService->decorator()->decoratePreviewElement( $this->elementService->renderer()->renderElement( $data ), $parent )
    );

    if ($response === '%%HIDDEN%%') {
      if (isset($data['_modules'])) {
        foreach( $data['_modules'] as $element ) {
          $this->render_element( $element, $data );
        }
      }
    }

    $this->elements[$data['_id']] = [
      $data['_type'],
      $response,
      $this->get_inline_css(),
      $this->get_context_ids()
    ];

    if ( $should_render_children ) {
      $this->is_element_parent_render = false;
      $this->setup_preview_containers();
    }

    array_pop($this->target);

  }

  public function get_inline_css() {

    $inline_css = '';
    $styling = CS()->novus()->service('Styling');

    add_filter('cs_css_post_processing', '__return_false');

    foreach ($this->inline_styling_handles as $handle) {
      $inline_css .= $styling->processStyle( $handle ) . ' ';
    }

    remove_filter('cs_css_post_processing', '__return_false');

    return $inline_css;

  }

  public function get_context_ids() {
    $dc = $this->plugin->component('Dynamic_Content');

    $post = $dc->get_contextual_post();
    $term = $dc->get_contextual_term();
    $user = $dc->get_contextual_user();

    return [
      is_a( $post, 'WP_Post') ? $post->ID : null,
      is_a( $term, 'WP_Term') ? $term->term_id : null,
      is_a( $user, 'WP_User') ? $user->ID : null
    ];
  }

  public function is_element_preview() {
    return $this->is_element_preview;
  }

  public function is_element_parent_render() {
    return $this->is_element_parent_render;
  }

  public function pause_preview() {
    if ( empty( $this->the_content_stack ) ) {
      remove_filter( 'cs_is_preview', '__return_true' );
      $this->teardown_preview_containers();
    }
    array_push($this->the_content_stack, true);
  }

  public function resume_preview() {
    array_pop($this->the_content_stack);
    if ( empty( $this->the_content_stack ) ) {
      add_filter( 'cs_is_preview', '__return_true' );
      $this->setup_preview_containers();
    }
  }

  public function setup_preview_containers() {
    if (!$this->is_element_preview) {
      $this->is_element_preview = true;
      add_filter( 'x_breadcrumbs_data', 'x_bars_sample_breadcrumbs', 10, 2 );
      $this->elementService->renderer()->childrenOverrideStart( [ $this, 'preview_container_output' ] );
    }
  }

  public function teardown_preview_containers() {
    if ($this->is_element_preview) {
      $this->is_element_preview = false;
      remove_filter( 'x_breadcrumbs_data', 'x_bars_sample_breadcrumbs', 10, 2 );
      $this->elementService->renderer()->childrenOverrideStop( [ $this, 'preview_container_output' ] );
    }
  }

  public function preview_container_output( $children, $parent ) {
    echo '{%%{children}%%}';

    $in_link = $this->elementService->renderer()->inLinkSetup( $parent );

    foreach( $children as $element ) {
      $this->render_element( $element, $parent );
    }

    $this->elementService->renderer()->inLinkTeardown( $in_link );
  }


  public function track_inline_styling_handles( $handle ) {
    $this->inline_styling_handles[] = $handle;
  }

  public function render_repeat( $data ) {
    if ( ! apply_filters( 'cs_render_looper_is_virtual', false ) || ! isset( $data['unique_id'] ) ) {
      return $data;
    }
    if (!isset($data['class'])) $data['class'] = '';
    $data['class'] = trim( 'tco-observe-' . $data['_id'] . ' '. $data['class']);
    return $data;
  }

  public function capture_portal( $content, $action ) {

    $id = end($this->target);
    if (!isset($this->portals[$id])) {
      $this->portals[$id] = '';
    }

    $this->portals[$id] .= "<div tco-html-portal=\"$action\">$content</div>";

  }

  public function capture_views($content, $action) {
    $this->capture_portal( $content, $action);
    return $content;
  }

  public function expand_dc_in_preview( $content ) {
    return apply_filters( 'cs_is_preview', false ) ? cs_dynamic_content( $content ) : $content;
  }

}
