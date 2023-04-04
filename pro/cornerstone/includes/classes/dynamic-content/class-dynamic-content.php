<?php

// use cs_expand_content anywhere you would normally use do_shortcode but also want dynamic content to expand
// use dynamic content anywhere you know is already inside do_shortcode or apply_filters('the_content')

class Cornerstone_Dynamic_Content extends Cornerstone_Plugin_Component {

  protected $fields = array();
  protected $groups = array();
  protected $cache = array();
  protected $recursion_depth = 0;

  public function setup() {

    $this->plugin->component( 'Dynamic_Content_Post' );
    $this->plugin->component( 'Dynamic_Content_Term' );
    $this->plugin->component( 'Dynamic_Content_User' );
    $this->plugin->component( 'Dynamic_Content_Query' );
    $this->plugin->component( 'Dynamic_Content_Looper' );
    $this->plugin->component( 'Dynamic_Content_Url' );
    $this->plugin->component( 'Dynamic_Content_Rivet' );

    do_action( 'cs_dynamic_content_register' );

    if ( defined( 'WPCF_VERSION' ) ) {
      $this->plugin->component( 'Dynamic_Content_Toolset' );
    }

    if ( function_exists( 'WC' ) ) {
      $this->plugin->component( 'Dynamic_Content_WooCommerce' );
    }

    $this->plugin->component( 'Dynamic_Content_Global' );

    // API - use this filter to expand DC directives.
    add_filter( 'cs_dynamic_content', [ $this, 'expand_string' ] );
    add_filter( 'cs_dynamic_content_array', [ $this, 'expand_array' ] );

    // Dynamic Content
    add_filter( 'cs_decode_shortcode_attribute', 'cs_dynamic_content' );
    add_filter( 'get_the_excerpt',  'cs_dynamic_content', 100 );
    add_filter( 'cs_css_post_process', 'cs_dynamic_content' );

    add_filter( 'widget_text', 'cs_dynamic_content', 0 ); // hopefully before do_shortcode

    // Setup cs_expand_content function
		add_filter( 'cs_expand_content', 'cs_dynamic_content' ); // First run dynamic content

    // removing this and only running inside the text element for now
    // add_filter( 'cs_expand_content', 'wp_filter_content_tags' ); // run applicable WordPress filters (only wp_filter_content_tags for now)

    add_filter( 'cs_expand_content', 'do_shortcode', 11 ); // run do_shortcode on the final result

    add_filter( 'cs_defer_view', 'cs_expand_content' );

    // allow infinitely nested dynamic content. Needs to panic after a certain number of levels
    add_filter( 'cs_dynamic_content_string_result', [ $this, 'recursion'] );

  }





  public function register_field($field) {

    if (isset($field['name']) && isset($field['group']) ) {
      $key = $field['group'] . ':' . $field['name'];
      $this->fields[$key] = $field;
    }

  }

  public function register_group( $group ) {

    if (isset($group['name']) ) {
      $this->groups[$group['name']] = cs_define_defaults( $group, array(
        'label' => 'Group'
      ) );
    }

  }

  public function get_dynamic_fields() {

    do_action( 'cs_dynamic_content_setup' );

    return apply_filters( 'cs_dynamic_content_ui', array(
      'fields' => $this->fields,
      'groups' => $this->groups
    ) );
  }

  public function expand_array( $content ) {

    if ( ! apply_filters( 'cs_dynamic_content_array_should_expand', true ) ) {
      return $content;
    }

    $content = apply_filters( 'cs_dynamic_content_before_expand_array', $content );

    list( $result, $args ) = $this->expand( $this->find_matches( $content ) );

    return apply_filters( 'cs_dynamic_content_array_after_expand_array', $result );

  }

  public function pattern() {
    return '/{{dc:([A-Za-z0-9_-]*):?([A-Za-z0-9_-]*)(.*?)}}/';
  }

  public function find_matches( $content ) {
    preg_match($this->pattern(), trim( $content ), $matches );
    return $matches;
  }

  public function parse_string( $content ) {
    return $this->parse_matches( $this->find_matches( $content ) );
  }

  public function expand_string( $content ) {

    if ( ! apply_filters( 'cs_dynamic_content_should_expand', true ) ) {
      return $content;
    }

    $content = apply_filters( 'cs_dynamic_content_before_expand', $content );

    // for {{dc}}
    $content = preg_replace_callback(
      '/{{dc:([A-Za-z0-9_-]*):?([A-Za-z0-9_-]*)(.*?)}}/',
      array( $this, 'expand_string_callback' ),
      $content
    );

    // For encoded version (e.g. Subject, Telephone)
    $content = preg_replace_callback(
      '/%7B%7Bdc:([A-Za-z0-9_-]*):?([A-Za-z0-9_-]*)(.*?)%7D%7D/',
      array( $this, 'expand_string_callback_encoded' ),
      $content
    );

    return apply_filters( 'cs_dynamic_content_after_expand', $content );

  }

