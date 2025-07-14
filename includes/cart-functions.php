<?php

add_filter('woocommerce_product_single_add_to_cart_text', 'woo_customized_dynamic_cart_btn_text', 20, 2);
add_filter('woocommerce_product_add_to_cart_text', 'woo_customized_dynamic_cart_btn_text', 20, 2);

function woo_customized_dynamic_cart_btn_text($default_text, $product = null) {
    error_log('7: cart button text' . print_r($default_text, true));
    if (!$product) {
        global $product;
    }

    if (!$product instanceof WC_Product) {
        return $default_text;
    }

    $product_id = $product->get_id();

    // Get product level settings
    $enable_custom = get_post_meta($product_id, '_woo_enable_custom_text', true);
    $product_text   = get_post_meta($product_id, '_woo_product_cart_text', true);

    // Get global settings
    $global_enabled = get_option('woo_customized_enabled');
    $global_text    = get_option('woo_customized_cart_text');
    error_log('25 cart: enabled custom ::' . print_r($enable_custom, true));
    if ($global_enabled && $enable_custom == 'yes' && !empty($product_text)) {
        return esc_html($product_text);
    } elseif ($global_enabled && $enable_custom == 'yes' && !empty($global_text)) {
        return esc_html($global_text);
    }

    return $default_text;
}

add_filter('woocommerce_add_cart_item_data', 'woo_add_category_product_code_to_cart', 10, 2);
function woo_add_category_product_code_to_cart($cart_item_data, $product_id) {
    $terms = get_the_terms($product_id, 'product_cat');

    if (!empty($terms) && !is_wp_error($terms)) {
        // Take the first category only (or you can loop through all)
        $term_id = $terms[0]->term_id;
        $product_code = get_term_meta($term_id, 'product_code', true);
        if (!empty($product_code)) {
            $cart_item_data['category_product_code'] = sanitize_text_field($product_code);
        }
    }

    return $cart_item_data;
}

add_filter('woocommerce_get_item_data', 'woo_display_product_code_in_cart', 10, 2);
function woo_display_product_code_in_cart($item_data, $cart_item) {
    if (!empty($cart_item['category_product_code'])) {
        $item_data[] = array(
            'key'   => __('Product Code', 'woo-customized'),
            'value' => wc_clean($cart_item['category_product_code']),
            'display' => '',
        );
    }

    return $item_data;
}

