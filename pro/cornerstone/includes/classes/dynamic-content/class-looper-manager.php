<?php

class Cornerstone_Looper_Manager extends Cornerstone_Plugin_Component {

  protected $element_stack = array();
  protected $current_element = null;
  protected $provider_stack = array();
  protected $current_provider = null;

  public function setup() {
    add_action( 'cs_preview_archive_setup', [$this, 'setup_main_looper_provider' ] );
    add_action( 'cs_layout_begin_archive', [$this, 'setup_main_looper_provider' ] );
    add_filter( 'cs_render_element_data', [ $this, 'update_unique_id' ] );
  }

  public function setup_main_looper_provider() {
    $main_provider = apply_filters( 'cs_looper_main_query', new Cornerstone_Looper_Provider_Archive() );
    $main_provider->begin();
    $this->provider_stack[] = $main_provider;
    $this->current_provider = $main_provider;
  }

  public function maybe_start_element( $element ) {

    $is_provider = isset( $element['looper_provider'] ) && $element['looper_provider'];
    $is_consumer = isset( $element['looper_consumer'] ) && $element['looper_consumer'];

    if ( $is_provider || $is_consumer ) {

      $looper_element = new Cornerstone_Looper_Element( $element['unique_id'] );

      if ( $is_provider ) {

        try {
          $looper_element->set_is_provider();

          $provider = Cornerstone_Looper_Provider::create($element, $this);

          if ($this->current_provider) {
            $this->current_provider->pause();
          }

          $provider->begin();
          $this->provider_stack[] = $provider;
          $this->current_provider = $provider;

        } catch (Exception $e) {
          trigger_error( $e->getMessage(), E_USER_WARNING );
          $is_provider = false;
        }

      }


      if ( $is_consumer && $this->current_provider && ! $this->current_provider->current_consumer() ) {

        $this->current_provider->set_current_consumer( $element['_id'] );
        $looper_element->set_is_consumer();

        if ( isset( $element['looper_consumer_repeat'] ) ) {
          $looper_element->set_repeat( (int) $element['looper_consumer_repeat'] );
        }

        if ( isset( $element['looper_consumer_rewind'] ) ) {
          $looper_element->set_rewind( $element['looper_consumer_rewind'] );
        }

      } else {
        $is_consumer = false;
      }

      if ( $is_provider || $is_consumer ) {
        $looper_element->set_provider( $this->current_provider );
        $this->element_stack[] = $looper_element;
        $this->current_element = $looper_element;
      }

    }

    if ($is_consumer) return 'consumer';
    if ($is_provider) return 'provider';

    return false;

  }

  public function iterate() {
    if ($this->current_element && $this->current_element->is_consumer()) {
      return $this->current_element->consume();
    }
    return false;
  }

  public function end_element() {
    $element_removal = array_pop($this->element_stack);

    if ($element_removal) {

      if ($element_removal->is_provider()) {
        $latest_provider = array_pop($this->provider_stack);
        $latest_provider->dispose();

        $this->current_provider = end($this->provider_stack);
        if ($this->current_provider) {
          $this->current_provider->resume();
        }
      }

      if ($element_removal->is_consumer()) {
        if ($this->current_provider) {
          $this->current_provider->set_current_consumer(null);
          if ($element_removal->should_rewind()) {
            $this->current_provider->rewind();
          }
        }
      }

    }

    $this->current_element = end($this->element_stack);

  }

  public function get_provider() {
    return $this->current_provider;
  }

  public function get_current_data() {
    return $this->current_provider ? $this->current_provider->get_current_data() : array();
  }

  public function get_context() {
    return $this->current_provider ? $this->current_provider->get_context() : array();
  }

  public function get_index() {
    return $this->current_provider ? $this->current_provider->get_index() : 0;
  }

  public function get_size() {
    return $this->current_provider ? $this->current_provider->get_size() : 0;
  }

  public function update_unique_id( $data ) {
    $indexes = array_map(function( $consumer ) {
      return $consumer->provider()->get_index();
    }, array_filter($this->element_stack, function($looper_element) {
      return $looper_element->is_consumer();
    }) );

    $index_id = implode('-', $indexes);
    if ($index_id !== '') $data['unique_id'] .= "-$index_id";

    return $data;
  }

  public function debug_provider() {
    ob_start();

    if ( $this->current_provider ) {
      $type = get_class( $this->current_provider );
      $size = $this->get_size();
      $error = $this->current_provider->get_error();
      echo "Type: $type\n";
      if ( $error ) {
        $msg = $error->get_error_message();
        echo "Error: $msg\n";
        var_dump($error);
      }
      echo "Size: $size\n";
      echo "Current Data:\n";
      var_dump( $this->get_context() );
    } else {
      echo "No looper active";
    }

    return $this->debug_output( 'spider', ob_get_clean() );
  }

  public function debug_consumer() {
    ob_start();

    if ( $this->current_provider ) {
      $index = $this->get_index();
      echo "Index: $index\n";
      echo "Current Data:\n";
      var_dump( $this->get_current_data() );
    } else {
      echo "No looper active";
    }

    return $this->debug_output( 'bug', ob_get_clean() );
  }

  public function debug_output( $icon, $content ) {
    ob_start();
    ?>
    <style>.x-looper-debug { font-size: 10px; } .x-looper-debug > summary { list-style: none; } .x-looper-debug > summary::-webkit-details-marker { display: none; }</style>
    <details class="x-looper-debug">
    <summary> <?php echo cs_render_shortcode('x_icon', ['type' => $icon ] );?></summary>
    <pre><?php echo $content ?></pre>
    </details> <?php
    return ob_get_clean();
  }

}
