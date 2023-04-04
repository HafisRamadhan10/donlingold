<?php

abstract class Cornerstone_Regions_Entity {

  protected $post;
  protected $post_type;
  protected $type;
  protected $entity;

  protected $id = null;
  protected $title;
  protected $content = array();
  protected $new;
  protected $dirty;

  public function __construct( $post ) {

    $this->content = array(
      'regions' => array(),
      'settings' => array(),
    );

    if ( is_array( $post ) ) {
      if ( isset( $post['id'] ) ) {
        $post = $post['id'];
      } else {
        $this->create_new( $post );
      }
    } else {

      $this->load_from_post( $post );
    }

  }

  protected function create_new( $data ) {
    $this->set_title( isset( $data['title'] ) ? $data['title'] : $this->default_title() );
    $this->set_regions( isset( $data['regions'] ) ? $data['regions'] : array() );
    $this->set_settings( isset( $data['settings'] ) ? $data['settings'] : array() );
  }

  public function default_title() {
    return sprintf( csi18n('common.untitled-entity'), csi18n($this->entity) );
  }

  protected function load_from_post( $post ) {

    if ( is_int( $post ) ) {
      $post = get_post( $post );
    }

    if ( ! is_a( $post, 'WP_POST' ) ) {
      throw new Exception( "Unable to load {$this->type} from post." );
    }

    if ( $this->post_type !== $post->post_type ) {
      throw new Exception( "Attempted to load {$this->type} from incorrect post_type." );
    }

    $this->id = $post->ID;
    $this->set_title( $post->post_title ? $post->post_title : '' );
    $content = cs_maybe_json_decode( apply_filters("cs_{$this->type}load_content", $post->post_content ) );


    $this->content = wp_parse_args( is_array( $content ) ? $content : array(), array(
      'regions' => array(),
      'settings' => array(),
    ) );

    $this->content['regions'] = $this->normalize_regions( $this->content['regions'] );

  }

  public function normalize_regions($regions) {

    $migrations = CS()->component('Element_Migrations');

    foreach ( $regions as $region => $elements ) {
      $regions[$region] = $migrations->migrate( $elements );
    }

    return $regions;
  }

  public function save() {

    $settings = $this->get_settings();

    if (isset($settings['general_title'])) {
      $this->set_title($settings['general_title']);
      unset($settings['general_title']);
    }

    $update = array(
      'post_title'   => $this->get_title(),
      'post_type'    => $this->post_type,
      'post_status'  => 'tco-data',
      'post_content' => apply_filters("cs_{$this->type}_update_content", wp_slash( cs_json_encode( array(
        'regions'  => $this->get_regions(),
        'settings' => $settings
      ) ) ) )
    );

    if ( is_int( $this->id ) ) {
      $update['ID'] = $this->id;
    }

    do_action( 'cs_before_save_json_content' );
    $id = is_int( $this->id ) ? wp_update_post( $update ) : wp_insert_post( $update );
    do_action( 'cs_after_save_json_content' );

    if ( 0 === $id || is_wp_error( $id ) ) {
      throw new Exception( "Unable to update {$this->type}: $id" );
    }

    do_action("cs_save_region_entity", $this->type, $this->id );
    do_action("cs_save_{$this->type}", $this->id );

    delete_post_meta( (int) $id, '_cs_generated_tss');
    $this->load_from_post( (int) $id );

    return $this->serialize();

  }

  public function get_id() {
    return $this->id;
  }

  public function get_title() {
    return $this->title;
  }

  public function get_regions() {
    if ( ! isset( $this->content['regions'] ) ) {
      $this->content['regions'] = array();
    }
    return $this->content['regions'];
  }

  public function get_root_element_data() {
    $regions = $this->get_regions();
    $elements = [];
    foreach ($regions as $region => $children ) {
      $elements[] = [
        '_type' => 'region',
        '_region' => $region,
        '_modules' => $children
      ];
    }
    return $elements;
  }

  public function get_settings() {
    if ( ! isset( $this->content['settings'] ) ) {
      $this->content['settings'] = array();
    }

    $result = apply_filters( 'cs_regions_settings', array_merge( $this->get_default_settings(), $this->content['settings'] ), $this->type, $this->get_id() );

    return $result;
  }

