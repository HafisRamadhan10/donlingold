<?php

class Cornerstone_Font_Manager extends Cornerstone_Plugin_Component {

  public $queue = array();
  public $extend = array();
  public $custom_css_output = '';
  protected $font_items;
  protected $font_config;
  protected $loaded = array();
  protected $data = null;

  public function setup() {

    add_filter('cs_css_post_process_font-family', array( $this, 'css_post_process_font_family') );
    add_filter('cs_css_post_process_font-weight', array( $this, 'css_post_process_font_weight') );

    add_filter( 'cs_font_data', [$this, 'font_data' ] );

    add_filter( 'wp_check_filetype_and_ext', array( $this, 'upload_check'), 10, 5 );
    add_filter( 'upload_mimes', array( $this, 'upload_mimes' ), 999 );

    add_action( 'wp_head', array( $this, 'typekit_loading_styles' ) );
    add_action( 'wp_head', array( $this, 'load_initial_items'), 0 );

    add_action( 'cs_head_late', array( $this, 'load_queued_fonts' ) );
    add_action( 'wp_footer', array( $this, 'load_queued_fonts' ) );

  }

  public function font_data($data = []) {
    if ( is_null( $this->data ) ) {
      $system_fonts = include $this->plugin->path( 'includes/config/common/font-data.php' );
      $google_fonts = include $this->plugin->path( 'includes/config/common/fonts-google.php' );
      $this->data = array_merge( $system_fonts, $google_fonts );
    }
    return array_merge( $this->data, $data );
  }

  public function load_initial_items() {
    $items = $this->load_items();
    $force = did_action('cs_before_preview_frame');

    foreach ($items as $item) {
      if ($force || isset($item['force']) && $item['force']) {
        $this->queue_font( $item );
      }
    }

  }

  public function get_extended() {
    return apply_filters('cs_fonts_extend', array() );
  }

  public function default_font_items( $data = array() ) {
    return apply_filters('cornerstone_option_model_defaults_cornerstone_font_items', array(
      array(
        '_id'     => bin2hex('Body Copy'),
        'title'   => csi18n( 'app.fonts.body-copy' ),
        'family'  => 'Helvetica',
        'stack'   => 'Helvetica, Arial, sans-serif',
        'weights' => array( '300', '300i', '400', '400i', '700', '700i' ),
        'source'  => 'system'
      ),
      array(
        '_id'     => bin2hex('Headings'),
        'title'   => csi18n( 'app.fonts.headings' ),
        'family'  => 'Helvetica',
        'stack'   => 'Helvetica, Arial, sans-serif',
        'weights' => array( '300', '300i', '400', '400i', '700', '700i' ),
        'source'  => 'system'
      ),
    ) );
  }

  public function get_fallback_font() {
    return  array(
      'family'  => 'Helvetica',
      'stack'   => 'Helvetica, Arial, sans-serif',
      'weights' => array( '400', '400i', '300', '300i', '700', '700i' ), // The first weight will be used when falling back
      'source'  => 'system'
    );
  }

  public function get_font_items() {
    if ( ! $this->font_items ) {
      $this->font_items = $this->load_items();
    }
    return $this->font_items;
  }

  public function get_font_config() {
    if ( ! $this->font_config ) {
      $this->font_config = $this->load_config();
    }
    return $this->font_config;
  }

  protected function preload_config() {
    $preloaded = apply_filters('cs_preload_font_config', false );
    if ($preloaded) {
      return $preloaded;
    }
    $saved = get_option( 'cornerstone_font_config' );
    return ( is_null( $saved ) ) ? array() : json_decode( wp_unslash( $saved ), true );
  }

  protected function load_config() {
    return wp_parse_args( $this->preload_config(), array(
      'googleSubsets' => array(),
      'typekitKitID' => '',
      'customFontItems' => array(),
      'customFontFaceCSS' => '',
      'fontDisplay' => 'auto'
    ) );

  }

