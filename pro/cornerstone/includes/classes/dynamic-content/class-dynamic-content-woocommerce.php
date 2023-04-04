<?php

class Cornerstone_Dynamic_Content_WooCommerce extends Cornerstone_Plugin_Component {

  public function setup() {
    add_filter( 'cs_dynamic_content_woocommerce', array( $this, 'supply_field' ), 10, 4 );
    add_action( 'cs_dynamic_content_setup', array( $this, 'register' ) );
    add_filter( 'cs_dynamic_content_post_id', array($this, 'shop_page_id') );
    add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'add_to_cart_fragment' ) );
  }

  public function register() {
    cornerstone_dynamic_content_register_group(array(
      'name'  => 'woocommerce',
      'label' => csi18n('app.dc.group-title-woocommerce')
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'page_title',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.page-title' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'shop_url',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.shop-url' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'cart_url',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.cart-url' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'checkout_url',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.checkout-url' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'account_url',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.account-url' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'terms_url',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.terms-url' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'fallback_image',
      'type'  => 'image',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.fallback-image' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'cart_items_raw',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.cart-item-count-raw' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'cart_items',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.cart-item-count' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'cart_total_raw',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.cart-total-raw' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'cart_total',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.cart-total' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'cart_subtotal_raw',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.cart-subtotal-raw' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'cart_subtotal',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.cart-subtotal' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'currency_symbol',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.currency-symbol' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_price',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-price' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_regular_price',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-regular-price' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_sale_price',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-sale-price' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_price_html',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-price-html' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_sale_percentage_off',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-sale-percentage-off' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_id',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-id' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_class',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-class' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_sku',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-sku' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_title',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-title' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_url',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-url' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_short_description',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-short-description' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_image_id',
      'type'  => 'image',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-image-id' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_image',
      'type'  => 'image',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-image' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_gallery_ids',
      'type'  => 'array',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-gallery-ids' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_stock',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-stock' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_rating_count',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-rating-count' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_average_rating',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-average-rating' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_review_count',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-review-count' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_description',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-description' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_additional_information',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-additional-information' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_reviews',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-reviews' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_weight',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-weight' ),
      'controls' => array( 'product' )
    ));


    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_length',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-length' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_width',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-width' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_height',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-height' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_dimensions',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-dimensions' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_shipping_class',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-shipping-class' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_shipping_class_slug',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-shipping-class-slug' ),
      'controls' => array( 'product' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_type',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-type' ),
      'controls' => array( 'product' )
    ));

  }

  public function get_image_for_product( $product ) {
    $image_id = $product->get_image_id();

    if (!$image_id &&  $product->get_parent_id()) {
      $parent_product = wc_get_product( $product->get_parent_id() );
      if ( $parent_product ) {
        $image_id = $product->get_image_id();
      }
    }

    return $image_id;
  }

  public function supply_field( $result, $field, $args = array() ) {

    if ( 0 === strpos( $field, 'product') ) {
      $product = CS()->component('Dynamic_Content')->get_contextual_product( $args );

      if ( ! $product ) {
        return $result;
      }
    }

    if ( 0 === strpos( $field, 'cart') && ! WC()->cart ) {
      return $result;
    }

    switch ( $field ) {
      case 'page_title': {
        $result = woocommerce_page_title( false );
        break;
      }
      case 'shop_url': {
        $result = wc_get_page_permalink( 'shop' );
        break;
      }
      case 'cart_url': {
        $result = wc_get_page_permalink( 'cart' );
        break;
      }
      case 'checkout_url': {
        $result = wc_get_page_permalink( 'checkout' );
        break;
      }
      case 'account_url': {
        $result = wc_get_page_permalink( 'myaccount' );
        break;
      }
      case 'terms_url': {
        $result = wc_get_page_permalink( 'terms' );
        break;
      }
      case 'fallback_image':
        $result = wc_placeholder_img_src( isset( $args['size'] ) ? $args['size'] : 'woocommerce_thumbnail' );
        break;
      case 'cart_items_raw': {
        $result = WC()->cart->get_cart_contents_count();
        break;
      }
      case 'cart_items': {
        $result = $this->render_cart_items();
        break;
      }
      case 'cart_total_raw': {
        $result = WC()->cart->get_cart_total();
        break;
      }
      case 'cart_total': {
        $result = $this->render_cart_total();
        break;
      }
      case 'cart_subtotal_raw': {
        $result = WC()->cart->get_cart_subtotal();
        break;
      }
      case 'cart_subtotal': {
        $result = $this->render_cart_subtotal();
        break;
      }
      case 'currency_symbol': {
        $result = get_woocommerce_currency_symbol();
        break;
      }
      case 'product_price_html': {
        $result = $product->get_price_html();
        break;
      }
      case 'product_price': {
        $result = $this->format_price( $product->get_price(), $args, $product );
        break;
      }
      case 'product_regular_price': {
        $result = $this->format_price( $product->get_regular_price(), $args, $product );
        break;
      }
      case 'product_sale_price': {
        $result = $this->format_price( $product->get_sale_price(), $args, $product );
        break;
      }
      case 'product_sale_percentage_off': {

        $sale_price = $product->get_sale_price();

        if ($sale_price) {
          $result =  round(100 - ( (float) $sale_price / (float) $product->get_regular_price() * 100));
        }

        break;
      }
      case 'product_id': {
        $result = $product->get_id();
        break;
      }
      case 'product_sku': {
        $result = $product->get_sku();
        break;
      }
      case 'product_title': {
        $result = $product->get_title();
        break;
      }
      case 'product_url': {
        $result = $product->get_permalink();
        break;
      }
      case 'product_short_description': {
        $result = $product->get_short_description();
        break;
      }
      case 'product_image_id':
        $size = isset( $args['size'] ) ? $args['size'] : 'woocommerce_thumbnail';
        $image_id = $this->get_image_for_product( $product );
        $result = $image_id ? "$image_id:$size" : '';
        break;
      case 'product_image': {
        $size = isset( $args['size'] ) ? $args['size'] : 'woocommerce_thumbnail';
        $image_id = $this->get_image_for_product( $product );

        if ( $image_id ) {
          $result = cs_resolve_image_source( $image_id, $size );
        } else {
          $placeholder = wc_placeholder_img_src( $size );
          if ($placeholder) {
            $result = $placeholder;
          }
        }

        break;
      }
      case 'product_stock': {
        $result = $product->get_stock_quantity();
        break;
      }
      case 'product_rating_count': {
        $result = $product->get_rating_count();
        break;
      }
      case 'product_average_rating': {
        $result = $product->get_average_rating();
        break;
      }
      case 'product_review_count': {
        $result = $product->get_review_count();
        break;
      }
      case 'product_class': {
        $result = implode( ' ', wc_get_product_class( '', $product ) );
        break;
      }
      case 'product_description': {
        ob_start();
        the_content();
        $result = ob_get_clean();
        break;
      }
      case 'product_additional_information': {
        $result = '';
        if ( isset( $product ) && ( $product->has_attributes() || apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() ) ) ) {
          ob_start();
          do_action( 'woocommerce_product_additional_information', $product );
          $result = ob_get_clean();
        }
        break;
      }
      case 'product_reviews': {
        ob_start();
        comments_template();
        $result = ob_get_clean();
        break;
      }
      case 'product_weight': {
        $result = $product->has_weight() ? $product->get_weight() : '';
        break;
      }
      case 'product_length': {
        $result = $product->get_virtual() ? '' :  $product->get_length();
        break;
      }
      case 'product_width': {
        $result = $product->get_virtual() ? '' :  $product->get_width();
        break;
      }
      case 'product_height': {
        $result = $product->get_virtual() ? '' :  $product->get_height();
        break;
      }
      case 'product_dimensions': {
        $result = apply_filters( 'woocommerce_product_dimensions', wc_format_dimensions( $product->get_dimensions( false ) ), $product );
        break;
      }
      case 'product_shipping_class': {
        $term_id = $product->get_shipping_class_id();
        if ( $term_id ) {
          $term = get_term( $product->get_shipping_class_id(), 'product_shipping_class' );
          if (is_a( $term, 'WP_Term' ) ) {
            $result = $term->name;
          }
        }
        break;
      }
      case 'product_shipping_class_slug': {
        $result = $product->get_shipping_class();
        break;
      }
      case 'product_type': {
        $result = $product->get_type();
        break;
      }
      case 'product_gallery_ids': {
        $attachment_ids = $product->get_gallery_image_ids();
        $result = is_array( $attachment_ids ) ? $attachment_ids : [];
        break;
      }
    }

    return $result;

  }

  public function render_cart_items() {
    return sprintf('<span data-csdc-wc="cart-items">%d</span>', WC()->cart->get_cart_contents_count());
  }

  public function render_cart_total() {
    return sprintf('<span data-csdc-wc="cart-total">%s</span>', WC()->cart->get_cart_total());
  }

  public function render_cart_subtotal() {
    return sprintf('<span data-csdc-wc="cart-subtotal">%s</span>', WC()->cart->get_cart_subtotal());
  }

  public function add_to_cart_fragment( $fragments ) {

    $fragments['[data-csdc-wc="cart-items"]']    = $this->render_cart_items();
    $fragments['[data-csdc-wc="cart-total"]']    = $this->render_cart_total();
    $fragments['[data-csdc-wc="cart-subtotal"]'] = $this->render_cart_subtotal();
    return $fragments;

  }

  public function shop_page_id ( $id ) {

    if ( is_shop() && ! in_the_loop() && is_main_query() && ! apply_filters( 'cs_looper_in_wp_query', false ) ) {
      return wc_get_page_id ('shop');
    }

    return $id;

  }

  // Variation of WC price that doesn't generate additional HTML tags and omits the currency symbol

  public function format_price( $price, $args, $product ) {

    if (isset( $args['format'] ) && $args['format'] === "raw") {
      return $price;
    }

    // Follow global setting for tax inclusive/exclusive
    $is_tax_inclusive = get_option( 'woocommerce_tax_display_shop' ) === 'incl';

    // Allow overwriting
    if ( isset( $args['tax_inclusive'] ) ) {
      if ( $is_tax_inclusive && $args['tax_inclusive'] === 'false' ) {
        $is_tax_inclusive = false;
      }
      if ( ! $is_tax_inclusive && $args['tax_inclusive'] === 'true' ) {
        $is_tax_inclusive = true;
      }
    }

    $price = floatval( $is_tax_inclusive ? wc_get_price_including_tax( $product, [ 'price' => $price ] ) : wc_get_price_excluding_tax( $product, [ 'price' => $price ] ) );

    $args = wp_parse_args( $args, [
      'decimal_separator'  => wc_get_price_decimal_separator(),
      'thousand_separator' => wc_get_price_thousand_separator(),
      'decimals'           => wc_get_price_decimals(),
      'price_format'       => get_woocommerce_price_format(),
    ] );

    $negative = $price < 0;
    $price    = apply_filters( 'raw_woocommerce_price', $negative ? $price * -1 : $price );
    $price    = apply_filters( 'formatted_woocommerce_price', number_format( $price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator'] ), $price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator'] );

    if ( apply_filters( 'woocommerce_price_trim_zeros', false ) && $args['decimals'] > 0 ) {
      $price = wc_trim_zeros( $price );
    }

    return ( $negative ? '-' : '' ) . $price;

  }
}
