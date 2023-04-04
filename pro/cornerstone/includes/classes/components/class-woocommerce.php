<?php

class Cornerstone_WooCommerce extends Cornerstone_Plugin_Component {

  public function setup() {

    if( !class_exists( 'WC_API' ) ){
        return;
    }

    add_filter( 'cs_app_data', [ $this, 'app_data' ], 10, 2 );


    add_filter( 'cs_layout_default_preview_url', [ $this, 'set_default_preview_url' ], 10, 2 );
    add_filter( 'cs_looper_main_query', [ $this, 'setup_main_looper_query' ] );

    add_action( 'cs_layout_begin_single', [ $this, 'maybe_before_product'] );
    add_action( 'cs_layout_end_single', [ $this, 'maybe_after_product'] );
    add_filter( 'cs_layout_output_before_single', [ $this, 'product_wrapper_open'] );
    add_filter( 'cs_layout_output_after_single',  [ $this, 'product_wrapper_close'] );

    add_filter( 'cs_assignment_context_post_types', [$this, 'unset_preview_post_type' ] );
    add_filter( 'cs_preview_context_post_types', [$this, 'unset_preview_post_type' ] );

    add_filter( 'cs_assignment_contexts', [$this, 'assignment_contexts'] );
    add_filter( 'cs_preview_contexts', [$this, 'preview_contexts'] );
    add_filter( 'cs_condition_contexts', [$this, 'condition_contexts'] );

    add_filter( 'cs_condition_rule_single_product', [ $this, 'condition_rule_single_product' ] );
    add_filter( 'cs_condition_rule_archive_shop', [ $this, 'condition_rule_archive_shop' ] );

    add_filter( 'cs_condition_rule_wc_product_has', [ $this, 'condition_rule_wc_product_has' ], 10, 2 );
    add_filter( 'cs_condition_rule_wc_product_is', [ $this, 'condition_rule_wc_product_is' ], 10, 2 );

    add_filter( 'cs_condition_rule_wc_is_shop', [ $this, 'condition_rule_wc_is_shop' ], 10, 2 );
    add_filter( 'cs_condition_rule_wc_product_type', [ $this, 'condition_rule_wc_product_type' ], 10, 2 );
    add_filter( 'cs_condition_rule_wc_is_cart', [ $this, 'condition_rule_wc_is_cart' ], 10, 2 );
    add_filter( 'cs_condition_rule_wc_is_checkout', [ $this, 'condition_rule_wc_is_checkout' ], 10, 2 );
    add_filter( 'cs_condition_rule_wc_is_account', [ $this, 'condition_rule_wc_is_account' ], 10, 2 );

    add_filter( 'cs_detect_layout_type', [ $this, 'detect_layout_type'] );

    add_action( 'wp', [ $this, 'x_remove_checkout_terms_and_conditions'] );
  }

  public function setup_main_looper_query( $provider ) {
    if (is_shop() || is_product_tag() || is_product_category() ) {
      return new Cornerstone_Looper_Provider_Shop();
    }

    return $provider;
  }

  public function app_data( $data ) {

    $data['woocommerce'] = true;
    return $data;

  }

  public function set_default_preview_url( $url, $settings ) {
    if ($settings['layout_type'] === 'single-wc') {
      $posts = get_posts( ['numberposts' => 1, 'post_type' => 'product' ] );
      if (!empty($posts[0])) {
        return get_permalink( $posts[0]->ID );
      }
    }

    if ($settings['layout_type'] === 'archive-wc') {
      return get_permalink( wc_get_page_id( 'shop' ) );
    }

    return $url;
  }

  public function product_wrapper_open( $content ) {
    if ( is_singular( 'product' )) {
      global $product;
      ob_start();
      ?><div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>><?php
      return ob_get_clean();
    }

    return $content;
  }

  public function product_wrapper_close( $content ) {

    if ( is_singular( 'product' ) ) {
      return '</div>';
    }

    return $content;
  }

