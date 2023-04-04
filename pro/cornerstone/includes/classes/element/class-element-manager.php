<?php

class Cornerstone_Element_Manager extends Cornerstone_Plugin_Component {

  protected $elements = array();
  protected $components = array();

  public function init() {

    if ( ! did_action('init') ) {
      trigger_error( 'Cornerstone Element_Manager should not be requested before init action', E_USER_WARNING );
    }

    $this->register_native_elements();
    $this->upgrade_classic_elements();
    do_action( 'cs_register_elements' );

  }

  public function register_component( $name, $options = [] ) {

    if ( ! $name || ! is_array( $options ) ) {
      return;
    }

    $component = cs_define_defaults( $options, [
      'values'       => [],
      'migrations'   => [],
      'value_prefix' => '',
    ]);

    // remove the value_prefix at registration so we can use keys like "effects_duration" but the actual component only stores "duration" so it can be potentially be reprefixed at the element level
    if ( $component['value_prefix'] ) {
      $start = strlen( $component['value_prefix'] ) + 1;
      $unprefixed = [];
      foreach( $component['values'] as $key => $value ) {
        $key = substr($key, $start);
        $unprefixed[$key] = $value;
      }
      $component['values'] = $unprefixed;
    }

    $component['id'] = $name;
    $this->components[ $name ] = $component;

  }

  public function get_component( $name ) {
    return isset( $this->components[ $name ] ) ? $this->components[ $name ] : null;
  }

  public function register_element( $name, $element ) {

    if ( ! $element ) {
      return;
    }

    if ( isset( $this->elements[ $name ] ) ) {
      $this->elements[ $name ]->update( $element );
    }

    $this->elements[ $name ] = new Cornerstone_Element_Definition( $name, $element );

  }

  public function unregister_element( $name ) {
    unset( $this->elements[ $name ] );
  }

  public function get_element( $name ) {
    return isset( $this->elements[ $name ] ) ? $this->elements[ $name ] : $this->elements['undefined'];
  }

  public function get_element_names() {
    return array_keys( $this->elements );
  }

  public function get_all_elements() {
    return $this->elements;
  }

  public function get_element_definitions() {
    $elements = array();

    foreach ($this->elements as $element) {
      $elements[] = $element->serialize();
    }

    return $elements;
  }

  public function get_components() {
    return $this->components;
  }

  public function get_element_inspector_data() {
    $elements = array();

    foreach ($this->elements as $id => $element) {
      $elements[$id] = $element->get_inspector();
    }

    return $elements;
  }

  public function get_public_definitions() {

    $elements = array();

    foreach ($this->elements as $element) {
      if ( $element->in_library() ) {
        $elements[] = $element;
      }
    }

    usort( $elements, array( $this, 'sort_definitions' ) );

    return $elements;
  }

  public function sort_definitions( $a, $b ) {
    return strcasecmp( $a->get_title(), $b->get_title() );
  }

  public function register_native_elements() {

    $this->register_element('undefined', array(
      'title' => csi18n('elements.undefined-title'),
      'options' => array( 'library' => false )
    ) );

    $this->register_element('root', array(
      'valid_children' => array( 'region' ),
      'options' => array( 'library' => false )
    ) );

    $this->register_element('region', array(
      'title'   => csi18n('elements.region-title'),
      'valid_children' => array( 'bar', 'section', 'classic:section' ),
      'options' => array( 'library' => false )
    ) );

    $this->register_element('bar', array(
      'title' => csi18n('elements.bar-title'),
      'options' => array( 'library' => false )
    ) );

    $this->register_element('container', array(
      'title' => csi18n('elements.container-title'),
      'options' => array( 'library' => false )
    ) );

    $this->load_files( $this->plugin->get_registry( 'elements', 'base' ), $this->path( 'includes/elements' ) );
    $this->load_files( $this->plugin->get_registry( 'elements', 'definitions' ), $this->path( 'includes/elements/definitions' ) );
    $this->load_files( $this->plugin->get_registry( 'elements', 'classic' ), $this->path( 'includes/elements/definitions/classic' ) );

  }

  public function load_files( $files, $path ) {
    foreach ($files as $file) {
      if (is_array( $file ) ) {
        $flags = apply_filters('tco_feature_flags', [] );
        if ( isset( $flags[$file[0] ] ) && $flags[$file[0] ] ) {
          $filename = $file[1];
        } else {
          continue;
        }
      } else {
        $filename = $file;
      }
      $filename = "$path/$filename.php";
      if ( file_exists($filename) ) {
        require_once( $filename );
      }
    }
  }

  public function upgrade_classic_elements() {

    $classic_elements = $this->plugin->component( 'Element_Orchestrator' )->getModels();

    foreach ($classic_elements as $element) {
      $classic = $this->upgrade_classic_element( $element );
      if ( $classic ) {
        $this->register_element( 'classic:' . $element['name'], $classic );
      }
    }

  }

