<?php
add_filter('woocommerce_product_data_tabs', 'woo_custom_product_tab');

function woo_custom_product_tab($tabs) {
    $global_enabled = get_option('woo_customized_enabled');
    if (!$global_enabled) {
        return $tabs;
    }

    $tabs['woo_custom_tab'] = array(
        'label'    => __('Custom Settings', 'woo-customized'),
        'target'   => 'woo_custom_product_data',
        'class'    => array('show_if_simple', 'show_if_variable'),
        'priority' => 80,
    );

    return $tabs;
}

add_action('woocommerce_product_data_panels', 'woo_custom_product_tab_content');

function woo_custom_product_tab_content() {
    global $post;

    $custom_enabled = get_post_meta($post->ID, '_woo_enable_custom_text', true);
    $custom_text = get_post_meta($post->ID, '_woo_product_cart_text', true);
    ?>
    <div id="woo_custom_product_data" class="panel woocommerce_options_panel">
        <div class="options_group">
            <?php
            woocommerce_wp_checkbox(array(
                'id'    => '_woo_enable_custom_text',
                'label' => __('Enable custom Add to Cart text', 'woo-customized'),
                'desc_tip' => true,
                'description' => __('Enable to override the Add to Cart text for this product.', 'woo-customized'),
                'value' => $custom_enabled
            ));

            woocommerce_wp_text_input(array(
                'id'          => '_woo_product_cart_text',
                'label'       => __('Custom Add to Cart Text', 'woo-customized'),
                'desc_tip'    => true,
                'description' => __('This will replace the default Add to Cart button label.', 'woo-customized'),
                'value'       => $custom_text
            ));
            ?>
        </div>
    </div>
    <?php
}


add_action('woocommerce_process_product_meta', function($post_id) {
    error_log('post data:' . print_r($_POST['_woo_enable_custom_text'], true));
    update_post_meta($post_id, '_woo_enable_custom_text', isset($_POST['_woo_enable_custom_text']) ? 'yes' : 'no');
    update_post_meta($post_id, '_woo_product_cart_text', sanitize_text_field($_POST['_woo_product_cart_text']));
});