  protected function load_items() {
    $preloaded = apply_filters('cs_preload_font_items', false );
    if ($preloaded) {
      return $preloaded;
    }
    $stored = get_option( 'cornerstone_font_items' );
    if ($stored === false ) {
      $stored = wp_slash( cs_json_encode( $this->default_font_items() ) );
      update_option( 'cornerstone_font_items', $stored );
    }
    return ( is_null( $stored ) ) ? array() : json_decode( wp_unslash( $stored ), true );
  }

  protected function locate_font( $_id ) {
    $this->get_font_items();
    foreach ($this->font_items as $font) {
      if ( isset( $font['_id'] ) && $_id === $font['_id'] ) {
        return $font;
      }
    }
    return array(
      'family' => 'inherit',
      'stack' => 'inherit',
      'weights' => array( 'inherit' ),
      'source' => 'system'
    );
  }

  public function queue_font( $font ) {

    if ( 'system' === $font['source'] || 'extend' === $font['source'] ) {
      return;
    }

    if ( isset( $this->queue[$font['stack']] ) ) {
      $this->queue[$font['stack']]['weights'] = array_unique( array_merge( $this->queue[$font['stack']]['weights'], $font['weights'] ) );
    } else {
      $this->queue[$font['stack']] = $font;
    }

    if ( ! isset( $this->queue[$font['stack']]['weights'] ) ) {
      $this->queue[$font['stack']]['weights'] = array();
    }

  }


  protected function queue_font_weight( $font, $weight ) {
    $this->queue_font( $font );
    if (isset($this->queue[$font['stack']]) && isset($this->queue[$font['stack']]['weights']) ) {
      if ( ! in_array($weight, $this->queue[$font['stack']]['weights'], true ) ) {
        $this->queue[$font['stack']]['weights'][] = $weight;
        $this->queue[$font['stack']]['weights'][] = $weight . 'i';
      }
    }
  }

  public function css_post_process_font_family( $value ) {
    $font = $this->locate_font($value);
    $this->queue_font( $font );
    return $font['stack'];
  }

  protected function normalize_weight( $value ) {
    return ( false === strpos($value, ':' ) ) ? 'inherit:' . $value : $value;
  }

  public function css_post_process_font_weight( $value ) {
    $value = $this->normalize_weight( $value );
    $parts = explode(':', $value );

    if ( 'inherit' === $parts[0] ) {
      return $parts[1];
    }

    $font = $this->locate_font($parts[0]);
    $weight = ( in_array( $parts[1], $font['weights'], true ) ) ? $parts[1] : $font['weights'][0];
    $this->queue_font_weight( $font, $weight );

    return $weight;
  }

  public function load_queued_fonts() {

    if  (count( array_keys( $this->queue ) ) <=0 ) {
      return;
    }

    $sources = array();

    foreach ($this->queue as $font) {
      if ( ! isset( $font['source'] ) ) {
        continue;
      }
      if ( ! isset( $sources[$font['source'] ] ) ) {
        $sources[$font['source']] = array();
      }
      $sources[$font['source']][] = array(
        'family' => $font['family'],
        'weights' => $font['weights']
      );
    }

    ksort($sources);

    do_action( 'cs_load_queued_fonts', $this->queue, $sources );

    foreach ($sources as $source => $fonts) {
      $method = array( $this, "load_fonts_$source" );
      if ( is_callable( $method ) ) {
        call_user_func_array( $method, array( $fonts ) );
      }
    }

    $this->queue = array();

  }