  public function expand_string_callback_encoded( $matches ){
    return $this->expand_string_callback( $matches, true );
  }

  public function parse_matches( $matches ) {
    $type  = isset($matches[1]) ? $matches[1] : '';
    $field = isset($matches[2]) ? $matches[2] : '';
    $args  = isset($matches[3]) ? $this->parse_args( trim($matches[3]) ) : array();
    return [ $type, $field, $args ];
  }

  public function expand( $matches ) {

    list( $type, $field, $args ) = $this->parse_matches( $matches );

    $result = apply_filters( "cs_dynamic_content_{$type}", '', $field, $args );
    $result = apply_filters( "cs_dynamic_content_{$type}_{$field}", $result, $args );

    return [ $result, $args ];
  }

  public function expand_string_callback( $matches, $encode_uri = false ) {

    list( $result, $args ) = $this->expand( $matches );

    if ( ! $result && isset( $args['fallback'] ) ) {
      $result = $args['fallback'];
    }

    // if URL must be encoded
    if ( $encode_uri ) {
      $result = rawurlencode( $result );
    }

    if ( isset( $args['type'] ) ) {
      switch ($args['type']) {
        case 'json':
          $result = json_encode( $result );
          break;
        case 'date':
          $result = date_i18n( isset( $args['format'] ) ? $args['format'] : get_option('date_format'), strtotime( $result ) );
          break;
        case 'time':
          $result = date_i18n( isset( $args['format'] ) ? $args['format'] : get_option('time_format'), strtotime( $result ) );
          break;
      }
    }

    if ( is_scalar( $result ) && ! is_string( $result ) ) {
      $result = (string) $result;
    }

    if ( is_array( $result ) ) {
      $strings = array_filter( $result, 'is_scalar' );
      $result = implode( isset( $args['delimiter'] ) ? $args['delimiter'] : ',', $strings );
    }

    if ( is_string( $result ) ) {
      return apply_filters( 'cs_dynamic_content_string_result', $result, $args );
    }

    return '';

  }

  public function parse_args( $arg_string ) {

    $args = array();


    // un wptexturize
    $arg_string = str_replace( '&#8220;', '"', $arg_string ); // opening curly double quote
    $arg_string = str_replace( '&#8221;', '"', $arg_string ); // closing curly double quote
    $arg_string = str_replace( '&#8217;', "'", $arg_string ); // apostrophe
    $arg_string = str_replace( '&#8242;', "'", $arg_string ); // prime
    $arg_string = str_replace( '&#8243;', '"', $arg_string ); // double prime
    $arg_string = str_replace( '&#8216;', "'", $arg_string ); // opening curly single quote
    $arg_string = str_replace( '&#8217;', "'", $arg_string ); // closing curly single quote

    $arg_string = str_replace('&amp;quot;', '&quot;', $arg_string );
    $arg_string = str_replace('&amp;apos;', '&apos;', $arg_string );
    $arg_string = preg_replace_callback( '%(?:[^\\\](?:(&quot;)|(&apos;)))%', array( $this, 'parse_args_normalize_quotes' ), $arg_string);
    $arg_string = preg_replace_callback( '%(?:[^\\\](?:(&quot;)|(&apos;)))%', array( $this, 'parse_args_normalize_quotes' ), $arg_string);

    preg_match_all( '%(\w+)\s*=\s*(?:"((?:[^"\\\]++|\\\.)*+)"|\'((?:[^\'\\\]++|\\\.)*+)\')%', $arg_string, $matches );

    foreach( $matches[1] as $index => $key ) {
      $arg = '';
      if ( isset( $matches[2][$index] ) && $matches[2][$index] ) $arg = $matches[2][$index];
      if ( isset( $matches[3][$index] ) && $matches[3][$index] ) $arg = $matches[3][$index];
      $args[$key] = str_replace( '\}', '}', wp_unslash( $arg ) );
    }

    return $args;
  }

  public function parse_args_normalize_quotes($matches) {
    return str_replace('&apos;', "'", str_replace('&quot;', '"', $matches[0]));
  }

  public function get_contextual_post( $args = [] ) {
    // see Cornerstone_Dynamic_Content_Post::supply_field
    global $post;

    return $this->get_cached_post(
      isset( $args['post'] ) ? $args['post'] : apply_filters( 'cs_dynamic_content_post_id', is_a( $post, 'WP_Post' ) ? $post->ID : get_the_ID() )
    );
  }

  public function get_cached_post( $post_id ) {


    $key = "post:" . (in_array( $post_id, ['prev', 'next' ]) ? get_the_ID() . ':' . $post_id : $post_id);

    if ( ! isset( $this->cache[$key] ) ) {

      $post = null;
      $current_id = get_the_ID();

      if ( 'next' === $post_id ) {
        $next = get_next_post();
        if ( is_a( $next, 'WP_Post' ) && $current_id !== $next->ID ) {
          $post = $next;
        }
      } elseif ( 'prev' === $post_id ) {
        $prev = get_previous_post();

        if ( $prev && is_a( $prev, 'WP_Post' ) && $current_id !== $prev->ID ) {
          $post = $prev;
        }
      } elseif ( (int) $post_id > 0 ) {
        $post = get_post( (int) $post_id );
      }

      $this->cache[$key] = is_a( $post, 'WP_Post' ) ? $post : null;

    }

    return $this->cache[$key];

  }

