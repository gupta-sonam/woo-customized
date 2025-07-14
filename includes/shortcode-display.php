<?php
/**
 * Shortcode: [woo_cust_pdts image="yes" pagination="yes" per_page="5"]
 */

add_shortcode('woo_cust_pdts', 'woo_custom_product_list_shortcode');

function woo_custom_product_list_shortcode($atts) {
    ob_start();

    $atts = shortcode_atts([
        'image'      => 'yes',     
        'pagination' => 'yes',
        'per_page'   => -1,
        'paged'      => (get_query_var('paged')) ? get_query_var('paged') : 1
    ], $atts);

    $args = [
        'post_type'      => 'product',
        'posts_per_page' => (int)$atts['per_page'],
        'paged'          => $atts['paged'],
        'post_status'    => 'publish'
    ];

    $loop = new WP_Query($args);

    if ($loop->have_posts()) {
        echo '<div class="woo-custom-product-list">';

        while ($loop->have_posts()) {
            $loop->the_post();
            global $product;
            error_log('product obj:' . print_r($product, true));
            $product_id = $product->get_id();
            $price = $product->get_price_html();
            $title = get_the_title();
            $short_desc = apply_filters('woocommerce_description', $product->get_description());
            $button_text = apply_filters('woocommerce_product_add_to_cart_text', $product->add_to_cart_text(), $product);

            echo '<div class="woo-custom-product">';

            // Image
            if ($atts['image'] === 'yes') {
                echo '<div class="woo-img">' . $product->get_image() . '</div>';
            }

            // Title and Price
            echo '<div class="woo-info">';
            echo '<h3>' . esc_html($title) . '</h3>';
            echo '<p>' . $price . '</p>';
            echo '<a href="#" class="woo-show-details" data-desc="' . esc_attr(wp_strip_all_tags($short_desc)) . '">Show Details</a>';
            echo '</div>';

            // Quantity and Add to Cart
            echo '<div class="woo-action">';
            echo '<div class="woo-qty-controls">';
            echo '<button class="woo-qty-minus">-</button>';
            echo '<input type="number" value="1" min="1" class="woo-qty-input" data-product_id="' . esc_attr($product_id) . '">';
            echo '<button class="woo-qty-plus">+</button>';
            echo '</div>';
            echo '<button class="woo-add-to-cart-button" data-product_id="' . esc_attr($product_id) . '">' . esc_html($button_text) . '</button>';
            echo '</div>';

            echo '</div>'; // .woo-custom-product
        }

        echo '</div>'; // .woo-custom-product-list

        // Pagination
        if ($atts['pagination'] === 'yes') {
            echo '<div class="woo-pagination">';
            echo paginate_links([
                'total'   => $loop->max_num_pages,
                'current' => max(1, $atts['paged']),
                'format'  => '?paged=%#%'
            ]);
            echo '</div>';
        }
    } else {
        echo '<p>No products found.</p>';
    }

    wp_reset_postdata();
    return ob_get_clean();
}
