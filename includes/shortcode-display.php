<?php
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

    if ($loop->have_posts()) : ?>
        <div class="woo-custom-product-list">
            <?php while ($loop->have_posts()) : $loop->the_post();
                global $product;
                $product_id = $product->get_id();
                $price_html = $product->get_price_html();
                $price_val = $product->get_price();
                $title = get_the_title();
                $short_desc = apply_filters('woocommerce_description', $product->get_description());
                $button_text = apply_filters('woocommerce_product_add_to_cart_text', $product->add_to_cart_text(), $product);
            ?>
                <div class="woo-custom-product" data-price="<?php echo esc_attr($price_val); ?>">
                    <?php if ($atts['image'] === 'yes') : ?>
                        <div class="woo-img"><?php echo $product->get_image(); ?></div>
                    <?php endif; ?>

                    <div class="woo-info">
                        <h3><?php echo esc_html($title); ?></h3>
                        <p class="woo-single-price"><?php echo $price_html; ?></p>
                        <p><?php _e('Total', 'woo-customized');?>: <span class="woo-total-price"><?php echo wc_price($price_val); ?></span></p>
                        <a href="#" class="woo-show-details" data-desc="<?php echo esc_attr(wp_strip_all_tags($short_desc)); ?>"><?php _e('Show Details', 'woo-customized');?></a>
                    </div>

                    <div class="woo-action">
                        <div class="woo-qty-controls">
                            <button class="woo-qty-minus">-</button>
                            <input type="number" value="1" min="1" class="woo-qty-input" data-product_id="<?php echo esc_attr($product_id); ?>">
                            <button class="woo-qty-plus">+</button>
                        </div>
                        <button class="woo-add-to-cart-button" data-product_id="<?php echo esc_attr($product_id); ?>">
                            <?php echo esc_html($button_text); ?>
                        </button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <?php if ($atts['pagination'] === 'yes') : ?>
            <div class="woo-pagination">
                <?php echo paginate_links([
                    'total'   => $loop->max_num_pages,
                    'current' => max(1, $atts['paged']),
                    'format'  => '?paged=%#%'
                ]); ?>
            </div>
        <?php endif; ?>

    <?php else : ?>
        <p><?php _e('No products found.', 'woo-customized');?></p>
    <?php endif;

    wp_reset_postdata();
    return ob_get_clean();
}