  public function get_contextual_term( $args = [] ) {


    // Resolve term by ID
    if ( isset( $args['term'] ) ) {
      $key = 'term:' . $args['term'];
      if ( ! isset( $this->cache[$key] ) ) {
        $this->cache[$key] = get_term( (int) $args['term'] );
      }
      return $this->cache[$key];
    }

    // Get the current looper data and queried object
    $data = $this->plugin->component('Looper_Manager')->get_current_data();
    $queried = get_queried_object();

    // Priority 1: Return the current term from looper data
    if ( is_a( $data, 'WP_Term') ) {
      return $data;
    }

    // Priority 2: Return the current queried object if is a term
    if (is_a( $queried, 'WP_Term') ) {
      return $queried;
    }

    // Priority 3: If we are looping over a post, use its first term
    if (is_a( $data, 'WP_Post') ) {
      return $this->get_cached_first_term_for_post( $data );
    }

    // Priority 4: If the current query is a post, use its first term
    if (is_a( $queried, 'WP_Post') ) {
      return $this->get_cached_first_term_for_post( $queried );
    }

    return null;

  }

  public function get_cached_first_term_for_post( $post ) {

    $key = 'term-post:' . $post->ID;

    if ( ! isset( $this->cache[$key] ) ) {
      $first_post_term = $this->get_first_term_for_post( $post );
      $this->cache[$key] = $first_post_term  ? $first_post_term : null;
    }

    return $this->cache[$key];

  }

  public function get_first_term_for_post( $post ) {

    if ($post->post_type === 'post') {

      $post_cat = get_the_category( $post->id );
      if ( isset( $post_cat[0] ) && is_a( $post_cat[0], 'WP_Term' ) ) {
        return $post_cat[0];
      }

      $post_tag = get_the_tags( $post->id );
      if ( isset( $post_tag[0] ) && is_a( $post_tag[0], 'WP_Term' ) ) {
        return $post_tag[0];
      }

    }

    if ($post->post_type === 'product') {

      $product_cat = get_the_terms( $post->ID, 'product_cat' );
      if ( isset( $product_cat[0] ) && is_a( $product_cat[0], 'WP_Term' ) ) {
        return $product_cat[0];
      }

      $product_tag = get_the_terms( $post->ID, 'product_tag' );
      if ( isset( $product_tag[0] ) && is_a( $product_tag[0], 'WP_Term' ) ) {
        return $product_tag[0];
      }

    }

    return null;
  }

  public function get_contextual_product( $args = [] ) {
    if ( isset( $args['product'] ) ) {
      $product_id = $args['product'];
    } else {
      global $product;
      $product_id = empty($product) ? get_the_ID() : $product->get_id();
    }

    return $this->get_cached_product( $product_id );
  }

  public function get_cached_product( $product_id ) {
    $key = "product:$product_id";

    if ( ! isset( $this->cache[$key] ) ) {
      $this->cache[$key] = wc_get_product( $product_id );
    }

    return $this->cache[$key];
  }

  public function get_contextual_author( $args ) {
    $post = $this->get_contextual_post( $args );
    if ( ! $post )  {
      return null;
    }
    return $this->get_cached_user( get_post_field( 'post_author', $post ) );
  }

  public function get_contextual_user( $args = [] ) {

    // Return a specific user
    if ( isset( $args['user'] ) ) {
      $user_id = $args['user'];
      if ('author' === $user_id ) {
        global $post;
        $user_id = get_post_field( 'post_author', apply_filters( 'cs_dynamic_content_post_id', $post->ID ) );
      }
      return $this->get_cached_user( $user_id );
    }

    // Return user if it is the current context in the Looper Provider
    $data = $this->plugin->component('Looper_Manager')->get_current_data();

    if ( is_a( $data, 'WP_User') ) {
      return $data;
    }

    // Return the logged in user
    return $this->get_cached_user( get_current_user_id() );
  }

  public function get_cached_user( $user_id ) {
    if ( !$user_id ) {
      return null;
    }

    $key = "user:$user_id";
    if ( ! isset( $this->cache[$key] ) ) {
      $user = get_user_by( 'ID', (int) $user_id );
      if ( ! $user ) {
        return null;
      }
      $this->cache[$key] = $user;
    }

    return $this->cache[$key];
  }

  public function recursion( $result ) {
    $this->recursion_depth++;
    if ($this->recursion_depth > 100) {
      trigger_error( 'Dynamic Content stopped proccessing after a depth of 100. It is likely that you have self referencing dynamic content', E_USER_WARNING );
      return $result;
    }
    $result = cs_expand_content( $result );
    $this->recursion_depth--;
    return $result;
  }

}