  public function upgrade_classic_element( $element ) {

    if ( $element['flags']['context'] === 'generator' ) {
      return false;
    }

    $values = array();

    $options = array(
      'is_classic'   => true,
      'query_styles' => false,
      'classic'      => $element['flags'],
      'library'      => $element['flags']['library'] ? [ 'content', 'layout-single', 'layout-archive'] : false
    );

    if ( $element['flags']['context'] === '_layout' ) {
      $options['is_draggable'] = false;
      $options['empty_placeholder'] = false;
    }

    if ( ( isset( $options['classic']['empty_placeholder']) && ! $options['classic']['empty_placeholder'] ) ) {
      $options['empty_placeholder'] = false;
    }

    if ( isset($options['classic']['render_children'] ) ) {
      $options['render_children'] = true;
    }

    if ( ( isset( $options['classic']['dropzone']) ) ) {
      $options['is_draggable'] = false;
      $options['dropzone'] = $options['classic']['dropzone'];
    }

    if ( isset( $options['classic']['label_key'] ) ) {
      $options['label_key'] = $options['classic']['label_key'];
    }

    if ( isset( $options['classic']['alt_breadcrumb'] ) ) {
      $options['alt_breadcrumb'] = $options['classic']['alt_breadcrumb'];
    }

    if ( isset( $options['classic']['can_preview'] ) ) {
      $options['can_preview'] = $options['classic']['can_preview'];
    }

    $protected_keys = ( isset( $options['classic']['protected_keys'] ) && is_array( $options['classic']['protected_keys'] ) ) ? $options['classic']['protected_keys'] : array();

    if ( isset($options['classic']['child'] ) && $options['classic']['child'] ) {
      $options['library'] = false;
    }

    $controls = $this->upgrade_classic_element_controls( $element['controls'] );

    foreach ($element['defaults'] as $key => $value) {
      if ( 'elements' === $key ) {
        $options['default_children'] = CS()->component('Element_Migrations')->migrate($value);
        continue;
      }
      $designation = 'markup';
      $values[$key] = cs_value( $value, $designation, in_array( $key, $protected_keys, true ) );
    }

    $valid_children = array();

    if ( 'section' === $element['name'] ) {
      $valid_children[] = 'classic:row';
    } elseif ( 'row' === $element['name'] ) {
      $valid_children[] = 'classic:column';
    } elseif ( 'column' === $element['name'] ) {
      $valid_children[] = '*';
    }
    else {
      foreach($element['controls'] as $control) {
        if ($control['type'] !== 'sortable') continue;
        if (isset($control['options']) && isset($control['options']['element'])) {
          $valid_children[] = 'classic:' . $control['options']['element'];
        }
      }
    }

    if ( count( $valid_children ) > 0 ) {
      $options['valid_children'] = $valid_children;
    }


    $title = $element['ui']['title'];
    $builder = function() use ( $controls, $title ) {
      return [
        'controls'       => [
          [
            'type' => 'group-module',
            'label' =>  $title,
            'options' => [ 'name' => 'classic-element' ],
            'controls' => $controls
          ]
        ]
      ];
    };

    return array(
      'title'          => sprintf( csi18n('common.classic'), $title ),
      'values'         => $values,
      'style'          => '__return_empty_string',
      'render'         => array( $this, 'upgrade_classic_element_render' ),
      'icon'           => $element['icon'],
      'options'        => $options,
      'active'         => $element['active'],
      'builder'        => $builder
    );
  }

  public function upgrade_classic_element_controls( $controls ) {
    $upgraded = array();

    foreach ($controls as $key => $control ) {
      $upgrade_control = $this->upgrade_classic_element_control( $control );
      if ( $upgrade_control ) {
        $upgraded[] = $upgrade_control;
      }
    }

    return $upgraded;
  }

  public function upgrade_classic_element_control( $control ) {

    if ( in_array( $control['context'], array( '_layout' ), true ) ) {
      return false;
    }

    $conditions = array();

    if ( isset( $control['condition'] ) && is_array( $control['condition'] ) ){
      foreach ($control['condition'] as $key => $value) {
        $conditions[] = $this->upgrade_classic_element_control_condition( $key, $value );
      }
    }

    return array(
      'type'        => 'classic:' . $control['type'],
      'key'         => $control['key'],
      'label'       => ( isset( $control['ui']) && isset( $control['ui']['title'] ) ) ? $control['ui']['title'] : '',
      'options'     => ( isset( $control['options'] ) ) ? $control['options'] : array(),
      'conditions'  => $conditions
    );
  }

  public function upgrade_classic_element_control_condition( $key, $value ) {

    $not = ':not' === substr($key, -strlen(':not'));

    if ( is_array( $value ) ) {
      $op = ( $not ) ? 'NOT IN' : 'IN';
    } else {
      $op = ( $not ) ? '!=' : '==';
    }

    return array(
      'key' => str_replace(':not', '', $key ),
      'value' => $value,
      'op' => $op
    );
  }

  public function upgrade_classic_element_render( $element ) {

    $render_data = $element;
    $render_data['_type'] = str_replace('classic:', '', $render_data['_type']);

    $content = '';
    if ( ! empty( $element['_modules'] ) ) {
      ob_start();
      do_action( 'x_render_children', $element['_modules'], $element );
      $content = ob_get_clean();
    }

    return $this->plugin->component('Classic_Renderer')->render_classic_element( $render_data, $content );

  }

}
