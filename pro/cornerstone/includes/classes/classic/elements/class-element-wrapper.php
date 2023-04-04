<?php
/**
 * Parent class for Cornerstone Elements
 * All element inherit from this class for underlying functionality
 */

class Cornerstone_Element_Wrapper {

	public $register_shortcodes = true;
	public $text_domain = '';
	public $shortcode_prefix = 'cs_';

	// The following properties are for internal use. Do not override
	protected $name;
	protected $path;
	protected $definition;
	protected $defaults;
	protected $applied_defaults;
	protected $flags;
	protected $control_group;
	protected $hook_prefix;

	protected $shortcode_template = null;

	protected static $default_flags = array( 'library' => true, 'context' => 'all', 'dynamic_child' => false, 'linked_child' => false, 'child' => false, '_v' => 'mk2', 'can_preview' => true );
	protected static $default_ui = array( 'title' => 'Element', 'description' => '', 'autofocus' => '', 'icon_id' => null );
	protected static $common_controls = array( 'id', 'class', 'style' );

	protected static $valid_contexts = array( 'all', 'content', 'design' );
	protected static $internal_whitelist = array( 'section', 'row', 'column', 'responsive-text', 'undefined' );

	public function __construct( $name, $path, $definition, $native ) {

		$this->name = $name;
		$this->path = $path;

		$this->definition = $definition;
		$this->definition->register_shortcodes = true;
		$this->definition->shortcodes = array();

		if ( isset( $this->definition->shortcode_name ) && is_scalar( $this->definition->shortcode_name ) ) {
			$this->shortcode_name = $this->definition->shortcode_name;
		} else {
			if ( isset( $this->definition->shortcode_prefix ) && is_scalar( $this->definition->shortcode_prefix ) )
				$this->shortcode_prefix = $this->definition->shortcode_prefix;
			$this->shortcode_name = $this->shortcode_prefix . str_replace( '-', '_', $this->name );
		}

		$this->hook_prefix = "cs_element_{$this->name}_";

	}

	/**
	 * Each element is registered with every page load. This involves the minimal
	 * amount of overhead, and most often involves only shortcode registration
	 * @return void
	 */
	public function register() {

		do_action( $this->hook_prefix . 'register' );

		if ( apply_filters( $this->hook_prefix . 'register_shortcode', true ) )
			$this->register_shortcode();

		do_action( $this->hook_prefix . 'after_register' );

	}

	public function register_shortcode() {

		$source = $this;

		if ( method_exists( $this->definition, 'shortcode_output' ) ) {
			$source = $this->definition;
		} else {

			$filename = $this->path . "shortcode.php";

			if ( !file_exists( $filename ) ) {
				$filename = $this->path . "shortcode-{$this->name}.php";
				if ( !file_exists( $filename ) ) {
					trigger_error( "Cornerstone shortcode template file for {$this->name}' not found.", E_USER_WARNING );
					return;
				}
			}

			$this->shortcode_template = $filename;

		}

		add_shortcode( $this->shortcode_name, array( $source, 'shortcode_output' ) );

	}

	public function defaults() {

		if ( !isset( $this->defaults ) ) {

			$defaults = apply_filters( $this->hook_prefix . 'defaults', false );

			if ( false === $defaults ) {
				$defaults = $this->get_file_array( 'defaults' );
			}

			$this->defaults = apply_filters( $this->hook_prefix . 'update_defaults', $defaults );

		}

		return $this->defaults;

	}

	public function flags() {

		if ( !isset( $this->flags ) ) {
			$this->flags = wp_parse_args( apply_filters( $this->hook_prefix . 'flags', array() ), self::$default_flags );

			// Force elements into a valid context, unless given special privledges internally.
			if ( !in_array($this->flags['context'], self::$valid_contexts )
				&& !in_array( $this->name, self::$internal_whitelist ) ) {

				$this->flags['context'] = 'all';

			}

			if ($this->flags['context'] !== 'all') {
				$this->flags['library'] = false;
			};

		}

		return $this->flags;

	}


	public function shortcode_output( $atts, $content = '', $shortcode_name = '' ) {

		$defaults = $this->controls()->get_transformed_atts( $this->defaults() );
		$atts = shortcode_atts( $defaults, $atts, $shortcode_name );

    if ( isset( $atts['content'] ) ) {
			unset( $atts['content'] );
    }

		extract( $atts );

		ob_start();

		include( $this->shortcode_template );

		return ob_get_clean();

	}

	public function ui() {

		if ( !isset( $this->ui ) ) {

			$this->ui = wp_parse_args( apply_filters( $this->hook_prefix . 'ui', array() ), self::$default_ui );

		}

		return $this->ui;

	}

	public function controls() {

		if ( !isset( $this->controls ) ) {

			$controls = apply_filters( $this->hook_prefix . 'controls', false );

			if ( false === $controls ) {
				$controls = $this->get_file_array( 'controls' );
			}

			$this->controls = Cornerstone_Control_Group::factory( apply_filters( $this->hook_prefix . 'update_controls', $controls ), self::$common_controls, array_keys( $this->defaults() ) );

		}

		return $this->controls;

	}

	/**
	 * Internal safety check to make sure element is registered properly
	 * @return boolean
	 */
	public function is_valid() {
		return true;
	}

	public function name() {
		return $this->name;
	}

	public function definition() {
		return $this->definition;
	}

