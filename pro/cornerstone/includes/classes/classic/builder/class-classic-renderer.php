<?php
class Cornerstone_Classic_Renderer extends Cornerstone_Plugin_Component {

	public $dependencies = array( 'Front_End' );
  protected $ready = false;

  public function before_render() {

    if ( $this->ready ) {
      return;
    }

    $this->ready = true;

		Cornerstone_Shortcode_Preserver::init();
		Cornerstone_Shortcode_Preserver::sandbox( 'cs_render_the_content' );

		add_filter( 'cs_preserve_shortcodes_no_wrap', '__return_true' );
    add_filter( 'cs_render_the_content', 'cs_dynamic_content' );

    $this->orchestrator = $this->plugin->component( 'Element_Orchestrator' );
		$this->orchestrator->load_elements();

  }


	public function render_classic_element( $element, $content = '' ) {

    $this->before_render();

    $is_preview = apply_filters( 'cs_is_preview', false );
		$definition = $this->orchestrator->get( $element['_type'] );
    $flags = $definition->flags();

    if ( $definition->is_active() ) {
      $markup = $definition->preview(
        $element,
        $this->orchestrator,
        ( isset( $element['_parent_data'] ) ) ? $element['_parent_data'] : null,
        [],
        $content
      );
    } else {
      if ( $is_preview ) {
        $message = ( $flags['undefined_message']) ? $flags['undefined_message'] : csi18n('app.elements-undefined-preview');
        $markup = "<div class=\"tco-empty-element cs-undefined-element\"><p class=\"tco-empty-element-message\">$message</p></div>";
      } else {
        $markup = '';
      }
    }


    if ( ! $is_preview ) {
      return $markup;
    }

		$markup = apply_filters( 'cs_render_the_content', cs_noemptyp($markup) ); // similar to apply_filters( 'the_content', $content );
    return is_string( $markup ) ? $markup : '';
  
	}

}