  public function maybe_before_product() {
    if ( is_singular( 'product' ) ) {
      remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );
      do_action( 'woocommerce_before_single_product' );
    }
  }

  public function maybe_after_product() {
    if ( is_singular( 'product' ) ) {
      do_action( 'woocommerce_after_single_product' );
    }
  }


  public function unset_preview_post_type( $post_types ) {
    unset($post_types['product']);
    return $post_types;
  }

  public function assignment_contexts( $contexts ) {

    $contexts['labels']['single-wc' ] = __( 'WooCommerce Single', 'cornerstone' );
    $contexts['labels']['archive-wc'] = __( 'WooCommerce Archive', 'cornerstone' );

    $contexts['controls']['single-wc' ] = $this->assignment_context_single();
    $contexts['controls']['archive-wc'] = $this->assignment_context_archive();

    return $contexts;
  }

  public function preview_contexts( $contexts ) {

    $contexts['labels']['single-wc' ] = __( 'WooCommerce Single', 'cornerstone' );
    $contexts['labels']['archive-wc'] = __( 'WooCommerce Archive', 'cornerstone' );

    $contexts['controls']['single-wc' ] = $this->preview_context_single();
    $contexts['controls']['archive-wc'] = $this->preview_context_archive();

    return $contexts;
  }

  public function condition_contexts( $contexts ) {

    $contexts['labels']['wc' ] = __( 'WooCommerce', 'cornerstone' );

    $contexts['controls']['wc'] = $this->condition_contexts_wc();

    return $contexts;
  }

  public function condition_contexts_wc() {

    return [
      [
        'key'   => 'wc:product-is',
        'label' => __('Product (is)', 'cornerstone'),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => [
            [ 'value' => 'is-downloadable', 'label' => __('Downloadable', 'cornerstone') ],
            [ 'value' => 'is-featured', 'label' => __('Featured', 'cornerstone') ],
            [ 'value' => 'is-in-stock', 'label' => __('In Stock', 'cornerstone') ],
            [ 'value' => 'is-on-backorder', 'label' => __('On Backorder', 'cornerstone') ],
            [ 'value' => 'is-on-sale', 'label' => __('On Sale', 'cornerstone') ],
            [ 'value' => 'is-purchasable', 'label' => __('Purchasable', 'cornerstone') ],
            [ 'value' => 'is-shipping-taxable', 'label' => __('Shipping Taxable', 'cornerstone') ],
            [ 'value' => 'is-sold-individually', 'label' => __('Sold Individually', 'cornerstone') ],
            [ 'value' => 'is-taxable', 'label' => __('Taxable', 'cornerstone') ],
            [ 'value' => 'is-virtual', 'label' => __('Virtual', 'cornerstone') ],
            [ 'value' => 'is-visible', 'label' => __('Visible', 'cornerstone') ],
          ]
        ]
      ], [
        'key'   => 'wc:product-has',
        'label' => __('Product (has)', 'cornerstone'),
        'toggle' => [
          'type' => 'boolean',
          'labels' => [
            __('has', 'cornerstone'),
            __('has not', 'cornerstone'),
          ]
        ],
        'criteria' => [
          'type'    => 'select',
          'choices' => [
            [ 'value' => 'has-image', 'label' => __('Image', 'cornerstone') ],
            [ 'value' => 'has-gallery', 'label' => __('Gallery', 'cornerstone') ],
            [ 'value' => 'has-reviews', 'label' => __('Reviews', 'cornerstone') ],
            [ 'value' => 'has-attributes', 'label' => __('Attributes', 'cornerstone') ],
            [ 'value' => 'has-child', 'label' => __('Child', 'cornerstone') ],
            [ 'value' => 'has-default-attributes', 'label' => __('Default Attributes', 'cornerstone') ],
            [ 'value' => 'has-dimensions', 'label' => __('Dimensions', 'cornerstone') ],
            [ 'value' => 'has-options', 'label' => __('Options', 'cornerstone') ],
            [ 'value' => 'has-weight', 'label' => __('Weight', 'cornerstone') ]
          ]
        ]
      ], [
        'key'   => 'wc:product-type',
        'label' => __('Product Type', 'cornerstone'),
        'toggle' => [
          'type' => 'boolean',
        ],
        'criteria' => [
          'type'    => 'select',
          'choices' => apply_filters( 'cs_conditions_wc_product_types', [
            [ 'value' => 'simple',    'label' => __('Simple', 'cornerstone') ],
            [ 'value' => 'external',  'label' => __('External', 'cornerstone') ],
            [ 'value' => 'variable',  'label' => __('Variable', 'cornerstone') ],
            [ 'value' => 'variation', 'label' => __('Variation', 'cornerstone') ],
          ] )
        ]
      ], [
        'key'    => 'wc:is-shop',
        'label'  => __('Shop', 'cornerstone'),
        'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.being-viewed') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.being-viewed') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
      ], [
        'key'    => 'wc:is-cart',
        'label'  => __('Cart', 'cornerstone'),
        'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.being-viewed') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.being-viewed') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
      ], [
        'key'    => 'wc:is-checkout',
        'label'  => __('Checkout', 'cornerstone'),
        'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.being-viewed') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.being-viewed') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
      ], [
        'key'    => 'wc:is-account',
        'label'  => __('Account', 'cornerstone'),
        'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.being-viewed') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.being-viewed') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
      ]
    ];
  }

  public function assignment_context_single() {

    $conditions = [
      [
        'key'    => "single:product",
        'label'  => __('All Products'),
      ]
    ];

    $post_type = 'product';
    $post_type_obj = get_post_type_object( $post_type );

    $conditions[] = [
      'key'    => "single:specific-post-of-type|$post_type",
      'label'  => sprintf(__('%s (Specific)', 'cornerstone'), $post_type_obj->labels->singular_name),
      'toggle' => ['type' => 'boolean'],
      'criteria' => [
        'type'    => 'select',
        'choices' => "posts:$post_type"
      ]
    ];

    $post_type_taxonomies = get_object_taxonomies($post_type);

    foreach ($post_type_taxonomies as $taxonomy) {
      if ($taxonomy === 'post_format') {
        continue;
      }

      $taxonomy_obj = get_taxonomy($taxonomy);

      $conditions[] = [
        'key'    => "single:post-type-with-term|$post_type|$taxonomy",
        'label'  => sprintf(_x('%s %s', '[Post Type] [Post Taxonomy]', 'cornerstone'), $post_type_obj->labels->singular_name, $taxonomy_obj->labels->singular_name),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => "terms:$taxonomy"
        ]
      ];
    }

    if ($post_type_obj->hierarchical) {

      $conditions[] = [
        'key'    => "single:parent|$post_type",
        'label'  => sprintf(__('%s Parent', 'cornerstone'), $post_type_obj->labels->singular_name),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => "posts:$post_type"
        ]
      ];

      $conditions[] = [
        'key'    => "single:ancestor|$post_type",
        'label'  => sprintf(__('%s Ancestor', 'cornerstone'), $post_type_obj->labels->singular_name),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => "posts:$post_type"
        ]
      ];

      if (post_type_supports($post_type, 'page-attributes')) {
        $conditions[] = [
          'key'    => "single:page-template|$post_type",
          'label'  => sprintf(__('%s Template', 'cornerstone'), $post_type_obj->labels->singular_name),
          'toggle' => ['type' => 'boolean'],
          'criteria' => [
            'type'    => 'select',
            'choices' => cs_get_page_template_options($post_type)
          ]
        ];
      }
    }

    if (post_type_supports($post_type, 'post-formats')) {
      $conditions[] = [
        'key'    => "single:format|$post_type",
        'label'  => sprintf(__('%s Format', 'cornerstone'), $post_type_obj->labels->singular_name),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => cs_get_post_format_options()
        ]
      ];
    }

    $conditions[] = [
      'key'    => "single:publish-date|$post_type",
      'label'  => sprintf(__('%s Publish Date', 'cornerstone'), $post_type_obj->labels->singular_name),
      'toggle' => [
        'type'   => 'boolean',
        'labels' => [csi18n('app.conditions.before'), csi18n('app.conditions.after')]
      ],
      'criteria' => ['type' => 'date-picker'],
    ];

    $conditions[] = [
      'key'    => "single:status|$post_type",
      'label'  => sprintf(__('%s Status', 'cornerstone'), $post_type_obj->labels->singular_name),
      'toggle' => ['type' => 'boolean'],
      'criteria' => [
        'type'    => 'select',
        'choices' => cs_get_post_status_options()
      ]
    ];

    return array_merge( $conditions, [
      [
        'key'    => 'wc:is-cart',
        'label'  => __('Cart', 'cornerstone'),
        'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.being-viewed') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.being-viewed') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
      ], [
        'key'    => 'wc:is-checkout',
        'label'  => __('Checkout', 'cornerstone'),
        'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.being-viewed') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.being-viewed') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
      ], [
        'key'    => 'wc:is-account',
        'label'  => __('Account', 'cornerstone'),
        'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.being-viewed') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.being-viewed') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
      ]
    ]) ;
  }

  public function assignment_context_archive() {

    $conditions = [
      [
        'key'    => "archive:shop",
        'label'  => __('Shop'),
      ]
    ];

    $post_type = 'product';
    $post_type_obj = get_post_type_object( $post_type );
    $post_type_taxonomies = get_object_taxonomies($post_type);
    $taxonomy_options = [];
    $taxonomy_conditions = [];

    foreach ($post_type_taxonomies as $taxonomy) {

      $taxonomy_obj = get_taxonomy($taxonomy);
      if ( ! $taxonomy_obj->public ) {
        continue;
      }

      $taxonomy_options[] = ['value' => $taxonomy, 'label' => $taxonomy_obj->labels->singular_name];

      $taxonomy_conditions[] = [
        'key'    => "archive:post-type-with-term|$post_type|$taxonomy",
        'label'  => sprintf(_x('%s %s', '[Post Type] [Post Taxonomy]', 'cornerstone'), $post_type_obj->labels->singular_name, $taxonomy_obj->labels->singular_name),
        'criteria' => [
          'type'    => 'select',
          'choices' => "terms:$taxonomy"
        ]
      ];
    }

    $conditions[] = [
      'key'    => "archive:taxonomy|$post_type",
      'label'  => sprintf(_x('%s Taxonomy', 'cornerstone'), $post_type_obj->labels->singular_name),
      'toggle' => ['type' => 'boolean'],
      'criteria' => [
        'type'    => 'select',
        'choices' => $taxonomy_options
      ]
    ];

    return array_merge( $conditions, $taxonomy_conditions );
  }

  public function preview_context_single() {

    $post_type_obj = get_post_type_object( 'product' );

    return [
      [
        'key'    => "single:post-type|product",
        'label'  => $post_type_obj->labels->singular_name,
        'criteria' => [
          'type'    => 'select',
          'choices' => "posts:product"
        ]
      ], [
        'key'      => 'wc:is-cart',
        'label'    => __('Cart', 'cornerstone'),
        'criteria' => [
          'url' => wc_get_page_permalink( 'cart' )
        ]
      ], [
        'key'      => 'wc:is-checkout',
        'label'    => __('Checkout', 'cornerstone'),
        'criteria' => [
          'url' => wc_get_page_permalink( 'checkout' )
        ]
      ], [
        'key'      => 'wc:is-account',
        'label'    => __('Account', 'cornerstone'),
        'criteria' => [
          'url' => wc_get_page_permalink( 'account' )
        ]
      ]
    ];

  }

  public function preview_context_archive() {

    $archive = [
      [
        'key'      => 'archive:shop',
        'label'    => __('Shop', 'cornerstone'),
        'criteria' => [
          'url' => wc_get_page_permalink( 'shop' )
        ]
      ]
    ];

    $post_type = 'product';
    $post_type_obj = get_post_type_object( 'product' );
    $post_type_taxonomies = get_object_taxonomies($post_type);

    foreach ($post_type_taxonomies as $taxonomy) {
      if ($taxonomy === 'post_format') {
        continue;
      }

      $taxonomy_obj = get_taxonomy($taxonomy);

      $archive[] = [
        'key'    => "archive:post-type-with-term|$post_type|$taxonomy",
        'label'  => sprintf(_x('%s %s', '[Post Type] [Post Taxonomy]', 'cornerstone'), $post_type_obj->labels->singular_name, $taxonomy_obj->labels->singular_name),
        'criteria' => [
          'type'    => 'select',
          'choices' => "terms:$taxonomy"
        ]
      ];
    }

    return $archive;
  }

  public function is_wc_archive() {
    return is_shop() || is_product_tag() || is_product_category();
  }

  public function detect_layout_type( $type ) {

    if ( is_woocommerce() && $this->is_wc_archive() ) {
      return 'layout-archive-wc';
    }

    if ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) {
      return 'layout-single-wc';
    }

    return $type;

  }

  public function condition_rule_single_product() {
    return is_singular('product');
  }

  public function condition_rule_archive_shop() {
    return $this->is_wc_archive();
  }

  public function condition_rule_wc_product_is( $result, $args ) {

    list($type) = $args;

    global $product;

    if (empty($product)) {
      return false;
    }

    switch ($type) {
      case 'is-downloadable': {
        return $product->is_downloadable();
      }
      case 'is-featured': {
        return $product->is_featured();
      }
      case 'is-in-stock': {
        return $product->is_in_stock();
      }
      case 'is-on-backorder': {
        return $product->is_on_backorder();
      }
      case 'is-on-sale': {
        return $product->is_on_sale();
      }
      case 'is-purchasable': {
        return $product->is_purchasable();
      }
      case 'is-shipping-taxable': {
        return $product->is_shipping_taxable();
      }
      case 'is-sold-individually': {
        return $product->is_sold_individually();
      }
      case 'is-taxable': {
        return $product->is_taxable();
      }
      case 'is-virtual': {
        return $product->is_virtual();
      }
      case 'is-visible': {
        return $product->is_visible();
      }
    }

    return $result;

  }

  public function condition_rule_wc_product_has( $result, $args ) {

    list($type) = $args;

    global $product;

    if (empty($product)) {
      return false;
    }

    switch ($type) {
      case 'has-image': {
        return !empty( $product->get_image_id() );
      }
      case 'has-gallery': {
        return !empty( $product->get_gallery_image_ids() );
      }
      case 'has-reviews': {
        return ! empty( get_comments_number( $product->get_id()) );
      }
      case 'has-attributes': {
        return $product->has_attributes();
      }
      case 'has-child': {
        return $product->has_child();
      }
      case 'has-default-attributes': {
        return $product->has_default_attributes();
      }
      case 'has-dimensions': {
        return $product->has_dimensions();
      }
      case 'has-options': {
        return $product->has_options();
      }
      case 'has-weight': {
        return $product->has_weight();
      }
    }

    return $result;

  }

  public function condition_rule_wc_is_shop( $result, $args ) {
    return is_shop();
  }

  public function condition_rule_wc_is_cart( $result, $args  ) {
    return is_cart();
  }

  public function condition_rule_wc_is_checkout( $result, $args  ) {
    return is_checkout();
  }

  public function condition_rule_wc_is_account( $result, $args  ) {
    return is_account_page();
  }

  public function condition_rule_wc_product_type( $result, $args  ) {
    list($type) = $args;

    global $product;

    if (empty($product)) {
      return false;
    }

    return $type === $product->get_type();

  }

  public function x_remove_checkout_terms_and_conditions() {
    remove_action('woocommerce_checkout_terms_and_conditions','wc_terms_and_conditions_page_content', 30);
    add_action('woocommerce_checkout_terms_and_conditions', [ $this, 'x_wc_terms_and_conditions_page_content' ], 30);
  }

  public function x_wc_terms_and_conditions_page_content() {

    $terms_page_id = wc_terms_and_conditions_page_id();

    if ( ! $terms_page_id ) {
      return;
    }

    $page = get_post( $terms_page_id );

    if ( $page && 'publish' === $page->post_status && $page->post_content && ! has_shortcode( $page->post_content, 'woocommerce_checkout' ) ) {

      echo '<div class="woocommerce-terms-and-conditions" style="display: none; max-height: 200px; overflow: auto;">' . wc_format_content( wp_kses_post( do_shortcode( str_replace( '[cs_content]','[cs_content _p="' . $page->ID . '"]', $page->post_content ) ) ) ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

    }
  }

}