  public function default_settings() {
    return array (
      'customCSS' => '',
      'customJS' => '',
      'assignments' => [],
      'layout_type' => 'any',
      'preview_url' => '',
      'assignment_priority' => 0
    );
  }

  public function get_default_settings() {
    return apply_filters('cs_regions_default_settings', array_merge( $this->default_settings(), array(
      'general_title' => $this->get_title(),
    ) ), $this->type );
  }

  public function serialize() {

    if (!$this->post) {
      $this->post = get_post($this->id);
    }

    $settings = $this->get_settings();

    return array(
      'id' => $this->id,
      'title' => $this->get_title(),
      'regions'  => $this->get_regions(),
      'settings' => $settings,
      'builder' => array(
        'libraryScope' => $this->get_library_scope( $settings ),
        'previewUrl' => $this->get_preview_url( $settings ),
        'subType' => $this->get_sub_type( $settings ),
        'language' => CS()->component('Wpml')->get_language_data_from_post( $this->post, true ),
        'settings' => $this->get_settings_controls(),
        'titleKey' => 'general_title',
        'settingKeys' => [
          'customCss' => 'customCSS',
          'customJs'  => 'customJS',
          'assignments' => 'assignments',
          'assignmentPriority' => 'assignment_priority',
        ],
        'portableSettings' => ['customCSS', 'customJS', 'layout_type', 'header_enabled', 'footer_enabled'],
        'previewUrlKey' => 'preview_url'
      )
    );
  }

  public function set_title( $title ) {
    $this->title = CS()->common()->sanitize( $title );
    $settings = $this->get_settings();
    $settings['general_title'] = $this->title;
    $this->set_settings( $settings );
    return $this->title;
  }

  public function set_settings( $settings ) {
    if ( ! current_user_can( 'unfiltered_html' ) ) {
      unset( $settings['customJS'] );
      unset( $settings['customCSS'] );
    }
    $this->content['settings'] = array_merge( $this->get_settings(), CS()->common()->sanitize( $settings ) );
  }

  public function set_regions( $regions ) {
    $this->content['regions'] = CS()->common()->sanitize( $regions );
  }

  public function delete() {

    do_action("cs_delete_region_entity", $this->type, $this->id );
    do_action("cs_delete_{$this->type}", $this->id );

    if (!wp_delete_post( $this->id, true )) {
      throw new Exception( 'Failed to delete' );
    }

    return ['deleted' => $this->id];

  }

  public function get_settings_controls() {
    return $this->get_base_settings_controls();
  }

  public function get_general_controls() {
    return array();
  }

  public function get_base_settings_controls() {
    return array(
      array(
        'type'  => 'group',
        'label' => __('General', 'cornerstone'),
        'controls' => array_merge(array(
          array(
            'key' => 'general_title',
            'type' => 'text',
            'label' => __( 'Title', 'cornerstone' ),
          ) ),
          $this->get_general_controls()
        )
      ),
      array(
        'type'  => 'group',
        'label' => __('Assignment', 'cornerstone'),
        'description' => sprintf( __('Set the conditions for when this %s will be displayed. If there are multiple matches the %s with the lowest priority will be used.', 'cornerstone'), csi18n($this->entity), csi18n($this->entity) ),
        'controls' => array(
          array(
            'type' => 'assignments',
            'keys'  => [
              'value' => 'assignments',
              'context' => 'layout_type'
            ],
            'label' => __('Conditions', 'cornerstone'),
            'conditions' => [ ['user_can:{context}.manage_assignments' => true] ]
          ),
          array(
            'type' => 'number',
            'key'  => 'assignment_priority',
            'label' => __('Priority', 'cornerstone'),
            'conditions' => [ ['user_can:{context}.manage_assignments' => true] ]
          )
        )
      )
    );
  }

  public function get_preview_url( $settings ) {

    if ( isset( $settings['preview_url'] ) && strpos($settings['preview_url'], 'http') === 0 ) {
      return $settings['preview_url'];
    }

    return apply_filters( 'cs_layout_default_preview_url', $this->get_default_preview_url( $settings ), $settings, $this );

  }

  public function get_default_preview_url( $settings) {
    return home_url();
  }

  public function get_sub_type( $settings ) {
    return null;
  }

  public function get_library_scope( $settings ) {
    return 'all';
  }

  public function get_style_priority() {
    return 10;
  }

}