	public function model_data() {

		$flags = $this->flags();
		$ui = $this->ui();

		$data = array(
			'name'          => $this->name,
			'ui'            => $ui,
			'icon'          => $ui['icon_id'],
			'flags'         => $flags,
			'active'        => $this->is_active(),
			'base_defaults' => $this->defaults(),
			'defaults'      => $this->get_applied_defaults(),
			'controls'      => $this->controls()->model_data()
		);

		$context_default_key = $flags['context'] . '_defaults';

		if ( method_exists( $this->definition, $context_default_key ) ) {
			$data[$context_default_key] = call_user_func_array( array( $this->definition, $context_default_key ), array() );
		}

		return $data;

	}

	protected function get_applied_defaults() {

		if ( ! isset( $this->applied_defaults ) ) {

			$this->applied_defaults = $this->controls()->backfill_content( $this->defaults() );

		}

		return $this->applied_defaults;

	}

	protected function get_file_array( $file = '' ) {
		$filename = $this->path . $file . '.php';
		return ( file_exists( $filename) ) ? include( $filename ): array();
	}

	protected function get_file_template( $file = '' ) {
		$filename = $this->path . $file . '.php';
		if ( !file_exists( $filename) )
			return '';

		ob_start();
		include( $filename );
		return ob_get_clean();
	}

	/**
	 * Data is assumed to be sanitize
	 * @param  [type] $atts    [description]
	 * @param  string $content [description]
	 * @param  [type] $parent  [description]
	 * @return [type]          [description]
	 */
	public function build_shortcode( $original_atts, $content = '', $parent = null ) {

		if ( !apply_filters( $this->hook_prefix . 'should_have_markup', true, $original_atts, $content, $parent ) ) {
			return '';
		}

		$atts = $this->compose( $original_atts );

		$atts = $this->controls()->filter_atts_for_shortcode( $atts );

		if ( isset( $atts['_modules'] ) ) {
			$atts['elements'] = $atts['_modules'];
		}

		$atts = apply_filters( $this->hook_prefix . 'update_build_shortcode_atts', $atts, $parent, $original_atts );
		$atts = apply_filters( 'cornerstone_control_injections', $atts );

		$atts = $this->build_shortcode_clean_atts( $atts );

		if ( isset( $atts['content'] ) ) {
			if ( '' == $content ) {
				$content = $atts['content'];
      }
			unset( $atts['content'] );
		}

    $content = apply_filters( 'cs_element_update_build_shortcode_content', $content, $parent );
		$content = apply_filters( $this->hook_prefix . 'update_build_shortcode_content', $content, $parent );

	  $output = "[{$this->shortcode_name}";

	  foreach ($atts as $attribute => $value) {
			$clean = cs_clean_shortcode_att( $value );
			if ( '' !== $clean ) {
				$att = sanitize_key( $attribute );
				$output .= " {$att}=\"{$clean}\"";
			}
	  }

	  if ( $content == '' && !apply_filters( $this->hook_prefix . 'always_close_shortcode', false ) ) {
	    $output .= "]";
	  } else {
	    $output .= "]{$content}[/{$this->shortcode_name}]";
	  }

	  return $output;

	}

	public function build_shortcode_clean_atts( $atts ) {

		unset( $atts['_type'] );
		unset( $atts['_region'] );
		unset( $atts['_id'] );
		unset( $atts['elements'] );

		foreach ($atts as $key => $value) {

			if ( 'content' == $key )
				continue;

			if ( !is_scalar( $value ) ) {
				unset($atts[$key]);
				continue;
			}

		}

		return $atts;

	}

	public function preview( $element, $orchestrator, $parent = null, $transient = null, $inception = false ) {

		$element = $this->sanitize( $element );

		$sanitize_parent = false; // Recursive calls are already sanitized.

		if ( $transient ) {
			if ( isset( $transient['parent'] ) ) {
				$parent = $transient['parent'];
				$sanitize_parent = true;
			}

			if ( isset( $transient['children_count'] ) ) {
				$element['_element_count'] = $transient['children_count'];
			}

		}

		if ( ! is_null( $parent ) ) {

			$parent_definition = $orchestrator->get( $parent['_type'] );

			if ( $sanitize_parent )
				$parent = $parent_definition->sanitize( $parent );

			$parent = $parent_definition->compose( $parent );

			unset( $parent['elements'] );

		}

		if ( isset( $element['_csmeta'] ) ) {
			unset( $element['_csmeta'] );
		}

		$markup = apply_filters( $this->hook_prefix . 'preview', '', $element, $parent );

    $flags = $this->flags();

		if ( '' === $markup ) {

			$content = '';

      if ( $inception && $flags['dynamic_child'] ) { // Added for V2
				$content = apply_filters( 'cs_is_preview', false ) ? '{%%{children}%%}' : $inception;
      }

			if ( isset( $element['elements'] ) && is_array( $element['elements'] ) && !empty( $element['elements'] ) ) {
				if ( $flags['dynamic_child'] ) {
					$content = '';
				} else {
					foreach ($element['elements'] as $child ) {
						$child_definition = $orchestrator->get( $child['_type'] );
						unset( $child['_type'] );
						$content .= $child_definition->preview( $child, $orchestrator, $element, null, '' );
					}
				}
			}

			$markup = $this->build_shortcode( $element, $content, $parent );

		}

		return $markup;

	}

	public function compose( $data ) {
		return wp_parse_args( $data, $this->get_applied_defaults() );
	}

	public function sanitize( $data ) {
		return $this->controls()->sanitize( $data );
	}

	public function is_active() {
		return apply_filters( $this->hook_prefix . 'is_active', true );
	}

	public function version() {
		return 'mk2';
	}

}