  public function load_fonts_google( $fonts ) {

    if ( ! apply_filters('cs_load_google_fonts', '__return_true' ) ) {
      return;
    }

    $in_footer = 'wp_footer' === current_action();

    $config = apply_filters( 'cs_google_font_config', wp_parse_args($this->get_font_config(), array(
      'googleSubsets' => array(),
      'fontDisplay' => 'auto'
    ) ) );

    $subsets = array_merge( array('latin', 'latin-ext'), $config['googleSubsets'] );
    $subsets = array_unique($subsets);

    $family_strings = array();

    foreach ($fonts as $font) {
      $weights = array_unique( $font['weights'] );
      $to_load = str_replace(' ', '+', $font['family'] ) . ':' . implode(',', $weights );
      if ( ! isset( $this->loaded[$to_load] ) ) {
        $family_strings[] = $to_load;
        $this->loaded[$to_load] = true;
      }
    }

    if ( count($family_strings) <=0 ) {
      return;
    }

    $request = esc_url( add_query_arg( array(
      'family' => implode('%7C', $family_strings), //Was | (pipe), but %7C is required for W3C Markup validation, this is also more optimized than using urlencoder
      'subset' => implode(',', $subsets ),
      'display' => $config['fontDisplay']
    ), apply_filters('cs_google_fonts_uri', '//fonts.googleapis.com/css' ) ) );

    $atts = cs_atts( array(
      'rel'   => 'stylesheet',
      'href'  => apply_filters( 'cs_google_fonts_href', $request ),
      'type'  => 'text/css',
      'media' => 'all',
      'data-x-google-fonts' => null,
    ) );

    $output = "<link $atts/>";

    if ( $in_footer ) {
      $output = $this->late_google_font_script( $output );
    }

    echo $output;

  }

  public function late_google_font_script( $output ) {

    ob_start();

    ?>
    <script>
      (function($){
        if ( ! $ ) return;
        var $gf = $('<?php echo $output; ?>');
        $('head').append($gf);
      })(jQuery);
    </script>
    <?php

    return ob_get_clean();

  }

  public function load_fonts_typekit( $fonts ) {
    add_action( did_action('cs_head_late_after') ? 'wp_footer' : 'cs_head_late_after', array( $this, 'output_typekit_script') );
  }

  public function load_fonts_custom( $fonts ) {

    $config = apply_filters( 'cs_custom_font_config', wp_parse_args($this->get_font_config(), array(
      'customFontItems' => array(),
      'fontDisplay'     => 'auto'
    ) ) );

    $load = array();
    $buffer = '';

    foreach ($fonts as $font) {
      $load[] = $font['family'];
    }

    foreach ($config['customFontItems'] as $item) {
      if (in_array($item['family'], $load)) {
        $buffer .= $this->make_custom_font_css( $item, $config );
      }
    }

    if ( $buffer ) {
      CS()->novus()->service('Styling')->addStyles( 'cs-custom-fonts', $buffer, 3 );
    }

  }

  public function identify_custom_font_variants( $item ) {

    $variants = [];
    $variant_config = [];

    foreach ($item['files'] as $file) {
      $key = $file['weight'] . ':' . $file['style'];

      if ( ! isset( $variants[ $key ] ) ) {
        $variant_config[$key] = [ esc_attr($file['weight']), esc_attr($file['style']) ];
        $variants[ $key ] = [];
      }
      $file_parts = explode( '.', $file['filename']);
      $format = array_pop( $file_parts );
      if ($format) {
        $variants[ $key ][] = [esc_attr($file['url']), $this->normalize_format( $format)];
      }
    }

    return [$variants, $variant_config];

  }

  public function normalize_format( $format ) {
    switch ($format) {
      case 'ttf':
        return "format('truetype')";
      case 'otf':
        return "format('opentype')";
      case 'woff':
        return "format('woff')";
      case 'woff2':
        return "format('woff2')";
    }

    return "";
  }

  public function make_custom_font_css( $item, $config ) {

    list( $variants, $variant_config ) = $this->identify_custom_font_variants( $item );

    $family = isset($item['stack']) ? $item['stack'] : $item['family'];
    $display = esc_attr( $config['fontDisplay'] );

    $buffer = '';

    foreach ($variants as $key => $variant_files) {
      list($weight, $style) = $variant_config[$key];

      $sources = [];
      foreach ($variant_files as $file) {
        list($url, $format) = $file;
        $sources[] = "url('$url') $format";
      }
      $sources = implode(', ', $sources);
      $buffer .= "@font-face { font-family: $family; font-display: $display; src: $sources; font-weight: $weight; font-style: $style; }";
    }

    return $buffer;
  }

  public function output_typekit_script() {

    $config = $this->get_font_config();

    if ( ! $config['typekitKitID'] ) {
      return;
    }

    ?>
    <script id="cs-typekit-loader">
      (function(doc){
        var config = { kitId:'<?php echo $config['typekitKitID'];?>', async:true }

        var timer = setTimeout(function(){
          doc.documentElement.className = doc.documentElement.className.replace(/\bwf-loading\b/g,"") + " wf-inactive";
        }, 3000)

        var tk = doc.createElement("script")
        var loaded = false
        var firstScript = doc.getElementsByTagName("script")[0]

        doc.documentElement.className += " wf-loading"

        tk.src = 'https://use.typekit.net/' + config.kitId + '.js'
        tk.async = true
        tk.onload = tk.onreadystatechange = function(){
          if (loaded || this.readyState && this.readyState != "complete" && this.readyState != "loaded") return
          loaded = true
          clearTimeout(timer)
          try { Typekit.load(config) } catch(e){}
        }

        firstScript.parentNode.insertBefore(tk, firstScript)
      })(window.document)
    </script>
    <?php

  }

  public function typekit_loading_styles() {

    $config = $this->get_font_config();

    if ( ! $config['typekitKitID'] ) {
      return;
    }

    $css = '.wf-loading a, .wf-loading p, .wf-loading ul, .wf-loading ol, .wf-loading dl, .wf-loading h1, .wf-loading h2, .wf-loading h3, .wf-loading h4, .wf-loading h5, .wf-loading h6, .wf-loading em, .wf-loading pre, .wf-loading cite, .wf-loading span, .wf-loading table, .wf-loading strong, .wf-loading blockquote { visibility: hidden !important; }';
    CS()->novus()->service('Styling')->addStyles( 'typekit', $css, 0 );

  }

  public function item_permissions( $value, $operation ) {

    $permissions = $this->plugin->component('App_Permissions');

    if ( 'update' === $operation ) {
      return $permissions->user_can('fonts.create') || $permissions->user_can('fonts.change') || $permissions->user_can('fonts.rename');
    }

    if ( 'delete' === $operation ) {
      return $permissions->user_can('fonts.delete');
    }

    return true;

  }

  public function config_permissions( $value, $operation ) {

    $permissions = $this->plugin->component('App_Permissions');

    if ( 'update' === $operation ) {
      return $permissions->user_can('fonts.manage-google') || $permissions->user_can('fonts.manage-adobe-fonts');
    }

    return 'delete' !== $operation;

  }

  public function upload_check( $result, $file, $filename, $mimes, $real_mime ) {

    $mime_types = $this->mime_types();

    $parts = explode( '.', $filename);
    $ext = end($parts);

    if ( isset($mime_types[$ext]) && false !== strpos( $mime_types[$ext], $real_mime ) ) {
      $ext_mime_types = explode('|', $mime_types[$ext]);
      $result['ext'] = $ext;
      $result['type'] = array_shift( $ext_mime_types );
    }

    return $result;

  }

  public function upload_mimes( $mime_types ) {

    $new_types = $this->mime_types();

    foreach ($new_types as $ext => $type) {
      if (! isset($mime_types[$ext])) {
        $mime_types[$ext] = $type;
      }
    }

    return $mime_types;
  }

  public function mime_types() {

    return apply_filters( 'cs_font_manager_mime_types', array(
      'woff2' => 'font/woff2|application/octet-stream',
      'woff' => 'font/woff|application/font/woff|application/font-woff|application/octet-stream',
      'ttf' => 'font/sfnt|application/x-font-ttf'
    ) );

  }

  public function get_app_data() {
    return array(
      'fontItems'           => $this->get_font_items(),
      'fontConfig'          => $this->get_font_config(),
      'customFontMimeTypes' => $this->mime_types(),
      'fallbackFont'        => $this->get_fallback_font(),
      'extend'              => $this->get_extended()
    );
  }

}
